@include('admin.layouts.header')

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('admin.layouts.sidebar')

        <!-- Layout container -->
        <div class="layout-page">

            @include('admin.layouts.topbar')

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-fluid flex-grow-1 container-p-y">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>


                @include('admin.layouts.footer')

                <div class="content-backdrop fade"></div>
            </div>
            <!-- / Layout page -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
@include('admin.layouts.footer_script')

