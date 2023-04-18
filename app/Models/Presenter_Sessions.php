<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenter_Sessions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'radio_id',
        'shortcode',
        'code_type',
        'account',
        'status'
    ];

    public function radio()
    {
        return $this->belongsTo(Radio::class, 'radio_id');
    }

    public function presenter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function players()
    {
        return $this->hasMany(Players::class, 'session_id');
    }
}
