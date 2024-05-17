<?php
$cartItems = Cart::content();
$subTotal = Cart::subtotal(0, '', '');

$location_map = cache()->remember('location_map', now()->addHours(24), function () {
    return "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14608.043416377432!2d90.36473256476027!3d23.74699234976879!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bff5173b337d%3A0xe2c832749bcc40cc!2sKINIVALO!5e0!3m2!1sen!2sbd!4v1695732492271!5m2!1sen!2sbd";
});
?>

@livewire('footer-card')

<footer class="navbar-default footerbg">
    <div class="container ">
        <div class="col-lg-4">
            <a class="first_a" href="{{ route('/') }}"><img src="{{ asset('/'.$basic->f_logo) }}"
                    alt="kinivalo" title="{{ $basic->name }}"></a>
            <br><br><br>
            <div class="row">
                <div class="column">
                    <a href="https://play.google.com/store/apps/details?id=com.kinivalo&pli=1"><img
                            src="https://www.kinivalo.com/images/play.png" alt="DBID"
                            title="{{ $basic->name }}"></a>
                </div>
                <div class="column">
                    <a href="https://play.google.com/store/apps/details?id=com.kinivalo&pli=1"><img
                            src="https://www.kinivalo.com/images/app.png" alt="DBID"
                            title="{{ $basic->name }}"></a>
                </div>
            </div>
            <br>
            @if ($basic->footer_details)
                <div class="footer_details">
                    {!! $basic->footer_details !!}
                </div>
            @endif
            <div class="footersubc"><b>যোগাযোগের ঠিকানা </b></div>
            <div class="footersub p_icon"><i class="fa fa-map-marker"> </i> {{ $basic->address }} </div>
            </br>
            <div class="footersubc line-height"><i class="fa fa-phone"> </i> {{ $basic->contact_no }} </div>
            <div class="footersubc"><i class="fa fa-envelope"> </i> {{ $basic->email_address }} </div>
        </div><br>
        <div class="col-lg-4">
            <div class="footerttl">গুরুত্বপূর্ণ লিঙ্ক সমূহ</div><br>
            @foreach (App\Page::all() as $page)
                <div class="footersub footersub_one"><a href="{{ url('page/' . $page->slug) }}" target="_blank"> {{ $page->title }} </a></div>
            @endforeach

        </div>
        <div class="col-lg-4">
            <div class="footerttl">Verified by DBID</div>
            <div class="footersubc"><img src="https://www.kinivalo.com/image/bdlogo.webp" alt="DBID"
                    title="{{ $basic->name }}"></div><br>
            <div class="footersubc">Member ID : 757344794 </div>
            <div class="footersubc">Trade License : 023500 </div>
            <div class="footersubc"><a href="https://kinivalo.com.bd" target="_new">www.kinivalo.com.bd</a> এর একটি
                অঙ্গ প্রতিষ্ঠান।</div>
                {{-- ===========Location Map start===============--}}
            <iframe
                src="{{ $location_map }}"
                width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
                 {{-- ===========Location Map end===============--}}
        </div>
    <div class="col-lg-12 copywrites"> </div>
        <div class="col-lg-6 footer_media_link">
            <div class="swidth"><a target="_new" href="{{ $basic->facebook }}" class="facebookf"><i class="fab fa-facebook-f"></i></a></div>
            <div class="swidth"><a target="_new" href="{{ $basic->twitter }}" class="twitterf"><i class="fab fa-twitter"></i></a></div>
            <div class="swidth"><a target="_new" href="{{ $basic->instagram }}" class="instagramf"><i
                        class="fab fa-instagram"> </i> </a></div>
            <div class="swidth"><a target="_new" href="{{ $basic->youtube }}" class="youtubef"><i
                        class="fab fa-youtube"> </i> </a></div>
            <div class="swidth"><a target="_new" href="{{ $basic->linkedin }}" class="linkedinf"><i
                        class="fab fa-linkedin"> </i> </a></div>
        </div>
        <div class="col-lg-6 text-right">
            <div class="copywtext">Copyright © {{ date('Y') }} | {{ $basic->name }} | Development &amp;
                Maintenance by <a href="https://mehetech.com/" target="_new">MeheTech</a> </div>
            <div class="footersubc"><img src="https://www.kinivalo.com/images/s-cart.png" width="30%"
                    alt="DBID" title="{{ $basic->name }}"></div>
        </div>

    </div>
</footer>

@push('js')
    <script>
    function CartDataRemove1(rowId, id) {
        var rowId = rowId;
        var token = '{{ csrf_token() }}';
        var deliveryCost = parseInt($("#deliveryCost").text());

        $('#' + id).remove();

        $.post("{{ url('/cart/remove') }}", {
                _token: token,
                rowId: rowId
            })
            .done(function(data) {
                data = JSON.parse(data);
                var totalAmount = data.totalAmount;
                totalAmount = totalAmount.replace(/,/g, '');
                $("#CartDetailsTotal").text(data.totalAmount + " Tk.");
                $("#CartDetailsTotal2").text(data.totalAmount + " Tk.");
                $("#totalCartItems2").text(data.totalItem + " Items");
                $("#subtotal").text(data.totalAmount);
                $("#totalCost").text(parseInt(totalAmount) + deliveryCost);
                $("#val-subtotal").val(data.totalAmount);
                $("#val-totalCost").val(parseInt(totalAmount) + deliveryCost);
                if (data.totalItem <= 0) {
                    window.location.href = '{{ url('/cart') }}';
                }
                console.log(data);
            });
    }
</script>
@endpush

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>
@push('js')
<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "253456421907159");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>


<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "450px";
        document.body.style.overflow = "hidden"; // Prevent scrolling while the navigation is open
        document.getElementById("overlay").style.display = "block"; // Show the overlay

        // Add an event listener to the overlay to close the navigation when clicked
        document.getElementById("overlay").addEventListener("click", closeNav);
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.body.style.overflow = "auto"; // Restore scrolling when the navigation is closed
        document.getElementById("overlay").style.display = "none"; // Hide the overlay

        // Remove the event listener from the overlay
        document.getElementById("overlay").removeEventListener("click", closeNav);
    }
</script>

@endpush
