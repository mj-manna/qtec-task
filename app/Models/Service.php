<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
    ];


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
