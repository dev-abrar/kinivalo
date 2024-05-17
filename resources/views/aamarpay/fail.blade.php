<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="shortcut icon" href="https://www.kinivalo.com/image/manufacturer_logo/fevicon.webp">
<title>Payment Fail</title>
<style>
    /* Global styles if needed */
    body {
        font-family: Arial, sans-serif;
    }

    /* Style for the list items */
    ul li {
        border-top: solid 1px #514444;
        padding: 10px;
    }
    .box{
        border: solid 1px #423535;
        margin: 8px 34%;
        background: #efefef;
        border-radius: 5px;
    }
    .shoppingbtn {
    background-color: red;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
  }
    @media  only screen and (max-width: 900px) {
        .box {
            margin: 15px !important;
        }
    }
</style>
</head>
<body>
    <div class="box">
    <div style="text-align: center; padding:10px;">
        <a href="https://kinivalo.online/"><img src="https://www.kinivalo.com/image/manufacturers_logo/logo.png" width="60%"></a>
        <h3>Sorry!! Your payment has been failed.</h3>
        <a href="https://www.kinivalo.com/" class="shoppingbtn" >More Shopping</a>
    </div>
    <br><br>
    <div style="text-align: center;">
        @if(isset($response))
            <ul style="list-style-type: none; padding: 0;">
                <li><strong>Order ID:</strong> {{ $response->mer_txnid }}</li>
                <li><strong>Payment Type:</strong> {{ $response->card_type }}</li>
                <li><strong>Amount:</strong> {{ $response->amount_original }}</li>
                <li><strong>Currency:</strong> {{ $response->currency }}</li>
                <li><strong>Payment Execute Time:</strong> {{ $response->pay_time }}</li>
                <li><strong>Payment Status :</strong> {{ $response->pay_status }}</li>
            </ul>
        @endif
    </div>
</div>
</body>
</html>
