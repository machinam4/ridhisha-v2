<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Players extends Model
{
    use HasFactory;
    use Prunable;

    protected $fillable = [
        'TransactionType',
        'TransID',
        'TransTime',
        'TransAmount',
        'BusinessShortCode',
        'BillRefNumber',
        'InvoiceNumber',
        'OrgAccountBalance',
        'ThirdPartyTransID',
        'MSISDN',
        'FirstName',
        'user_id',
    ];

    public function presenter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prunable()
    {
        return static::where('TransTime', '<=', now()->subMonth());
    }
}
