<?php

namespace App\Http\Controllers\WaiterSystem;

use App\Enums\OrderStatus;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Address\Address;
use App\Models\Order\Order;
use App\Models\Waiter;
use App\Models\User;
use App\Services\Address\AddressServices;
use App\Services\Waiter\WaiterServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Throwable;

class WaiterController extends Controller
{
    private     WaiterServices $waiterServices;
    private AddressServices $addressServices;
    public function __construct(WaiterServices $waiterServices)
    {
        $this->waiterServices = $waiterServices;
    }
    public function ss(Request $request)
    {

        try {
            $data = $this->waiterServices->ss($request);
            return  $data;
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function show(Request $request)
    {

        try {

            $user = Auth::id();
            $orders = Waiter::with('order.table')->where('waiter_id', $user)->get();
           $aa=[];
            foreach ($orders as $or) {
                // return $or;
                if ($or->order->status_order == 1) {
                    $aa[] = $or;
                }
            }
            return $aa;
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    public function showdeliveryorder(Request $request)
    {

        try {

                $user = Auth::id();
            $aa=[];
               $orders = Waiter::with('order.orderExternal.userAddress.user')->where('waiter_id', $user)->get();
             foreach( $orders as  $order){
                // return $order;
                if ($order->order->status_order == 1) {
               $address = $order->order->orderExternal->userAddress->address_id;
               $child = Address::find($address);
               $this->addressServices = new AddressServices();
               $ancestors=   $this->addressServices-> showuseraddress($address);
               $order['address']= $ancestors;
       $aa[]= $order;
            }}
       return $aa;
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }




    public function changestatus(Request $request)
    {

        try {
            $order = Order::find($request->id);
            $order->update([
                'status_order' => OrderStatus::delivered,
            ]);
            return ResponseService::success("order delivered succ", $order);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public static function  SelectDelevary(Request $request)
    {
        $waiters =  Role::where('name', 'delivery')->first()->users()->with('Employee.transports')->get();
        // $array[] = null;
        foreach ($waiters as $waiter) {
            if ($waiter->Employee->active != null && $waiter->Employee->transports->transport_id == $request->transport_id) {
                $array[] = $waiter->id;
                echo 1;

            }
        }
        $lastwaiter = null;
        $lasts = Waiter::with('user.employee.transports')->where([['jobs', $request->jobs]])->orderBy('id', 'DESC')->get();
        foreach ($lasts as $last) {
            if ($last->user->Employee->transports->transport_id == $request->transport_id) {
                $lastwaiter = $last->user->id;
                break;
            }
        }
        $index = -1;
        if ($lastwaiter) {
            $index = array_search($lastwaiter, $array);
        }
        //   echo $index+1;
        if (count($array) > $index + 1) {
            $request['waiter_id'] = $array[$index + 1];
        } else {
            $request['waiter_id'] =   $array[0];
        }
        return  $rr = Waiter::create($request->all(['waiter_id', 'jobs', 'order_id']));
    }
}
