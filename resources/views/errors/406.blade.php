@include('layouts.header')

<body>
    <!-- Content -->

    <!-- Not Authorized -->
    <div class="container-xxl ">
        <div class="misc-wrapper">
            <h2 class="mb-1">You are not subscribed!</h2>
            <p class="mb-4 mx-2">
                You do not have permission to view this page using the credentials that you have provided while login.
                <br />
                Please contact your site administrator or renew the plan.
            </p>
            <div class="card px-3">
                <div class="row">
                    <div class="col-lg-7 card-body border-end">
                        <h4 class="mb-2">Checkout</h4>
                        <p class="mb-0">
                            All plans include 40+ advanced tools and features to boost your product. <br />
                            Choose the best plan to fit your needs.
                        </p>
                        <div class="row py-4 my-2">
                            <div class="col-md mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-basic checked">
                                    <label
                                        class="form-check-label custom-option-content form-check-input-payment d-flex gap-3 align-items-center"
                                        for="customRadioVisa">
                                        <input name="customRadioTemp" class="form-check-input" type="radio"
                                            value="credit-card" id="customRadioVisa" checked />
                                        <span class="custom-option-body">
                                            <img src="../../assets/img/icons/payments/visa-light.png" alt="visa-card"
                                                width="58" data-app-light-img="icons/payments/visa-light.png"
                                                data-app-dark-img="icons/payments/visa-dark.png" />
                                            <span class="ms-3">Credit Card</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-basic">
                                    <label
                                        class="form-check-label custom-option-content form-check-input-payment d-flex gap-3 align-items-center"
                                        for="customRadioPaypal">
                                        <input name="customRadioTemp" class="form-check-input" type="radio"
                                            value="paypal" id="customRadioPaypal" />
                                        <span class="custom-option-body">
                                            <img src="../../assets/img/icons/payments/paypal-light.png" alt="paypal"
                                                width="58" data-app-light-img="icons/payments/paypal-light.png"
                                                data-app-dark-img="icons/payments/paypal-dark.png" />
                                            <span class="ms-3">Paypal</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-2 mb-4">Plan List</h4>

                    </div>
                    <div class="col-lg-5 card-body">
                        <h4 class="mb-2">Order Summary</h4>
                        <p class="pb-2 mb-0">
                            It can help you manage and service orders before,<br />
                            during and after fulfilment.
                        </p>
                        <div class="bg-lighter p-4 rounded mt-4">
                            <p class="mb-1">A simple start for everyone</p>
                            <div class="d-flex align-items-center">
                                <h1 class="text-heading display-5 mb-1">$59.99</h1>
                                <sub>/month</sub>
                            </div>
                            <div class="d-grid">
                                <button type="button" data-bs-target="#pricingModal" data-bs-toggle="modal"
                                    class="btn btn-label-primary">
                                    Change Plan
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <p class="mb-0">Subtotal</p>
                                <h6 class="mb-0">$85.99</h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <p class="mb-0">Tax</p>
                                <h6 class="mb-0">$4.99</h6>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between align-items-center mt-3 pb-1">
                                <p class="mb-0">Total</p>
                                <h6 class="mb-0">$90.98</h6>
                            </div>
                            <div class="d-grid mt-3">
                                <button class="btn btn-success">
                                    <span class="me-2">Proceed with Payment</span>
                                    <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
                                </button>
                            </div>

                            <p class="mt-4 pt-2">
                                By continuing, you accept to our Terms of Services and Privacy Policy. Please note that
                                payments are
                                non-refundable.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- <div class="container-fluid misc-bg-wrapper">
        <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}" alt="page-misc-not-authorized"
            data-app-light-img="illustrations/bg-shape-image-light.png"
            data-app-dark-img="illustrations/bg-shape-image-dark.png" />
    </div> --}}
    <!-- /Not Authorized -->


    <section class="section-py bg-body first-section-pt">
        <div class="container mt-2">

        </div>
    </section>

    <!-- Page JS -->
</body>
@include('layouts.footer_script')

</html>
