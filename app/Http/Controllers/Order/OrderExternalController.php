<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrintController;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use App\Models\Order\OrderExternalUser;
use App\Models\ProductType;
use App\Models\TypeOrder;
use App\HTTP\Responses\ResponseService;
use App\Models\Restaurant\Restaurant;
use Exception;
use Throwable;

use App\Services\Order\OrderExternalService;
use App\Services\SettingRestaurant\SettingRestaurantServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\PrintConnector;

class OrderExternalController extends Controller
{

  private OrderExternalService  $order;

  public function __construct(OrderExternalService $order)
  {
    $this->order = $order;
  }
  public function store(Request $request)
  {

    try {
      $order = $this->order->order2($request);
      $orderprint = Order::with('orderDetalis.productType', 'notes', 'offers.offerDetails.productType', 'notes')->find($order);
      Printcontroller::printInvoice($orderprint);
      if ($order == 'product not found') {
        return ResponseService::error("product not found", "");
      }
      if ($order == 'address not found') {
        return ResponseService::error("address not found", "");
      }
      return response()->json(
        [
          'status' => 200,
          'id' => $order->id,
          'message' => 'تم الطلب بنجاح '
        ]
      );
    } catch (Throwable $exception) {

      return ResponseService::error($exception->getMessage(), 'An error occurred');
    }
  }

  public function show()
  {
    // $order=Order::find(20);
    // return $order->orderExternal->with('adderess');
    return  $authors = OrderExternalUser::whereHas('order', function ($query) {
      $query->where('order_id', '=', 20)->select('id');
    })->with([
      'order.orderDetalis.productType.product',
      'user',
      'street.region.city',
    ])->get();
  }
}
