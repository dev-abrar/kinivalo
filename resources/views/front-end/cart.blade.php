@extends('front-end.master')

@section('title')
@endsection

@section('content')
    @push('css')
    @endpush
    <section class="best_seller_product cart_page" id="main_content_area">
        <section class="details_section">
            <div class="container">
                @if (Cart::count())
                    <form action="{{ url('/order/submit') }}" method="post" id="order_details" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="rown first_rw">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col_one">
                                <div class="panel panel-success">
                                    <div class="panel-heading first_heading">
                                        <p> অর্ডারটি কনফার্ম করতে
                                            আপনার নাম, মোবাইল নাম্বার এবং ঠিকানা লিখে নিচে <span>অর্ডার কনফার্ম করুন</span> বাটনে ক্লিক করুন। 
                                        </p>
                                    </div>
                                    <div class="panel-body first_panel">
                                        <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12">
                                            <div class="form-group same_form">
                                                <!--<input name="product_id" type="hidden" value="">-->
                                                <p><b>Apner Name / আপনার নাম</b></p>
                                                @if ($customer)
                                                    <input
                                                        name="customer_name" type="text" class="form-control"
                                                        placeholder=" এখানে আপনার নাম লিখুন" aria-describedby="basic-addon1"
                                                        value="{{ $customer->name }}">
                                                @else
                                                    <input
                                                        name="customer_name" type="text" class="form-control"
                                                        placeholder=" এখানে আপনার নাম লিখুন"
                                                        aria-describedby="basic-addon1">
                                                @endif

                                                @error('customer_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group same_form">
                                                <p><b>Mobile Number</b></p>
                                                @if ($customer)
                                                    <input readonly type="number"                                                    
                                                        name="customer_mobile" min="11" max="11" required
                                                        class="form-control"
                                                        placeholder="ইংরেজি সংখ্যায় মোবাইল নাম্বার লিখুন"
                                                        aria-describedby="basic-addon1" value="{{ $customer->mobile }}">
                                                @else
                                                    <input type="number"
                                                        name="customer_mobile" min="11" max="11" required
                                                        class="form-control"
                                                        placeholder="ইংরেজি সংখ্যায় মোবাইল নাম্বার লিখুন"
                                                        aria-describedby="basic-addon1">
                                                @endif

                                                @error('customer_mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group same_form">
                                                <p><b>আপনার এলাকা সিলেক্ট করুন</b></p>
                                                <select id="dArea" onchange="UpdateOrderInfo(this.value)"
                                                    name="customer_area" required="required" class="form-control">
                                                    <option value="" disabled>আপনার এলাকা নির্বাচন করুন</option>
                                                    <option value="1">ঢাকা সিটিতে - ৳{{ $basic->delivery_cost1 }}</option>
                                                    <option selected value="2"> ঢাকা সিটির বাহিরে - ৳{{ $basic->delivery_cost2 }}</option>
                                                </select>
                                                @error('customer_area')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group same_form">
                                                <p><b> আপনার ঠিকানা লিখুন </b></p>
                                                @if ($customer)
                                                    <textarea class="form-control" name="customer_address" required=""
                                                        placeholder="Apner Thikana Likhun / আপনার ঠিকানা লিখুন" spellcheck="false">{{ $customer->address }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="customer_address" required=""
                                                        placeholder="Apner Thikana Likhun / আপনার ঠিকানা লিখুন" spellcheck="false"></textarea>
                                                @endif

                                                @error('customer_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group diff_form">

                                                @php
                                                    $bkash = DB::table('payment_config')
                                                        ->where('id', 1)
                                                        ->value('activity');
                                                @endphp
                                                @php
                                                    $cod = DB::table('payment_config')
                                                        ->where('id', 2)
                                                        ->value('activity');
                                                @endphp
                                                @php
                                                    $aamarpay = DB::table('payment_config')
                                                        ->where('id', 3)
                                                        ->value('activity');
                                                @endphp
                                                @php
                                                    $nagad = DB::table('payment_config')
                                                        ->where('id', 4)
                                                        ->value('activity');
                                                @endphp

                                                <div class="radio-container">
                                                    @if ($cod == 1)
                                                        <input type="radio" checked id="option1"
                                                            name="payment_method" value="cash_on_delivery"
                                                            class="radio-input">
                                                        <label for="option1" class="radio-label"><img class="rbimg"
                                                                src="{{ asset('image/cashondelivery.png') }}"></label>
                                                    @endif
                                                    @if ($bkash == 1)
                                                        <input type="radio" id="option2" name="payment_method"
                                                            value="bkash" class="radio-input">
                                                        <label for="option2" class="radio-label"><img class="rbimg"
                                                                src="{{ asset('image/bkash.png') }}"></label>
                                                    @endif
                                                    @if ($aamarpay == 1)
                                                        <input type="radio" id="option4" name="payment_method"
                                                            value="aamarpay" class="radio-input">
                                                        <label for="option4" class="radio-label"><img class="rbimg"
                                                                src="{{ asset('image/rocket.png') }}"></label>
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <input id="submitBTN" type="submit" class="btn btn-success1"
                                                    value="অর্ডার কনফার্ম করুন">
                                            </div>

                                            <!--<div class="form-group" id="loading_order" style="padding-bottom: 15px;display: none;">-->
                                            <!--     <img src="{{ asset('/') }}images/loading_wait.gif" style="width: 25px;" /> আপনার অর্ডার প্রক্রিয়া করা হচ্ছে, অনুগ্রহ করে কিছুক্ষণ অপেক্ষা করুন।-->
                                            <!--</div>-->
                                            <!--<div class="form-group" style="padding-bottom: 15px">-->
                                            <!--     <a href="{{ url('/') }}" class="btn btn-info1"> আরও কেনাকাটা করুন </a>-->
                                            <!--</div>-->


                                            <div class="form-group same_form">
                                                <p><b> বিশেষ নির্দেশনা: </b></p>
                                                <textarea name="note" required=""
                                                    placeholder="অর্ডার সম্পর্কিত কোনো নির্দেশনা থাকলে এখানে লিখুন।" spellcheck="false">{{ old('note') }}</textarea>
                                                @error('note')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            @livewire('cart-component')
                        </div>
                    </form>
                @else
                    <!--<div class="row" style="margin: 20px 0;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 5px;padding-right: 5px">
                            <center> <img src="{{ asset('/') }}image/no-product.jpg" class="img-responsive">
                                <h3> কোন পণ্য পাওয়া যায়নি !!</h3>
                                <a href="{{ url('/') }}" class="btn btn-info">কেনাকাটা করুন</a>
                            </center>
                        </div>
                    </div>-->
                    <div class="row" style="margin: 20px 0;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center; padding-left: 5px; padding-right: 5px;">
                            <img src="{{ asset('/') }}image/no-product.jpg" class="img-responsive" style="margin: 0 auto;">
                            <h3>কোন পণ্য পাওয়া যায়নি !!</h3>
                            <a href="{{ url('/') }}" class="btn btn-info">কেনাকাটা করুন</a>
                        </div>
                    </div>

                @endif
                <div class="panel panel-info">
                    <div class="panel-body mobile-padding-zero">
                        <div class="panel-heading  ">
                            <h4 class="sectionTitle">প্রয়োজনীয় পণ্য</h4>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 rs_product">
                            
                            @foreach ($related as $product)
                                <div class="col-5 col-xs-6  product-hover-area" style="padding: 0">
                                    <div class="catprobox">
                                        <div class="mydivouter">

                                            <a style="padding: 0px;height: 180px;overflow: hidden;"
                                                class="img-hover col-sm-12 padding-zero"
                                                href="{{ url('product') }}/{{ $product->slug }}"
                                                id="1186">
                                                <img class="img-responsive zoomEffect" style="margin: 0 auto;padding:5px"
                                                    src="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}"
                                                    alt="{{ $product->title }}">
                                            </a>

                                            <span id="productPrice1186" class="col-sm-12  col-xs-12 text-center"
                                                style="background: #fff;padding: 0;display: block;line-height:18px;color: #D2691E;font-size: 14px;font-weight: bold;height: 38px">

                                                @if ($product->rprice > $product->sprice)
                                                    <del
                                                        style="color:#b8b8b8;font-size:14px">৳{{ $product->rprice }}</del>
                                                @endif <br><label
                                                    style="color:green;font-size: 20px;"> ৳
                                                    {{ $product->sprice }}</label>

                                            </span>

                                            <span class="col-sm-12 text-center"
                                                style="background: #fff;padding: 2px;overflow: hidden;height: 38px;font-size: 12px;display: block;color:#525252;font-weight: bold;">{{ $product->title }}</span>

                                            <div style="text-align:center;">
                                                <?php $has_option = App\ProductVariation::select('product_id')
                                                    ->where('product_id', $product->id)
                                                    ->count(); ?>
                                                <a class="orderbtn" href="{{ url('/product') }}/{{ $product->slug }}">
                                                    অর্ডার করুন
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </section>
    </section>

    @push('js')
        <script>
            $("#division").on('change', function(e) {
                e.preventDefault();
                var ddlDistrict = $("#district");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/district-by-division') }}",
                    data: {
                        _token: $('input[name=_token]').val(),
                        division: $(this).val()
                    },
                    success: function(response) {
                        // var jsonData=JSON.parse(response);
                        $('option', ddlDistrict).remove();
                        $('#district').append('<option value="">--Select District--</option>');
                        $.each(response, function() {
                            $('<option/>', {
                                'value': this.id,
                                'text': this.name
                            }).appendTo('#district');
                        });
                    }

                });
            });

            $("#district").on('change', function(e) {
                e.preventDefault();
                var ddlthana = $("#thana");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/thana-by-district') }}",
                    data: {
                        _token: $('input[name=_token]').val(),
                        districts: $(this).val()
                    },
                    success: function(response) {
                        // var jsonData=JSON.parse(response);
                        $('option', ddlthana).remove();
                        $('#thana').append('<option value="">--Select Thana--</option>');
                        $.each(response, function() {
                            $('<option/>', {
                                'value': this.id,
                                'text': this.name
                            }).appendTo('#thana');
                        });
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $("select#dArea").change(function() {
                    var country_id = $("select#dArea option:selected").attr('value');
                    $("#paymentDiv").html("");
                    if (country_id.length > 0) {
                        $.ajax({
                            type: "POST",
                            url: "https://kinivalo.net/resources/views/front-end/payment_type.blade.php",
                            data: "country_id=" + country_id,
                            cache: false,
                            success: function(html) {
                                $("#paymentDiv").html(html);
                            }
                        });
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {

                @if (old('customer_area'))
                    $("#DeliAddress").val('{{ old('customer_area') }}');
                @endif

                $("#submitBTN").on('click', function() {
                    $("#order_details").submit();
                    $(this).prop('disabled', true);
                    $("#loading_order").show();
                });

                var deliAddress = $("#DeliAddress").val();
                var totalAmount = $("#subtotal").text();
                totalAmount = totalAmount.replace(/,/g, '');
                var deliveryCost = 0;

                if (deliAddress == 1) {
                    deliveryCost = {{ $basic->delivery_cost1 }};
                } else {
                    deliveryCost = {{ $basic->delivery_cost2 }};
                }

                $("#deliveryCost").text(deliveryCost);
                $("#totalCost").text(parseInt(totalAmount) + deliveryCost);
                $("#val-totalCost").val(parseInt(totalAmount) + deliveryCost);
                $("#val-deliveryCost").val(deliveryCost);
            });

            function UpdateOrderInfo(area) {
                var totalAmount = $("#subtotal").text();
                totalAmount = totalAmount.replace(/,/g, '');
                var deliveryCost = 0;

                if (area == 1) {

                    deliveryCost = {{ $basic->delivery_cost1 }};
                } else {
                    deliveryCost = {{ $basic->delivery_cost2 }};
                }
                $("#deliveryCost").text(deliveryCost);
                $("#totalCost").text(parseInt(totalAmount) + deliveryCost);
                $("#val-totalCost").val(parseInt(totalAmount) + deliveryCost);
                $("#val-deliveryCost").val(deliveryCost);
            }
        </script>
        <script>
            $("#division").on('change', function(e) {
                e.preventDefault();
                var ddlDistrict = $("#district");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/district-by-division') }}",
                    data: {
                        _token: $('input[name=_token]').val(),
                        division: $(this).val()
                    },
                    success: function(response) {
                        // var jsonData=JSON.parse(response);
                        $('option', ddlDistrict).remove();
                        $('#district').append('<option value="">--Select District--</option>');
                        $.each(response, function() {
                            $('<option/>', {
                                'value': this.id,
                                'text': this.name
                            }).appendTo('#district');
                        });
                    }

                });
            });

            $("#district").on('change', function(e) {
                e.preventDefault();
                var ddlthana = $("#thana");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/thana-by-district') }}",
                    data: {
                        _token: $('input[name=_token]').val(),
                        districts: $(this).val()
                    },
                    success: function(response) {
                        // var jsonData=JSON.parse(response);
                        $('option', ddlthana).remove();
                        $('#thana').append('<option value="">--Select Thana--</option>');
                        $.each(response, function() {
                            $('<option/>', {
                                'value': this.id,
                                'text': this.name
                            }).appendTo('#thana');
                        });
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $("select#dArea").change(function() {
                    var country_id = $("select#dArea option:selected").attr('value');
                    $("#paymentDiv").html("");
                    if (country_id.length > 0) {
                        $.ajax({
                            type: "POST",
                            url: "https://kinivalo.net/resources/views/front-end/payment_type.blade.php",
                            data: "country_id=" + country_id,
                            cache: false,
                            success: function(html) {
                                $("#paymentDiv").html(html);
                            }
                        });
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {

                @if (old('customer_area'))
                    $("#DeliAddress").val('{{ old('customer_area') }}');
                @endif

                $("#submitBTN").on('click', function() {
                    $("#order_details").submit();
                    $(this).prop('disabled', true);
                    $("#loading_order").show();
                });

                var deliAddress = $("#DeliAddress").val();
                var totalAmount = $("#subtotal").text();
                totalAmount = totalAmount.replace(/,/g, '');
                var deliveryCost = 0;

                if (deliAddress == 1) {
                    deliveryCost = {{ $basic->delivery_cost1 }};
                } else {
                    deliveryCost = {{ $basic->delivery_cost2 }};
                }

                $("#deliveryCost").text(deliveryCost);
                $("#totalCost").text(parseInt(totalAmount) + deliveryCost);
                $("#val-totalCost").val(parseInt(totalAmount) + deliveryCost);
                $("#val-deliveryCost").val(deliveryCost);
            });

            function UpdateOrderInfo(area) {
                var totalAmount = $("#subtotal").text();
                totalAmount = totalAmount.replace(/,/g, '');
                var deliveryCost = 0;

                if (area == 1) {

                    deliveryCost = {{ $basic->delivery_cost1 }};
                } else {
                    deliveryCost = {{ $basic->delivery_cost2 }};
                }
                $("#deliveryCost").text(deliveryCost);
                $("#totalCost").text(parseInt(totalAmount) + deliveryCost);
                $("#val-totalCost").val(parseInt(totalAmount) + deliveryCost);
                $("#val-deliveryCost").val(deliveryCost);
            }
        </script>
    @endpush

@endsection
