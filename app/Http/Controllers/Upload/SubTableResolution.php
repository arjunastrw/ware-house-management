<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\Resolution;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SubTableResolution extends Controller
{
    public function uploadResolution(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileResolution')) {
            foreach ($request->file('excelFileResolution') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $resolutions = $sheet->toArray();

                foreach ($resolutions as $row) {
                    // Ambil nilai 'merks' dari baris excel
                    $resolution = $row[0] ?? null;

                    // Jika nilai 'type' tidak ada, lanjutkan ke baris selanjutnya
                    if (!$resolution) {
                        continue;
                    }

                    // Coba untuk menambahkan data baru atau memperbarui data yang sudah ada
                    Resolution::updateOrCreate(
                        ['resolution' => $resolution], // Kunci pencarian
                        ['resulotion' => $resolution]  // Nilai yang akan dimasukkan atau diperbarui
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }
}
