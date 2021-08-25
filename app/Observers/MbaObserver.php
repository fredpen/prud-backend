<?php

namespace App\Observers;

use App\Helpers\FileHelper;
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
        $mba->benefits()->delete();
        FileHelper::removeAfile($mba->photos()->pluck('url'));
        $mba->photos()->delete();
        // $mba->plans()->delete();
        return $this->burstMbaCache();
    }

    private function burstMbaCache()
    {
        Cache::forget("listOfActiveMbas");
        return Cache::forget("listOfMbas");
    }
}
