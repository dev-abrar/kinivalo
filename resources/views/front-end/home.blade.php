@extends('front-end.master')

@section('content')
    <section class="slider_area section_one" id="slider_area">
        <div class="mobile-padding-top-0 top_div">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 div_two">
                    <div id="wrapper">
                        <div class="slider-wrapper theme-default">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    @foreach ($sliders as $key => $slider)
                                        <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}"
                                            class="@if ($key == 0) active @endif"></li>
                                    @endforeach
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner inner_one" role="listbox">
                                    @foreach ($sliders as $key => $slider)
                                        <div class="item @if ($key == 0) active @endif">
                                            <a href="{{ $slider->link }}">
                                                <img src="{{ $slider->img }}"
                                                    alt="{{ $slider->title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Controls -->
                                <a class="left carousel-control" href="#carousel-example-generic" role="button"
                                    data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" role="button"
                                    data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--content area start-->

    <section class="best_seller_product section_two" id="main_content_area">
        <div class="container">
            @if ($hotdeals1)
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  mobile-border-of div_three">
                        <a href="{{ url('/hotdeals') }}" class="pull-left"><img
                                src="{{ asset('/image/hot-deal-english.gif') }}" width="150px" alt="hot-deal"
                                title="{{ $basic->name }}"></a>
                        <a href="{{ url('hotdeals') }}" class="pull-right">
                            <h4 class="sectionTitle">সকল হট ডিল</h4>
                        </a>
                        <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 div_foure">
                            <div class="slider">
                                <ul class="product-category owl-carousel nav">
                                    @foreach ($hotdeals1 as $product)
                                        @php
                                            $hotproduct = $product->product;
                                            if (isset($hotproduct) && $hotproduct->rprice) {
                                                $off = round((($hotproduct->rprice - $hotproduct->sprice) / $hotproduct->rprice) * 100);
                                            }
                                        @endphp
                                        <li class="product first_li">
                                            <div class="tw-hotdeals mydivouter">
                                                @if ($off != 0)
                                                    <span class="percentage-span-new first_span"
                                                        style="background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;">
                                                        <font class="percentage-amount-new">{{ $off }}</font>
                                                        <font class="percentage-sign-new">%</font>
                                                        <font class="percentage-discount-amount-new">ছাড়</font>
                                                    </span>
                                                @endif
                                                <div class="myDIV">
                                                    <span class="price-text second_span">৳&nbsp; {{ $hotproduct->sprice }}</span>
                                                    <a href="product/{{ $hotproduct->slug }}">
                                                        <img data-original="{{ asset('/') }}image/product_image/thumbnail/{{ $hotproduct->img1 }}"
                                                            alt="" title="{{ $hotproduct->title }}" />
                                                    </a>
                                                </div>
                                                <div class="mybuttonoverlap order_btn_one">
                                                    <?php $has_option = $hotproduct->product_variations->count(); ?>{{--  a-change --}}
                                                    @if ($has_option)
                                                        <a class="hcartbtn"
                                                            href="{{ url('/product/'. $hotproduct->slug) }}"
                                                            >অর্ডার করুন</a>
                                                    @else
                                                        <a class="hcartbtn"
                                                            href="{{ url('/product/'. $hotproduct->slug) }}"
                                                            >অর্ডার করুন</a>
                                                    @endif
                                                </div>

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @if (count($hotdeals2))
                            <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 div_five">
                                <div class="slider">
                                    <ul class="product-category owl-carousel nav">
                                        @foreach ($hotdeals2 as $product)
                                            @php

                                                $hotproduct = $product->product;
                                                if ($hotproduct->rprice) {
                                                    $off = round((($hotproduct->rprice - $hotproduct->sprice) / $hotproduct->rprice) * 100);
                                                }

                                            @endphp
                                            <li class="product second_li">
                                                <div class="tw-hotdeals mydivouter">
                                                    @if ($off != 0)
                                                        <span class="percentage-span-new span_three"
                                                            style=" background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;">
                                                            <font class="percentage-amount-new">{{ $off }}</font>
                                                            <font class="percentage-sign-new">%</font>
                                                            <font class="percentage-discount-amount-new">ছাড়</font>
                                                        </span>
                                                    @endif

                                                    <span class="price-text">৳&nbsp; {{ $hotproduct->sprice }}</span>
                                                    <a href="product/{{ $hotproduct->slug }}">
                                                        <img data-original="{{ asset('/') }}image/product_image/thumbnail/{{ $hotproduct->img1 }}"
                                                            alt="" title="{{ $hotproduct->title }}" />
                                                    </a>

                                                    <div class="mybuttonoverlap order_btn_one">
                                                        {{-- @php $has_option = App\ProductVariation::select('product_id')->where('product_id',$hotproduct->id)->count() @endphp  --}}
                                                        @php $has_option = $hotproduct->product_variations->count() @endphp
                                                        @if ($has_option)
                                                            <a class="hcartbtn"
                                                                href="{{ url('/product/'.$hotproduct->slug) }}"
                                                                >অর্ডার করুন</a>
                                                        @else
                                                            <a class="hcartbtn"
                                                                href="{{ url('/product/'.$hotproduct->slug) }}"
                                                                >অর্ডার করুন</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif


            @if ($home_options->section_1 && count($latest_products))
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  mobile-border-of div_three">
                        <a href="{{ url('/latest') }}">
                            <h4 class="sectionTitle">{{ $home_options->section_name_1 }}</h4>
                        </a>
                        <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 div_six"
                            id="Product_Ajax">
                            @foreach ($latest_products as $product)
                                <div class="col-sm-2 col-xs-6  product-hover-area w5" style="padding: 0">
                                    <div class="productbox">
                                        <div class="mydivouter">
                                            @php
                                                if ($product->rprice) {
                                                    $off = round((($product->rprice - $product->sprice) / $product->rprice) * 100);
                                                }
                                            @endphp
                                            @if ($off != 0)
                                                <span class="percentage-span-new span_three"
                                                    style="background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;">
                                                    <font class="percentage-amount-new">{{ $off }}</font>
                                                    <font class="percentage-sign-new">%</font>
                                                    <font class="percentage-discount-amount-new">ছাড়</font>
                                                </span>
                                            @endif
                                            <div class="myDIV">
                                                <a  href="{{ url('/product') }}/{{ $product->slug }}"
                                                    class="img-hover col-sm-12 padding-zero first_a" id="1186">
                                                    <img class="pimg img-responsive zoomEffect"
                                                        data-original="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}"
                                                        alt="{{ $product->title }}">
                                                </a>
                                                <span class="col-sm-12  col-xs-12 text-center footer_span_one"
                                                    >
                                                    @if ($product->rprice > $product->sprice)
                                                        <del>৳{{ $product->rprice }}</del>
                                                    @endif <br><label> ৳
                                                        {{ $product->sprice }}</label>
                                                </span>
                                                <span class="col-sm-12 text-center footer_span_two">{{ $product->title }}</span>
                                            </div>
                                            <div class="order_btn_two">
                                                @php $has_option = $product->product_variations->count() @endphp
                                                <a class="orderbtn"
                                                    href="{{ url('/product') }}/{{ $product->slug }}">অর্ডার
                                                    করুন</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            {{ $latest_products->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            if ($('.product-category').hasClass('owl-carousel')) {

                $('.owl-carousel').owlCarousel({
                    items: 5,
                    margin: 15,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    slideBy: 5,
                    autoplayHoverPause: true,
                    rewind: true,
                    responsive: {
                        0: {
                            items: 2
                        },
                        760: {
                            items: 2
                        },
                        960: {
                            items: 4
                        },
                        1170: {
                            items: 5
                        }
                    }
                })
            }
        });
    </script>
@endsection
