<div class="panel panel-info bordernone single_product_main">
    @assets
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/swiper-bundle.min.css" />
    @endassets
     
    @script
    <script src="{{ asset('/') }}front_asset/css/swiper-bundle.min.js"></script>
    <script src="{{ asset('/') }}front_asset/product_preview/zoom-image.js"></script>
    <script>
        document.addEventListener('livewire:navigated', function() {
            var swiper = new Swiper(".mySwiper", {
                loop: false,
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
            });

            var swiper2 = new Swiper(".mySwiper2", {
                loop: true,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                thumbs: {
                    swiper: swiper,
                },
            });
        });
    </script>
    @endscript

    <div class="panel-body mobile-padding-zero">
        <div class="row">
            <div class="col-sm-12 mobpad0">
                <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12 details_whole">
                    @php
                        if ($product->rprice) {
                            $off = round((($product->rprice - $product->sprice) / $product->rprice) * 100);
                        }
                    @endphp
                    @if ($off != 0)
                        <span class="percentage-span-new span_one"
                            style="background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;">
                            <span class="percentage-amount-new">{{ $off }}</span>
                            <span class="percentage-sign-new">%</span>
                            <span class="percentage-discount-amount-new">ছাড়</span>
                        </span>
                    @endif

                    {{-- slider start  --}}
                    <div class="tab-design-product mobile-padding-zero mobile-padding-10px col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="swiper mySwiper2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img
                                        src="{{ $color_photo ? $color_photo : asset('/image/product_image/' . $product->img1) }}" />
                                </div>
                                @foreach ($product->multiple_images as $item)
                                    <div class="swiper-slide">
                                        <img class="zoom_effict"
                                            src="{{ asset('/') }}image/product_image/{{ $item->image }}" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper" wire:ignore>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('/') }}image/product_image/{{ $product->img1 }}"
                                        class="show-small-img" />
                                </div>
                                @foreach ($product->multiple_images as $item)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('/') }}image/product_image/{{ $item->image }}"
                                            class="show-small-img" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- slider end  --}}

                    <div class="middle_div mobile-margin-left-zero mobile-margin-bottom-45 col-lg-6 col-md-6 col-sm-6 col-xs-12  right">
                        <div  class="col-sm-12 creativ" id="P_UserOrderForm1186">
                            <h4 class="modal-title p_title" id="gridSystemModalLabel">
                                {{ $product->title }}</h4>
                            <div class="col-xs-12 col-sm-6 col-md-6 creativ_one">
                                <p class="p_one">
                                    মূল্য : <?php if($product->rprice > $product->sprice) { ?><small><del>৳
                                            {{ $product->rprice }}</del></small><?php } ?>
                                    <strong> ৳ {{ $product_price > 0 ? $product_price : $product->sprice }} </strong>
                                </p>

                                <div class="col-sm-12 col-md-12  col-xs-12 creative_two">
                                    <h3 class="font-size-title-mobile"><i
                                            class="fa fa-mobile"></i> App Price :
                                        <?php if($product->appprice > $product->appprice) { ?><small><del>৳
                                                {{ $product->appprice }}</del></small><?php } ?>
                                        <strong> ৳ {{ $product->appprice }}
                                        </strong>
                                    </h3>

                                    <h3 class="font-size-title-mobile">
                                        <i class="fa fa-download"> </i> Download
                                        App - <a
                                            href="https://play.google.com/store/apps/details?id=com.kinivalo&hl=en&gl=US">Android</a>
                                        Or <a
                                            href="https://play.google.com/store/apps/details?id=com.kinivalo&hl=en&gl=US">iOS</a>
                                    </h3>
                                </div>
                                <div class="alert-message"></div>
                                <div class="col-xs-12 col-sm-12 col-md-12 deal-quantity deal_quan">
                                    <div id="Quantity">
                                        <span class="poriman">পরিমান: </span>

                                        <div  class="nameless">
                                            <div class="btn_one" type="button"
                                                wire:click.prevent="DecrementFunction()">
                                                -
                                            </div>

                                            <span
                                                id="quantity-value" wire:model="qty">{{ $qty }}</span>

                                            <div class="btn_two" type="button" wire:click.prevent="IncrementFunction()">
                                                +
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                @if (count($sizes))
                                    <div class="col-xs-12 col-sm-12 col-md-12 deal-quantity deal_quan_tw">
                                        <div id="Quantity">
                                            <span>সাইজ
                                                : &nbsp;&nbsp; </span>

                                            <div class="option">
                                                <select name="size" id="var_size"
                                                    wire:change.prevent="size($event.target.value)">
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->id }}">
                                                            {{ $size->option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                @endif

                                @push('css')
                                    <style>
                                        .color-option1 {
                                            width: 40px;
                                            height: 40px;
                                            border-radius: 10%;
                                            display: inline-block;
                                            margin-right: 3px;
                                            cursor: pointer;
                                            vertical-align: middle;
                                            border: 3px solid black;
                                        }
                                    </style>
                                @endpush
                                @if (count($productColors))
                                    <div class="col-xs-12 col-sm-12 col-md-12 deal-quantity quantity_one">
                                        <div id="Quantity">
                                            <p class="p_code">আপনার পছন্দের কালার নির্বাচন করুন</p>
                                            <span></span>
                                            <div class="option p-1 color_option">
                                                <select name="color" id="var_color"
                                                    wire:change.prevent="color($event.target.value)">
                                                    @foreach ($productColors as $color)
                                                        <option value="{{ $color->id }}">
                                                            {{ $color->color_name }}</option>
                                                    @endforeach
                                                </select>

                                                {{-- color start  --}}
                                                @foreach ($productColors as $color)
                                                    <div wire:click.prevent="color({{ $color->id }})"
                                                        class="color-option p1 show-small-img {{ $color_id === $color->id ? 'color-option1' : '' }}">
                                                        <img type="button"
                                                            src="{{ asset('image/color_photo/' . $color->color_photo) }}"
                                                            title="{{ $color->color_name }}">
                                                    </div>
                                                @endforeach
                                                {{-- color end  --}}

                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-12 col-md-12 col-xs-12 delivery_div">
                                       
                                        <h3 class="font-size-title-mobile">
                                        Delivery Time: 2-3 Days
                                        
                                    </h3>
                                </div>
                            </div>

                            @if (count($productColors))
                                <div class="col-xs-12 col-sm-6 col-md-6 product_colors">
                                    <div class="cent">
                                        <span class="color_span" id="orderButtonError"></span>
                                    </div>
                                    <h4 class="text-danger">{{ $colorMessage }}</h4>
                                    <div class="btn col-xs-12 col-sm-12 col-md-12">
                                        <input class="faltu" type="button" id="orderButton" wire:click.prevent="addToCartWithBuy"
                                            value="এখন অর্ডার করুন">
                                    </div>
                                    <br>
                                    <div class="cent">
                                        <span class="end_span" id="addToCartButtonError"></span>
                                    </div>
                                    <div class="{{ $product->id }}add cbtn col-xs-12 col-sm-12 col-md-12"
                                        wire:click.prevent='addToCart'>
                                        কার্টে রাখুন</div>
                                </div>
                            @else
                                <!-- Buttons Section -->
                                <div class="col-xs-12 col-sm-6 col-md-6 btn_section">
                                    <div class="btn col-xs-12 col-sm-12 col-md-12">
                                        <input class="faltu" wire:loading.attr="disabled" type="button" id="orderButton"
                                            wire:click.prevent="addToCartWithBuy" value="এখন অর্ডার করুন">
                                    </div>
                                    <br>
                                    <div wire:loading.attr="disabled"
                                        class="{{ $product->id }}add cbtn col-xs-12 col-sm-12 col-md-12"
                                        wire:click.prevent='addToCart'> কার্টে রাখুন
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-12 col-xs-12" style="padding:0">

                                @if ($basic->notice_enabled == 1)
                                    <div class="col-sm-12 col-md-12 col-xs-12" style="padding:0">
                                        <h3 class="font-size-notis noticb">
                                            {{ $basic->notice_text }}
                                        </h3>
                                    </div>
                                @endif

                                <div class="col-sm-12 col-md-12 col-xs-12 khali_div">
                           
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 "><br></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
