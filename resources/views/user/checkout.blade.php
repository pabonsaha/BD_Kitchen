@extends('user.layout.app')

@section('content')
    <!-- Banner part start -->
    <main class="mb-[60px]">
        <!-- populer kitchen description start  -->
        <section class="container mx-auto mt-[0px] text-center">
            <h4 class="text-[#E32938] capitalize inter-700 text-2xl text-wrap md:text-3xl lg:text-4xl m-[40px]">Checkout</h4>
        </section>
        <form method="POST" action="{{route('order.store')}}">
            @csrf
            <section class="container mx-auto mt-[40px]">
            <div class="grid grid-cols-2">

                <input class="hidden" name="shipping_charge" value="{{$shop->delivery_charge}}">
                <input class="hidden" name="seller_id" value="{{$shop->user_id}}">

                <div class="product_id">
                    <p class="capitalize inter-700 text-xl text-wrap  mb-[40px]">Product List</p>
                    @php
                        $subTotal = 0;
                    @endphp
                    @foreach ($products as $product)

                        <input class="hidden" name="product[{{$product->id}}][id]" value="{{$product->id}}">
                        <input class="hidden" name="product[{{$product->id}}][price]" value="{{$product->unit_price}}">
                        <input class="hidden" name="product[{{$product->id}}][quantity]" value="{{$product->quantity_value}}">

                        <div
                            class="mb-[15px] h-[120px] flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="object-contain w-full rounded-t-lg h-36 md:w-48 md:rounded-none md:rounded-s-lg"
                                 src="{{ asset('storage/' . $product->thumbnail_img) }}" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal w-full">
                                <h5 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $product->name }}</h5>
                                <div class="flex flex-row justify-between">
                                    <h4 class="font-semibold text-[#E32938]">{{ getPriceFormat($product->unit_price) }} *
                                        {{$product->quantity_value}}</h4>
                                    <div class="hidden product_details_container">
                                        <input class="product_id" value="{{$product->id}}">
                                        <input class="product_name" value="{{$product->name}}">
                                        <input class="product_image" value="{{ asset('storage/' . $product->thumbnail_img) }}">
                                        <input class="product_price" value="{{$product->unit_price}}">
                                    </div>
                                    <h4 class="font-semibold text-[#E32938]">{{ getPriceFormat($product->unit_price* $product->quantity_value) }}</h4>

                                </div>
                            </div>
                        </div>
                        @php
                            $subTotal += (int)$product->unit_price;
                        @endphp
                    @endforeach
                    <div class="mt-[20px] flex flex-row justify-between   md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <p class="font-semibold">Subtotal</p>
                        <p class="text-[#E32938] font-semibold">{{getPriceFormat($subTotal)}}</p>
                        <input name="sub_total" class="hidden" value="{{$subTotal}}">
                    </div>
                    <div class="mt-[10px] flex flex-row justify-between   md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <p class="font-semibold">Delivery Charge</p>
                        <p class="text-[#E32938] font-semibold">{{getPriceFormat($shop->delivery_charge)}}</p>
                    </div>
                    <div class="mt-[10px] flex flex-row justify-between   md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <p class="font-semibold">Total</p>
                        <p class="text-[#E32938] font-semibold">{{getPriceFormat($subTotal+$shop->delivery_charge)}}</p>
                        <input name="total" class="hidden" value="{{$subTotal+$shop->delivery_charge}}">

                    </div>
                </div>

                <div class="cart_list">
                    <p class="capitalize inter-700 text-xl text-wrap mb-[12px]">Shipping Address</p>


                            <div class="form">
                                <label for="Name">Name</label>
                                <input class="inputForm" required value="{{old('name')}}" type="text" name="shipping_addresses_name">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form">
                                <label for="Name">Phone Number</label>
                                <input class="inputForm" required type="tel" value="{{old('phone')}}" name="shipping_addresses_phone">
                                @error('phone')
                                <span class="error">{{ $message }}</span>
                                @enderror

                            </div>

                    <div class="form">
                        <label for="Name">Street Address</label>
                        <input class="inputForm" required value="{{old('name')}}" type="text" name="shipping_addresses_street_address">
                        @error('name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form">
                        <label for="Name">City</label>
                        <input class="inputForm" required value="{{old('name')}}" type="text" name="shipping_addresses_city">
                        @error('name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>



                </div>
            </div>

            <div>
                <button class="mt-2 px-6 flex items-center btn text-[#E32938] border border-solid border-[#E3293880] bg-[#FCEAEB] m-auto" type="submit">Place Order</button>
            </div>

        </section>

        </form>


    </main>
@endsection

@push('script')

@endpush

@push('css')
    <style>
        #registerContent {
            font-family: "Inter", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-variation-settings: "slnt" 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 80vh;
        }

        #mainContent {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 70%;
            height: 90%;
            gap: 2
        }

        #imagecontainer {

            width: 50%;
            height: 100%;
            display: flex;
            justify-content: flex-end;
        }

        #imagecontainer img {
            width: 80%;
            height: inherit;

        }

        #formcontainer {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #formcontainer h4 {
            color: #E32938;
            font-size: 24px;
            font-weight: bold;
        }

        .form {
            display: flex;
            flex-direction: column;
            margin-bottom: 8px;
        }

        .form input {
            width: 300px;
            border: 1px solid rgb(168, 168, 168);
            border-radius: 3px;
            height: 30px;
            padding-left: 5px;
        }

        .form .error {
            font-size: 12px;
            color: #E32938;
        }

        .submit {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;

        }

        .submit p {
            font-size: 14px;
            align-self: flex-end;
            margin-bottom: 8px;
            margin-top: 0px;
        }

        .submit p a {
            color: #E32938;
            font-weight: bold;
        }

        .submit button {
            background-color: #E32938;
            color: white;
            font-weight: 400;
            font-size: 16px;
            padding: 5px 20px;
            border-radius: 5px;
        }
    </style>
@endpush
