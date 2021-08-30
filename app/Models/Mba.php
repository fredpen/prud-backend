<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mba extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "mbas";

    protected $hidden = ['deleted_at', 'updated_at'];

    public function photos()
    {
        return $this->hasMany(MbaPhoto::class);
    }

    public function benefits()
    {
        return $this->hasMany(MbaBenefits::class);
    }

    public function activeBenefits()
    {
        return $this->hasMany(MbaBenefits::class);
    }

    public function plans()
    {
        return $this->hasMany(MbaPlan::class);
    }

    public function activePlans()
    {
        return $this->hasMany(MbaPlan::class)->where('isActive', true);
    }
}
