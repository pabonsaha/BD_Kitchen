@extends('user.layout.app')

@section('content')
    <!-- Banner part start -->
    <main class="mb-[60px]">
        <!-- populer kitchen description start  -->
        <section class="container mx-auto mt-[0px]">
            <img src="{{ asset('storage/' . $shop->banner) }}" alt="" style="height: 500px !important" width="100%">
        </section>

        <section class="container mx-auto mt-[40px]">
            <div class="grid grid-cols-2">

                <div class="product_id">
                    {{-- <p class="capitalize flex justify-center items-start inter-700 text-2xl text-wrap md:text-3xl lg:text-4xl mb-[40px]">Product List</p> --}}

                    {{--                    @foreach ($products as $product)--}}
                    {{--                        <div--}}
                    {{--                            class="mb-[15px] h-[120px] flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">--}}
                    {{--                            <img class="object-contain w-full rounded-t-lg h-36 md:w-48 md:rounded-none md:rounded-s-lg"--}}
                    {{--                                 src="{{ asset('storage/' . $product->thumbnail_img) }}" alt="">--}}
                    {{--                            <div class="flex flex-col justify-between p-4 leading-normal w-full">--}}
                    {{--                                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">--}}
                    {{--                                    {{ $product->name }}</h5>--}}
                    {{--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{!! $product->description !!}</p>--}}
                    {{--                                <div class="flex flex-row justify-between">--}}
                    {{--                                    <h4 class="font-semibold text-[#E32938]">{{ getPriceFormat($product->unit_price) }}</h4>--}}
                    {{--                                    <div class="hidden product_details_container">--}}
                    {{--                                        <input class="product_id" value="{{ $product->id }}">--}}
                    {{--                                        <input class="product_name" value="{{ $product->name }}">--}}
                    {{--                                        <input class="product_image"--}}
                    {{--                                               value="{{ asset('storage/' . $product->thumbnail_img) }}">--}}
                    {{--                                        <input class="product_price" value="{{ $product->unit_price }}">--}}
                    {{--                                    </div>--}}
                    {{--                                    <button class="self-end add_to_cart_button">--}}
                    {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"--}}
                    {{--                                             viewBox="0 0 13 13" fill="none">--}}
                    {{--                                            <path--}}
                    {{--                                                d="M10.4 10.4C9.6785 10.4 9.1 10.9785 9.1 11.7C9.1 12.0448 9.23696 12.3754 9.48076 12.6192C9.72456 12.863 10.0552 13 10.4 13C10.7448 13 11.0754 12.863 11.3192 12.6192C11.563 12.3754 11.7 12.0448 11.7 11.7C11.7 11.3552 11.563 11.0246 11.3192 10.7808C11.0754 10.537 10.7448 10.4 10.4 10.4ZM0 0V1.3H1.3L3.64 6.2335L2.756 7.826C2.6585 8.008 2.6 8.2225 2.6 8.45C2.6 8.79478 2.73696 9.12544 2.98076 9.36924C3.22456 9.61304 3.55522 9.75 3.9 9.75H11.7V8.45H4.173C4.1299 8.45 4.08857 8.43288 4.05809 8.4024C4.02762 8.37193 4.0105 8.3306 4.0105 8.2875C4.0105 8.255 4.017 8.229 4.03 8.2095L4.615 7.15H9.4575C9.945 7.15 10.374 6.877 10.595 6.4805L12.922 2.275C12.9675 2.171 13 2.0605 13 1.95C13 1.77761 12.9315 1.61228 12.8096 1.49038C12.6877 1.36848 12.5224 1.3 12.35 1.3H2.7365L2.1255 0M3.9 10.4C3.1785 10.4 2.6 10.9785 2.6 11.7C2.6 12.0448 2.73696 12.3754 2.98076 12.6192C3.22456 12.863 3.55522 13 3.9 13C4.24478 13 4.57544 12.863 4.81924 12.6192C5.06304 12.3754 5.2 12.0448 5.2 11.7C5.2 11.3552 5.06304 11.0246 4.81924 10.7808C4.57544 10.537 4.24478 10.4 3.9 10.4Z"--}}
                    {{--                                                fill="#E32938"/>--}}
                    {{--                                        </svg>--}}
                    {{--                                    </button>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endforeach--}}

                    <!-- New Demo Food List Section -->
                    <p class="capitalize inter-700 text-2xl text-wrap md:text-3xl lg:text-4xl mb-[10px] mt-[60px]">
                        Popular
                    </p>
                    <p class="mb-3 font-normal mb-[30px] text-gray-700">Most ordered right now.</p>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($products as $product)
                            <div
                                class="flex flex-col-reverse items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100">
                                <div class="flex flex-col justify-between  leading-normal w-full p-4">
                                    <h5 class="text-2xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h5>
                                    <h4 class="font-semibold text-[#E32938]">From
                                        tk {{ getPriceFormat($product->unit_price) }}</h4>
                                    <p class="mb-3 font-normal text-gray-700">{{strip_tags($product->description)}}</p>

                                </div>

                                <img
                                    class="p-2 object-contain w-full rounded-t-lg h-36 md:w-48 md:rounded-none md:rounded-e-lg"
                                    src="{{ asset('storage/' . $product->thumbnail_img) }}" alt="Demo Food image">
                                <button
                                    class=" mr-2 ml-2 p-6 text-[#E32938] text-2xl font-bold add_to_cart_button border border-[#E32938] w-12 h-12 rounded-full flex items-center justify-center hover:bg-[#E32938] hover:text-white transition-colors duration-200">
                                    +
                                </button>
                                <div class="hidden product_details_container">
                                    <input class="product_id" value="{{ $product->id }}">
                                    <input class="product_name" value="{{ $product->name }}">
                                    <input class="product_image"
                                           value="{{ asset('storage/' . $product->thumbnail_img) }}">
                                    <input class="product_price" value="{{ $product->unit_price }}">
                                </div>
                            </div>

                        @endforeach


                    </div>

                </div>


                <div class="max-w-md w-100 bg-white mt-40 rounded-lg border border-gray-200 shadow-md p-4">
                    <form method="GET" action="{{route('checkout')}}">
                        <input name="shop_id" class="hidden" value="{{$shop->id}}">
                        <!-- Header -->
                        <div class="bg-red-500 text-white text-center py-4 rounded-t-lg">
                            <h2 class="text-lg font-semibold">Delivery</h2>
                            <p class="text-sm">15 Min</p>
                        </div>


                        <!-- Your Items -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-4">Your Items</h3>
                            <div class="space-y-4 cart_product_list">

                                <!-- Empty Cart State -->
                                <div class="p-8 text-center empty_cart_state">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png"
                                         alt="Empty Cart"
                                         class="w-32 h-32 mx-auto mb-4 opacity-50">
                                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Your Cart is Empty</h3>
                                    <p class="text-gray-500 mb-6">Please add items from the menu to start your order</p>
                                    <button
                                        class="text-red-500 border border-red-500 px-6 py-2 rounded-full hover:bg-red-500 hover:text-white transition-colors duration-300">
                                        Browse Menu
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="border-t pt-4">
                            <h4 class="font-semibold mb-2">Order Summary</h4>
                            <div class="flex justify-between text-sm">
                                <p>Subtotal</p>
                                <p>Tk <span id="subtotal">500</span></p>
                            </div>
                            <div class="flex justify-between text-sm">
                                <p>Delivery Fee</p>
                                <p>Tk <span id="delivery_fee">{{$shop->delivery_charge}}</span></p>
                            </div>
                            <div class="flex justify-between text-lg font-semibold mt-2 border-t pt-2">
                                <p>Total</p>
                                <p>Tk <span id="total">535</span></p>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="mt-4">
                            <button class="w-full bg-red-500 text-white py-2 rounded-lg font-semibold hover:bg-red-600">
                                Go To Checkout
                            </button>

                        </div>
                    </form>
                </div>


            </div>
            {{-- Location code  --}}
{{--            <div class="max-w-md w-[636px] mx-auto bg-white mt-40 rounded-lg border border-gray-200 shadow-md p-6">--}}
{{--                <div class="flex flex-col gap-2">--}}
{{--                    <p>Delivery Address</p>--}}
{{--                    <div class="flex flex-row items-center justify-between">--}}
{{--                        <div class="flex items-center gap-2">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256"--}}
{{--                                 xml:space="preserve">--}}
{{--                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"--}}
{{--                                   transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">--}}
{{--                                    <path--}}
{{--                                        d="M 45 0 C 27.677 0 13.584 14.093 13.584 31.416 c 0 4.818 1.063 9.442 3.175 13.773 c 2.905 5.831 11.409 20.208 20.412 35.428 l 4.385 7.417 C 42.275 89.252 43.585 90 45 90 s 2.725 -0.748 3.444 -1.966 l 4.382 -7.413 c 8.942 -15.116 17.392 -29.4 20.353 -35.309 c 0.027 -0.051 0.055 -0.103 0.08 -0.155 c 2.095 -4.303 3.157 -8.926 3.157 -13.741 C 76.416 14.093 62.323 0 45 0 z M 45 42.81 c -6.892 0 -12.5 -5.607 -12.5 -12.5 c 0 -6.893 5.608 -12.5 12.5 -12.5 c 6.892 0 12.5 5.608 12.5 12.5 C 57.5 37.202 51.892 42.81 45 42.81 z"--}}
{{--                                        style="fill: #000000;"/>--}}
{{--                                </g>--}}
{{--                            </svg>--}}
{{--                            <p>Current location 22 bashabo tempu stand</p>--}}
{{--                        </div>--}}
{{--                        <button class="whitespace-nowrap px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">--}}
{{--                            Change Address--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="max-w-md w-[636px] mx-auto bg-white mt-40 rounded-lg border border-gray-200 shadow-md p-6">--}}
{{--                <div class="flex flex-row justify-between items-center">--}}
{{--                    <p> Payment Method</p>--}}

{{--                    <p>--}}
{{--                        <input type="radio" name="payment_method" value="cash_on_delivery" class="mr-2">--}}
{{--                        Cash on Delivery--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}

        </section>


    </main>
@endsection

@push('script')
    <script>
        let productsID = [];
        $(document).on('click', '.cart_increment_button', function (e) {
            e.preventDefault();
            let productID = $(this).data("id");
            let input = $(this).siblings('input');
            $(input).get(0).value++;
            $(this).siblings('span').text($(input).get(0).value);
            $(`#product_total${productID}`).text($(`#product_quantity${productID}`).get(0).value * $(`#product_price${productID}`).val());
            calculateTotalPrice();

        });
        $(document).on('click', '.cart_decrement_button', function (e) {
            e.preventDefault();
            let productID = $(this).data("id");
            let input = $(this).siblings('input');
            if ($(input).get(0).value > 1) {
                $(input).get(0).value--;
            }
            $(this).siblings('span').text($(input).get(0).value);
            $(`#product_total${productID}`).text($(`#product_quantity${productID}`).get(0).value * $(`#product_price${productID}`).val());
            calculateTotalPrice();
        });

        $('.add_to_cart_button').on('click', function () {

            $('.empty_cart_state').addClass('hidden');
            let productContainer = $(this).siblings('.product_details_container');
            console.log(productContainer);
            let productName = $(productContainer).children('.product_name').val();
            let productID = $(productContainer).children('.product_id').val();
            let productPrice = $(productContainer).children('.product_price').val();
            let productImage = $(productContainer).children('.product_image').val();

            if (productsID.includes(productID)) {

                $(`#product_quantity${productID}`).get(0).value++;
                $(`#product_total${productID}`).text($(`#product_quantity${productID}`).get(0).value * productPrice);
                calculateTotalPrice();
                return 0;
            }
            productsID.push(productID);

            if (productsID.length > 0) {
                $('#place_order_button').removeClass('hidden');
            } else {

                $('#place_order_button').addClass('hidden');
            }


            let cartProduct = `
<div class="flex items-center justify-between border-b pb-2">
                                    <div class="flex items-center">
                                        <img src="${productImage}" alt="Item Image"
                                             class="w-12 h-12 rounded-full">
                                        <div class="ml-3">
                                            <h4 class="font-medium text-sm">${productName}</h4>
                                            <p class="text-xs text-gray-500">For 1 Person</p>
                                        </div>
                                    </div>
<input type="number" value="${productID}" name="products[${productID}][id]" class="hidden">
<input type="number" class="hidden"  min="1" name="products[${productID}][quantity]" value="${productPrice}" id="product_price${productID}">
                                    <div class="text-right">
                                        <p class="text-red-500 font-semibold text-sm">Tk <span class="product_total" id="product_total${productID}">${productPrice}</span></p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <button class="text-red-500 font-bold cart_decrement_button" data-id="${productID}" >-</button>
                                            <span class="px-2 text-sm">1</span>
                                            <button class="text-red-500 font-bold cart_increment_button" data-id="${productID}">+</button>
<input type="number" class="hidden"  min="1" name="products[${productID}][quantity]" value="1" id="product_quantity${productID}">
                                        </div>
                                    </div>
                                </div>
            `;

            $('.cart_product_list').append(cartProduct);
            calculateTotalPrice();

        });


        function calculateTotalPrice() {
            let priceTotal = $('.product_total');
            let subTotal = 0;
            $(priceTotal).each(function (index, value) {
                subTotal += parseInt($(value).text());
            });
            $('#subtotal').text(subTotal);
            $('#total').text(parseInt($('#delivery_fee').text()) + subTotal);
        }
    </script>
@endpush
