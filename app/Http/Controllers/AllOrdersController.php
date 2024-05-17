<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderCustomer;
use App\Notifications\NewOrderAdmin;
use App\Product;
use App\Order;
use App\OrderDetail;
use App\Models\User;
use App\Notifysetting;
use App\Cart;
use Mail;

class AllOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function orderconfirm($id)
    {
      Cart::forget();

      $order_details = Order::find($id);
      $products = OrderDetail::join('products','products.id','order_details.product_id')
                  ->where('order_details.order_id',$id)->get(array('products.title','products.img1','order_details.product_qty','order_details.product_price','order_details.total_price','order_details.options'));
        //return $products;
        return view('front-end.orderconfirm', [
          'order_details' => $order_details,
          'products' => $products
        ]);
    }
    
    public function download_invoice($id)
    {
      Cart::forget();
      $order_details = Order::find($id);
      $products = OrderDetail::join('products','products.id','order_details.product_id')
                  ->where('order_details.order_id',$id)->get(array('products.title','products.img1','order_details.product_qty','order_details.product_price','order_details.total_price','order_details.options'));
        //return $products;
        return view('front-end.invoice_print', [
          'order' => $order_details,
          'products' => $products
        ]);
    }
    
    public function orderdetails($order_no)
    {
      $order_details = Order::where('tracking_no',$order_no)->first();
      $products = null;

      if(!$order_details == null){
        $products = OrderDetail::join('products','products.id','order_details.product_id')
        ->where('order_details.order_id',$order_details->id)->get(array('products.title','products.img1','order_details.product_qty','order_details.product_price','order_details.total_price'));
        //return $products;
      }
        return view('front-end.orderhistory', [
          'order_details' => $order_details,
          'products' => $products
        ]);
    }
    public function ordertrack(Request $request)
    {
      $phone = $request->phone;
      $products = null;

      $order_details = Order::where('customer_phone',$phone)->orderBy('id','DESC')->first();
      if($order_details){
        $products = OrderDetail::join('products','products.id','order_details.product_id')
        ->where('order_details.order_id',$order_details->id)->get(array('products.title','products.img1','order_details.product_qty','order_details.product_price','order_details.total_price'));
      }
        //return $products;
        return view('front-end.orderhistory', [
          'order_details' => $order_details,
          'products' => $products
        ]);
    }

    public function ordersubmit(Request $request)
    {
        //return $request->all();
        request()->validate([
          'customer_name' => 'required|min:3',
          'customer_mobile' => 'required|min:11|max:11',
          'customer_area' => 'required',
          'customer_address' => 'required',
          'note' => 'nullable'
        ]);

        $order_date = date('Y-m-d');
        $status = 'pending';

        $order = new Order();

        $order->order_date = $order_date;
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_mobile;
        $order->customer_email = $request->customer_email;
        
        $order->customer_area = $request->customer_area;
        $order->payment_method = $request->payment_method;
        $order->subtotal_cost = $request->subTotal;
        $order->deliver_cost = $request->delivery;
        $order->total_cost = $request->totalCost;
        $order->delivery_address = $request->customer_address;
        $order->division = $request->division;
        $order->district = $request->district;
        $order->upazila = $request->upazila;
        $order->note = $request->note;
        $order->delivery_status = $status;
        $order->status = $status;
        
        DB::table('customer')
        ->where('mobile', $request->customer_mobile)
        ->update([
            'name' => $request->customer_name,
            'mobile' => $request->customer_mobile,
            'address' => $request->customer_address,
        ]);

        $order->save();

        $order_id = $order->id;
        $tracking_no = $order_id.rand(1000000000,9999999999);

        $update_order = Order::find($order_id);
        $update_order->tracking_no = $tracking_no;
        $update_order->save();

        $products = $request->products;
        $qty = $request->qty;
        $price = $request->price;
        $total = $request->total;
        $var_colors = $request->has('var_colors') ? $request->var_colors : null;
        $var_sizes = $request->has('var_sizes') ? $request->var_sizes : null;

        $total_product = count($products);

        $sl = 1;
        for($i=0;$i<$total_product;$i++){
          $order_details = new OrderDetail();
          $options = ($request->has('var_colors') && isset($var_colors[$i])) ? $var_colors[$i] : null;
          $options .= ($request->has('var_sizes') && isset($var_sizes[$i])) ? $var_sizes[$i] : null;

        //   $options = $request->has('var_colors') ? $var_colors[$i] : null;
        //   $options .= $request->has('var_sizes') ? $var_sizes[$i] : null;

          $product = Product::find($products[$i]);
          $new_qty = $product->qty - $qty[$i];
          $product->qty = $new_qty;
          $product->save();

          $order_details->order_id = $order_id;
          $order_details->product_id = $products[$i];
          $order_details->product_qty = $qty[$i];
          $order_details->product_price = $price[$i];
          $order_details->total_price = $total[$i];
          $order_details->options = $options;
          $order_details->sts = 1;

          $order_details->save();

          $sl++;
        }

        $order = $update_order;

        $admin = Notifysetting::latest()->first();
        if($admin->notify_admin == 1 && $admin->admin_mail != null){
          Notification::route('mail',$admin->admin_mail)->notify(new  NewOrderAdmin($order));
        }
        if($admin->notify_customer == 1 && $request->customer_email != null){
          Notification::route('mail',$request->customer_email)->notify(new  NewOrderCustomer($order));
        }
        
        
        if ($request->payment_method == 'bkash') {
            Cart::forget();
            return redirect()->route('url-pay', $order_id)->with('msg', 'Thank you! Your order has been received.');
       
        } elseif ($request->payment_method == 'aamarpay') {
            Cart::forget();
            return redirect()->route('payment', $order_id)->with('msg', 'Thank you! Your order has been received.');
       
		} else {
            return redirect()->route('confirm', $order_id)->with('msg', 'Thank you! Your order has been received.');
        }
    
        
    }

    public function sendmail(){
        $order = Order::find(12);

        Notification::route('mail','robiulkarim139@gmail.com')->notify(new  NewOrderCustomer($order));
    }

    public function additem(Request $request)
    {
        $product = Product::find($request->product_id);
        $qty = $request->quantity;
        $color = $request->color;
        $size = $request->size;

        if($color && $size){
            Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $qty, 'price' => $product->sprice, 'weight' => 0, 'options' => ['color' => $color, 'size' => $size]]);
        } else if($color && !$size){
            Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $qty, 'price' => $product->sprice, 'weight' => 0, 'options' => ['color' => $color]]);
        } else if(!$color && $size){
            Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $qty, 'price' => $product->sprice, 'weight' => 0, 'options' => ['size' => $size]]);
        } else {
            Cart::add($product->id, $product->title, $qty, $product->sprice);
        }

        $totalItem = Cart::count();
        $totalAmount = Cart::subtotal();
        
        $data = array(
          'totalItem' => $totalItem,
          'totalAmount' => $totalAmount
        );
        return json_encode($data);
      
        return view('front-end.cart');
    }

    public function cart()
    {
        session_start();
        
        $cartItems = Cart::content();
        $subTotal = Cart::subtotal(0,'','');
        $more = Product::with('products_categories')->where('products.status','publish')->orderBy('products.title', 'DESC')->groupBy('products.id')->take(30)->get();
        $smsActivity = DB::table('sms_config')->where('id', 1)->first();
        
        if($smsActivity->activity == 1){
            $mobileNumber = $_SESSION['mobileNumber'] ?? null; // Use the null coalescing operator to provide a default value if 'mobileNumber' is not set
            $customer = DB::table('customer')->where('mobile', $mobileNumber)->first();
            if ($customer && $mobileNumber == $customer->mobile && $customer->verify == 1) {
                // Mobile number matches, customer exists, and verify is equal to 1, render cart view
                return view('front-end.cart', [
                    'cartItems' => $cartItems,
                    'subTotal' => $subTotal,
                    'customer' => $customer,
                    'related' => $more
                ]);
            } else {
                // Mobile number doesn't match, customer not found, or verify is not equal to 1, render verify_mobile view
                return view('front-end.verify_mobile');
            }
            
         }else{
        
            // SMS activity is not equal to 1, render cart view with default values
            return view('front-end.cart', [
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
                'customer' => null,
                'related' => $more
            ]);
            
        }
        
        
        
        
        
    }

    public function cartupdate(Request $request)
    {
        Cart::update($request->id, $request->qty);

        //return $request->rowId;

        $total = Cart::total($request->id);
        $totalItem = Cart::count();
        $totalAmount = Cart::subtotal();

        $data = array(
          'total' => $total,
          'totalItem' => $totalItem,
          'totalAmount' => $totalAmount
        );
        return json_encode($data);
    }

    public function cartremove(Request $request)
    {
        Cart::remove($request->rowId);

        //return $request->rowId;

        $totalItem = Cart::content()->count();
        $totalAmount = Cart::total(0,'','');

        $data = array(
          'totalItem' => $totalItem,
          'totalAmount' => $totalAmount
        );
        return json_encode($data);
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
        //
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
