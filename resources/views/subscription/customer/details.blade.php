@extends('layouts.master')

@section('title', $title ?? _trans('order.Payment & Billing Details'))

@section('content')


    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('order.Payment & Billing Details'), [
            '#' => _trans('order.Payment & Billing Details') . ' ' . _trans('product.Management'),
            'payment' => _trans('order.Payment & Billing Details'),
        ]) !!}


        <div class="row">
            <div class="col-md-12">


                <!-- Current Plan -->


                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title m-0"><strong>Current Plan</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">

                                        <div class="mb-3">
                                            <h6 class="mb-1">{{ optional($user->currentSubscription->plan)->name }}</h6>

                                        </div>
                                        <div class="mb-3">
                                            <h6 class="mb-1">Activated at
                                                {{ gmdate('d-m-Y', optional($user->currentSubscription)->created) }}
                                            </h6>

                                        </div>
                                        <div class="mb-3">
                                            <h6 class="mb-1">Active until
                                                {{ gmdate('d-m-Y', optional($user->currentSubscription)->expire_at) }}
                                            </h6>

                                        </div>
                                        <div class="mb-3">
                                            <h6 class="mb-1">
                                                <span
                                                    class="me-2">{{ getPriceFormat(optional($user->currentSubscription->plan)->price) }}
                                                    Per
                                                    {{ ucfirst(optional($user->currentSubscription->plan)->plan_type) }}</span>
                                                @if (optional($user->currentSubscription->plan)->is_popular)
                                                    <span class="badge bg-label-primary">Popular</span>
                                                @endif
                                            </h6>
                                            {{-- <p>Standard plan for small to medium businesses</p> --}}
                                        </div>
                                    </div>
                                    @if ($user->currentSubscription->payment_status == 'paid')
                                        <div class="col-4">
                                            <button
                                                href="{{ route('subscription.customer.immediateSubscriptionCancel', $user->id) }}"
                                                class="btn btn-danger mb-2 " id="immediateSubscriptionCancel">Immediate
                                                Subscription Cancelation</button>
                                            <button
                                                href="{{ route('subscription.customer.revokeSubscriptionCancel', $user->id) }}"
                                                class="btn btn-warning" id="revokeSubscriptionCancel">Cancelation After This
                                                Subscription
                                                Period</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-lg-6 ">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title m-0"><strong>{{ _trans('order.Customer Details') }}</strong></h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-start align-items-center mb-4">
                                    <div class="avatar me-2">
                                        <img src="{{ getFilePath($user->avatar) }}" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="app-user-view-account.html" class="text-body text-nowrap">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                        </a>
                                        <small class="text-muted">Username: #58909</small>
                                        <input type="number" hidden value="{{ $user->id }}" name="user_id">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6><strong>Contact info</strong></h6>
                                </div>
                                <p class="mb-1">Email: {{ $user->email }}</p>
                                <p class="mb-0">Phone: {{ $user->phone }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- /Current Plan -->
                <div class="card">
                    <div class="card-header">
                        <h5>Billing History</h5>
                    </div>

                    <div class="card-datatable table-responsive">
                        <table class="data-table table border-top">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Customer Details</th>
                                    <th>Stripe Customer ID</th>
                                    <th>Stripe Subscripiton No</th>
                                    <th>Stripe Invoice No</th>
                                    <th>Price</th>
                                    <th>Created Date</th>
                                    <th>Expire Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptionPaymentList as $list)
                                    <tr>
                                        <td>{{ $list->plan->name }}</td>
                                        <td>
                                            {{-- <pre>{{ json_decode($list->customer_details)->name }}</br>{{ json_decode($list->customer_details)->email }}</br>{{ optional(json_decode($list->customer_details))->phone }}Address:</br>{{ json_decode($list->customer_details)->address->city }}</br>{{ json_decode($list->customer_details)->address->state }}</br>{{ optional(json_decode($list->customer_details))->phone }}</br></br>{{ json_decode($list->customer_details)->address->country }}</pre> --}}
                                        </td>
                                        <td>{{ $list->customer_id }}</td>
                                        <td>{{ $list->subscription_no }}</td>
                                        <td>
                                            <pre><a href="{{ route('subscription.customer.invoicePreview', $list->invoice_no) }}">View House Brand Invoice</a></br><a href="{{ route('subscription.customer.stripeGenerateInvoice', $list->invoice_no) }}">View Stripe Invoice</a></pre>
                                        </td>
                                        <td>{{ getPriceFormat($list->price / 100) }}</td>
                                        <td>{{ gmdate('d-m-Y', $list->created) }}</td>
                                        <td>{{ gmdate('d-m-Y', $list->expire_at) }}</td>
                                        <td>

                                            @if ($list->payment_status == 'paid')
                                                <span class="badge bg-label-success">{{ $list->payment_status }}</span>
                                            @else
                                                <span class="badge bg-label-danger">{{ $list->payment_status }}</span>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-felx justify-content-center">
                        {{ $subscriptionPaymentList->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {


            $(document).on("click", "#immediateSubscriptionCancel", function() {


                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will immediately cancel the subsctipion!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Cancel it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        window.location.href =
                            "{{ route('subscription.customer.immediateSubscriptionCancel', $user->id) }}";
                    }
                });
            });
            $(document).on("click", "#revokeSubscriptionCancel", function() {


                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will cancel the subsctipion after the subscription period!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        window.location.href =
                            "{{ route('subscription.customer.revokeSubscriptionCancel', $user->id) }}";

                    }
                });
            });

        });
    </script>
@endpush
