<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Developed By" content="https://github.com/ArifulSikder">
    
    
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    @yield('metatags')
    
    <link rel="shortcut icon" href="{{ asset('/') }}image/manufacturer_logo/fevicon.webp">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/responsive.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/normalize.css">
    <link rel="stylesheet" href="{{ asset('/') }}slider-asset/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/fontawesome-free/css/fontawesome5.15.4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/etalage.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/mega_menu.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/css/customshop_style.css">
    <link rel="stylesheet" href="{{ asset('/') }}front_asset/etalage.css" type="text/css" media="all" />


    <script src="{{ asset('/') }}slider-asset/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}back-end/plugins/jquery/jquery.slim.min.js"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    <script src="{{ asset('/') }}front_asset/jquery.etalage.min.js"></script>
    {!! $basic->header_code !!}
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N3M52HLH');
    </script>
    <!-- End Google Tag Manager -->
    <meta name="facebook-domain-verification" content="gbqj102uo38di9fg5wbs0m5vdg6q2b" />
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '635553668537929');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=635553668537929&ev=PageView&noscript=1" /></noscript>
    @yield('style')
    @stack('css')
    <!-- End Meta Pixel Code -->
    @livewireStyles
</head>

<body style="background-color:#fff">
    <!--	=======================header top section=========================-->
    @include('front-end.includes.header')
    <!--=========================header bottom section==================-->


    <div class="wrapper">
        @yield('content')
    </div>
    <!--content area end-->
    @include('front-end.includes.footer')


    @livewireScripts
    <script src="{{ asset('/') }}slider-asset/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}slider-asset/js/owl.carousel.min.js"></script>
    <script src="{{ asset('/') }}front_asset/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            //owl carousel

            $("#searchpro,#msearchpro").keyup(function() {
                var text = $(this).val();
                
                if (text == "") {
                    text = "null";
                }
                var url = "{{ url('/') }}/search/" + text;

                $(document).prop('title', 'Search Result');
                //console.log(url);
                
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        $(".wrapper").html(data);
                    }
                });
            });
        });
    </script>
    <script>
        $('.megaDropMenu').hover(function() {
            $(this).addClass('open');
        }, function() {
            $(this).removeClass('open');
        });
    </script>

    <script>
        $(window).scroll(function() {
            var wScroll = $(this).scrollTop();
            if (wScroll > 88) {
                $('#SidebarCardMenu').css({
                    'display': 'block'
                });
            }
            if (wScroll < 88) {
                $('#SidebarCardMenu').css({
                    'display': 'none'
                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            @php
                $items = Cart::content();
                $item_ids = [];
                $i = 0;
                if ($items) {
                    foreach ($items as $item) {
                        $item_ids[$i] = $item['id'];
                        $i++;
                    }
                }
                $cart_items = json_encode($item_ids);
            @endphp

            var cart_items = <?php echo $cart_items; ?>;
            cart_items.forEach((id) => {
                $("." + id + "add").css("background-color", "#ff5722");
            });
        });

        // function ProductAddTwoCart(product_id) {
        //     var product_id = product_id;
        //     var color = null;
        //     var size = null;
        //     var quantity = parseInt($("#quantity-value").text());
        //     if (!quantity) {
        //         quantity = 1;
        //     }
        //     if (document.getElementById("var_color")) {
        //         color = $('#var_color').val();
        //     }
        //     if (document.getElementById("var_size")) {
        //         size = $('#var_size').val();
        //     }
        //     //console.log(product_id+"add");
        //     $("." + product_id + "add").css("background-color", "#ff5722");

        //     var token = '{{ csrf_token() }}';

        //     $.post("{{ url('/cart/additem') }}", {
        //             _token: token,
        //             product_id: product_id,
        //             quantity: quantity,
        //             color: color,
        //             size: size
        //         })
        //         .done(function(data) {
        //             data = JSON.parse(data);
        //             $("#CartDetailsTotal").text(data.totalAmount + " Tk.");
        //             $("#CartDetailsTotal2").text(data.totalAmount + " Tk.");
        //             $("#totalCartItems2").text(data.totalItem + " Items");
        //             $("#MtotalCartItems").text(data.totalItem);

        //             window.location.reload();

        //         });

        // }


        // function buyNow(product_id) {
        //     var product_id = product_id;
        //     var color = null;
        //     var size = null;
        //     var quantity = parseInt($("#quantity-value").text());
        //     if (!quantity) {
        //         quantity = 1;
        //     }
        //     if (document.getElementById("var_color")) {
        //         color = $('#var_color').val();
        //     }
        //     if (document.getElementById("var_size")) {
        //         size = $('#var_size').val();
        //     }
        //     var token = '{{ csrf_token() }}';

        //     $.post("{{ url('/cart/additem') }}", {
        //             _token: token,
        //             product_id: product_id,
        //             quantity: quantity,
        //             color: color,
        //             size: size
        //         })
        //         .done(function(data) {
        //             data = JSON.parse(data);
        //             $("#CartDetailsTotal").text(data.totalAmount + " Tk.");
        //             $("#CartDetailsTotal2").text(data.totalAmount + " Tk.");
        //             $("#totalCartItems2").text(data.totalItem + " Items");
        //             window.location.href = '{{ url('/cart') }}';
        //         });
        // }
    </script>
    <script>
        window.onscroll = function() {
            myFunction()
        };

        var header = document.getElementById("menuBar");
        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.style.position = "fixed";
            } else {
                header.style.position = "relative";
            }
        }
    </script>
    <script src="{{ asset('/') }}front_asset/js/lazyloading.min.js"></script>
    <script>
        $(document).ready(function() {
            $("img").lazyload();
        });
    </script>
 
    <script>
        @yield('script')
    </script>
    @yield('js')
    @stack('js')
    {!! $basic->footer_code !!}

</body>

</html>
