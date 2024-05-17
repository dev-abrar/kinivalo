<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>#{{ $order->tracking_no }} Invoice - Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style type="text/css" >
        .bottom-part {
            display: none;
        }
        @media print {
            body {-webkit-print-color-adjust: exact;}
            .table th {
                background-color: #e4e4e4 !important;
            }
            .table tr.custom td {
            }
            .bottom-part {
                display: block;
            }
            #print_btn {
                display: none;
            }
        }
    </style>
</head>
<body onload="print_onload()">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <button class="btn btn-success" id="print_btn" style="background: #980647 !important;position: fixed;top:50px;left: 0px;width: 150px; z-index: 100;">Print(Crt+P)</button>
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <div class="row">
                     <small><div style="position: absolute;">Print date: {{ date('Y-m-d h:i:s A') }}</div></small>
                    <div class="col-6 text-left">
                        <h2 class="page-header" style="font-size: 100px;font-weight: 600;">INVOICE</h2>
                    </div>
                    <div class="col-6 text-right">
                        <img src="{{ asset('/') }}{{$basic->logo}}" style="margin-top: 10px; width:400px;">
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <dive style="border: 1px solid #ccc;text-align:center;margin:6px 0 15px 0;width:100%;padding: 0 !important;">
               
            </dive>
        </div>

        <!-- info row -->
        <div class="row invoice-info" style="font-weight:600;">
            <div class="col-sm-6 invoice-col">
                <address>
                    <div>Invoice No : {{$order->tracking_no}}</div>
                    <div>Order Date  : {{$order->order_date}}</div>
                    <div> Phone : {{$basic->contact_no}}</div>
                    <div> Email address : {{$basic->email_address}}</div>
                    <div> Address : {{$basic->address}}</div>
                </address>
            </div>
            <div class="col-sm-6 invoice-col text-right">
                <address>
                    <div>Name : {{$order->customer_name}}</div>
                    <div>Phone Number  : {{$order->customer_phone}}</div>
                    <div> Delivery Address : {{$order->delivery_address}}</div>
                    <div> Customer Note : You can check the parcel.Cannot return a used parcel</div>
                </address>
            </div>
          
        </div>
        <!-- /.row -->
        <div style="height:70vh;">
            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="background:#e4e4e4;">
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php( $sl = 1 )
                        @foreach($products as $product)
                            <tr>
                                <td><img src="{{url('image/product_image')}}/{{ $product->img1 }}" width="50"  /> &nbsp;{{ $product->title }} {{$product->options}}</td>
                                <td>৳ {{$product->product_price}}</td>
                                <td>{{$product->product_qty}}</td>
                                <td>৳ {{$product->total_price}}</td>
                            </tr>
                            @php($sl++)
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-7">
                    <p class="lead">Note: {{$order->order_notes}}</p>
                </div>
                <!-- /.col -->
                <div class="col-5">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width:50%">Subtotal:</td>
                                <td>৳ {{ number_format($order->subtotal_cost,2) }}</td>
                            </tr>
                            <tr>
                                <td>Delivery Cost:</td>
                                <td>৳ {{ number_format($order->deliver_cost,2) }}</td>
                            </tr>
                            <tr>
                                <td>Discount:</td>
                                <td>৳ {{ number_format($order->discount,2) }}</td>
                            </tr>
                            <tr class="custom" style="font-weight: bold !important; font-size: 20px !important;">
                                <td style="padding: 8px 14px;">Invoice Total:</td>
                                <td style="padding: 8px 14px;">৳ {{ number_format($order->total_cost,2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
<script>
    document.getElementById("print_btn").addEventListener("click", function () {
        window.print();
    });
    function print_onload() {
        //window.print();
    }
</script>
</body>
</html>
