<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponseService;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\Setting;
use Illuminate\Http\Request;

class RestaurnatController extends Controller
{
    public function Addrestaurnt(Request $request)
  {
    $res=Restaurant::Create(
        $request->all()
    );
    return $res;
  }
  public function ChangeStatus(Request $request)
  {
    $restaurant=Restaurant::find($request->id)->first();
    $restaurant->status = !$restaurant->status;
    $restaurant->save();
    return $restaurant;
  }

  public function editrestaurant(Request $request)
  {
    $restaurant=Restaurant::find($request->id)->first();
    $restaurant->status = $request->status;
    $restaurant->start = $request->start;
    $restaurant->end = $request->end;
    $restaurant->name = $request->name;
    $restaurant->save();
    return $restaurant;
  }
  public function Changereservationstatus(Request $request)
  {
    $reservation=Setting::find(1)->first();
    $reservation->status = !$reservation->status;
    $reservation->save();
    return $reservation;
  }
  public function Changepaymentstatus(Request $request)
  {
    $payment=Setting::find(2);
    $payment->status = !$payment->status;
    $payment->save();
    return $payment;
  }
  public function showpaymentstatus(Request $request)
  {
    $payment=Setting::find(2);
    return $payment;
  }

  public function Showreservation(Request $request)
  {
    $reservation=Setting::find(1)->first();
    return ResponseService::success("show succ", $reservation->status);
  }










}
