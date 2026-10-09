<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\GoogleSheetsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncGoogleSheets extends Command
{
    protected $signature   = 'sheets:sync';
    protected $description = 'Sync data dari Google Sheets ke database';

    public function handle(GoogleSheetsService $sheets): int
    {
        $this->info('Memulai sync dari Google Sheets...');

        // ⚠️  SESUAIKAN nama sheet dan range dengan sheet Anda
        $rows = $sheets->getSheetData('Sheet1!A:L');

        $synced = 0;
        $errors = 0;

        foreach ($rows as $row) {
            try {
                // ⚠️  SESUAIKAN nama key di sini dengan HEADER di Google Sheet Anda
                // Semua key otomatis di-lowercase oleh service

                $passportNumber = $row['passport_number']
                    ?? $row['no passport']
                    ?? $row['passport']
                    ?? null;

                $uniqueCode = $row['unique_code']
                    ?? $row['kode unik']
                    ?? $row['kode']
                    ?? null;

                if (empty($passportNumber)) {
                    continue; // Lewati baris kosong
                }

                // Simpan / update customer
                $customer = Customer::updateOrCreate(
                    ['passport_number' => strtoupper(trim($passportNumber))],
                    [
                        'name'        => $row['name'] ?? $row['nama'] ?? null,
                        'email'       => $row['email'] ?? null,
                        'phone'       => $row['phone'] ?? $row['telepon'] ?? $row['no hp'] ?? null,
                        'nationality' => $row['nationality'] ?? $row['kewarganegaraan'] ?? null,
                    ]
                );

                // Simpan / update order (jika ada kode unik)
                if ($customer && !empty($uniqueCode)) {

                    // 1. Ambil nama visa dari row sheet (misal: 'C1')
                    $visaType = $row['visa_type'] ?? $row['jenis visa'] ?? $row['jenis_visa'] ?? null;

                    // 2. Cari product menggunakan LIKE (Mencari teks yang mengandung kata dari Google Sheet)
                    $product = Product::where('name', 'LIKE', '%' . trim($visaType) . '%')->first();

                    // 3. Validasi jika produk wajib ada sebelum insert order
                    if (!$product) {
                        throw new \Exception("Produk untuk jenis visa '{$visaType}' tidak ditemukan di database.");
                    }

                    // 4. Ambil booking code dari sheet jika ada, jika tidak ada generate otomatis / pakai unique code
                    $bookingCode = $row['booking_code']
                        ?? $row['kode booking']
                        ?? strtoupper(trim($uniqueCode)); // Opsi cadangan: menyamakan booking_code dengan unique_code

                    // PROSES UPDATE OR CREATE ORDER SESUAI TARGET
                    Order::updateOrCreate(
                        [
                            // Cari data berdasarkan kombinasi unique_code yang sudah ada
                            'unique_code' => strtoupper(trim($uniqueCode)),
                        ],
                        [
                            'customer_id'     => $customer->id,
                            'visa_type'       => $visaType,
                            'product_id'      => $product->id,
                            'booking_code'    => $bookingCode, // Jika data baru diinsert, jika data lama diupdate
                            'status'          => $this->mapStatus($row['status'] ?? 'pending'),
                            'submission_date' => $this->parseDate($row['submission_date'] ?? $row['tanggal submit'] ?? null),
                            'expected_date'   => $this->parseDate($row['expected_date'] ?? $row['estimasi selesai'] ?? null),
                            'notes'           => $row['notes'] ?? $row['catatan'] ?? null,
                            'sheet_row_id'    => $row['_row_index'],
                        ]
                    );
                }

                $synced++;
            } catch (\Exception $e) {
                // Jika produk tidak ditemukan atau ada error database, exception ditangkap di sini
                $this->error("Error baris {$row['_row_index']}: " . $e->getMessage());
                $errors++;
            }
        }

        $this->info("Selesai! ✅ Berhasil: {$synced} | ❌ Error: {$errors}");
        return 0;
    }

    private function mapStatus(string $status): string
    {
        $map = [
            'menunggu'   => 'pending',
            'pending'    => 'pending',
            'baru'       => 'pending',
            'proses'     => 'processing',
            'processing' => 'processing',
            'diproses'   => 'processing',
            'on process' => 'processing',
            'disetujui'  => 'approved',
            'approved'   => 'approved',
            'acc'        => 'approved',
            'ditolak'    => 'rejected',
            'rejected'   => 'rejected',
            'tolak'      => 'rejected',
            'selesai'    => 'completed',
            'completed'  => 'completed',
            'done'       => 'completed',
            'finish'     => 'completed',
        ];

        return $map[strtolower(trim($status))] ?? 'pending';
    }

    private function parseDate(?string $date): ?string
    {
        if (empty($date)) return null;
        try {
            return Carbon::parse($date)->toDateString();
        } catch (\Exception $e) {
            return null;
        }
    }
}
