<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Calibration;
use App\Models\MeasuringDevice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        //Card
// Get start and end periods using a separate function
        list($startPeriod, $endPeriod) = $this->getPeriod($request->input('startPeriod'), $request->input('endPeriod'));
        $latestCalibrations = Calibration::whereIn('cal_date', function ($query) use ($startPeriod, $endPeriod) {
            $query->select(DB::raw('MAX(cal_date)'))
                ->from('calibrations')
                ->whereBetween('cal_date', [$startPeriod, $endPeriod])
                ->groupBy('measuring_device_id');
        })->get();

        $latestCalibrationsByDevice = $latestCalibrations->groupBy('measuring_device_id');

        $okCount = $latestCalibrationsByDevice->filter(function ($calibration) {
            return $calibration->first()->result === 'OK';
        })->count();

        $nokCount = $latestCalibrationsByDevice->filter(function ($calibration) {
            return $calibration->first()->result === 'N-OK' && $calibration->first()->next_action !== 'SCRAP';
        })->count();

        $nokCountWithScrapAction = $latestCalibrationsByDevice->filter(function ($calibration) {
            return $calibration->first()->result === 'N-OK' && $calibration->first()->next_action === 'SCRAP';
        })->count();

        $countCalibration =

//Chart
            // Get start and end years from the request, default to the current year
        $startYear = $request->input('startYear', date('Y'));
        $endYear = $request->input('endYear', date('Y'));

        // Determine the start and end dates of the dynamic period (July-June) for the selected years
        $startPeriod = Carbon::create($startYear - 1, 7, 1); // July of start year
        $endPeriod = Carbon::create($endYear, 6, 30); // June of end year

        // Retrieve the latest calibration data for each measuring device within the period
        $latestCalibrations = Calibration::whereBetween('cal_date', [$startPeriod, $endPeriod])
            ->select('measuring_device_id', DB::raw('MAX(cal_date) as latest_cal_date'))
            ->groupBy('measuring_device_id')
            ->get();

        // Initialize an array to hold the counts for each month
        $monthlyData = [];

        // Loop through the months from July to June
        for ($month = 7; $month <= 12; $month++) {
            $monthlyData[Carbon::create($startYear - 1, $month, 1)->monthName] = ['OK' => 0, 'N-OK' => 0, 'SCRAP' => 0];
        }
        for ($month = 1; $month <= 6; $month++) {
            $monthlyData[Carbon::create($endYear, $month, 1)->monthName] = ['OK' => 0, 'N-OK' => 0, 'SCRAP' => 0];
        }

        // Loop through each calibration to count each result type for each month
        foreach ($latestCalibrations as $calibration) {
            $latestCalibration = Calibration::where('measuring_device_id', $calibration->measuring_device_id)
                ->where('cal_date', $calibration->latest_cal_date)
                ->first();

            // Get the month of the latest calibration
            $monthName = Carbon::parse($calibration->latest_cal_date)->monthName;

            // Update the counts for the corresponding month and result type
            if ($latestCalibration->result === 'OK') {
                $monthlyData[$monthName]['OK']++;
            } elseif ($latestCalibration->result === 'N-OK') {
                if ($latestCalibration->next_action === 'SCRAP') {
                    $monthlyData[$monthName]['SCRAP']++; // Increment 'Scrap' count
                } else {
                    $monthlyData[$monthName]['N-OK']++; // Increment 'N-OK' count
                }
            }
        }

        // Organize data for the chart
        $data = [
            'labels' => array_keys($monthlyData), // Months as labels
            'datasets' => [
                [
                    'label' => 'OK',
                    'data' => array_column($monthlyData, 'OK'),
                    'backgroundColor' => 'green',
                ],
                [
                    'label' => 'N-OK',
                    'data' => array_column($monthlyData, 'N-OK'),
                    'backgroundColor' => 'yellow',
                ],
                [
                    'label' => 'Scrap',
                    'data' => array_column($monthlyData, 'SCRAP'),
                    'backgroundColor' => 'red',
                ],
            ],
        ];

        // Additional options for the chart
        $options = [
            'scales' => [
                'xAxes' => [['stacked' => true]], // Stacked horizontally
                'yAxes' => [['stacked' => true]], // Stacked vertically
            ],
        ];
