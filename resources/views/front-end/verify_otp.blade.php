@extends('front-end.master')

@section('title')

@endsection

@section('content')
@push('css')
@endpush
<?php
$cartItems = Cart::content();
$subTotal = Cart::subtotal(0,'','');
?>
<section class="best_seller_product verify_opt" id="main_content_area">
    <section class="details_section">
      <div class="container">
        @livewire('verify-otp', ['mobileNumber' => $mobileNumber])
            <div class="panel panel-info ">
                <div class="panel-heading">
                     <h4 class="sectionTitle">প্রয়োজনীয় পণ্য</h4>
                </div>
                <div class="panel-body mobile-padding-zero">
                <div class="col-lg-12 col-md-12 col-sm-12 rs_product">
                   @foreach(DB::table('products')->orderBy('id', 'desc')->limit(20)->get() as $product)
                    <div class="col-5 col-xs-6 product-hover-area">
                        <div class="catprobox">
                            <div class="mydivouter">
                            
                                <a class="img-hover col-sm-12 padding-zero top_a" href="{{ url('product') }}/{{ $product->slug }}" id="1186">
                                    <img class="img-responsive zoomEffect" src="{{ asset('/') }}image/product_image/thumbnail/{{ $product->img1 }}" alt="{{ $product->title }}">
                                </a>
                                <span class="col-sm-12 col-xs-12 text-center top_span">
                
                                    @if($product->rprice > $product->sprice)<del >৳{{ $product->rprice }}</del> @endif <br><label> ৳ {{ $product->sprice }}</label>
                
                                </span>
                
                                <span class="col-sm-12 text-center second_span">{{ $product->title }}</span>
                                
                                <div class="order_btn">
                                    <?php $has_option = App\ProductVariation::select('product_id')->where('product_id', $product->id)->count() ?>
                                    <a class="orderbtn" href="{{ url('/product') }}/{{ $product->slug }}" >অর্ডার করুন </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
                  </div>
                </div>
            </div>
      </div>
  </section>
</section>

<script>
  $("#division").on('change',function(e){
    e.preventDefault();
    var ddlDistrict=$("#district");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{url('/district-by-division')}}",
      data:{_token:$('input[name=_token]').val(),division:$(this).val()},
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', ddlDistrict).remove();
          $('#district').append('<option value="">--Select District--</option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('#district');
          });
        }

    });
  });

  $("#district").on('change',function(e){
    e.preventDefault();
    var ddlthana=$("#thana");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{url('/thana-by-district')}}",
      data:{_token:$('input[name=_token]').val(),districts:$(this).val()},
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', ddlthana).remove();
          $('#thana').append('<option value="">--Select Thana--</option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('#thana');
          });
        }
      });
  });

</script>

<script>
	$(document).ready(function(){
	$("select#dArea").change(function(){
		var country_id =  $("select#dArea option:selected").attr('value'); 
		$("#paymentDiv").html( "" );
		if (country_id.length > 0 ) { 
		 $.ajax({
				type: "POST",
				url: "https://kinivalo.net/resources/views/front-end/payment_type.blade.php",
				data: "country_id="+country_id,
				cache: false,
				success: function(html) {    
					$("#paymentDiv").html( html );
				}
			});
		} 
	});
	});
</script>


