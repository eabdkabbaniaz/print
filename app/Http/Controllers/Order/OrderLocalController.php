<?php

namespace App\Http\Controllers\Order;

use App\Enums\InvoiceStatus;
use App\Models\Order\Order;
use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrintController;
use App\Http\Responses\ResponseService;
use App\Models\Order\OrderDetalis;
use Illuminate\Http\Request;
use App\Services\Order\OrderLocalService;
use App\Services\SettingRestaurant\SettingRestaurantServices;

class OrderLocalController extends Controller
{

  private OrderLocalService  $order;


  public function __construct(OrderLocalService $order)
  {
    $this->order = $order;
  }
  public function store(Request $request)
  {
    $order_id = $this->order->store($request);
    $orderprint = Order::with('orderDetalis.productType', 'notes', 'offers.offerDetails.productType', 'notes')->find($order_id);
    PrintController::printInvoice($orderprint);
    return ResponseService::success('Order placed successfully');
  }
}
