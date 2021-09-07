<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Wallet extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $guarded = [];

    protected $table = "wallet";

    protected $hidden = ['created_at', 'updated_at', 'user_id', 'id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
