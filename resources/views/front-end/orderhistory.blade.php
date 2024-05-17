@extends('front-end.master')

@section('title')
Order History
@endsection

@section('content')
<section class="best_seller_product order_history" id="main_content_area">
    <section class="details_section">
      <div class="container">
        <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-sm-offset-2  col-md-offset-2  col-xl-offset-2 first_col">

                    <div class="panel panel-info">
                      @if($products)
                        <div class="panel-heading"><strong> Customer Information  </strong></div>
                        <div class="panel-body">
                            <table class="table table-bordered first_table">
                                <tbody id="CustomerOrderData">
                                        <tr>
                                          <td> Name</td>
                                          <td> {{$order_details->customer_name}}</td>
                                        </tr>
                                        <tr>
                                            <td> Phone</td>
                                            <td>  {{$order_details->customer_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td> Area</td>
                                            <td> @if($order_details->customer_area == 1) Inside Dhaka @else Outside Dhaka @endif </td>
                                        </tr>
                                        <tr>
                                            <td> Shipping Address</td>
                                            <td> {{$order_details->delivery_address}} </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <br />
                        <div class="panel-heading second_panel_heading"><strong> Order Information  </strong>
                          <span> <u>Order Date</u>: {{$order_details->order_date}} </span>
                          <div class="empty_div"></div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered second_table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody id="CustomerOrderData">
                                        @foreach($products as $product)
                                        <tr class="diff_tr">
                                            <td>
                                                <img class="img-responsive" src="{{asset('/')}}image/product_image/{{$product->img1}}">
                                                {{$product->title}} <br>
                                                <strong>৳ {{$product->product_price}} ✖ {{$product->product_qty}}</strong>
                                            </td>
                                            <td><strong>৳ {{$product->total_price}}</strong></td>
                                        </tr>
                                        @endforeach
                                        <tr class="same_tr">
                                          <td> Delivery Cost</td>
                                          <td>  ৳ {{$order_details->deliver_cost}}</td>
                                        </tr>
                                        <tr class="same_tr">
                                            <td> Total</td>
                                            <td>  ৳ {{$order_details->total_cost}}</td>
                                        </tr>
                                        <tr class="same_tr">
                                            <td> Order Number</td>
                                            <td> {{$order_details->tracking_no}} </td>
                                        </tr>
                                        <tr class="same_tr">
                                            <td> Order Status</td>
                                            <td> {{ucfirst($order_details->delivery_status)}} </td>
                                        </tr>
                                        <tr  class="same_tr">
                                            <td> Payment Method</td>
                                            <td> Cash On Delivery </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        @else
                        <h3 class="last_heading">কোনো অর্ডার পাওয়া যায়নি!!</h3>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 purchase_div">
                    <center>
                        <a href="{{ url('/') }}" class="btn btn-info"> কেনাকাটা করুন </a>
                    </center>
                </div>
        </div>
    </div>
    </section>
</section>
@endsection
