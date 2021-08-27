<?php

namespace Database\Factories;

use App\Models\Mba;
use App\Models\MbaPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MbaPlanFactory extends Factory
{

    protected $model = MbaPlan::class;

    public function definition()
    {
        $code = rand(1, 6);
        return [
            'mba_id' =>  Mba::inRandomOrder()->first(),
            'type' =>  $this->getType($code),
            'cost' =>  $this->getCost($code),
            'numbers_of_shares_you_get' =>  $this->getNumOfShares($code),
            'tenure_in_months' =>  $this->getTenure($code),
            'roi_in_percentage' =>  $this->getRoi($code),
            "start_date" => now(),
            "end_date" => now()->addMonths($this->getTenure($code)),
        ];
    }

    private function getType($code)
    {
        if ($code == 1 || $code == 2) return "Gold";
        return $code == 3 || $code == 4 ? "Platinum" : "Diamond";
    }

    private function getCost($code)
    {
        if ($code == 1 || $code == 2) return 5000000;
        return $code == 3 || $code == 4  ? 10000000 : 20000000;
    }

    private function getNumOfShares($code)
    {
        if ($code == 1 || $code == 2) return 1;
        return $code == 3 || $code == 4  ? 2 : 4;
    }

    private function getTenure($code)
    {
        return  $code % 2 == 0 ? 12 : 24;
    }

    private function getRoi($code)
    {
        return  $code % 2 == 0 ? 23 : 48;
    }
}
