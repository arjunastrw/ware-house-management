<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\Range;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SubTableRange extends Controller
{
    public function uploadRange(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileRange')) {
            foreach ($request->file('excelFileRange') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $ranges = $sheet->toArray();

                foreach ($ranges as $row) {
                    // Ambil nilai 'ranges' dari baris excel
                    $range = $row[0] ?? null;

                    // Jika nilai 'range' tidak ada, lanjutkan ke baris selanjutnya
                    if (!$range) {
                        continue;
                    }

                    // Coba untuk menambahkan data baru atau memperbarui data yang sudah ada
                    Range::updateOrCreate(
                        ['range' => $range], // Kunci pencarian
                        ['range' => $range]  // Nilai yang akan dimasukkan atau diperbarui
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }
}
