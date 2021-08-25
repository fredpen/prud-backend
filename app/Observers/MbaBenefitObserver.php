<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class MbaBenefitObserver
{
    public function created()
    {
        return $this->burstMbaCache();
    }

    public function updated()
    {
        return $this->burstMbaCache();
    }


    public function deleted()
    {
        return $this->burstMbaCache();
    }

    private function burstMbaCache()
    {
        Cache::forget("listOfActiveMbas");
        return Cache::forget("listOfMbas");
    }
}
