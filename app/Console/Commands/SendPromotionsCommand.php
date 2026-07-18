<?php

namespace App\Console\Commands;

use App\Mail\PromotionEmail;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPromotionsCommand extends Command
{
    protected $signature = 'crm:send-promotions {--all : Send to all customers} {--lost : Send only to lost customers}';
    protected $description = 'Send promotional emails to customers';

    public function handle()
    {
        if ($this->option('lost')) {
            $customers = Customer::lost()->get();
            $this->info("Sending promotions to {$customers->count()} lost customers...");
        } elseif ($this->option('all')) {
            $customers = Customer::all();
            $this->info("Sending promotions to all {$customers->count()} customers...");
        } else {
            $this->error('Please specify a target group using --all or --lost');
            return;
        }

        foreach ($customers as $customer) {
            Mail::to($customer->email)->send(new PromotionEmail($customer));
            $this->line("Email sent to {$customer->email}");
        }

        $this->info('All promotional emails have been sent!');
    }
}
