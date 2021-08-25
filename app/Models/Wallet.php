<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "wallet";

    protected $hidden = ['created_at', 'updated_at', 'user_id', 'id'];
    
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
