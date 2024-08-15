<?php

namespace App\Jobs;

use App\Events\NewOrderExternal;
use App\Events\NewOrderInternal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EventOrderInternal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public  $section_id;

    public function __construct($order,$section_id)
    {
        $this->order= $order;
        $this->section_id= $section_id;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = $this->order; 
        $section_id = $this->section_id; 
        event(new NewOrderInternal($order, $section_id));
    }
}
