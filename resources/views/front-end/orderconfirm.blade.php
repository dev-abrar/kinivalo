@extends('front-end.master')

@section('title')
Order Confirmation
@endsection


@section('content')
@push('css')
@endpush
<section class="best_seller_product order_confirmation" id="main_content_area">
    <section class="details_section">
      <div class="container">
        <div class="row">
            <div class="orderbody panel-body">
                    <div class="col-lg-12 col-md-8 col-sm-8 col-xs-12 text-center orderlogo">
                       <a href="{{ route('/') }}"><img src="{{ asset('/') }}{{$basic->logo}}" width="30%" title="{{$basic->name}}"></a>
                   </div>
                   <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
                       <h2 class="inv_title">INVOICE</h2>
                       <div class="orderinfo">Invoice: {{$order_details->tracking_no}} </div>
                       <div class="orderinfo">Date: {{$order_details->order_date}}</div>
                       <div class="orderinfo">Payment: Cash On Delivery</div>
                   </div> 
                   <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12 text-right">
                       <h2 class="inv_title">SHIP TO </h2>
                       <div class="orderinfo">Name: {{$order_details->customer_name}}</div>
                       <div class="orderinfo">Phone: {{$order_details->customer_phone}}</div>
                       <div class="orderinfo">Address: {{$order_details->delivery_address}}</div>
                   </div>
                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"><strong class="strong_one">Order Information</strong></div>
                        <div class="panel-body" style="padding: 0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody id="CustomerOrderData">
                                        @foreach($products as $product)
                                        <tr class="first_tr">
                                            <td>
                                                {{$product->title}}{{$product->options}} <br>
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
                                            <td>Tax</td>
                                            <td>৳ 0 </td>
                                        </tr>
                                        <tr class="same_tr">
                                            <td> Total</td>
                                            <td> ৳ {{$order_details->total_cost}}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
        </div>
        
                <iframe style="display:none;" id="pdfViewer" src="{{ url('order/download_invoice/'.$order_details->id)}}"></iframe>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 empty_div">
                    <center>
                   
                  <button id="printButton" class="btn btn-info btn_one"> Download Invoice </button>

                    </center></br>
                    <center>
                        <a href="{{ url('/') }}" class="btn btn-info last_a"> কেনাকাটা করুন </a>
                    </center>
                </div>
        </div>
    </div>
    </section>
</section>
<style>
.centered-notification {
background-color: #f0f0f0;
color: green;
padding: 10px;
position: fixed;
top: 80%;
left: 50%;
transform: translate(-50%, -50%);
border-radius: 5px;
/*width: 450px;*/
/*height: 150px;*/
text-align:center;
font-size:35px;
padding-top: 16px;
border:solid 3px red;
}
</style>
<script>
  // Get the iframe element
  var pdfViewer = document.getElementById('pdfViewer');

  // Add an event listener to the Print button
  document.getElementById('printButton').addEventListener('click', function() {
    // Set the iframe source if it's not already loaded
    if (!pdfViewer.src) {
      pdfViewer.src = "{{ url('order/download_invoice/'.$order_details->id)}}";
    }

    // Show the hidden iframe
    pdfViewer.style.display = 'none';

    // Trigger the print dialog for the iframe content
    pdfViewer.contentWindow.print();
  });
</script>

<script>
function showNotification() {
    // Use SweetAlert2 to create a notification
    Swal.fire({
        title: 'Order Placed Successfully',
        html: 'আপনার অর্ডারটি সফলভাবে সম্পন্ন  হয়েছে । আমাদের কল সেন্টার থেকে ফোন করে আপনার অর্ডারটি কনর্ফাম করা হবে ।',
        icon: 'success',
        confirmButtonText: 'CHECK-INVOICE',
        showConfirmButton: true,
        customClass: {
            confirmButton: 'custom-confirm-button',  // Apply the custom class to the confirm button
            icon: 'custom-icon',  // Apply the custom class to the icon
             popup: 'custom-popup'  // Apply custom class to the popup box
        }
    });
}

// Automatically show the notification when the page loads
window.onload = showNotification;
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@endsection
