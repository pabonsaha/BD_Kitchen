@extends('layouts.master')

@section('title', $title ?? _trans('common.Edit Order'))

@section('content')


    <div class="container-xxl flex-grow-1 container-p-y pt-0">

        {!! breadcrumb( _trans('common.Edit Order'), ['#' => _trans('order.Order').' '. _trans('product.Management'),'##'=>_trans('order.Customer').' '._trans('order.Order'), 'order' =>  _trans('common.Edit Order')]) !!}
        <div class="row invoice-preview">
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
                            </div>
                        </div>
                    </div>
                    <!-- Order Details Table -->
                    <div>
                        <form action="{{ route('order.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 ">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title m-0">{{_trans('order.Order Items')}}</h5>
                                            <button type="button" id="addItemButton" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#addItem"><i class="ti ti-plus ti-xs me-0 me-sm-2"></i>{{_trans('common.Add Item')}}</button>
                                        </div>
                                        <div class="card-datatable table-responsive">
                                            <table class="data-table table border-top">
                                                <thead>
                                                <tr>
                                                    <th class="col-1">#</th>
                                                    <th class="col-3">{{_trans('common.Name')}}</th>
                                                    <th class="col-3">{{_trans('common.Variation')}}</th>
                                                    <th class="col-1">{{_trans('common.Price')}}</th>
                                                    <th class="col-2">{{_trans('common.qty')}}</th>
                                                    <th class="col-2">{{_trans('common.Total')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody id="orderItemWrapper">

                                                @foreach ($order->items as $key => $cart_item)
                                                    <tr id="cartRow{{ $cart_item->id }}">
                                                        <td><i class="ti ti-trash text-danger cursor-pointer deleteProduct"
                                                               data-id="{{ $cart_item->id }}"></i></td>

                                                        <td>
                                                            <img src="{{ getFilePath(optional($cart_item->product)->thumbnail_img) }}"
                                                                 class="me-2" height="50px" alt="">
                                                            {{ optional($cart_item->product)->name }}
                                                            <input type="number" value="{{ optional($cart_item->product)->id }}"
                                                                   hidden name="product[{{ $key }}][product_id]">
                                                        </td>
                                                        <td>

                                                            @foreach ($cart_item->variation as $index => $item)
                                                                <span><b class="me-1">{{ $item['attribute'] }}:</b><span
                                                                        class="text-primary">{{ $item['value'] }}</span></span><br>
                                                                <input type="text" value="{{ $item['attribute'] }}" hidden
                                                                       name="product[{{ $key }}][variant][{{ $index }}][attribute]">
                                                                <input type="text" value="{{ $item['value'] }}" hidden
                                                                       name="product[{{ $key }}][variant][{{ $index }}][value]">
                                                            @endforeach

                                                        </td>
                                                        <td>
                                                            <span>{{ getPriceFormat($cart_item->price) }}</span>
                                                            <input class="form-control w-60" id="product-{{ $key }}-price"
                                                                   type="number" hidden name="product[{{ $key }}][price]"
                                                                   value="{{ $cart_item->price }}" />
                                                        </td>

                                                        <td>
                                                            <input class="form-control w-60 quantity" type="number"
                                                                   data-product_id="{{ $key }}"
                                                                   name="product[{{ $key }}][quantity]"
                                                                   value="{{ $cart_item->quantity }}" min="1" />
                                                        </td>
                                                        <td>
                                                            {{ getCurrency() }}
                                                            <span
                                                                id="product-{{ $key }}-total_price-view">{{ number_format($cart_item->price * $cart_item->quantity, 2) }}</span>
                                                            <input class="total_price_of_product" type="text" hidden
                                                                   id="product-{{ $key }}-total_price"
                                                                   value="{{ $cart_item->price * $cart_item->quantity }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex flex-column justify-content-end align-items-end m-3 mb-2 p-1">

                                                <div class="d-flex justify-content-between mb-2 w-px-300">
                                                    <span class="text-heading"><strong>{{_trans('common.Subtotal')}}:</strong></span>
                                                    <h6 class="mb-0"><strong>{{ getCurrency() }} <span
                                                                id="sub_total">{{ $order->sub_total_amount }}</span> </strong></h6>
                                                    <input type="text" name="sub_total" hidden id="sub_total_input"
                                                           value="{{ $order->sub_total_amount }}">
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="d-flex me-4 w-px-300">
                                                        <select name="discount_type" class="form-select me-2 charges" id="discount_type"
                                                                data-placeholder="Discount type">
                                                            <option selected value="0">{{_trans('order.Discount Type')}}</option>
                                                            <option value="1"
                                                                {{ $order->admin_discount_type == 1 ? 'selected' : '' }}>
                                                                Parcentage</option>
                                                            <option value="2"
                                                                {{ $order->admin_discount_type == 2 ? 'selected' : '' }}>
                                                                Fixed Amount</option>
                                                        </select>
                                                        <input type="number" class="form-control w-50 charges" name="discount_value"
                                                               id="discount_value" min="0.0" value="{{ $order->admin_discount_value }}">


                                                    </div>
                                                    <div class="w-px-300 justify-content-between d-flex">
                                                        <span class="text-heading">{{_trans('common.Discount')}}:</span>
                                                        <h6 class="mb-0">{{ getCurrency() }} <span
                                                                id="discount_amount">{{ $order->admin_discount_amount }}</span> </h6>
                                                        <input type="text" name="discount_amount" hidden id="discount_amount_input"
                                                               value="{{ $order->admin_discount_amount }}">

                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="d-flex me-4 w-px-300">
                                                        <select name="tax_type" id="tax_type" class="form-select me-2 charges"
                                                                data-placeholder="Tax type">
                                                            <option selected value="0">{{_trans('order.Tax Type')}}</option>
                                                            <option value="1" {{ $order->tax_type == 1 ? 'selected' : '' }}>
                                                                {{_trans('common.Percentage')}}
                                                            </option>
                                                            <option value="2" {{ $order->tax_type == 2 ? 'selected' : '' }}>
                                                                {{_trans('order.Fixed Amount')}}
                                                            </option>
                                                        </select>
                                                        <input type="number" class="form-control w-50 charges" name="tax_value"
                                                               id="tax_value" min="0.0" value="{{ $order->tax_value }}">

                                                    </div>

                                                    <div class="w-px-300 justify-content-between d-flex">
                                                        <span class="text-heading">{{_trans('common.Tax')}}:</span>
                                                        <h6 class="mb-0">{{ getCurrency() }} <span
                                                                id="tax">{{ $order->tax_amount }}</span> </h6>
                                                        <input type="text" name="tax_amount" hidden id="tax_amount_input"
                                                               value="{{ $order->tax_amount }}">

                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2 w-px-300">
                                                    <span class="text-heading">{{_trans('order.Shipping Charge')}}:</span>
                                                    <div class="d-flex align-items-center">
                                                        {{ getCurrency() }}<input type="number" id="shipping_charge"
                                                                                  name="shipping_charge" class="ms-1 form-control p-1 text-end charges"
                                                                                  style="width: 100px" min="0.0"
                                                                                  value="{{ $order->shipping_charges }}" />

                                                    </div>
                                                </div>
                                                <br>
                                                <div class="d-flex justify-content-between w-px-300 border-top pt-2">
                                                    <h4 class=" mb-0">Total:</h4>
                                                    <h4 class="mb-0">{{ getCurrency() }} <span id="total">0</span> </h4>
                                                    <input type="text" name="total" hidden id="total_input"
                                                           value="{{ $order->grand_total_amount }}">

                                                </div>

                                            </div>
                                        </div>
                                    <div class="col-12 d-flex justify-content-center mb-3">
                                        <button class="btn btn-primary">{{_trans('common.Update')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

{{--            Customer Detals--}}
            <div class="col-12 col-lg-4 ">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title m-0"><strong>{{_trans('order.Customer Details')}}</strong></h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <div class="avatar me-2">
                                <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle"/>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-body text-nowrap">
                                    <h6 class="mb-0">{{ $order->user->name }}</h6>
                                </a>
                                <small class="text-muted">Username: #58909</small>
                                <input type="number" hidden value="{{ $order->user->id }}" name="user_id">
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-start align-items-center mb-4">
                            <span
                                class="avatar rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center"><i
                                    class="ti ti-shopping-cart ti-sm"></i></span>
                            <h6 class="text-body text-nowrap mb-0">12 Orders</h6>
                        </div> --}}
                        <div class="d-flex justify-content-between">
                            <h6><strong>{{_trans('contact.Contact').' '._trans('common.Info')}}</strong></h6>
                        </div>
                        <p class="mb-1">Email: {{ $order->user->email }}</p>
                        <p class="mb-0">Phone: {{ $order->user->phone }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h6 class="card-title m-0">{{_trans('order.Shipping Address')}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($shipping_addresses as $shipping_address)
                                <div class="col-6 mb-2">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content"
                                               for="shippingAddress{{ $shipping_address->id }}">
                                                <span class="custom-option-body">

                                                    <small>{{_trans('common.Name')}}:
                                                        {{ $shipping_address->name }}</small>
                                                    <br>
                                                    <small>{{_trans('common.Email')}}:
                                                        {{ $shipping_address->email }}</small><br>
                                                    <small>{{_trans('common.Phone')}}:
                                                        {{ $shipping_address->phone }}</small><br>
                                                    <small>{{_trans('contact.Street')}}:
                                                        {{ $shipping_address->street_address }}</small><br>
                                                    <small>State:
                                                        {{ $shipping_address->state }}</small><br>
                                                    <small>{{_trans('contact.ZIP Code')}}:
                                                        {{ $shipping_address->zip_code }}</small><br>
                                                    <small>{{_trans('contact.Country')}}:
                                                        {{ $shipping_address->country }}</small><br>
                                                </span>
                                            <input name="shippingAddressId" class="form-check-input" type="radio"
                                                   value="{{ $shipping_address->id }}"
                                                   id="shippingAddress{{ $shipping_address->id }}"/>
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-6 mb-2">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content"
                                           for="shippingAddress{{ $order->id }}">
                                            <span class="custom-option-body">

                                                <small>{{_trans('common.Name')}}: {{optional($order->shipping_address)->name}}
                                                    </small>
                                                <br>
                                                <small>{{_trans('common.Email')}}:{{optional($order->shipping_address)->email}}
                                                   </small><br>
                                                <small>{{_trans('common.Phone')}}:{{optional($order->shipping_address)->phone}}
                                                    </small><br>
                                                <small>{{_trans('contact.Street')}}:{{optional($order->shipping_address)->street_address}}
                                                    </small><br>
                                                <small>State:{{optional($order->shipping_address)->state}}
                                                    </small><br>
                                                <small>{{_trans('contact.ZIP Code')}}:{{optional($order->shipping_address)->zip_code}}
                                                    </small><br>
                                                <small>{{_trans('contact.Country')}}: {{optional($order->shipping_address)->country}}
                                                    </small><br>
                                            </span>
                                        <input name="shippingAddressId" class="form-check-input" type="radio"
                                               value=""
                                               id="shippingAddress{{ $order->id }}" checked/>
                                    </label>
                                </div>
                            </div>

                            @error('shippingAddressId')
                            <span class="text-danger editDescriptionError error">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h6 class="card-title m-0">{{_trans('common.Note')}}</h6>
                    </div>
                    <div class="card-body">
                        <textarea name="note" placeholder="Note" class="form-control" id="note" cols="30"
                                  rows="5">{{ $order->note }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">{{_trans('order.Add New Address')}}</h3>
                        </div>
                        <form id="editUserForm" class="row g-3" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalEditUserCountry">{{_trans('order.Select Product')}}</label>
                                <select id="modalProductSelect" name="modalEditUserCountry" class="select2 form-select"
                                    data-allow-clear="true">
                                    <option value="">{{_trans('order.Select Product')}}</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div id="variantsWrapper" class="col-12">

                            </div>
                            <div class="col-12">
                                <h6 id="priceWrapper"> price: {{ getCurrency() }} <span id="modalPrice"></span> </h6>
                            </div>


                            <div class="col-12 text-center">
                                <button type="button" id="addItemSubmitButton" disabled
                                    class="btn btn-primary me-sm-3 me-1">{{_trans('common.Submit')}}</button>
                                <button id="modalClose" type="reset" class="btn btn-label-secondary"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    {{_trans('common.Cancel')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@push('scripts')
    <script>
        $(function() {

            calculateTotalPrices();


            $(document).on('change', '.charges', function() {

                calculateTotalPrices();
            });

            $(document).on('change', '.quantity', function() {
                let product_id = $(this).attr('data-product_id');
                let quantity = $(this).val();
                let price = $(`#product-${product_id}-price`).val();
                let total_price = parseFloat(price) * parseFloat(quantity);


                $(`#product-${product_id}-total_price-view`).text(total_price.toFixed(2));
                $(`#product-${product_id}-total_price`).val(total_price.toFixed(2));
                calculateTotalPrices();
            });


            function calculateTotalPrices() {

                let subtotal = 0.00;
                let total = 0
                $(".total_price_of_product").each(function(index, element) {
                    let value = $(element).val();

                    subtotal += parseFloat(value);
                });

                total += parseFloat(subtotal).toFixed(2);

                let discount_amount = parseFloat(calculateDiscountAmount(total));
                total -= discount_amount;
                let tax_amount = parseFloat(calculateTaxAmount(total));
                let shipping_charge = parseFloat($('#shipping_charge').val());

                total += tax_amount;
                total += shipping_charge;

                $('#sub_total').text(parseFloat(subtotal).toFixed(2));
                $('#sub_total_input').val(parseFloat(subtotal).toFixed(2));
                $('#total').text(parseFloat(total).toFixed(2));
                $('#total_input').val(parseFloat(total).toFixed(2));
            }

            function calculateDiscountAmount(subtotal) {
                let discount_type = $('#discount_type').find(":selected").val();
                let discount_value = $('#discount_value').val() == "" ? 0.00 : $('#discount_value').val();

                let discount_amount = 0;

                if (discount_type == 1) {
                    discount_amount = (discount_value / 100) * subtotal;
                }
                if (discount_type == 2) {
                    discount_amount = discount_value;
                }

                $('#discount_amount').text(parseFloat(discount_amount).toFixed(2));
                $('#discount_amount_input').val(parseFloat(discount_amount).toFixed(2));

                return parseFloat(discount_amount).toFixed(2);
            }

            function calculateTaxAmount(subtotal) {
                let tax_type = $('#tax_type').find(":selected").val();
                let tax_value = $('#tax_value').val() == "" ? 0.00 : $('#tax_value').val();

                let tax_amount = 0;


                if (tax_type == 1) {
                    tax_amount = (tax_value / 100) * subtotal;
                }
                if (tax_type == 2) {
                    tax_amount = tax_value;
                }
                $('#tax').text(parseFloat(tax_amount).toFixed(2));
                $('#tax_amount_input').val(parseFloat(tax_amount).toFixed(2));

                return parseFloat(tax_amount).toFixed(2);
            }


            $(document).on("click", ".deleteProduct", function() {

                let id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Deleted!',
                            text: 'Product remove from cart list',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect waves-light'
                            }
                        });
                        $(`#cartRow${id}`).remove();
                        calculateTotalPrices();
                    }
                });
            });


            let variation = [];
            let attribute = [];
            let attribute_values = [];
            let price = 0;
            let product = {};
            let countRow = -1;
            let totalItems = {{ count($order->items) }} + 1;


            $('#modalProductSelect').on('change', function() {
                let product_id = $(this).val();
                if (product_id != '') {
                    console.log('here');

                    $.ajax({
                        url: '/order/product/' + product_id,
                        method: 'get',
                        success: function(response) {
                            product = response;
                            console.log(response);

                            variation = response.variants ?? [];
                            console.log(variation, 'this is response variation');
                            let s = '';
                            $(response.choice_options).each(function(index, value) {
                                s +=
                                    `
                                    <div class="row mb-1">
                                        <div class="col-2">${value.name}:</div>
                                        <div class="col-8">`;
                                $(value.pivot.value).each(function(row, data) {
                                    s +=
                                        `<span class="badge bg-label-secondary me-1 cursor-pointer attribute_value attribute${value.name}" data-attribute = "${value.name}" data-value = "${data}" data-index="${index}" >${data}</span>`;

                                });

                                s += `</div>
                                    </div>
                                `;
                            });

                            if (response.choice_options.length == 0) {
                                $('#priceWrapper').show();
                                price = response.discount_price;
                                $('#modalPrice').text(price);
                                $('#addItemSubmitButton').prop('disabled', false);
                            }

                            $('#variantsWrapper').empty();
                            $('#variantsWrapper').append(s);
                        },
                        error: function(error) {
                            console.log(error.responseJSON.message);
                            // handle the error case
                        }
                    });
                }
            })


            $(document).on('click', '.attribute_value', function() {
                attribute_values[$(this).data('index')] = $(this).data('value');
                attribute[$(this).data('index')] = $(this).data('attribute');

                $(`.attribute${$(this).data('attribute')}`).addClass('bg-label-secondary');
                $(`.attribute${$(this).data('attribute')}`).removeClass('bg-primary');
                $(this).addClass('bg-primary');
                $(this).removeClass('bg-label-secondary');

                matchVariant();
            });

            $('#addItemButton').on('click', function() {

                $('#variantsWrapper').empty();
                $('#priceWrapper').hide();
                attribute_values = [];

            })

            function matchVariant() {
                let variationString = '';
                $(attribute_values).each(function(index, value) {
                    variationString += `${value}-`;
                });
                variationString = variationString.substring(0, variationString.length - 1);

                $(variation).each(function(index, value) {
                    if (value.variant == variationString) {
                        $('#priceWrapper').show();
                        $('#modalPrice').text(value.price);
                        price = value.price;
                        $('#addItemSubmitButton').prop('disabled', false);
                    }
                });
            }

            $('#addItemSubmitButton').on('click', function() {
                let s =

                    `
                <tr id="cartRow${countRow}">
                                            <td><i class="ti ti-trash text-danger cursor-pointer deleteProduct"
                                                    data-id="${countRow}"></i></td>

                                            <td>
                                                <img src="${product.thumbnail_img}"
                                                    class="me-2" height="50px" alt="">
                                                 ${product.name}
                                                <input type="number" value="${product.id}"
                                                    hidden
                                                    name="product[${totalItems}][product_id]">
                                            </td>
                                            <td>`;
                if (attribute.length > 0) {
                    $(attribute).each(function(index, value) {
                        s +=
                            `
                        <span><b class="me-1">${value}:</b><span
                                                                class="text-primary">${attribute_values[index]}</span></span><br>
                                                        <input type="text" value="${value}" hidden
                                                            name="product[${totalItems}][variant][${index}][attribute]">
                                                        <input type="text" value="${attribute_values[index]}" hidden
                                                            name="product[${totalItems}][variant][${index}][value]">

                        `;
                    });

                } else {
                    s += '---'
                }




                s += `</td>
                                            <td>
                                                {{ getCurrency() }}
                                                <span> ${price} </span>
                                                <input class="form-control w-60"
                                                    id="product-${totalItems}-price"
                                                    type="number" hidden
                                                    name="product[${totalItems}][price]"
                                                    value="${price}" />
                                            </td>

                                            </td>
                                            <td>
                                                <input class="form-control w-60 quantity" type="number"
                                                    data-product_id="${totalItems}"
                                                    name="product[${totalItems}][quantity]"
                                                    value="1" min="1" />
                                            </td>
                                            <td>
                                                $
                                                <span
                                                    id="product-${totalItems}-total_price-view">${price}</span>
                                                <input class="total_price_of_product" type="text" hidden
                                                    id="product-${totalItems}-total_price"
                                                    value="${price}">
                                            </td>
                                        </tr>

                `;

                $('#orderItemWrapper').append(s);
                countRow--;
                totalItems++;
                attribute = [];
                attribute_values = [];
                calculateTotalPrices();
                $('#modalClose').click();

            });

        });
    </script>
@endpush
