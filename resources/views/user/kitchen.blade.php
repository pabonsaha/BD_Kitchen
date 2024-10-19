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
                    <p class="capitalize inter-700 text-2xl text-wrap md:text-3xl lg:text-4xl mb-[40px]">Product List</p>
                    @foreach ($products as $product)
                        <div
                            class="mb-[15px] h-[120px] flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="object-contain w-full rounded-t-lg h-36 md:w-48 md:rounded-none md:rounded-s-lg"
                                src="{{ asset('storage/' . $product->thumbnail_img) }}" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal w-full">
                                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $product->name }}</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{!! $product->description !!}</p>
                                <div class="flex flex-row justify-between">
                                    <h4 class="font-semibold text-[#E32938]">{{ getPriceFormat($product->unit_price) }}</h4>

                                    <button class="self-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 13 13" fill="none">
                                            <path
                                                d="M10.4 10.4C9.6785 10.4 9.1 10.9785 9.1 11.7C9.1 12.0448 9.23696 12.3754 9.48076 12.6192C9.72456 12.863 10.0552 13 10.4 13C10.7448 13 11.0754 12.863 11.3192 12.6192C11.563 12.3754 11.7 12.0448 11.7 11.7C11.7 11.3552 11.563 11.0246 11.3192 10.7808C11.0754 10.537 10.7448 10.4 10.4 10.4ZM0 0V1.3H1.3L3.64 6.2335L2.756 7.826C2.6585 8.008 2.6 8.2225 2.6 8.45C2.6 8.79478 2.73696 9.12544 2.98076 9.36924C3.22456 9.61304 3.55522 9.75 3.9 9.75H11.7V8.45H4.173C4.1299 8.45 4.08857 8.43288 4.05809 8.4024C4.02762 8.37193 4.0105 8.3306 4.0105 8.2875C4.0105 8.255 4.017 8.229 4.03 8.2095L4.615 7.15H9.4575C9.945 7.15 10.374 6.877 10.595 6.4805L12.922 2.275C12.9675 2.171 13 2.0605 13 1.95C13 1.77761 12.9315 1.61228 12.8096 1.49038C12.6877 1.36848 12.5224 1.3 12.35 1.3H2.7365L2.1255 0M3.9 10.4C3.1785 10.4 2.6 10.9785 2.6 11.7C2.6 12.0448 2.73696 12.3754 2.98076 12.6192C3.22456 12.863 3.55522 13 3.9 13C4.24478 13 4.57544 12.863 4.81924 12.6192C5.06304 12.3754 5.2 12.0448 5.2 11.7C5.2 11.3552 5.06304 11.0246 4.81924 10.7808C4.57544 10.537 4.24478 10.4 3.9 10.4Z"
                                                fill="#E32938" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart_list">
                    <p class="capitalize inter-700 text-2xl text-wrap md:text-3xl lg:text-4xl mb-[40px]">Cart List</p>
                    <div class="border">

                        <div class="w-auto h-auto flex flex-col items-center bg-white border-b md:flex-row">
                            <img class="object-cover rounded-t-lg h-[50px] w-[150px] md:rounded-none md:rounded-s-lg ml-2"
                                src="{{ asset('storage/' . $shop->banner) }}" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal w-full">
                                <h5 class="mb-2 text-base font-semibold tracking-tight text-gray-900 dark:text-white">
                                    test Product</h5>
                                <div class="flex flex-row">
                                    <button
                                        class="text-[#E32938] text-extrabold text-2xl mr-2 cart_increment_button">+</button>
                                    <input type="number" min="1" disabled value="1"
                                        class="w-[50px] border border-[#E32938] text-[#E32938] text-extrabold pl-2 text-center">
                                    <button
                                        class="text-[#E32938] text-extrabold text-xl ml-2 cart_decrement_button">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="mt-2 flex items-center btn text-[#E32938] border border-solid border-[#E3293880] bg-[#FCEAEB] m-auto">Order</button>
                </div>
            </div>

        </section>


    </main>
@endsection

@push('script')
    <script>
        $(".cart_increment_button").click(function() {
            let input = $(this).siblings('input');
            $(input).get(0).value++;
        });
        $(".cart_decrement_button").click(function() {
            let input = $(this).siblings('input');
            if ($(input).get(0).value > 1) {
                $(input).get(0).value--;
            }
        });
    </script>
@endpush
