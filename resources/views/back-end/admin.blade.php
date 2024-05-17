<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/toastr/toastr.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="{{ asset('/') }}back-end/plugins/sweetalert2/sweetalert2.min.css">    {{-- tag input --}}
    <link rel="stylesheet" href="{{ asset('back-end/plugins/tag-input/css/taginput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        
        .nav-treeview>.nav-item>.nav-link.active {
            background-color: #7e7ee4 !important;
            color: #212529; 
        }
        </style>

    @yield('css')
    @stack('css')
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="preloader">
        <div class="load-me">
            <div class="la-ball-running-dots la-2x ball-color">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="btn btn-danger btn-sm" href="{{ url('cache-clear') }}"><i
                            class="fas fa-eraser"></i>Refresh</a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-light-warning">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('/') }}back-end/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $basic->name }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->

                <!-- Sidebar Menu -->
                @include('back-end.includes.left-menu')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> | {{ $basic->name }} | All rights reserved.
            </strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    @livewireScripts
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('/') }}back-end/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('/') }}back-end/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/') }}back-end/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/') }}back-end/dist/js/adminlte.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('/') }}back-end/plugins/toastr/toastr.min.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('/') }}back-end/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{ asset('/') }}back-end/plugins/raphael/raphael.min.js"></script>
    <script src="{{ asset('/') }}back-end/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{ asset('/') }}back-end/plugins/jquery-mapael/maps/world_countries.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/') }}back-end/plugins/chart.js/Chart.min.js"></script>

    <!-- PAGE SCRIPTS -->
    <script src="{{ asset('/') }}back-end/dist/js/pages/dashboard2.js"></script>
    <!-- Summernote -->
    <script src="{{ asset('/') }}back-end/plugins/summernote/summernote-bs4.min.js"></script>
    <!--- currency formate--->
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="{{ asset('/') }}back-end/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://doctorlink.in/assets/add_row/js/dynamicrows.js"></script>
        <!-- taginput -->
    <script src="{{ asset('back-end/plugins/tag-input/js/taginput.js') }}"></script>
    <script src="{{ asset('/') }}back-end/plugins/sweetalert2/sweetalert2.all.js"></script>
    
    <script>
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href = link;
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })

        });
    </script>
    <script>
        $(function() {
            $('[data-dynamicrows]').dynamicrows({
                animation: 'fade',
                copyValues: false,
                minrows: 1
            });
        });


        function pleasePreview(input, previewId) {
            var selectorIdAndClass = $('#' + previewId);

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    selectorIdAndClass.removeClass('d-none');
                    selectorIdAndClass.attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('Select a file to see the preview');
                selectorIdAndClass.attr('src', '');
            }
        }
    </script>
    {{-- preloader  --}}
    <script>
        window.onload = function() {
            window.addEventListener("beforeunload", function(e) {
                $('#preloader').fadeIn();
                $('.wrapper,.main-footer').hide();

            });
            $('#preloader').fadeOut();
            $('.wrapper,.main-footer').show();
        };
    </script>
    @yield('links')
    <script>
        @yield('script')
    </script>
    @yield('js')
    @stack('js')
</body>

</html>
