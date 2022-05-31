<?php

namespace App\Jobs;

use App\Imports\CustomerImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\CustomerController;
use Excel;

class SaveCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $excelFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($excelFile)
    {
        $this->excelFile = $excelFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = $this->excelFile;
        Excel::import(new CustomerImport, $file);
        CustomerController::sentMail();


    }
}
