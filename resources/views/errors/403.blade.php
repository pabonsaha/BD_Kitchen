@include('layouts.header')

<body>
    <!-- Content -->

    <!-- Not Authorized -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-1 mx-2">You are not authorized or subscribed!</h2>
            <p class="mb-4 mx-2">
                You do not have permission to view this page using the credentials that you have provided while login.
                <br />
                Please contact your site administrator.
            </p>
            <a href="{{route('login')}}" class="btn btn-primary mb-4">Back to home</a>
            <div class="mt-4">
                <img src="{{asset('assets/img/illustrations/page-misc-you-are-not-authorized.png')}}"
                    alt="page-misc-not-authorized" width="170" class="img-fluid" />
            </div>
        </div>
    </div>
    <div class="container-fluid misc-bg-wrapper">
        <img src="{{asset('assets/img/illustrations/bg-shape-image-light.png')}}" alt="page-misc-not-authorized"
            data-app-light-img="illustrations/bg-shape-image-light.png"
            data-app-dark-img="illustrations/bg-shape-image-dark.png" />
    </div>
    <!-- /Not Authorized -->

    <!-- Page JS -->
</body>
@include('layouts.footer_script')

</html>
