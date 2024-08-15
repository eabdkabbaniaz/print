<?php

namespace App\Http\Controllers\PreparatioSection;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WaiterSystem\WaiterController;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Jobs\SendCustomerNotification;
use App\Jobs\SendEmployeeNotification;
use App\Jobs\SendWaiterEmployeeNotification;
use App\Models\Order\OrderDetalis;
use App\Models\TransportationCost;
use App\Models\User;
use App\Notifications\NewOrderForDelivery;
use PhpParser\Node\Stmt\Return_;
use App\Services\Waiter\WaiterServices;


class HeadPreparationController extends Controller
{
    private WaiterController $waiterController;

    public function __construct(WaiterServices $waiterServices)
    {
        // إنشاء كائن من الفئة WaiterController وتمرير WaiterServices
        $this->waiterController = new WaiterController($waiterServices);
    }



    public function ex(Request $request)
    {

        $products = $request->input('products');

        foreach ($products as $product) {
            $total_price = $product['price_per_one'] * $product['amount'];
            return     $d = [
                'product_id' => $product['product_id'],
                'amount' => $product['amount'],
                'price_pre_one' => $product['price_per_one'],
                'order_id' => 31,
                'total_price' => $total_price,
            ];
        }
    }


    public function update(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $order = Order::where('id', $order_id)->first();
            if (!$order) {
                return ResponseService::error('Order not found', 'Error');
            }
            $order->update([
                'status_order' => OrderStatus::READY,
            ]);

            $request['jobs'] = $order->type_id == OrderType::EXTERNAL ? 1 : 0;
            $request['order_id'] = $request->order_id;


            if ($order->type_id == OrderType::EXTERNAL) {
                $customer_id =     $order->orderExternal->userAddress->user->id;

                $user = User::find($customer_id);
                if ($user) {
                    dispatch(new SendCustomerNotification($order_id, $user));
                    
                    $request['transport_id'] = $order->orderExternal->transportcost->transport_id;
                    $delivery_id = WaiterController::SelectDelevary($request);
                    $user = User::find($delivery_id)->first();
                    if ($user) {
                        dispatch(new SendEmployeeNotification($order_id, $user));
                    } else {
                        return 'user not found';
                    }
                } else {
                    return 'user not found';
                }
              
            } else if ($order->type_id == OrderType::INTERNAL) {
                $delivery_id = $this->waiterController->ss($request);

                $user = User::find($delivery_id);
                if ($user) {
                    dispatch(new SendWaiterEmployeeNotification($order_id, $user));
                } else {
                    return 'user not found';
                }
            }






            return ResponseService::success('تم تاكيد تجهيز الطلبية بنجاح بنجاح', " ");
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function getadderss(Request $request)
    {
        $order = Order::with([
            'orderDetalis.productType.category.section',
        ])->find($request->id);
        $section = [];
        foreach ($order->orderDetalis as $or) {
            $section[] =
                $or->productType->category->section_id;
        }
        if (count(array_unique($section)) === 1) {
            return $section[0];
        } else {
            return array_unique($section);
        }
    }
}