<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewOfferCreateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewOfferNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $offer;
    public $users;
    public function __construct($offer,$users)
    {
        $this->offer = $offer;
        $this->users = $users;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        
        $offer = $this->offer; 
        $users = $this->users; 
        
        $users->each(function ($user) use ($offer) {
            $user->notify(new NewOfferCreateNotification($offer));
        });
}
}
