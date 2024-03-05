<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\FreqCalMeasuringDevice;
use App\Models\MeasuringDevice;
use App\Models\Merk;
use App\Models\Type;
use App\Models\Range;
use App\Models\Resolution;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadMeasuringDevice extends Controller
{
    public function uploadMeasuringDevice(Request $request)
    {
        // Validasi request
        $request->validate([
            'excelFile.*' => 'required|mimes:xlsx,xls|max:2048' // Batasan ukuran dan jenis file
        ]);

        if ($request->hasFile('excelFileMeasuringDevice')) {
            foreach ($request->file('excelFileMeasuringDevice') as $file) {
                // Proses unggah dan pemrosesan masing-masing file Excel
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('excel', $fileName);

                // Baca file Excel
                $spreadsheet = IOFactory::load($file);

                // ambil data dari sheet
                $sheet = $spreadsheet->getActiveSheet();
                $measuringData = $sheet->toArray();

                $isHeader = true; // Flag untuk menandakan apakah baris yang sedang diproses adalah header

                foreach ($measuringData as $row) {
                    if ($isHeader) {
                        $isHeader = false; // Lewati baris header
                        continue;
                    }

                    $noControl = $row[0] ?? null;

                    if (!$noControl) {
                        continue;
                    }

                    // Cari atau buat entri baru di tabel terkait
                    $measuringDevice = MeasuringDevice::updateOrCreate(
                        ['no_control' => $noControl], // Sesuaikan dengan kolom 'no_control' sesuai dengan ketentuan
                        [
                            'device_name' => $this->findOrCreateDeviceName($row[1]),
                            'type_id' => $this->findOrCreateType($row[2]),
                            'merk_id' => $this->findOrCreateMerk($row[3]),
                            'no_seri' => $row[4],
                            'range_id' => $this->findOrCreateRange($row[5]),
                            'resolution_id' => $this->findOrCreateResolution($row[6]),
                            'ata_sai' => $row[7] ?? null,
                            'inv_no' => $row[8] ?? null,
                            'no_doc_bc' => $row[9] ?? null,
                        ]
                    );
                }
            }

            // Kembalikan respons setelah selesai mengunggah semua file
            return redirect()->back()->with('success', 'Files uploaded successfully');
        }
    }

    private function findOrCreateDeviceName($deviceName)
    {
        $device = FreqCalMeasuringDevice::where('device_name', $deviceName)->first();
        if ($device) {
            return $device->id;
        } else {
        }
    }




    // Metode untuk mencari atau membuat entri baru di tabel Type
    private function findOrCreateType($typeName)
    {
        if (!$typeName) {
            $typeName = '-';
        }
        // Cari tipe berdasarkan nama
        $type = Type::where('type', $typeName)->first();

        // Jika tipe sudah ada, kembalikan ID-nya
        if ($type) {
            return $type->id;
        }

        // Jika tipe belum ada, buat tipe baru
        $newType = Type::create(['type' => $typeName]);

        // Kembalikan ID tipe baru
        return $newType->id;
    }

    // Metode untuk mencari atau membuat entri baru di tabel Merk
    private function findOrCreateMerk($merkName)
    {
        if (!$merkName) {
            $merkName = '-';
        }

        $merk = Merk::where('merk', $merkName)->first();

        if ($merk) {
            return $merk->id;
        }

        $newMerk = Merk::create(['merk' => $merkName]);

        return $newMerk->id;
    }

    // Metode untuk mencari atau membuat entri baru di tabel Range
    private function findOrCreateRange($rangeName)
    {
        $range = Range::where('range', $rangeName)->first();

        if ($range) {
            return $range->id;
        }

        $newRange = Range::create(['range' => $rangeName]);

        return $newRange->id;
    }

    // Metode untuk mencari atau membuat entri baru di tabel Resolution
    private function findOrCreateResolution($resolutionName)
    {
        if (!$resolutionName) {
            $resolutionName = '-';
        }

        $resolution = Resolution::where('resolution', $resolutionName)->first();

        if ($resolution) {
            return $resolution->id;
        }

        $newResolution = Resolution::create(['resolution' => $resolutionName]);

        return $newResolution->id;
    }
}
