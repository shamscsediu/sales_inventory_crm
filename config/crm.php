<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CRM Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing general configuration related to the CRM system.
    |
    */

    'lost_customer_inactivity_days' => (int) env('LOST_CUSTOMER_INACTIVITY_DAYS', 90),
];
