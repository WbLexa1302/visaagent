<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaType extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'processing_time'
    ];

    /**
     * Get the applications for this visa type.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