<script>
    $(document).ready(function() {

        @if( old('customer_area') )
          $("#DeliAddress").val('{{old('customer_area')}}');
        @endif

        $("#submitBTN").on('click',function () {
            $("#order_details").submit();
            $(this).prop('disabled',true);
            $("#loading_order").show();
        });

        var deliAddress = $("#DeliAddress").val();
        var totalAmount = $("#subtotal").text();
        totalAmount = totalAmount.replace(/,/g,'');
        var deliveryCost = 0;

        if(deliAddress == 1){
          deliveryCost = {{$basic->delivery_cost1}};
        } else {
          deliveryCost = {{$basic->delivery_cost2}};
        }

        $("#deliveryCost").text(deliveryCost);
        $("#totalCost").text(parseInt(totalAmount)+deliveryCost);
        $("#val-totalCost").val(parseInt(totalAmount)+deliveryCost);
        $("#val-deliveryCost").val(deliveryCost);
    });
    
    function IncrementFunction(id,rowId){
      var rowId = rowId;
      var id = id;
      var qty = parseInt($("#quantity-value"+id).text())+1;
      var token = '{{ csrf_token() }}';
      var deliveryCost = parseInt($("#deliveryCost").text());

      $("#quantity-value"+id).text(qty);
      $("#quantity-value2"+id).text(qty);
      $("#val-quantity-value"+id).val(qty);

      $.post( "{{ url('/cart/update') }}", { _token: token, rowId: rowId, id: id, qty:qty})
        .done(function( data ) {
           data = JSON.parse(data);
           var totalAmount = data.totalAmount;
           totalAmount = totalAmount.replace(/,/g,'');
          $("#CartDetailsTotal").text(data.totalAmount+" Tk.");
          $("#CartDetailsTotal2").text(data.totalAmount+" Tk.");
          $("#totalCartItems2").text(data.totalItem+" Items");
          $("#total"+id).text(data.total);
          $("#subtotal").text(data.totalAmount);
          $("#totalCost").text(parseInt(totalAmount)+deliveryCost);
          $("#val-total"+id).val(data.total);
          $("#val-subtotal").val(data.totalAmount);
          $("#val-totalCost").val(parseInt(totalAmount)+deliveryCost);
          console.log(data);
        });
    }

    function DecrementFunction(id,rowId){
      var rowId = rowId;
      var id = id;
      var qty = parseInt($("#quantity-value"+id).text())-1;
      var token = '{{ csrf_token() }}';
      var deliveryCost = parseInt($("#deliveryCost").text());
      if(qty <= 0){
        qty = 1;
      }
      $("#quantity-value"+id).text(qty);
      $("#quantity-value2"+id).text(qty);
      $("#val-quantity-value"+id).val(qty);

      $.post( "{{ url('/cart/update') }}", { _token: token, rowId: rowId, id: id, qty:qty})
        .done(function( data ) {
           data = JSON.parse(data);
           var totalAmount = data.totalAmount;
           totalAmount = totalAmount.replace(/,/g,'');
          $("#CartDetailsTotal").text(data.totalAmount+" Tk.");
          $("#totalCartItems2").text(data.totalItem+" Items");
          $("#total"+id).text(data.total);
          $("#subtotal").text(data.totalAmount);
          $("#totalCost").text(parseInt(totalAmount)+deliveryCost);
          $("#val-total"+id).val(data.total);
          $("#val-subtotal").val(data.totalAmount);
          $("#val-totalCost").val(parseInt(totalAmount)+deliveryCost);
          console.log(data);
        });
    }

    function CartDataRemove(rowId,id){
      var rowId = rowId;
      var token = '{{ csrf_token() }}';
      var deliveryCost = parseInt($("#deliveryCost").text());

      $('#'+id).remove();

      $.post( "{{ url('/cart/remove') }}", { _token: token, rowId: rowId})
        .done(function( data ) {
           data = JSON.parse(data);
           var totalAmount = data.totalAmount;
           totalAmount = totalAmount.replace(/,/g,'');
          $("#CartDetailsTotal").text(data.totalAmount+" Tk.");
          $("#totalCartItems2").text(data.totalItem+" Items");
          $("#subtotal").text(data.totalAmount);
          $("#totalCost").text(parseInt(totalAmount)+deliveryCost);
          $("#val-subtotal").val(data.totalAmount);
          $("#val-totalCost").val(parseInt(totalAmount)+deliveryCost);
          if(data.totalItem <= 0){
            window.location.href = '{{ url('/cart') }}';
          }
          //console.log(data);
        });
    }

    function UpdateOrderInfo(area){
        var totalAmount = $("#subtotal").text();
        totalAmount = totalAmount.replace(/,/g,'');
        var deliveryCost = 0;

        if(area == 1){

          deliveryCost = {{$basic->delivery_cost1}};
        } else {
          deliveryCost = {{$basic->delivery_cost2}};
        }
        $("#deliveryCost").text(deliveryCost);
        $("#totalCost").text(parseInt(totalAmount)+deliveryCost);
        $("#val-totalCost").val(parseInt(totalAmount)+deliveryCost);
        $("#val-deliveryCost").val(deliveryCost);
    }

</script>
// <script>
// function IncrementFunction(itemId, rowId) {
//   var quantityValueId = "quantity-value" + itemId;
//   var inputValQuantityId = "val-quantity-value" + itemId;
//   var quantityElement = document.getElementById(quantityValueId);
//   var inputQuantityElement = document.getElementById(inputValQuantityId);
//   var alertContainer = document.getElementById("alertContainer");
  
//   var currentQuantity = parseInt(inputQuantityElement.value, 10);
  
//   if (currentQuantity < 5) {
//     currentQuantity++;
//     quantityElement.innerText = currentQuantity;
//     inputQuantityElement.value = currentQuantity;
//     alertContainer.style.display = 'none'; // Hide alert if it's visible
//   } else {
//     // Show alert in the div container
//     alertContainer.innerHTML = 'সর্বোচ্চ 5 টা প্রোডাক্ট সিলেক্ট করা যাবে';
//     alertContainer.style.display = 'block'; // Make the alert visible  
//   }
// }

// function DecrementFunction(itemId, rowId) {
//   var quantityValueId = "quantity-value" + itemId;
//   var inputValQuantityId = "val-quantity-value" + itemId;
//   var quantityElement = document.getElementById(quantityValueId);
//   var inputQuantityElement = document.getElementById(inputValQuantityId);
//   var alertContainer = document.getElementById("alertContainer");
  
//   var currentQuantity = parseInt(inputQuantityElement.value, 10);
  
//   if (currentQuantity > 1) {
//     currentQuantity--;
//     quantityElement.innerText = currentQuantity;
//     inputQuantityElement.value = currentQuantity;
//     alertContainer.style.display = 'none'; // Hide alert if it's visible
//   } else {
//     // Show alert in the div container
//     alertContainer.innerHTML = 'সর্বনিম্ন ১টা সিলেক্ট করতে হবে';
//     alertContainer.style.display = 'block'; // Make the alert visible 
//   }
// }
// </script>

@endsection
