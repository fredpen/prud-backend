<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes,
        HasFactory;

    protected $guarded = [];

    protected $table = "wallet";

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