//Reminder

// Fetch upcoming reminders for the next 7 days (including today) grouped by measuring_device_id
        $latestExpiredDates = Calibration::select('measuring_device_id', DB::raw('MAX(next_action) as max_next_action'), DB::raw('MAX(result) as max_result'), DB::raw('MAX(expired_date) as max_expired_date'))
            ->groupBy('measuring_device_id')
            ->get();

// Now, determine if each reminder is upcoming or expired
        $upcomingReminders = [];
        $expiredReminders = [];

        foreach ($latestExpiredDates as $reminder) {
            if ($reminder->max_expired_date) {
                $expiredDate = Carbon::parse($reminder->max_expired_date);
                $today = Carbon::today();
                $sevenDaysLater = Carbon::today()->addDays(7);
                if (($expiredDate->isToday() || ($expiredDate->isFuture() && $expiredDate->lte($sevenDaysLater))) && $reminder->max_next_action != 'SCRAP') {
                    // Reminder is upcoming if the max expired date is within the next 7 days and max_next_action is not 'SCRAP'
                    $upcomingReminders[] = $reminder;
                } elseif ($expiredDate->isPast() && $reminder->max_next_action != 'SCRAP') {
                    // Reminder is expired if the max expired date is in the past and max_next_action is not 'SCRAP'
                    $expiredReminders[] = $reminder;
                }
            }
        }


        $totalCalibrations = $this->totalCalibrations();
        $totalMeasuringDevice = $this->totalMeasuringDevice();


        // Pass the selected year to the view
        return view('dashboard', [
            'upcomingReminders' => $upcomingReminders,
            'expiredReminders' => $expiredReminders,

            'okCount' => $okCount,
            'nokCount' => $nokCount,
            'nokScrapCount' => $nokCountWithScrapAction,
            'user' => $user,
            'data' => $data,
            'options' => $options,
            'startYear' => $startYear,
            'endYear' => $endYear,
            'startPeriod' => $startPeriod->format('Y-m'), // Format as 'YYYY-MM'
            'endPeriod' => $endPeriod->format('Y-m'), // Format as 'YYYY-MM'
            'totalCalibrations' => $totalCalibrations,
            'totalMeasuringDevice' => $totalMeasuringDevice
        ]);
    }

    private function totalCalibrations()
    {
        return Calibration::count();
    }

    private function totalMeasuringDevice()
    {
        return MeasuringDevice::count();
    }

    private function getPeriod($startPeriod, $endPeriod)
    {
        //Card
        if (!$startPeriod || !$endPeriod) {
            // Default to July-June if start or end period is not provided
            $startPeriod = date('Y') - 1 . '-07'; // Default start period to July of previous year
            $endPeriod = date('Y') . '-06'; // Default end period to June of current year
        }

        // Convert periods to Carbon instances for comparison
        $startPeriod = Carbon::parse($startPeriod);
        $endPeriod = Carbon::parse($endPeriod);

        return [$startPeriod, $endPeriod];
    }


    public function userOnlineStatus()
    {
        $users = DB::table('users')->get();

        foreach ($users as $key => $user) {
            if (Cache::has('user-is-online-' . $user->id)) {
                $users[$key]->status = 'Online';
            } else {
                $users[$key]->status = 'Offline';
            }
        }


        return view('users.index', compact('users'))->with('i', 0);
    }
//     private function getSidebarOptions()
// {
//     $user = auth()->user();

//     // Default sidebar options
//     $sidebarOptions = ['Dashboard'];

//     // Add role-specific options
//     if ($user && $user->hasRole('Admin')) {
//         $sidebarOptions[] = 'Admin Option';
//     } elseif ($user && $user->hasRole('inspector')) {
//         $sidebarOptions[] = 'Inspector Option';
//     }

//     return $sidebarOptions;


}
