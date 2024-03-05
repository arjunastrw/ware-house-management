<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\Merk;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SubTableMerk extends Controller
{
    public function uploadMerk(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileMerk')) {
            foreach ($request->file('excelFileMerk') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $merks = $sheet->toArray();

                foreach ($merks as $row) {
                    // Ambil nilai 'merks' dari baris excel
                    $merk = $row[0] ?? null;

                    // Jika nilai 'type' tidak ada, lanjutkan ke baris selanjutnya
                    if (!$merk) {
                        continue;
                    }

                    // Coba untuk menambahkan data baru atau memperbarui data yang sudah ada
                    Merk::updateOrCreate(
                        ['merk' => $merk], // Kunci pencarian
                        ['merk' => $merk]  // Nilai yang akan dimasukkan atau diperbarui
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }
}
