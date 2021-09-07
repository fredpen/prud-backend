<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investments extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $table = 'investments';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mba()
    {
        return $this->belongsTo(Mba::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(MbaPlan::class, 'user_id');
    }

    public static function describeKey(int $key): string
    {
        $description = self::investmentParam();
        return $description[$key];
    }

    public static function getFieldToUpdate(int $key): string
    {
        $description = self::investmentParam();
        return $description[$key] . "_on";
    }

    public static function investmentParam(): array
    {
        return [
            "1" => "created",
            "2" => "payment_confirmed",
            "3" => "activated",
            "4" => "closed",
            "5" => "cancelled",
        ];
    }

}
