<section class=" area-mobile-off header">

    <section class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 padding-zero">
                    <div class="header_logo">
                        <a href="{{ route('/') }}"><img src="{{ asset('/'.$basic->logo) }}"
                                alt="kinivalo" title="{{ $basic->name }}"></a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-8 col-sm-8 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 search_fill">
                        <div class="form-group">
                            <div class="searchbox input-group">
                                <input type="search" id="searchpro" class="form-control" placeholder="সার্চ করুন.....">
                                <span class="searchbtn input-group-addon"> &nbsp;<i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12 form-group">
                    <ul class="navbar-nav">
                        <li data-toggle="modal" data-target="#mySms" class="top-menu-padding top_li">
                            <a
                                href="#" title="Track Your Order" class="font-color1">
                                Order Track
                            </a>
                        </li>
                        <li class="top-menu-padding second_li">
                            <a href="tel:{{ $basic->phone }}" title="Call" class="headerbtn font-color1">
                                <i class="fa fa-phone-square"> </i> {{ $basic->phone }}
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </section>
    <nav class="navbar navbar-default lightHeader navmenu" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse fault">
                <nav id="menu">
                    <label for="tm" id="toggle-menu"><i class="fa fa-list"></i> <span
                            class="drop-icon">▾</span></label>
                    <input type="checkbox" id="tm">
                    <ul class="main-menu clearfix">
                        <li><a href="{{ url('/') }}">হোম</a></li>
                        @php
                            $menus = App\Category::with('categories')
                                ->where('sts', '=', 1)
                                ->orderBy('id', 'ASC')
                                ->whereNull('mctg')
                                ->get();
                            $totalmenu = count($menus);
                            $i = 1;
                        @endphp
                        @foreach ($menus as $menu)
                            <?php
                            $slug = str_replace(['+', '%26'], ['-', '&'], urlencode($menu->slug));
                            ?>
                            <li><a href="{{ url('category') }}/{{ $slug }}"
                                    @if ($i == $totalmenu) style="border-right:1px solid #868686;" @endif>{{ $menu->name }}
                                    <?php
                                    $subctg = $menu->categories->where('sts','=',1)->where('mctg',$menu->id);
                                    $frow2 = $subctg->count();
                                    if($frow2>0){
                                ?>
                                    <span class="drop-icon">▾</span>
                                    <label title="Toggle Drop-down" class="drop-icon" for="sm1">▾</label>
                                </a>
                                <input type="checkbox" id="sm1">
                                <ul class="sub-menu">
                                    @foreach ($subctg as $submenu)
                                        <?php
                                        $sub_slug = str_replace(['+', '%26'], ['-', '&'], urlencode($submenu->slug));
                                        ?>
                                        <li><a
                                                href="{{ url('category') }}/{{ $sub_slug }}">{{ $submenu->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <?php
                                    } else {
                                        echo "</a></li>";
                                    }
                                $i++;
                                ?>
                        @endforeach
                    </ul>
                </nav>
            </div>


        </div>
    </nav>
</section>

<div class="modal fade header_track" id="mySms" role="dialog">
    <div class="modal-dialog">
        <form action="{{ url('order/track') }}" method="post">
            @csrf
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <strong>ট্র্যাক অর্ডার রেকর্ড</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 form-group">
                        <input required type="number" class="form-control"
                            name="phone" placeholder="ইংরেজিতে আপনার মোবাইল নাম্বার লিখুন">
                    </div>
                </div>
                <div class="modal-footer">
                    <input
                        type="submit" class="btn  pull-right" value="সার্চ করুন">
                </div>
            </div>
        </form>

    </div>
</div>

<nav id="menuBar" class="navbar navbar-default lightHeader top_navbar" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <div class="fisrt_div">
                <div class="second_div">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="div_three">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('/') }}{{ $basic->logo }}"
                            alt="kinivalo" title="{{ $basic->name }}">
                    </a>
                </div>
                <div class="div_foure">
                    <a href="{{ url('/cart') }}">
                        <span class="badge"
                            id="MtotalCartItems">{{ Cart::count() }}</span>
                        <img class="img-responsive" src="{{ asset('/') }}image/manufacturer_logo/cart-icon.png"
                            alt="{{ $basic->name }}">
                        <!--<i class="fa fa-shopping-cart" style="color: #fff; font-size: 22px; font-weight: bold; padding-top: 11px;"></i>-->
                    </a>
                </div>
            </div>
            <div class="col-xs-12 div_five">
                <form action="#" method="post" class="form" role="search">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="search" id="msearchpro" class="form-control" placeholder="সার্চ করুন">
                            <span class="input-group-addon">
                                &nbsp;<i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <div class="main-menu-custom">
                <ul>
                    @foreach ($menus as $menu)
                        <?php
                        $slug = str_replace(['+', '%26'], ['-', '&'], urlencode($menu->slug));
                        ?>
                        <li class="menu-item" onclick="toggleSubMenu('about-submenu{{ $menu->id }}')">
                            <a href="{{ url('category') }}/{{ $slug }}">
                                {{ $menu->name }} 
                            </a>
                            <i class="angelf fa fa-angle-down" aria-hidden="true"></i>
                            <span class="submenu-arrow"></span> <!-- Move the arrow icon here -->
                        </li>
                        <ul id="about-submenu{{ $menu->id }}" class="submenu-custom">
                            <?php
                            $subctg = $menu->categories->where('sts', '=', 1)->where('mctg', $menu->id);
                            $frow2 = $subctg->count();
                            ?>
                            @foreach ($subctg as $submenu)
                                <?php
                                $sub_slug = str_replace(['+', '%26'], ['-', '&'], urlencode($submenu->slug));
                                ?>
                                <li class="msttile">
                                    <a href="{{ url('category') }}/{{ $sub_slug }}">
                                        {{ $submenu->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                    <li data-toggle="modal" data-target="#mySms" class="top-menu-padding bottom_li">
                        <a
                            href="#" title="Track Your Order" class="font-color1">
                            অর্ডার ট্র্যাকিং
                        </a>
                    </li>
                </ul>
            </div>

            @push('js')
                <script>
                    let currentlyOpenSubmenuId = null;

                    function toggleSubMenu(submenuId) {
                        const submenu = document.getElementById(submenuId);
                        if (submenu) {
                            if (submenu.style.display === 'block' && currentlyOpenSubmenuId === submenuId) {
                                submenu.style.display = 'none';
                                currentlyOpenSubmenuId = null;
                            } else {
                                if (currentlyOpenSubmenuId) {
                                    const currentlyOpenSubmenu = document.getElementById(currentlyOpenSubmenuId);
                                    currentlyOpenSubmenu.style.display = 'none';
                                }
                                submenu.style.display = 'block';
                                currentlyOpenSubmenuId = submenuId;
                            }
                        }
                    }
                </script>
            @endpush
        </div>
    </div>
</nav>
