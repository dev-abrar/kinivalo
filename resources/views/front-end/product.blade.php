@extends('front-end.master')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('/') }}front_asset/product_preview/main.css">
        <style>
            div#social-links ul li {
                display: inline-block;
                padding: 5px;
            }

            div#social-links ul li a span {
                font-size: 30px;
            }
            
        </style>
    @endpush
    <section class="best_seller_product all_product" id="main_content_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt15 mobile-padding-left-15px">

                    @livewire('single-product-cart', ['product' => $product, 'sizes' => $sizes])

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <strong class="panel_strong"><i class="fa fa-bar-chart"> </i> পন্যের বিবরণ </strong>
                        </div>
                        <div class="panel-body same_panel">
                            <div class="row">
                                <div class=" col-lg-12 col-sm-12 brand text-center first_col">
                                    <div id="my-tab-content" class="tab-content first_tab">
                                        <!-- top category tab -->
                                        <div class="tab-pane active" id="course-detail1186">
                                            <div class="tab-content panel-body same_tab">
                                                <div class="tab-content panel-body same_tab">

                                                    <div id="ListStyle2" class="col-sm-12 text-left product-dynamic-details same_tab">
                                                        <div id="description" class="tab-pane active">
                                                            <div class="tabbox-container">
                                                                {!! $product->long_description !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($product->video)
                        <div class="panel panel-info ">
                            <div class="panel-heading"><strong class="panel_strong"><i
                                        class="fa fa-play"> </i> ভিডিও </strong></div>
                            <div class="panel-body same_panel mobile-padding-zero">
                                <div class="col-sm-12">
                                    {!! $product->video !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="panel panel-info ">
                        <div class="panel-heading "><strong class="panel_strong"><i
                                    class="fa fa-bus"> </i> ডেলিভারি এন্ড পেমেন্ট </strong></div>
                        <div class="panel-body same_panel mobile-padding-zero">
                            <div class="col-sm-6">
                                {!! $basic->inside_details !!}
                            </div>
                            <div class="col-sm-6">
                                {!! $basic->outside_details !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!--Similar Product-->
                <div class="panel panel-info panel_foure">
                    <div class="panel-heading">
                        <h4 class="sectionTitle">রিলেটেড প্রোডাক্ট</h4>
                    </div>
                    <div class="panel-body mobile-padding-zero">
                        <div class="col-lg-12 col-md-12 col-sm-12 rs_product">
                            @foreach ($related as $product)
                                <div class="col-5 col-xs-6  product-hover-area">
                                    <div class="catprobox">
                                        <div class="mydivouter">
                                            @php
                                                if ($product->rprice) {
                                                    $off = round((($product->rprice - $product->sprice) / $product->rprice) * 100);
                                                }
                                            @endphp
                                            @if ($off != 0)
                                                <span class="percentage-span-new first_span"
                                                    style="background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;">
                                                    <font class="percentage-amount-new">{{ $off }}</font>
                                                    <font class="percentage-sign-new">%</font>
                                                    <font class="percentage-discount-amount-new">ছাড়</font>
                                                </span>
                                            @endif
                                            <a class="img-hover col-sm-12 padding-zero first_a"
                                                href="{{ url('product') }}/{{ $product->slug }}" id="1186">
                                                <img class="img-responsive zoomEffect"
                                                    data-original="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}"
                                                    alt="{{ $product->title }}">
                                            </a>
                                            <span id="productPrice1186" class="col-sm-12  col-xs-12 text-center second_span">
                                                @if ($product->rprice > $product->sprice)
                                                    <del>৳{{ $product->rprice }}</del>
                                                @endif <br><label>
                                                    ৳ {{ $product->sprice }}</label>
                                            </span>
                                            <span class="col-sm-12 text-center span_three">{{ $product->title }}</span>
                                            <div class="order_btn">
                                                @php $has_option = $product->product_variations->count(); @endphp
                                                <a class="orderbtn"
                                                    href="{{ url('/product') }}/{{ $product->slug }}">অর্ডার
                                                    করুন</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--Similar Product End-->
            </div>
        </div>
    </section>
    @push('js')
<script src="{{ asset('/') }}front_asset/css/swiper-bundle.min.js"></script>
<script src="{{ asset('/') }}front_asset/product_preview/zoom-image.js"></script>
<script>
    document.addEventListener('livewire:navigated', function() {
//                              Livewire.on('post-created', (event) => {
//        //
//    });
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
<script>
    document.addEventListener('livewire:init', function() {
        var swiper = new Swiper(".mySwiper", {
            loop: false,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
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
@endpush
@endsection

@section('js')
    <script src="{{ asset('/') }}front_asset/product_preview/zoom-image.js"></script>
    <script src="{{ asset('/') }}front_asset/product_preview/main.js"></script>

    <script src="{{ asset('front_asset/js/zoom_image.js') }}"></script>
    {{-- <script>
        $('.zoom_effict').extm({
          squareOverlay:true,
        });
      </script> --}}

      <script>
         document.addEventListener('livewire:init', function() {
        var swiper = new Swiper(".mySwiper", {
            loop: false,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
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
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/') }}front_asset/css/swiper-bundle.min.css" />
@endpush
