<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account'
    ];

    public function mpesas()
    {
        return $this->hasMany(Radio_Mpesa::class);
    }
}