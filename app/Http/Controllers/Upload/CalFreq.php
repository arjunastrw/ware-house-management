<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\FreqCalMeasuringDevice;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CalFreq extends Controller
{
    public function uploadCalFreq(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileCalFreq')) {
            foreach ($request->file('excelFileCalFreq') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $cal_freq = $sheet->toArray();

                $isHeader = true; // Flag untuk menandakan apakah baris yang sedang diproses adalah header

                foreach ($cal_freq as $row) {
                    if ($isHeader) {
                        $isHeader = false; // Lewati baris header
                        continue;
                    }

                    // Ambil nilai dari setiap kolom
                    $deviceName = $row[0] ?? null;
                    $calStatus = $row[1] ?? null;
                    $freqCalUnit = $row[2] ?? null;
                    $lifeTimeNum = $row[3] ?? null;

                    // Jika nilai 'cal freq' tidak ada, lanjutkan ke baris selanjutnya
                    if (!$deviceName) {
                        continue;
                    }

                    // Coba untuk menambahkan data baru atau memperbarui data yang sudah ada
                    FreqCalMeasuringDevice::updateOrCreate(
                        ['device_name' => $row[0]],
                        ['cal_status' => $row[1], 'freq_cal_num' => $row[2], 'life_time_num' => $row[3]]
                    );

                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }
}
