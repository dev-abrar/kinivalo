<div class="footer_cart">
    <div id="mySidenav" class="sidenav">
        <div class="panel-heading"><strong> কার্ট</strong>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        </div>
    
        @if (Cart::count())
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="10%">ছবি</th>
                        <th width="25%">নাম</th>
                        <th width="10%">পরিমাণ</th>
                        <th width="15%">মূল্য</th>
                        <th width="2%">রিমুভ</th>
                    </tr>
                </thead>
                <tbody id="CustomerOrderData">
                    @foreach ($cartItems as $item)
                    @php
                        $product = App\Product::find($item['id']);
                                    $cart_key = $item['id'];
                                    if ($item['options']['size']) {
                                        $cart_key .= '_size_' . $item['options']['size'];
                                    }
                                    if ($item['options']['color']) {
                                        $cart_key .= '_color_' . $item['options']['color'];
                                    }

                    @endphp
                        <tr class="first_tr" id="{{ $item['id']}}">
                            <td class="td_one">
                                <img
                                    src="{{ asset('/') }}image/product_image/{{ $product->img1 }}"
                                    title="{{ $product->title }}">
                            </td>
                            <td>
    
                                @if (isset($item['options']['size']))
                                    @php($size = App\VariationsOption::select('option')->where('id',$item['options']['size'])->first())
                                @endif
    
                                {{ $product->title }}
    
                                @if (isset($item['options']['size']))
                                    - Size: {{ $size->option }}
                                    <input type="hidden" value=" - Size: {{ $size->option }}" name="var_sizes[]" />
                                @endif
                                <input type="hidden" value="{{ $item['id'] }}" name="products[]" />
                            </td>
    
                            <td class="td_three">
                                <div class="empty_div">
                                    <span id="quantity-value2{{ $item['id'] }}">{{ $item['qty'] }}</span>
                                </div>
                            </td>
                            <td>৳ {{ $item['price'] }}</td>
                            <td class="td_foure">
                                <a href="javascript:void(0)"
                                wire:click.prevent="removeItem('{{ $cart_key }}')">
                                    <i class="fa fa-remove" title="Remove"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="second_tr">
                        <td colspan="3">
                            সাব টোটাল</td>
                        <td colspan="3">
                            ৳<span class="" id="CartDetailsTotal2"> {{ Cart::subtotal() }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ url('/cart') }}" class="btn btn-info check_out"> চেক আউট </a>
        @else
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rw_div">
                    <center> <img src="{{ asset('/') }}image/no-product.jpg" class="img-responsive">
                        <h3> কোন পণ্য পাওয়া যায়নি !!</h3>
                        <a href="{{ url('/') }}" class="btn btn-info">কেনাকাটা করুন</a>
                    </center>
                </div>
            </div>
        @endif
    
    </div>
    
    <div id="overlay"></div>

    <footer onclick="openNav()" class="navbar-fixed-bottom area-mobile-off end_footer">
        <div class="cartbox cart_anchor">
            <span id="CartDetailsTotal" class="cartamount">{{ Cart::subtotal() }} Tk.</span>
            <span class="cartitem end_span">
                <i class="fa fa-shopping-cart " title="My Cart"> </i>
                <span id="totalCartItems2">{{ Cart::count() }} আইটেম</span>
            </span>
        </div>
    </footer>

</div>
