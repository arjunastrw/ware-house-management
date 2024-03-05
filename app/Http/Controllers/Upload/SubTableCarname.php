<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\Carname;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SubTableCarname extends Controller
{
    public function uploadCarname(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileCarName')) {
            foreach ($request->file('excelFileCarName') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $carnames = $sheet->toArray();

                foreach ($carnames as $row) {
                    // Ambil nilai 'ranges' dari baris excel
                    $carname = $row[0] ?? null;

                    // Jika nilai 'range' tidak ada, lanjutkan ke baris selanjutnya
                    if (!$carname) {
                        continue;
                    }

                    // Coba untuk menambahkan data baru atau memperbarui data yang sudah ada
                    Carname::updateOrCreate(
                        ['carname' => $carname], // Kunci pencarian
                        ['carname' => $carname]  // Nilai yang akan dimasukkan atau diperbarui
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }
}
