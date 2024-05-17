<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="shortcut icon" href="https://www.kinivalo.com/image/manufacturer_logo/fevicon.webp">
<title>Payment Success</title>
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
        <a href="https://www.kinivalo.com/"><img src="https://www.kinivalo.com/image/manufacturers_logo/logo.png" width="60%"></a>
        <h3>Congratulations!! Your payment has been successfully done.</h3>
        <a href="https://www.kinivalo.com/" class="shoppingbtn" >More Shopping</a>
    </div>
    <br><br>
    <div style="text-align: center;">
        @if(isset($response))
            @php
                $responseData = json_decode($response);
            @endphp
            
            <ul style="list-style-type: none; padding: 0;">
                <li><strong>Mer txnid / Order ID:</strong> {{ $responseData->mer_txnid }}</li>
                <li><strong>Pg txnid:</strong> {{ $responseData->pg_txnid }}</li>
                <li><strong>Bank Transaction ID:</strong> {{ $responseData->bank_trxid }}</li>
                <li><strong>Payment Type:</strong> {{ $responseData->payment_type }}</li>
                <li><strong>Amount:</strong> {{ $responseData->amount_currency }}</li>
                <li><strong>Currency:</strong> {{ $responseData->currency }}</li>
                <li><strong>Payment Execute Time:</strong> {{ $responseData->date }}</li>
                <li><strong>Payment Status :</strong> {{ $responseData->pay_status }}</li>
            </ul>
            
        @endif
    </div>
</div>
</body>
</html>
