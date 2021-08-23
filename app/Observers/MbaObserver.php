<?php

namespace App\Observers;

use App\Models\Mba;
use Illuminate\Support\Facades\Cache;

class MbaObserver
{
    public function created(Mba $mba)
    {
        return $this->burstMbaCache();
    }

    public function updated(Mba $mba)
    {
        return $this->burstMbaCache();
    }


    public function deleted(Mba $mba)
    {
        return $this->burstMbaCache();
    }

    private function burstMbaCache()
    {
        Cache::forget("listOfActiveMbas");
        return Cache::forget("listOfMbas");
    }
}
