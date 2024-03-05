<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Calibration;
use App\Models\Carname;
use App\Models\MeasuringDevice;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadControlMeasuringDevice extends Controller
{
    public function uploadControlMeasuringDevice(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran danenis file
        ]);

        if ($request->hasFile('excelFileControlMeasuringDevice')) {
            foreach ($request->file('excelFileControlMeasuringDevice') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $controlMeasuringData = $sheet->toArray();

                $isHeader = true; // Flag untuk menandakan apakah baris yang sedang diproses adalah header

                foreach ($controlMeasuringData as $row) {
                    if ($isHeader) {
                        $isHeader = false;
                        continue;
                    }

                    $nik = $row[1] ?? null;

                    if (!$nik) {
                        continue;
                    }

                    // Cari atau buat entri baru di tabel terkait
                    $controlMeasuringData = Calibration::updateOrCreate(
                        ['nik' => $nik],
                        [
                            'shift' => $row[2] ?? null,
                            'measuring_device_id' => $this->findOrCreateMeasuringDevice($row[3]), // ambil no control
                            'expired_date' => isset($row[4]) ? date('Y-m-d', strtotime($row[4])) : null,
                            'con_before_cal' => $row[5],
                            'con_after_cal' => $row[6],
                            'cal_date' => isset($row[7]) ? date('Y-m-d', strtotime($row[7])) : null,
                            'cal_supplier' => $row[8] ?? null,
                            'no_certificate' => $row[9],
                            'file1' => $row[10],
                            'file2' => $row[11],
                            'result' => $row[12],
                            'area_id' => $this->findOrCreateArea($row[13]), // ambil area,
                            'carname_id' => $this->findOrCreateCarName($row[14]), // ambil area,
                            'service_place' => $row[15], // ambil area,
                            'start_ser_date' => $row[16] ?? null, // ambil area,
                            'finish_ser_date' => $row[17] ?? null, // ambil area,
                            'problem' => $row[18] ?? null, // ambil area,
                            'life_time' => $row[19] ?? null, // ambil area,
                            'next_action' => $row[20] ?? null, // ambil area,
                        ]
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }

    private function findOrCreateMeasuringDevice($measuringDeviceName)
    {
        $measuringDevice = MeasuringDevice::where('no_control', $measuringDeviceName)->first();
        if ($measuringDevice) {
            return $measuringDevice->id;
        }

        return null;
    }

    private function findOrCreateArea($areaName)
    {
        // Jika nama area kosong atau null, atur menjadi '-'
        if (!$areaName) {
            $areaName = '-';
        }

        // Cari area berdasarkan nama
        $area = Area::where('area', $areaName)->first();

        // Jika area sudah ada, kembalikan ID-nya
        if ($area) {
            return $area->id;
        }

        // Jika area belum ada, buat area baru
        $newArea = Area::create(['area' => $areaName]);

        // Kembalikan ID area baru
        return $newArea->id;
    }

    private function findOrCreateCarName($carName)
    {
        // Jika nama area kosong atau null, atur menjadi '-'
        if (!$carName) {
            $carName = '-';
        }

        // Cari area berdasarkan nama
        $carname = Carname::where('carname', $carName)->first();

        // Jika area sudah ada, kembalikan ID-nya
        if ($carname) {
            return $carname->id;
        }

        // Jika area belum ada, buat area baru
        $newCarname = Carname::create(['carname' => $carName]);

        // Kembalikan ID area baru
        return $newCarname->id;
    }


}



