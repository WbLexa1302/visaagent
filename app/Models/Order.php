<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'unique_code',
        'booking_code',
        'passport_number',
        'country_code',
        'process_type',
        'status',
        'visa_type',
        'status',
        'submission_date',
        'completion_date',
        'notes',
        'sheet_row_id',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'completion_date' => 'date',
    ];

    /**
     * Relasi ke model Customer (Many-to-One)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => '#F59E0B',
            'processing' => '#3B82F6',
            'approved'   => '#10B981',
            'rejected'   => '#EF4444',
            'completed'  => '#6366F1',
            default      => '#6B7280',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Menunggu',
            'processing' => 'Diproses',
            'approved'   => 'Disetujui',
            'rejected'   => 'Ditolak',
            'completed'  => 'Selesai',
            default      => 'Tidak Diketahui',
        };
    }

    // Tambahkan juga relasi product agar Filament bisa membaca nama produknya
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
