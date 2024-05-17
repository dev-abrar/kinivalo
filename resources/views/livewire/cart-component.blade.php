
<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12 cart_component_main">
    <div class="panel panel-info panel_info">
        <div class="panel-heading">
            <strong class="strong_one">আপনারঅর্ডার</strong>
        </div>
        <div class="panel-body">
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
                        <tr class="tr_one" 
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
                            <td  class="tdwidth td_two" style="">
                                @if (isset($item['options']['color']))
                                    <img src="{{ asset('image/color_photo/' . $productColors->color_photo) }}"
                                        title="{{ $productColors->color_name }}"
                                        style="max-width:40px;height:40px;">
                                @endif
                            </td>
                            <td class="tdwidth td_three">
                                <div class="quantity-container" style="padding: 3px 10px; width: 98px;">
                                    <div type="button"
                                        style="color: #ddd; font-size: 16px; text-align: left; cursor: pointer; font-weight: bold; float: left; padding: 2px 4px; border: 1px solid;"
                                        wire:click.prevent="decrementCart('{{ $cart_key }}')">
                                        <i class="fa fa-minus-square"></i>
                                    </div>
                                    <span
                                        style="float: left; font-size: 16px; text-align: center; color: gray; cursor: pointer; border: 1px solid #ddd; height: 28px; line-height: 30px; padding: 0px 4px; width: 28px;"
                                        id="quantity-value{{ $item['id'] }}">{{ $item['qty'] }}</span>
                                    <input id="val-quantity-value{{ $item['id'] }}" type="hidden"
                                        value="{{ $item['qty'] }}" name="qty[]" />
                                    <div type="button"
                                        wire:click.prevent="incrementCart('{{ $cart_key }}')"
                                        style="color: #ddd; font-size: 16px; text-align: right; cursor: pointer !important; font-weight: bold; float: left; padding-left: 5px; padding: 2px 4px; border: 1px solid;">
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
                            <td class="tdwidth last_td">
                                <a wire:click.prevent="removeItem('{{ $cart_key }}')">
                                    <i class="fa fa-remove" title="Remove"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                        <tr class="tr_two">
                            <td colspan="4" class="ctable " style="">সাব টোটাল - ৳  </td>
                            <td colspan="4">
                               <span id="subtotal">{{ Cart::subtotal(0, '', '') }}</span>
                              <input id="val-subtotal" type="hidden" value="{{ Cart::subtotal(0, '', '') }}" name="subTotal" />
                            </td>
                        </tr>
                        <tr class="tr_two">
                            <td colspan="4">ডেলিভারি চার্জ - ৳</td>
                            <td colspan="2" id="CustomerDeliveryPoint">
                              <span id="deliveryCost"></span>
                              <input id="val-deliveryCost" type="hidden" value="" name="delivery" />
                            </td>
                        </tr>
                        <tr class="tr_two">
                            <td colspan="4">Tex - ৳</td>
                            <td colspan="2" id="CustomerDeliveryPoint">
                              <span id="tax">0</span>
                              <input id="val-tax" type="hidden" value="0"/>
                            </td>
                        </tr>
                        <tr class="tr_two">
                          <td colspan="4">সর্বমোট - ৳ </td>
                          <td colspan="2" id="GrandOrderTk">
                               <span id="totalCost">0</span>
                              <input id="val-totalCost" type="hidden" value="" name="totalCost" />
                          </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>