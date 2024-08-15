<?php

namespace App\Services\SettingRestaurant;

use App\Enums\SizeTable;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Restaurant\Restaurant;
use App\Models\Table\Table;
use App\Models\TableSize;
use App\Services\CRUDServices;
use Carbon\Carbon;

class SettingRestaurantServices 
{
   

    public static function showStatusResturant()
    {
        $restaurant = Restaurant::find(1);
        $now = Carbon::now('Asia/Damascus')->toTimeString();
  
        $start = Carbon::parse($restaurant->start)->toTimeString();
        $end = Carbon::parse($restaurant->end)->toTimeString();
        if ($restaurant->status == true) {
          if ($now > $end ||  $now < $start) {
            return "المطعم مغلق حالياً";
          }
        } else if ($restaurant->status == false) {
          return "المطعم مغلق حالياً";
        }
    }



  
}
