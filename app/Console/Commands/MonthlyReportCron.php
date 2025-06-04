<?php

namespace App\Console\Commands;

use App\Http\Controllers\HomeController;
use Illuminate\Console\Command;
// use App\Http\Controllers\ReportController;

class MonthlyReportCron extends Command
{
    protected $signature = 'report:monthly';
    protected $description = 'Send the monthly sales report via email';

    public function handle()
    {
        try {
            // Directly instantiate the controller and call the method
            $controller = new HomeController();
            $controller->monthly_report();
            $this->info('Monthly sales report sent.');
        } catch (\Throwable $e) {
            report($e); 
            $this->error('Failed to send monthly report: ' . $e->getMessage());
        }
    }
}

