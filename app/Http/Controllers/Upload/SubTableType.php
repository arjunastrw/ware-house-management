<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Imports\TypesImport;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Type;



class SubTableType extends Controller
{
    public function uploadType(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileType')) {
            foreach ($request->file('excelFileType') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $types = $sheet->toArray();

                foreach ($types as $row) {
                    // Ambil nilai 'type' dari baris excel
                    $type = $row[0] ?? null;

                    // Jika nilai 'type' tidak ada, lanjutkan ke baris selanjutnya
                    if (!$type) {
                        continue;
                    }

                    // Coba untuk menambahkan data baru atau memperbarui data yang sudah ada
                    Type::updateOrCreate(
                        ['type' => $type], // Kunci pencarian
                        ['type' => $type]  // Nilai yang akan dimasukkan atau diperbarui
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }
}

