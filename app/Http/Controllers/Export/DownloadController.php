<?php

namespace App\Http\Controllers\Export;

use App\Exports\ExportMeasuringDevice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    public function export(Request $request)
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth <= 6) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }

        $startDate = $startYear . '-07-01';
        $endDate = $endYear . '-06-30';

        // Mengambil data dari request jika ada
        $customStartDate = $request->input('start_date');
        $customEndDate = $request->input('end_date');

        if ($customStartDate && $customEndDate) {
            $startDate = $customStartDate;
            $endDate = $customEndDate;
        }

        $response = Excel::download(new ExportMeasuringDevice($startDate, $endDate), 'calibration.xlsx');

        // Menambahkan header pada respons file Excel
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="calibration.xlsx"');
        $response->headers->set('Expires', '0');
        $response->headers->set('Cache-Control', 'must-revalidate');
        $response->headers->set('Pragma', 'public');

        return $response;
    }
}
