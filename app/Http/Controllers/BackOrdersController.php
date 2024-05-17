<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Product;

class BackOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['orders'] = Order::latest()->paginate(10);

        return view('back-end.orders', $data);
    }

    public function pendingorders()
    {
        $data['orders'] = Order::where('delivery_status', 'pending')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.pendingorders', $data);
    }

    public function processingorders()
    {
        $data['orders'] = Order::where('delivery_status', 'processing')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.processingorders', $data);
    }

    public function holdingorders()
    {
        $data['orders'] = Order::where('delivery_status', 'hold')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.holdingorders', $data);
    }

    public function deliveredorders()
    {
        $data['orders'] = Order::where('delivery_status', 'delivered')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.deliveredorders', $data);
    }

    public function completeorders()
    {
        $data['orders'] = Order::where('delivery_status', 'complete')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.completeorders', $data);
    }

    public function shippingorders()
    {
        $data['orders'] = Order::where('delivery_status', 'shipping')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.shippingorders', $data);
    }

    public function canceledorders()
    {
        $data['orders'] = Order::where('delivery_status', 'cancel')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.canceledorders', $data);
    }

    public function filterOrder($status)
    {
        $data['orders'] = Order::where('delivery_status', $status)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('back-end.filter_order', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order_details = Order::with('order_details')->find($id);
        $products = OrderDetail::where('order_id', $id)->with('order','product')->get();
        //return $products;
        return view('back-end.vieworder', [
            'order' => $order_details,
            'products' => $products,
        ]);
    }
    public function order_print($id)
    {
        $order_details = Order::find($id);
        $products = OrderDetail::join('products', 'products.id', 'order_details.product_id')
            ->where('order_details.order_id', $id)
            ->get(['products.title', 'products.img1', 'order_details.product_qty', 'order_details.product_price', 'order_details.total_price', 'order_details.options']);
        //return $products;
        return view('back-end.invoice_print', [
            'order' => $order_details,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function orderaccept(Request $request, $id)
    {
        $order = Order::find($id);

        $order->status = $request->delivery_status;
        $order->delivery_status = $request->delivery_status;
        $order->save();
        return back()->with('msg-success', 'Order has been successfully updated');
    }

    public function updatePaymentstatus(Request $request, $id)
    {
        if (Auth::user()->id == 1) {
            $order = Order::find($id);
            $order->payment_status = $request->payment_status;
            $order->save();
            return back()->with('msg-success', 'Order has been successfully updated');
        } else {
            return back()->with('msg-error', 'Your are not eligible for edit');
        }
    }

    public function updateCustomer(Request $request, $order_id)
    {
        if (Auth::user()->id == 1) {
            $order = Order::find($order_id);
            $order->customer_name = $request->customer_name;
            $order->customer_email = $request->customer_email;
            $order->customer_phone = $request->customer_phone;
            $order->delivery_address = $request->delivery_address;
            $order->save();
            return back()->with('msg-success', 'Customer info successfully updated');
        } else {
            $order = Order::find($order_id);
            $order->customer_name = $request->customer_name;
            $order->customer_email = $request->customer_email;
            $order->save();
            return back()->with('msg-success', 'Customer info successfully updated');
        }
    }

    public function updateQt(Request $request, $details_id)
    {
        // Find the order
        $order = Order::find($request->order_id);

        // Check if order exists
        if (!$order) {
            return back()->with('msg-error', 'Order not found');
        }
        // Get the associated order details
        $myDetails = OrderDetail::findOrFail($details_id);
        $orderDetails = OrderDetail::findOrFail($details_id)->update([
            'product_qty' => $request->product_qty,
            'total_price' => $myDetails->product_price * $request->product_qty,
        ]);

        // Update product_qty for each order detail

        // dd($orderDetails, $request->all());

        // $orderDetails->product_qty = $request->product_qty;
        // $orderDetails->total_price = $myDetails->product_price * $request->product_qty;
        // $orderDetails->save();

        $subTotal = OrderDetail::where('order_id', $request->order_id)->sum('total_price');
        $order->update([
            'subtotal_cost' => $subTotal,
            'total_cost' => $subTotal + $order->deliver_cost,
        ]);

        return redirect('orders/'.$request->order_id)->with('msg-success', 'Quantity successfully updated');

    }

    public function updateDiscount(Request $request, $id)
    {
        $order = Order::find($id);
        $after_discount = $request->subtotal_cost + $request->deliver_cost - $request->discount;
        $order->total_cost = $after_discount;
        $order->discount = $request->discount;
        $order->save();
        return back()->with('msg-success', 'Discount successfully updated');
    }

    public function updateNotes(Request $request, $id)
    {
        $order = Order::find($id);
        $order->order_notes = $request->order_notes;
        $order->save();
        return back()->with('msg-success', 'Order notes successfully updated');
    }

    public function orderdelivered(Request $request, $id)
    {
        $order = Order::find($id);

        $order->delivery_status = 'Delivered';

        $order->save();

        return back()->with('msg-success', 'Order has been delivered successfully.');
    }

    public function ordercanceled(Request $request, $id)
    {
        $order = Order::find($id);
        $products = OrderDetail::where('order_id', $id)->get();
        foreach ($products as $product) {
            $p = Product::find($product->product_id);
            $p->qty = $p->qty + $product->product_qty;
            $p->save();
        }

        $order->status = 'cancel';
        $order->delivery_status = 'cancel';

        $order->save();

        return back()->with('msg-success', 'Order has been Canceled successfully.');
    }
    public function orderdelete(Request $request, $id)
    {
        Order::find($id)->delete();
        OrderDetail::where('order_id', $id)->delete();
        return back()->with('msg-success', 'Order has been deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
