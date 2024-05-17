<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    <title>Kinivalo.com | Payment with bKash</title>
    <style>
      .center {
        text-align: center;
        padding: 100px;
       
      }

      button {
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
    .container {
    height: inherit;
    text-align: center;
    padding-right: 0px;
    padding-left: 0px;
    color: #fff;
    border-radius: 2px;
    background-color: #FFFFFF;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    font-family: 'Roboto', sans-serif;
    }
    .bkashcont{
    border: solid 2px #bd2a2a;
    margin: 15px 35%;
    height: 420px;
    border-radius: 5px;
    padding: 40px;
    line-height: 50px;
    }
    .hiddec{display:none;}
    </style>
</head>
<body>
    <p>Process payment system...</p>
  <div class="container hiddec">
    <div class="bkashcont">
        <div><img src="https://www.kinivalo.com/image/manufacturers_logo/logo.png" width="60%"></div>
        <form action="/bkash/checkout-url/create" method="POST">
          @csrf
          <button type="submit" id="bKash_button">Pay with bKash</button>
        </form>
    </div>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("bKash_button").click();
  });
</script>
</body>
</html>