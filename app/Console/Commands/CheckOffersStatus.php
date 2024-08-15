<?php

namespace App\Console\Commands;

use App\Enums\OfferStatus;
use App\Models\Offers\Offer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOffersStatus extends Command
{
    
    protected $signature = 'offers:check-status';

   
    protected $description =
    'Update the offer status to Expired at the specified expiration time atuo';

   
    public function handle()
    {
        $now = Carbon::now('Asia/Damascus');      
          $expiredOffers = Offer::where('end_datetime', '<=', $now)->get();
        foreach ($expiredOffers as $offer) {
           $offer->status_offer = OfferStatus::NONACTIVE;
           $offer->save();
            // $offer->updat([
            //     'status_offer'=>OfferStatus::NONACTIVE
            // ]);
        }
    }
}
