<div class="verify_main_header">
    @if (Cart::count())
        <div class="row ft_rw">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 css_div">
                <div class="panel panel-success">
                    <div class="panel-heading top_heading">
                        <p> তথ্য যাচাই করতে আপনার
                            মোবাইল নাম্বারে ৬ ডিজিটের একটি কোড পাঠানো হবে </p>
                    </div>
                    <form action="{{ url('/send_otp') }}" method="post"class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body panel_one">
                            <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12">
                                <div class="form-group group_one">
                                    <p><b>মোবাইল নাম্বার দিয়ে এগিয়ে
                                            যান </b> </p>
                                    <input type="number"
                                        name="mobileNumber" required class="form-control"
                                        placeholder="ইংরেজি সংখ্যায় মোবাইল নাম্বার লিখুন ">
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-success1" value=" সাবমিট করুন ">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 css_div_tw">
                <div class="panel panel-info">
                    <div class="panel-heading panel_tw"><strong>আপনার
                            অর্ডার</strong></div>
                    <div class="panel-body " style="padding: 0">
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
                                    {{-- @dd($cartItems) --}}
                                    @foreach ($cartItems as $item)
                                        @php
                                            $product = App\Product::find($item['id']);

                                            $productColors = DB::table('product_color')
                                                ->where('id', $item['options']['color'])
                                                ->first();
                                            if ($productColors) {
                                                $color_id = $productColors->id;
                                            }

                                            $cart_key = $item['id'];
                                            if ($item['options']['size']) {
                                                $cart_key .= '_size_' . $item['options']['size'];
                                            }
                                            if ($item['options']['color']) {
                                                $cart_key .= '_color_' . $item['options']['color'];
                                            }

                                        @endphp
                                        <tr class="tr_tw"
                                            id="{{ $item['id'] }}item">
                                            <td class="tdwidth">
                                                @if (isset($item['options']['size']))
                                                    @php
                                                        $size = App\VariationsOption::select('option')
                                                            ->where('id', $item['options']['size'])
                                                            ->first();
                                                    @endphp
                                                @endif

                                                {{-- @dd($item['options']); --}}

                                                {{ $product->title }}

                                                @if (isset($item['options']['color']))
                                                    - Color: {{ $productColors->color_name }}
                                                    <input type="hidden"
                                                        value="Color: {{ $productColors->color_name }}"
                                                        name="var_colors[]" />
                                                @endif
                                                @if (isset($item['options']['size']))
                                                    - Size: {{ $size->option }}
                                                    <input type="hidden" value=" - Size: {{ $size->option }}"
                                                        name="var_sizes[]" />
                                                @endif
                                                <input type="hidden" value="{{ $item['id'] }}" name="products[]" />
                                            </td>
                                            <td class="tdwidth td_tw" >
                                                @if (isset($item['options']['color']))
                                                    <img src="{{ asset('image/color_photo/' . $productColors->color_photo) }}"
                                                        title="{{ $productColors->color_name }}">
                                                @endif
                                            </td>

                                            <td class="tdwidth td_three">
                                                <div class="quantity-container">
                                                    <div class="btn_one" type="button"
                                                        wire:click.prevent="decrementCart('{{ $cart_key }}')">
                                                        <i class="fa fa-minus-square"></i>
                                                    </div>
                                                    <span
                                                        id="quantity-value{{ $item['id'] }}">{{ $item['qty'] }}</span>
                                                    <input id="val-quantity-value{{ $item['id'] }}" type="hidden"
                                                        value="{{ $item['qty'] }}" name="qty[]" />
                                                    <div class="btn_two" type="button"
                                                        wire:click.prevent="incrementCart('{{ $cart_key }}')">
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
                                                <a wire:click.prevent="removeItem('{{ $cart_key }}')">
                                                    <i class="fa fa-remove" title="Remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="tr_three">
                                        <td colspan="4" class="ctable">
                                            সাব টোটাল - ৳ </td>
                                        <td colspan="4">
                                            <span id="subtotal">{{ Cart::subtotal(0, '', '') }}</span>
                                            <input id="val-subtotal" type="hidden"
                                                value="{{ Cart::subtotal(0, '', '') }}" name="subTotal" />
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
        <div class="row end_rw">
            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 end_div">
                <img src="{{ asset('/') }}image/no-product.jpg" class="img-responsive">
                <h3>কোন পণ্য পাওয়া যায়নি !!</h3>
                <a href="{{ url('/') }}" class="btn btn-info">কেনাকাটা করুন</a>
            </div>
        </div>

    @endif
</div>
