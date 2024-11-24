

    <!DOCTYPE html>
    <html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

    @include('admin.layouts.head')


    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
       <h2 class="font-weight-bolder" style="color: rgb(18, 81, 158)">دان الرعاية</h2>  
        </div>

        <!-- Navbar -->
        @include('admin.layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @include('sweetalert::alert')

        @yield('content')
        
        <!-- /.content-wrapper -->

        @include('admin.layouts.footer')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('admin.layouts.footer_scripts')
    </body>

    </html>

