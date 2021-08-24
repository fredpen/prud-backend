<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbaPhoto extends Model
{
    use HasFactory;

    protected $table = "mba_photos";

    protected $guarded = [];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function mba()
    {
        return $this->belongsTo(Mba::class);
    }
}
