@extends('front-end.master')

@section('title')
Hot Deals
@endsection

@section('content')

<section class="best_seller_product hot_offers" id="main_content_area">
    <div class="container" >
            <div class="row first_row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  mobile-border-o hot_offers__firt_col" >
                    <h4 class="sectionTitle">HOT OFFERS</h4>
                    <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 hot_offers__second_col"  id="Product_Ajax">
                          @foreach($products as $product)
                            <div class="col-5 col-xs-6  product-hover-area" >
                                   <div class="catprobox">
                                       <div class="mydivouter">
                                        @php
                                            if($product->rprice){
                                              $off = round((($product->rprice - $product->sprice)/$product->rprice)*100);
                                            }
                                        @endphp
                                        @if($off != 0)
                                            <span class="percentage-span-new offers_first_spane" style="background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;"><font class="percentage-amount-new">{{ $off }}</font><font class="percentage-sign-new">%</font><font class="percentage-discount-amount-new">ছাড়</font></span>
                                        @endif
                                        <a class="img-hover col-sm-12 padding-zero" href="{{ url('product') }}/{{ $product->slug }}"  id="1186" >
                                            <img class="img-responsive zoomEffect" src="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}" alt="{{ $product->title }}">
                                        </a>
                                        <span  id="productPrice1186" class="col-sm-12  col-xs-12 text-center second_span">
                                             @if($product->rprice > $product->sprice)<del>৳{{ $product->rprice }}</del> @endif <br><label style=""> ৳ {{ $product->sprice }}</label>
    
                                        </span>
                                        <span  class="col-sm-12 text-center thired_span" >{{ $product->title }}</span>
                                        <div class="end_div">
                                            <?php $has_option = $product->product_variations->count() ?>
                                            <a class="orderbtn" href="{{ url('/product') }}/{{ $product->slug }}" >অর্ডার করুন</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                          @endforeach
                    </div>

                    <div class="col-md-12">
                      {{ $products->links() }}
                    </div>


                </div>


            </div>

    </div>
</section>

@endsection
