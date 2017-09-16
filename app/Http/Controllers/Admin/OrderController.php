<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderItem;
use App\OrderShipping;
use App\ProductStock;

class OrderController extends Controller
{
    private $editStatusOptions = ['PAYMENT_CONFIRMATION'=>'PAYMENT_CONFIRMATION', 'PAID'=>'PAID', 'CANCELLED' => 'CANCELLED',];
    private $statusOptions = ['ALL'=>'ALL', 'PAYMENT_CONFIRMATION'=>'PAYMENT_CONFIRMATION', 'PAID'=>'PAID', 'CANCELLED' => 'CANCELLED',];
    private $paymentConfirmation = 'PAYMENT_CONFIRMATION';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $filter = new \stdClass;
        $filter->status = $this->paymentConfirmation;
        $filter->email = '';

        $statusOptions = $this->statusOptions;
        $orders = Order::getByStatus($this->paymentConfirmation)->get();
        return view('admin.order.index' , compact('orders', 'statusOptions', 'filter'));
    }

    public function search(Request $request)
    {
        $filter = new \stdClass;
        $filter->status = $request->status;
        $filter->email = $request->email;

        $statusOptions = $this->statusOptions;
        // find search by what 
        // adjust searching method
        $orders = null;
        if( $request->status == 'ALL' )
        {
            $orders = Order::all();
        }
        else
        {
            $orders = Order::getByStatus($request->status)->get();
        }
        
        return view('admin.order.index' , compact('orders', 'statusOptions', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404, 'Not implemented');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404, 'Not implemented');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404, 'Not implemented');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = (object) [
            'title' => 'Order Edit'
        ];
        $order = Order::find($id);
        $orderShippings = OrderShipping::getByOrderId($id)->get();
        $orderItems = OrderItem::getByOrderId($id)->get();

        $editStatusOptions = $this->editStatusOptions;

        return view('admin.order.edit', compact('page', 'order', 'orderShippings', 'orderItems', 'editStatusOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        // if old status SOLD or PAID, reject changes
        if($order->status == 'SOLD' || $order->status == 'PAID')
        {
            return 'rejected';
        }
        // if old status PAYMENT_CONFIRMATION, new PAID -> move holding to sold
        else if($order->status == 'PAYMENT_CONFIRMATION' && $request->status == 'PAID')
        {
            
            // fetch product stock
            // revert productStock.holding = orderItem.qty

            // fetch order items
            $orderItems = OrderItems::GetByOrderId($order->id)->get();
            foreach($orderItems as $orderItem)
            {
                $productStock = ProductStock::productId($orderItem->product_id)->sizeId($orderItem->size_id)->get();

                // move from holding to sold
                $productStock->stock_holding -= $orderItem->count;
                $productStock->stock_sold += $orderItem->count;
                $productStock->save();
            }
        }
        // if old status PAYMENT_CONFIRMATION, new CANCELLED -> then revert hold stock
        else if($order->status == 'PAYMENT_CONFIRMATION' && $request->status == 'CANCELLED' )
        {
             // fetch order items
            $orderItems = OrderItems::GetByOrderId($order->id)->get();
            foreach($orderItems as $orderItem)
            {
                $productStock = ProductStock::productId($orderItem->product_id)->sizeId($orderItem->size_id)->get();

                // move from holding to available stock
                $productStock->stock_holding -= $orderItem->count;
                $productStock->stock += $orderItem->count;
                $productStock->save();
            }
        }
        // else should be from PAYMENT_CONFIRMATION to PAYENT_CONFIRMATION -> then don't update stock, only update reason
        $order->status = $request->status;
        $order->reason = $request->reason;
        $order->save();

        session()->flash('message', $order->status.' successfully');
        return redirect('admin/order/'.$order->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404, 'Not implemented');
    }
}
