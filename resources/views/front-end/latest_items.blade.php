@extends('front-end.master')

@section('title')
    Latest Collection
@endsection

@section('content')
    <section class="best_seller_product latest_item_product" id="main_content_area">
        <div class="container">
            <div class="row fist_row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  mobile-border-of first_col">
                    <h4 class="sectionTitle">লেটেস্ট কালেকশন</h4>
                    <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 second_col" id="Product_Ajax">
                        @if ($products->count() > 0)
                            @foreach ($products as $product)
                                <div class="col-5 col-xs-6  product-hover-area" style="padding: 0">
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
                                                href="{{ url('product') }}/{{ $product->slug }}"
                                                id="1186">
                                                <img class="img-responsive zoomEffect"
                                                    src="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}"
                                                    alt="{{ $product->title }}">
                                            </a>

                                            <span id="productPrice1186" class="col-sm-12  col-xs-12 text-center second_span">

                                                @if ($product->rprice > $product->sprice)
                                                    <del>৳{{ $product->rprice }}</del>
                                                @endif <br><label>
                                                    ৳ {{ $product->sprice }}</label>

                                            </span>

                                            <span class="col-sm-12 text-center last_span">{{ $product->title }}</span>
                                            <div class="end_div">
                                                <?php $has_option = $product->product_variations->count(); ?>
                                                <a class="orderbtn"
                                                    href="{{ url('/product') }}/{{ $product->slug }}">অর্ডার
                                                    করুন</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="last_heading">কোন আইটেম পাওয়া যায়নি!!</h3>
                        @endif
                    </div>

                    <div class="col-md-12">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
