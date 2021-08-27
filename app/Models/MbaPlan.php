<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbaPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'mba_plan';

    protected $hidden = ['deleted_at', 'updated_at'];

    public function mba()
    {
        return $this->belongsTo(Mba::class);
    }
}
