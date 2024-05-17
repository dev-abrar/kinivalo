<div class="main_otp_verify">
    @if(Cart::count())
    <div class="row fast_rw">
        
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 one">
            <div class="panel panel-success">
                <div class="panel-heading">
                <p class="heading_p"> আপনার এই <span>  {{$mobileNumber}}</span>নাম্বারে একটি ওটিপি কোড পাঠানো হয়েছে। </p> </div>  
                <form action="{{ url('/otp_submit') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                  @csrf
                 <div class="panel-body first_panel_body">
                    <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12">
                        <div class="form-group group_one">
                            <p> <b>ওটিপি কোড  এখানে লিখুন </b> </p>
                            <input type="number" name="user_otp" required class="form-control" placeholder=" ওটিপি কোড  এখানে লিখুন ">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success1" value=" সাবমিট করুন ">
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 two">
            <div class="panel panel-info">
                <div class="panel-heading"><strong class="st_one">আপনারঅর্ডার</strong></div>
                <div class="panel-body" style="padding: 0">
                    <div class="responsive-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>পণ্যের নাম</th>
                                    <th>কালার</th>
                                    <th>পরিমাণ</th>
                                    <th>মূল্য</th>
                                    <th>মোট</th>
                                    <th>রিমুভ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    @php
                                        $product = App\Product::find($item['id']);
                                    @endphp
                                    <tr class="first_tr"
                                        id="{{ $item['id'] }}item">
                                        <td class="tdwidth">
                                            @if (isset($item['options']['size']))
                                                @php
                                                    $size = App\VariationsOption::select('option')
                                                        ->where('id', $item['options']['size'])
                                                        ->first();
                                                @endphp
                                            @endif

                                            @if ($item['options']['color'])
                                                @php
                                                    $productColors = DB::table('product_color')
                                                        ->where('id', $item['options']['color'])
                                                        ->first();
                                                @endphp
                                            @endif

                                            {{ $product->title }}

                                            @if ($item['options']['color'])
                                                - Color: {{ $productColors->color_name }}
                                                <input type="hidden" value="Color: {{ $productColors->color_name }}"
                                                    name="var_colors[]" />
                                            @endif
                                            @if (isset($item['options']['size']))
                                                - Size: {{ $size->option }}
                                                <input type="hidden" value=" - Size: {{ $size->option }}"
                                                    name="var_sizes[]" />
                                            @endif
                                            <input type="hidden" value="{{ $item['id'] }}" name="products[]" />
                                        </td>
                                        <td class="tdwidth td_tw">
                                            @if ($item['options']['color'])
                                                <img src="{{ asset('image/color_photo/' . $productColors->color_photo) }}"
                                                    title="{{ $productColors->color_name }}">
                                            @endif
                                        </td>
                                        <?php $color_id = $productColors->id; ?>
                                        <td class="tdwidth td_three">
                                            <div class="quantity-container">
                                                <div class="td_div"
                                                    wire:click.prevent="decrement({{ $item['id'] }})">
                                                    <i class="fa fa-minus-square"></i>
                                                </div>
                                                <span
                                                    id="quantity-value{{ $item['id'] }}">{{ $item['qty'] }}</span>
                                                <input id="val-quantity-value{{ $item['id'] }}" type="hidden"
                                                    value="{{ $item['qty'] }}" name="qty[]" />
                                                <div class="td_div_tw" wire:click.prevent="increment({{ $item['id'] }})"
                                                    style="">
                                                    <i class="fa fa-plus-square" style="color:green"></i>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="tdwidth">
                                            ৳ {{ $item['price'] }}
                                            <input id="val-price{{ $item['id'] }}" type="hidden"
                                                value="{{ $item['price'] }}" name="price[]" />
                                        </td>
                                        <td class="tdwidth">
                                            ৳ <span
                                                id="total{{ $item['id'] }}">{{ $item['price'] * $item['qty'] }}</span>
                                            <input id="val-total{{ $item['id'] }}" type="hidden"
                                                value="{{ $item['price'] * $item['qty'] }}" name="total[]" />
                                        </td>
                                        <td class="tdwidth td_six">
                                            <a 
                                                wire:click.prevent="removeItem({{ $item['id'] }})">
                                                <i class="fa fa-remove" title="Remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="tr_tw">
                                    <td colspan="4" class="ctable"
                                        >
                                        সাব টোটাল - ৳ </td>
                                    <td colspan="4"
                                        >
                                        <span id="subtotal">{{ Cart::subtotal(0, '', '') }}</span>
                                        <input id="val-subtotal" type="hidden" value="{{ Cart::subtotal(0, '', '') }}"
                                            name="subTotal" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row second_rw">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 last_div">
            <center>  <img src="{{ asset('/') }}image/no-product.jpg" class="img-responsive">
                <h3> কোন পণ্য পাওয়া যায়নি !!</h3>
                <a href="{{ url('/') }}" class="btn btn-info">কেনাকাটা করুন</a>
            </center>
        </div>
    </div>
    @endif
</div>
