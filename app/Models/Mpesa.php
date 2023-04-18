<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'shortcode',
        'name',
        'username',
        'key',
        'secret',
        'passkey',
        'b2cPassword',
        // 'radio_id',
    ];

    public function radio()
    {
        return $this->hasMany(Radio_Mpesa::class);
    }
}
