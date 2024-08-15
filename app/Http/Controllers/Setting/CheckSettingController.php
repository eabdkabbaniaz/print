<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Services\SettingRestaurant\SettingRestaurantServices;
use Illuminate\Http\Request;

class CheckSettingController extends Controller
{
    public function checkSeting(){
        $status = SettingRestaurantServices::showStatusResturant();
        if ($status != null) {
          return response()->json(
            [
              'status' => 400,
              'message' => $status
            ]
          );
        }
        else{
          return response()->json(
            [
              'status' => 200,
              'message' => 'المطعم غير مغلق'
            ]
          );

        }
    }
}
