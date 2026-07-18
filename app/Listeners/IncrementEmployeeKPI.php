<?php

namespace App\Listeners;

use App\Events\CustomerRecovered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementEmployeeKPI
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CustomerRecovered $event): void
    {
        $customer = $event->customer;
        
        if ($customer->employee_id) {
            $customer->employee->increment('kpi_score');
        }
    }
}
