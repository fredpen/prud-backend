<?php

namespace Database\Factories;

use App\Models\Investments;
use App\Models\Mba;
use App\Models\MbaPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentsFactory extends Factory
{
    protected $model = Investments::class;

    public function definition()
    {
        $mba = Mba::inRandomOrder()->first();
        $mbaPlan = MbaPlan::inRandomOrder()->first();
        return [
            "mba_id" => $mba->id,
            "plan_id" => $mbaPlan->id,
            "num_of_units" => $mbaPlan->numbers_of_shares_you_get,
            "plan_name" => $mbaPlan->type,
            "tenure_in_months" => $mbaPlan->tenure_in_months,
            "roi_in_percentage" => $mbaPlan->roi_in_percentage,
            "amount_paid" => $mbaPlan->cost,
            "payment_description" => Investments::describeKey(1),
        ];
    }
}
