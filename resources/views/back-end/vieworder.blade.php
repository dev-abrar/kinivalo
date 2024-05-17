@extends('back-end.admin')

@section('title')
View Order
@endsection


@section('content')
<section class="content">
  <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-info">
          <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-3">
                  <h4><i class="fas fa-globe"></i> Order Details</h4>
                </div>
                @php
                  $delivery_status = $order->first()->delivery_status;
                  $payment_status = $order->first()->payment_status;
                @endphp
                <div class="col-3">
                    <form action="{{ url('orders/'.$order->id)}}" method="POST">
                    @csrf
                    <select name="delivery_status" class="form-control" onchange='this.form.submit()'>
                        <option value="pending" @if ($order->delivery_status == 'pending') selected @endif>Pending</option>
                        <option value="processing" @if ($order->delivery_status == 'processing') selected @endif>Processing</option>
                        <option value="hold" @if ($order->delivery_status == 'hold') selected @endif>Hold </option>
                        <option value="cancel" @if ($order->delivery_status == 'cancel') selected @endif>Cancel</option>
                        <option value="complete" @if ($order->delivery_status == 'complete') selected @endif>Complete</option>
                        <option value="return" @if ($order->delivery_status == 'return') selected @endif>Return</option>
                        <option value="shipping" @if ($order->delivery_status == 'shipping') selected @endif>Shipping</option>
                        <option value="delivered" @if ($order->delivery_status == 'delivered') selected @endif>Deliverd</option>
                    </select>
                    </form>
                </div>
                <div class="col-3">
                    <form action="{{ url('orders/payment/'.$order->id)}}" method="POST">
                    @csrf
                    <select name="payment_status" class="form-control" onchange='this.form.submit()'>
                        <option value="paid" @if ($order->payment_status == 'paid') selected @endif>Paid</option>
                        <option value="unpaid" @if ($order->payment_status == 'unpaid') selected @endif>Unpaid</option>
                    </select>
                    </form>
                </div>
                <div class="col-3">
                  <h4><small class="float-right">Date: {{$order->order_date}}</small></h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-8 invoice-col">
                  <b>Customer Info</b>
                  <form action="{{ url('orders/customerinfo/'.$order->id)}}" method="POST">
                    @csrf
                    <div> <input name="customer_name" value="{{$order->customer_name}}" class="cusmerinput"> </div>
                    <div> Phone: <input name="customer_phone" value="{{$order->customer_phone}}" class="cusmerinput"> </div>
                    <div> Email: <input name="customer_email" value="{{$order->customer_email}}" class="cusmerinput"> </div>
                    <div> Address: <input name="delivery_address" value="{{$order->delivery_address}}" class="cusmerinput"> </div>
                    <button class="cbtn" type="submit">submit</button>
                  </form>
               
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <br>
                  <b>Order ID:</b> {{$order->tracking_no}}<br>
                  <b>Payment:</b> {{ucfirst($order->payment_method)}}<br>
                  <b>Payment Status: </b><span style="color:;">{{ucfirst($order->payment_status)}}</span><br>
                  <b>Delivery Status: </b><span style="color:green;">Order {{ucfirst($order->delivery_status)}}</span><br>
                </div>
                
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>SL#</th>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                      @php( $sl = 1 )
                      {{-- @dd($products) --}}
                      @foreach($products as $product)
                      <tr>
                        <td>{{ $sl++ }}</td>
                        <td><img src="{{url('image/product_image')}}/{{ $product->product->img1 }}" width="50"  /> &nbsp;{{ $product->product->title }} {{$product->options}}</td>
                        <td>
                          <td>
                              <form class="update-quantity-form" id="update-quantity-form-{{ $product->id }}" action="{{ url('orders-qt/'.$product->id )}}" method="POST">
                                  @csrf
                                  <input type="hidden" name="order_id" value="{{ $order->id }}">
                                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                                  <input size="4" name="product_qty" type="number" value="{{$product->product_qty}}" class="cusmerinput">
                                  <button class="cbtn" type="submit">submit</button>
                              </form>
                          </td>
                          
                            </td>
                        <td>৳ {{$product->product_price}}</td>
                        <td>৳ {{$product->total_price}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <!--<p>{{$order->note}}</p>-->
                <div class="col-6">
                  <form action="{{ url('orders/notes/'.$order->id)}}" method="POST">
                    @csrf
                    <p class="lead">Note:</p>
                    <textarea class="form-control" name="order_notes" rows="">{{$order->order_notes}}</textarea>
                    <button class="cbtn" type="submit">submit</button>
                   </form>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>৳ {{$order->subtotal_cost}}</td>
                        <td></td>
                      </tr>
                      <tr>
                        <th>Delivery Cost:</th>
                        <td>৳ {{$order->deliver_cost}}</td>
                        <td></td>
                      </tr>
                      <tr>
                        <form action="{{ url('orders/discount/'.$order->id)}}" method="POST">
                        @csrf
                        <input name="subtotal_cost" type="hidden" value="{{$order->subtotal_cost}}">
                        <input name="deliver_cost" type="hidden" value="{{$order->deliver_cost}}">
                        <th>Discount ৳:</th>
                        <td><input name="discount" type="number" value="{{$order->discount}}" class="cusmerinput"></td>
                        <td><button class="cbtn" type="submit">submit</button></td>
                        </form>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>৳ {{$order->total_cost}}</td>
                        
                        <td></td>
                      </tr>
                    </tbody></table>
                  </div>
                  

                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                    <h4>Customer Note</h4>
                <p> {{$order->note}}</p>
                  <a href="{{ url('orders/print/'.$order->id)}}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
             
                </div>
              </div>
            </div>
          <!-- /.invoice -->
        </div>
      </div>
  </div><!--/. container-fluid -->


</section>

@endsection

@section('script')
  @foreach(['success','error'] as $type)
      @if(Session::has('msg-'.$type))
        toastr.{{ $type }}('{{ Session::get('msg-'.$type) }}');
      @endif
  @endforeach

@endsection
