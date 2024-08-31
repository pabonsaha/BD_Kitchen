@extends('layouts.master')

@section('title', $title ?? __('Invoice'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            {!! breadcrumb('Invoice', ['#' => 'Order Management', 'order' => 'Invoice']) !!}

            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card" id="invoice-preview-card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                            <div class="mb-xl-0 mb-4">
                                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                    <div class="app-brand-logo demo">
                                        <img src="{{ getFilePath(shopSetting()->logo) }}" width="50" height="50"
                                            alt="">
                                    </div>
                                    <span class="app-brand-text fw-bold fs-4"> {{ shopSetting()->shop_name }} </span>
                                </div>
                                <p class="mb-2">{!! str_replace(',', '<br>', shopSetting()->location) !!}</p>
                                <p class="mb-0">{{ shopSetting()->phone }}</p>
                                <p class="mb-0">{{ shopSetting()->email }}</p>
                            </div>
                            <div>
                                <h4 class="fw-medium mb-2">INVOICE: {{ $order->code }}</h4>
                                <div class="mb-2 pt-1">
                                    <span>Date Issues:</span>
                                    <span class="fw-medium">{{ dateFormat(date('Y/m/d')) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="mb-3">Invoice To:</h6>
                                <p class="mb-1">{{ optional($order->shipping_address)->name }}</p>
                                <p class="mb-1">{{ optional($order->shipping_address)->street_address }}</p>
                                <p class="mb-0">{{ optional($order->shipping_address)->state }}</p>
                                <p class="mb-0">{{ optional($order->shipping_address)->country }} {{ optional($order->shipping_address)->zip_code }}</p>
                                <p class="mb-0">{{ optional($order->shipping_address)->phone }}</p>
                                <p class="mb-0">{{ optional($order->shipping_address)->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border-top">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Variation</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $cart_item)
                                    <tr>

                                        <td>
                                            {{ optional($cart_item->product)->name }}
                                        </td>
                                        <td>

                                            @foreach ($cart_item->variation as $key => $item)
                                                <span><b class="me-1">{{ $item['attribute'] }}:</b><span
                                                        class="text-primary">{{ $item['value'] }}</span></span><br>
                                            @endforeach

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
                                <tr>
                                    <td colspan="3" class="align-top px-4 py-4">
                                        <span>Thanks for your business</span>
                                    </td>
                                    <td class="text-end pe-3 py-4">
                                        <p class="mb-2 pt-3">Subtotal:</p>
                                        <p class="mb-2">Discount:</p>
                                        <p class="mb-2">Tax:</p>
                                        <p class="mb-0 pb-3">Total:</p>
                                    </td>
                                    <td class="ps-2 py-4">
                                        <p class="fw-medium mb-2 pt-3">{{ getPriceFormat($order->sub_total_amount) }}</p>
                                        <p class="fw-medium mb-2">{{ getPriceFormat($order->admin_discount_amount) }}</p>
                                        <p class="fw-medium mb-2">{{ getPriceFormat($order->tax_amount) }}</p>
                                        <p class="fw-medium mb-0 pb-3">{{ getPriceFormat($order->grand_total_amount) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body mx-3">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-medium">Note:</span>
                                <span>It was a pleasure working with you. We hope you will keep us in mind for
                                    future projects. Thank You!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-label-primary d-grid w-100 mb-2" target="_blank"
                            href="{{ route('order.invoicePrint', $order->id) }}">
                            Print
                        </a>
                        <a class="btn btn-label-success d-grid w-100 mb-2" target="_blank"
                            href="{{ route('order.invoiceDownload', $order->id) }}">
                            Download
                        </a>
                        {{-- <button class="btn btn-label-success d-grid w-100 mb-2">Download</button> --}}
                        <a href="{{ route('order.edit', $order->id) }}" class="btn btn-label-warning d-grid w-100 mb-2">
                            Edit Invoice
                        </a>

                        <button
                            class="btn btn-primary d-grid w-100 mb-2"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#addPaymentOffcanvas">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"
                        ><i class="ti ti-currency-dollar ti-xs me-2"></i>Add Payment</span
                        >
                        </button>

                        <button
                            id="sendInvoice"
                            class="btn btn-primary d-grid w-100"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Send Invoice</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- /Invoice Actions -->
        </div>


        <!-- Send Invoice Sidebar -->
        <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
            <div class="offcanvas-header my-1">
                <h5 class="offcanvas-title">Send Invoice</h5>
                <button
                    type="button"
                    class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-0 flex-grow-1">
                <form action="{{route('order.sendInvoice')}}" method="post">
                    @csrf
                    <input name="order_id" type="hidden" value="{{$order->id}}">
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">To</label>
                        <input
                            name="invoice-to"
                            type="text"
                            class="form-control"
                            id="invoice-to"
                            value="{{($order->user->email)}}"
                            placeholder="user@email.com"/>
                    </div>
                    <div class="mb-3">
                        <label for="invoice-subject" class="form-label">Subject</label>
                        <input
                            name="invoice-subject"
                            type="text"
                            class="form-control"
                            id="invoice-subject"
                            value="Invoice of {{$order->code}}"
                            placeholder="Invoice of your product"/>
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="invoice-message" cols="3" rows="8"></textarea>
                    </div>
                    <div class="mb-4">
                      <span class="badge bg-label-primary">
                        <i class="ti ti-link ti-xs"></i>
                        <span class="align-middle">Invoice Attached</span>
                      </span>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Payment Sidebar -->
        <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">
            <div class="offcanvas-header mb-3">
                <h5 class="offcanvas-title">Add Payment</h5>
                <button
                    type="button"
                    class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                    <p class="mb-0">Invoice Balance:</p>
                    <p class="fw-medium mb-0">$5000.00</p>
                </div>
                <form>
                    <div class="mb-3">
                        <label class="form-label" for="invoiceAmount">Payment Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input
                                type="text"
                                id="invoiceAmount"
                                name="invoiceAmount"
                                class="form-control invoice-amount"
                                placeholder="100" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="payment-date">Payment Date</label>
                        <input id="payment-date" class="form-control invoice-date" type="text" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="payment-method">Payment Method</label>
                        <select class="form-select" id="payment-method">
                            <option value="" selected disabled>Select payment method</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Paypal">Paypal</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="payment-note">Internal Payment Note</label>
                        <textarea class="form-control" id="payment-note" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Add Payment Sidebar -->
    @endsection

    @push('scripts')
    @endpush
