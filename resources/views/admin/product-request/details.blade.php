@extends('layouts.master')

@section('title', $title ?? __('Cart Details'))

@section('content')


    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb('Cart Details', ['#' => 'Order Management','##'=>_trans('order.Customer').' '._trans('order.Order'), 'cart' => 'Cart Details']) !!}

        <!-- Order Details Table -->
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
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
                                <tbody>

                                    @foreach ($cart_items as $cart_item)
                                        <tr id="cartRow{{ $cart_item->id }}">
                                            <td><i class="ti ti-trash text-danger cursor-pointer deleteProduct"
                                                    data-id="{{ $cart_item->id }}"></i></td>

                                            <td>
                                                <img src="{{ getFilePath(optional($cart_item->product)->thumbnail_img) }}"
                                                    class="me-2" height="50px" alt="">
                                                {{ optional($cart_item->product)->name }}
                                                <input type="number" value="{{ optional($cart_item->product)->id }}" hidden
                                                    name="product[{{ optional($cart_item->product)->id }}][product_id]">
                                            </td>
                                            <td>

                                                @foreach ($cart_item->variation as $key => $item)
                                                    <span><b class="me-1">{{ $item['attribute'] }}:</b><span
                                                            class="text-primary">{{ $item['value'] }}</span></span><br>
                                                    <input type="text" value="{{ $item['attribute'] }}" hidden
                                                        name="product[{{ optional($cart_item->product)->id }}][variant][{{ $key }}][attribute]">
                                                    <input type="text" value="{{ $item['value'] }}" hidden
                                                        name="product[{{ optional($cart_item->product)->id }}][variant][{{ $key }}][value]">
                                                @endforeach

                                            </td>
                                            <td>
                                                <span>{{ getPriceFormat($cart_item->price) }}</span>
                                                <input class="form-control w-60"
                                                    id="product-{{ optional($cart_item->product)->id }}-price"
                                                    type="number" hidden
                                                    name="product[{{ optional($cart_item->product)->id }}][price]"
                                                    value="{{ $cart_item->price }}" />
                                            </td>

                                            </td>
                                            <td>
                                                <input class="form-control w-60 quantity" type="number"
                                                    data-product_id="{{ optional($cart_item->product)->id }}"
                                                    name="product[{{ optional($cart_item->product)->id }}][quantity]"
                                                    value="{{ $cart_item->quantity }}" min="1" />
                                            </td>
                                            <td>
                                                {{ getCurrency() }}
                                                <span
                                                    id="product-{{ optional($cart_item->product)->id }}-total_price-view">{{ number_format($cart_item->price * $cart_item->quantity, 2) }}</span>
                                                <input class="total_price_of_product" type="text" hidden
                                                    id="product-{{ optional($cart_item->product)->id }}-total_price"
                                                    value="{{ $cart_item->price * $cart_item->quantity }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @error('product')
                                <p class="text-danger error ms-2">{{ $message }}</p>
                            @enderror
                            <div class="d-flex flex-column justify-content-end align-items-end m-3 mb-2 p-1">

                                <div class="d-flex justify-content-between mb-2 w-px-300">
                                    <span class="text-heading"><strong>Subtotal:</strong></span>
                                    <h6 class="mb-0"><strong>{{ getCurrency() }}<span id="sub_total">0</span> </strong>
                                    </h6>
                                    <input type="text" name="sub_total" hidden id="sub_total_input" value="0">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="d-flex me-4 w-px-300">
                                        <select name="discount_type" class="form-select me-2 charges" id="discount_type"
                                            data-placeholder="Discount type">
                                            <option selected value="0">{{_trans('order.Discount Type')}}</option>
                                            <option value="1">{{_trans('common.Parcentage')}}</option>
                                            <option value="2">{{_trans('common.Fixed').' '._trans('common.Amount')}}</option>
                                        </select>
                                        <input type="number" class="form-control w-50 charges" name="discount_value"
                                            id="discount_value" min="0.0" value="0.00">


                                    </div>
                                    <div class="w-px-300 justify-content-between d-flex">
                                        <span class="text-heading">{{_trans('common.Discount')}}:</span>
                                        <h6 class="mb-0">{{ getCurrency() }}<span id="discount_amount">0</span> </h6>
                                        <input type="text" name="discount_amount" hidden id="discount_amount_input"
                                            value="0">

                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="d-flex me-4 w-px-300">
                                        <select name="tax_type" id="tax_type" class="form-select me-2 charges"
                                            data-placeholder="Tax type">
                                            <option selected value="0">Tax Type</option>
                                            <option value="1">{{_trans('common.Parcentage')}}</option>
                                            <option value="2">{{_trans('common.Fixed').' '._trans('common.Amount')}}</option>
                                        </select>
                                        <input type="number" class="form-control w-50 charges" name="tax_value"
                                            id="tax_value" min="0.0" value="0.00">

                                    </div>

                                    <div class="w-px-300 justify-content-between d-flex">
                                        <span class="text-heading">Tax:</span>
                                        <h6 class="mb-0">{{ getCurrency() }}<span id="tax">0</span> </h6>
                                        <input type="text" name="tax_amount" hidden id="tax_amount_input"
                                            value="0">

                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mb-2 w-px-300">
                                    <span class="text-heading">{{_trans('order.Shipping Charge')}}:</span>
                                    <div class="d-flex align-items-center">
                                        {{ getCurrency() }}<input type="number" id="shipping_charge"
                                            name="shipping_charge" class="ms-1 form-control p-1 text-end charges"
                                            style="width: 100px" min="0.0" value="0.00" />

                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between w-px-300 border-top pt-2">
                                    <h4 class=" mb-0">Total:</h4>
                                    <h4 class="mb-0">{{ getCurrency() }} <span id="total">0</span> </h4>
                                    <input type="text" name="total" hidden id="total_input" value="0">

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <button class="btn btn-primary">{{_trans('order.Place Order')}}</button>
                    </div>

                </div>
                <div class="col-12 col-lg-4 ">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title m-0"><strong>{{_trans('order.Customer Details')}}</strong></h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <div class="avatar me-2">
                                    <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="app-user-view-account.html" class="text-body text-nowrap">
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                    </a>
                                    <small class="text-muted">{{_trans('order.Username')}}: #58909</small>
                                    <input type="number" hidden value="{{ $user->id }}" name="user_id">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6><strong>{{_trans('common.Contact').' '._trans('common.Info')}}</strong></h6>
                            </div>
                            <p class="mb-1">{{_trans('common.Email')}}: {{ $user->email }}</p>
                            <p class="mb-0">{{_trans('common.Phone')}}: {{ $user->phone }}</p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <h6 class="card-title m-0">{{_trans('order.Shipping Address')}}</h6>
                            <h6 class="m-0">
                                <a href=" javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#addNewAddress">Add</a>
                            </h6>
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
                                                    <small>{{_trans('common.State')}}:
                                                        {{ $shipping_address->state }}</small><br>
                                                    <small>{{_trans('contact.ZIP Code')}}:
                                                        {{ $shipping_address->zip_code }}</small><br>
                                                    <small>{{_trans('common.Country')}}:
                                                        {{ $shipping_address->country }}</small><br>
                                                </span>
                                                <input name="shippingAddressId" class="form-check-input" type="radio"
                                                    value="{{ $shipping_address->id }}"
                                                    id="shippingAddress{{ $shipping_address->id }}" checked />
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                                @error('shippingAddressId')
                                    <span class="text-danger editDescriptionError error">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <h6 class="card-title m-0">Note</h6>
                        </div>
                        <div class="card-body">
                            <textarea name="note" placeholder="Note" class="form-control" id="note" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>

        <div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="address-title mb-2">{{_trans('common.Add').' '._trans('common.New').' '._trans('common.Address')}}</h3>
                            <p class="text-muted address-subtitle">{{_trans('common.Add').' '._trans('common.New').' '._trans('common.Address').' '._trans('common.For').' '._trans('order.Shipping')}}</p>
                        </div>
                        <form id="addNewAddressForm" class="row g-3" method="POST" action="{{route('shippingAddress.store')}}">
                            @csrf
                            <input type="number" hidden value="{{ $user->id }}" name="modalUserID">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalAddressFirstName">{{_trans('common.Full Name')}}</label>
                                <input required type="text" id="modalAddressFirstName" name="modalAddressFullName"
                                    class="form-control" placeholder="John" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalAddressLastName">{{_trans('common.Phone')}}</label>
                                <input required type="text" id="modalAddressLastName" name="modalAddressPhone"
                                    class="form-control" placeholder="Doe" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddressEmail">{{_trans('common.Email')}}</label>
                                <input type="email" required id="modalAddressEmail" name="modalAddressEmail"
                                    class="form-control" placeholder="Doe" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddressAddress1">{{_trans('common.Street').' '._trans('common.Address')}} </label>
                                <input type="text" required id="modalAddressAddress1" name="modalAddressStreet"
                                    class="form-control" placeholder="12, Business Park" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalAddressLandmark">{{_trans('contact.State')}}</label>
                                <input type="text" required id="modalAddressState" name="modalAddressState"
                                    class="form-control" placeholder="California" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalAddressZipCode">{{_trans('contact.Zip Code')}}</label>
                                <input type="text" required id="modalAddressZipCode" name="modalAddressZipCode"
                                    class="form-control" placeholder="99950" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddressZipCode">{{_trans('contact.Country')}}</label>
                                <input type="text" id="modalAddressZipCode" name="modalAddressCountry" required
                                    class="form-control" placeholder="United States of America" />
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Submit')}}</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!--/ Edit User Modal -->

        <!--/ Add New Address Modal -->
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

        });
    </script>
@endpush
