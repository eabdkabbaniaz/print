<?php

namespace App\Console\Commands;

use App\Models\Reservation\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reservation-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date =Carbon::now('Asia/Damascus')->toDateString();
     $hour =Carbon::now('Asia/Damascus')->hour;
        
    $reservations = Reservation::with('time')->where('Date', $date)->get();
    foreach($reservations as $reservation){
      echo $reservation->time->time;
            if($reservation->time->time < $hour-1){
                $reservation->delete();
            }
    }
    }
}
