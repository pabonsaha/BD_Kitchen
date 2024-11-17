@extends('admin.layouts.master')

@section('title', $title ?? _trans('order.Order Details'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="mb-3 fw-bold">{{_trans('common.Payment Info')}}</h6>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="pe-4">{{_trans('common.Payment status')}}:</td>
                                        <td class="fw-medium"> @if ($order->payment_status == 'paid')
                                                <span class="badge bg-label-success">{{_trans('common.Paid')}}</span>
                                                @php
                                                    $payment_details = json_decode($order->payment_details);
                                                    $paymentDetailsText = _trans('common.Date').': ' . dateFormatwithTime($payment_details->created)."<br>";
                                                    $paymentDetailsText .= '<p>' . _trans('order.Payment ID') . ': ' . $payment_details->payment_intent_id . "</p>";
                                                    $paymentDetailsText .= '<p>' . _trans('common.Currency') . ': ' . $payment_details->currency . "</p>";
                                                    $paymentDetailsText .= '<p>' . _trans('common.Amount') . ': ' . $payment_details->amount_total . "</p>";
                                                    $paymentDetailsText .= '<p>' . _trans('common.Status') . ': ' . $payment_details->payment_status . "</p>";
                                                    $paymentDetailsText .= '<p>' . _trans('order.Customer Name') . ': ' . $payment_details->customer_details->name . "</p>";
                                                    $paymentDetailsText .= '<p>' . _trans('order.Customer Email') . ': ' . $payment_details->customer_details->email . "</p>";

                                                @endphp

                                                <span class="badge bg-label-primary" data-bs-toggle="popover"
                                                      data-bs-placement="right"
                                                      data-bs-content="{{ htmlspecialchars_decode($paymentDetailsText) }}"
                                                      title="Payment Details">{{_trans('common.Details')}}
                                                </span>
                                            @else
                                                <span class="badge bg-label-danger">{{_trans('common.Unpaid')}}</span>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Total Amount')}}:</td>
                                        <td>{{ getPriceFormat($order->sub_total_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Admin Discount')}}:</td>
                                        <td>{{ getPriceFormat($order->admin_discount_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('common.Tax')}}:</td>
                                        <td>{{ getPriceFormat($order->tax_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Shipping Charges')}}:</td>
                                        <td>{{ getPriceFormat($order->shipping_charges) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Total Order Amount')}}:</td>
                                        <td>{{ getPriceFormat($order->grand_total_amount) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <h6 class="mb fw-bold">{{_trans('order.Order Info')}}</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">{{_trans('order.Order Code')}}:</td>
                                            <td class="fw-medium">{{ $order->code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">{{_trans('order.Order Date')}}:</td>
                                            <td>{{ dateFormat($order->order_date) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">{{_trans('order.Order Status')}}:</td>
                                            <td><span class="badge bg-label-info">{{ $order->orderStatus->name }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row mt-2">
                                    @if(hasPermission('customer_order_list_read_invoice'))
                                        <div class="col-4">
                                            <a href="{{ route('admin.order.invoicePreview', $order->id) }}"
                                               class="btn btn-label-warning d-grid w-100 mb-2 waves-effect">{{_trans('order.Invoice')}}</a>
                                        </div>
                                    @endif

                                    @if(hasPermission('customer_order_list_cancel'))

                                        <div class="col-4">
                                            <button class="btn btn-label-danger delete-order" data-id="{{ $order->id }}"
                                                    id="delete_order">{{_trans('order.Cancel Order')}}</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold">{{_trans('order.Order Items')}}</h6>
                    </div>
                    <div class="card-datatable table-responsive">

                        <table class="datatables-order-details table border-top">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th>
                                    <th class="col-3">{{_trans('common.Name')}}</th>
                                    <th class="col-1">{{_trans('common.Price')}}</th>
                                    <th class="col-2">{{_trans('common.qty')}}</th>
                                    <th class="col-2">{{_trans('common.Total')}}</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($order->items as $cart_item)
                                    <tr id="cartRow{{ $cart_item->id }}">
                                        <td><span>{{ $loop->iteration }}</span></td>

                                        <td>
                                            <img src="{{ getFilePath(optional($cart_item->product)->thumbnail_img) }}"
                                                class="me-2" height="50px" alt="">
                                            {{ optional($cart_item->product)->name }}
                                        </td>

                                        <td>
                                            <span>{{ getPriceFormat($cart_item->price) }}</span>

                                        </td>

                                        </td>
                                        <td>

                                            <span>{{ $cart_item->quantity }}</span>

                                        </td>
                                        <td>
                                            {{ getCurrency() }}
                                            <span>{{ number_format($cart_item->price * $cart_item->quantity, 2) }}</span>

                                        </td>
                                    </tr>


                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body mx-3">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-medium">{{_trans('common.Note')}}:</span>
                                <span>{{_trans('order.It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You')}}!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Invoice -->

            <div class="col-12 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title m-0">{{_trans('order.Customer details')}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <div class="avatar me-2">
                                <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div class="d-flex flex-column">
                                <a href="" class="text-body text-nowrap">
                                    <h6 class="mb-0">{{ optional($order->user)->name }}</h6>
                                </a>
                                <small class="text-muted">{{_trans('order.Customer ID')}}: #58909</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <h6>{{_trans('common.Contact info')}}</h6>

                        </div>
                        <p class="mb-1">{{_trans('common.Email')}}: {{ optional($order->user)->email }}</p>
                        <p class="mb-0">{{_trans('common.Mobile')}}: {{ optional($order->user)->phone }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h6 class="card-title m-0">{{_trans('order.Shipping address')}}</h6>

                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{_trans('common.Name')}}: {{ optional($order->shipping_address)->name }}
                        </p>
                        <p class="mb-0">{{_trans('common.Email')}}: {{ optional($order->shipping_address)->email }}
                        </p>
                        <p class="mb-0">{{_trans('common.Phone')}}: {{ optional($order->shipping_address)->phone }}
                        </p>
                        <p class="mb-0">{{_trans('order.Shipping address')}}: {{ optional($order->shipping_address)->street_address }}
                        </p>
                        <p class="mb-0">{{_trans('common.State')}}: {{ optional($order->shipping_address)->state }}
                        </p>
                        <p class="mb-0">{{_trans('common.Zip Code')}}: {{ optional($order->shipping_address)->zip_code }}
                        </p>
                        <p class="mb-0">{{_trans('common.Country')}}: {{ optional($order->shipping_address)->country }}
                        </p>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h6 class="card-title m-0">{{_trans('common.Note')}}</h6>
                    </div>
                    <div class="card-body">
                        <p>{{ $order->note }}</p>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            $(document).on("click", "#delete_order", function() {

                let id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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

                        $.ajax({
                            url: '{{ route('admin.order.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                order_id: id,
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: response.icon,
                                    title: 'Canceled!',
                                    text: response.text,
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                }).then(function(result) {
                                    window.location.href =
                                        "{{ route('admin.order.index') }}";
                                });
                            },
                            error: function(error) {
                                console.log(error.responseJSON.message);
                                // handle the error case
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
