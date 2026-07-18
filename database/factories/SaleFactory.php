<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'employee_id' => Employee::factory(),
            'branch_id' => Branch::factory(),
            'total_amount' => $this->faker->randomFloat(2, 50, 2000),
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
