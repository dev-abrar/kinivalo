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
        .orderinfo {
            font-size: 17px;
            padding-bottom: 5px;
        }
        .inv_title {
            color: #ff1919;
        }
        .inv_vox{
            border: solid 5px #e62e04;
            padding: 20px;
            margin: auto 10%;
            min-height: 400px;
        }
    </style>
</head>
<body onload="print_onload()">
<div class="wrapper inv_vox">
    <section class="invoice">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 text-center">
                        <img src="{{ asset('/') }}{{$basic->logo}}" style="margin: 20px;  width:400px;">
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div style="border: 1px solid #ccc;text-align:center;margin:6px 0 15px 0;width:100%;padding: 0 !important;">
               
            </div>
        </div>

        <!-- info row -->
        <div class="row invoice-info" style="font-weight:600;">
            <div class="col-sm-6 invoice-col">
                <address>
                    <h2 class="inv_title">INVOICE</h2>
                    <div class="orderinfo">Invoice: {{$order->tracking_no}} </div>
                    <div class="orderinfo">Date:  {{$order->order_date}} </div>
                    <div class="orderinfo">Payment: Cash on Delivery </div>
                </address>
            </div>
            <div class="col-sm-6 invoice-col text-right">
                <address>
                    <h2 class="inv_title">SHIP TO </h2>
                    <div class="orderinfo">Name : {{$order->customer_name}}</div>
                    <div class="orderinfo">Phone Number  : {{$order->customer_phone}}</div>
                    <div class="orderinfo"> Delivery Address : {{$order->delivery_address}}</div>
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
                                <td>{{ $product->title }} {{$product->options}}</td>
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
                <div class="col-7">
                    
                </div>
                <div class="col-5">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Delivery Cost:</td>
                                <td>৳ {{ number_format($order->deliver_cost,2) }}</td>
                            </tr>
                            <tr>
                                <td>Tax:</td>
                                <td>৳ 0</td>
                            </tr>
                            <tr class="custom" style="font-weight: bold !important; font-size: 20px !important;">
                                <td style="padding: 8px 14px;"> Total:</td>
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
