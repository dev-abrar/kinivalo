
<div class="search_product">
  <div class="container">
      <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mobile-padding-left-15px">
            <!--Similar Product-->
              <div class="panel panel-info ">
                  <div class="panel-heading">
                      <h4 class="sectionTitle">সার্চ রেজাল্টস</h4>
                  </div>
                  <div class="panel-body mobile-padding-zero">
                  <div class="col-lg-12 col-md-12 col-sm-12 top_col">
                    @if(count($products)>0)
                      @foreach($products as $product)
                          <div class="col-5 col-xs-6 product-hover-area">
                            <div class="catprobox">
                                <div class="mydivouter">
                                  @php
                                      if($product->rprice){
                                        $off = round((($product->rprice - $product->sprice)/$product->rprice)*100);
                                      }
                                  @endphp
                                  @if($off != 0)
                                      <span class="percentage-span-new top_span" style="background-image: url({{ asset('image/flash-deal-percentage.png') }}) !important;"><font class="percentage-amount-new">{{ $off }}</font><font class="percentage-sign-new">%</font><font class="percentage-discount-amount-new">ছাড়</font></span>
                                  @endif
                                  <a class="img-hover col-sm-12 padding-zero first_a" href="{{ url('product') }}/{{ $product->slug }}"  id="1186" >
                                      <img class="img-responsive zoomEffect" src="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}" alt="{{ $product->title }}">
                                  </a>

                                  <span id="productPrice1186" class="col-sm-12  col-xs-12 text-center second_span">

                                      @if($product->rprice > $product->sprice)<del>৳{{ $product->rprice }}</del> @endif <br><label> ৳ {{ $product->sprice }}</label>

                                  </span>

                                  <span  class="col-sm-12 text-center span_three">{{ $product->title }}</span>     
                                  <div class="last_div">
                                      <?php $has_option = App\ProductVariation::select('product_id')->where('product_id',$product->id)->count() ?>
                                      <a class="orderbtn" href="{{ url('/product') }}/{{ $product->slug }}" >অর্ডার করুন</a>
                                  </div>
                              </div>
                          </div>
                          </div>
                        @endforeach
                      @else
                        <h3 class="end_heading">কোন আইটেম পাওয়া যায়নি!!</h3>
                      @endif
                    </div>
                  </div>
              </div>
              <!--Similar Product End-->
          </div>
      </div>
  </div>
</div>
