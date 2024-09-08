<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';
    protected $primary = 'id';

    protected $guarded = ['id'];

    protected $casts =[
        'started_at' => 'date',
        'ended_at' => 'date',
        'total_amount' => MoneyCast::class,
        'subtotal' => MoneyCast::class,
        'fee' => MoneyCast::class,
        'tax' => MoneyCast::class,
    ];

    public function generateUniqueCode() : string 
    {
        $date = Carbon::now()->format('ymd');
        do {
            $randomString = $date . Str::upper(Str::random(6));
        } while (self::where('code', $randomString)->exists());

        return $randomString;
    }

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function product() : HasOne {
        return $this->hasOne(Product::class, 'product_id', 'id');
    }


    // Override method serializeDate untuk custom format
    // protected function serializeDate(\DateTimeInterface $date)
    // {
    //     return $date->format('Y-m-d'); // Format yyyy-mm-dd
    // }
}
