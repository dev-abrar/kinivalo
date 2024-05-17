<?php
$country_id = urlencode($_POST["country_id"]);
?>			
					
<div class="col-lg-12 col-md-12  col-sm-12 col-xs-12">                
	<?php if($country_id == 1){ ?>
	
	<div class="form-group payment_method">
      <select name="payment_method" required="required" class="form-control ">
          <option value="" disabled>Select Payment Method</option>
          <option selected value="cod">Cash on delivery</option>
          <option value="bkash">bKash</option>
      </select>
    </div>
	
	<?php } ?>
	
	<?php if($country_id == 2){ ?>
	<div class="form-group payment_method">
      <select name="payment_method" required="required" class="form-control">
          <option value="" disabled>Select Payment Method</option>
          <option value="bkash">bKash</option>
      </select>
    </div>
	<?php } ?>
</div>											
										