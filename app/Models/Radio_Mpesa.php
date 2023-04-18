<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio_Mpesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mpesa_id',
        'radio_id',
        'account',
    ];

    public function radio()
    {
        return $this->belongsTo(Radio::class, 'radio_id');
    }
    public function mpesa()
    {
        return $this->belongsTo(Mpesa::class, 'mpesa_id');
    }
}
