<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Payment Failed</title>
    <style>
        .bkashcont{
        border: solid 2px #bd2a2a;
        margin: 15px 35%;
        height: 420px;
        border-radius: 5px;
        padding: 40px;
        line-height: 50px;
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
        .bkashcont {
            margin: 15px !important;
        }
    }
    
    </style>
</head>
<body>
    <div class="bkashcont">

    <div style="text-align: center; padding:10px;">
        <a href="https://kinivalo.com/"><img src="https://www.kinivalo.com/image/manufacturers_logo/logo.png" width="60%"></a>
        <h3>Sorry !! Payment Failed, Please try again later</h3>
        <a href="https://kinivalo.com/" class="" >More Shopping</a>
    </div>
    
    <br><br>
    <div style="text-align: center; color: red;">
        @if(isset($statusMessage))
           {{ $statusMessage }}
        @endif

        @if(isset($response))
        {{ $response }}
        @endif
    </div>
    </div>
</body>
</html>