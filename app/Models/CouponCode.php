<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Support\Str;

class CouponCode extends Model
{
    //

    use DefaultDatetimeFormat;
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    protected $appends = ['description'];

    public static $typeMap = [
        self::TYPE_FIXED => 'fixed',
        self::TYPE_PERCENT => 'percent',
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'total',
        'used',
        'min_amount',
        'not_before',
        'not_after',
        'enabled',
    ];
    protected $casts = [
        'enabled' => 'boolean'
    ];
    protected $dates = [
        'not_before',
        'not_after'
    ]; 

    public function getDescriptionAttribute()
    {
        $str = '';
        if($this->min_amount > 0){
            $str = '满'.str_replace('.00', '', $this->min_amount);
        }
        if($this->type === self::TYPE_PERCENT){
            return $str.'优惠'.str_replace('.00', '', $this->value).'%';
        }

        return '减'.str_replace('.00', '', $this->value);
    }

    public static function findAvailableCode($length = 16)
    {
        do {
            $code = strtoupper(Str::random($length));    
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }
}
