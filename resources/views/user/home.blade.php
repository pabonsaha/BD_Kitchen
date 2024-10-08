@extends('user.layout.app')

@section('content')
    <!-- Banner part start -->
    <main>
        <!-- Missing Home Made Start -->
        <section>
            <div
                class="w-[320px] md:w-[550px] lg:w-[1034px] text-center box-shadow border-radius2 bg-gradient-to-b from-[#E329380D] to-[#E3293800] container mx-auto">
                <h1 class="text-[#455A64] inter-500 text-xl md:text-4xl lg:text-[64px] pt-[91px] pb-[41px]">
                    Missing Home Made <span class="text-[#E32938]">Food?</span>
                </h1>
                <p class="lg:text-[32px] pt-[20px] text-[#575A5B] inter-400 md:text-xl text-xs pb-4">
                    Homecooked Meals & Delicacies
                </p>
                <div class="flex items-center justify-center gap-1 text-wrap lg:text-[32px] md:text-xl text-xs capitalize">
                    <p class="text-[#575A5B] inter-400">prepared by</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path
                            d="M16 0L21.8496 7.94866L31.2169 11.0557L25.4649 19.0753L25.4046 28.9443L16 25.952L6.59544 28.9443L6.53509 19.0753L0.783095 11.0557L10.1504 7.94866L16 0Z"
                            fill="#00A86B" />
                        <path
                            d="M14.8643 20.8528L10.668 16.6564L11.717 15.6074L14.8643 18.7546L21.6189 12L22.668 13.0491L14.8643 20.8528Z"
                            fill="white" />
                    </svg>
                    <p class="text-[#575A5B] inter-400">
                        <span class="text-[#00A86B]">Verified </span>homechefs NEAR YOU
                    </p>
                </div>

                <div class="pt-[57px] flex justify-center pb-[92px]">
                    <input type="text" placeholder="Enter Your Location"
                        class="input border-radius4 border border-solid border-[#E3293826] w-fit md:w-[306px] md:h-[46px]" />
                    <button class="btn w-fit md:w-[148px] md:h-[46px] bg-[#E32938] text-white border-radius3">
                        Find Kitchen
                    </button>
                </div>
            </div>
        </section>
        <!-- Missing Home Made End -->

        <!-- Favourite Bengeli Food Start -->
        <section>
            <div class="container mx-auto mt-[71px]">
                <h1 class="capitalize inter-700 text-center text-2xl text-wrap md:text-3xl lg:text-4xl mb-[63px]">
                    Your favourite <span class="text-[#E32938]">Bangali </span>Food
                </h1>
                <div
                    class="flex justify-center items-center flex-col md:flex-row lg:flex-row gap-6 text-[black] inter-600 mb-[50px]">
                    <a href="#" target="_blank"
                        class="hover:bg-[#FCEAEB] hover:text-[#E32938] menu-padding menu-border_radius">Mixed</a>
                    <a href="#" target="_blank"
                        class="hover:bg-[#FCEAEB] hover:text-[#E32938] menu-padding menu-border_radius">Breakfast</a>
                    <a href="#" target="_blank"
                        class="hover:bg-[#FCEAEB] hover:text-[#E32938] menu-padding menu-border_radius">Lunch</a>
                    <a href="#" target="_blank"
                        class="hover:bg-[#FCEAEB] hover:text-[#E32938] menu-padding menu-border_radius">Dinner</a>
                    <a href="#" target="_blank"
                        class="hover:bg-[#FCEAEB] hover:text-[#E32938] menu-padding menu-border_radius">Dessert</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 lg:grid-cols-4">
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 22.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Fish</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 23.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Chicken</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 24.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Beef</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 25.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Vegetable</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 26.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Biriyani</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 27.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Kabab</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 28.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Butter Nan</h3>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('bd-kitten-assets/images/Rectangle 29.png') }}" alt="" />
                        <h3 class="inter-700 mt-4">Dessert</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Favourite Bengeli Food End -->

        <!-- Popular kitchen part start -->

        <!-- populer kitchen description start  -->
        <section class="container mx-auto mt-[60px]">
            <div class="text-center">
                <h3 class="text-4xl inter-700 text-[#455A64] mb-[40px]">
                    <span class="text-[#E32938]">Popular </span>Kitchen Near You
                </h3>
                <p class="text-[18px] text-[#455A64]">
                    your go-to destination for the most delectable Bengali cuisine right
                    in your neighborhood.
                </p>
            </div>
            <div class="lg:text-right text-center md:text-right mt-[21px]">
                <a href="{{route('kitchens')}}" class="btn bg-[#E32938] text-white border-radius5">
                    See All
                </a>
            </div>
        </section>
        <!-- populer kitchen description  end -->

        <!-- popular kitchen card item start -->

        <section class="container mx-auto mt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($shops as $shop)
                <a href="{{route('kitchen.index',$shop->slug)}}">
                    <div class="flex flex-col items-center justify-center">
                        <div class="card w-[306px] h-[327px] asset-shadow">
                            <figure class="px-[12px] pt-[40px]">
                                <img src="{{getFilePath($shop->banner)}}" alt="asset1" />
                            </figure>
                            <div class="flex justify-between items-center px-[12px] py-[12px]">
                                <div>
                                    <p class="text-[14px] text-[#455A64] inter-400">{{$shop->user->name}}</p>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M8 0L10.6756 4.31735L15.6085 5.52786L12.3292 9.40665L12.7023 14.4721L8 12.552L3.29772 14.4721L3.67079 9.40665L0.391548 5.52786L5.3244 4.31735L8 0Z"
                                            fill="#F4CE00" />
                                    </svg>
                                    <p class="ml-2 text-[#455A64] inter-400">
                                        4.9 (1000+) Reviews
                                    </p>
                                </div>
                            </div>

                            <h2 class="text-[#455A64] inter-700 text-[22px] px-[12px] py-[12px]">
                                {{$shop->shop_name}}
                            </h2>
                            <div class="flex items-center px-[12px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.6 1.2216V0H8.4V1.2216C6.54483 1.36457 4.80188 2.16601 3.48575 3.48126C2.16962 4.79651 1.36701 6.53893 1.2228 8.394H0V9.594H1.2228C1.36647 11.4503 2.1686 13.1942 3.48459 14.5113C4.80057 15.8284 6.54381 16.632 8.4 16.7772V18H9.6V16.7772C11.4562 16.632 13.1994 15.8284 14.5154 14.5113C15.8314 13.1942 16.6335 11.4503 16.7772 9.594H18V8.394H16.7772C16.633 6.53893 15.8304 4.79651 14.5143 3.48126C13.1981 2.16601 11.4552 1.36457 9.6 1.2216ZM9.6 3.6V8.394H14.4V9.594H9.6V14.4H8.4V9.594H3.6V8.394H8.4V3.6H9.6Z"
                                        fill="#455A64" />
                                </svg>
                                <p class="text-[#455A64] text-base ml-[12px]">
                                    {{$shop->location}}
                                </p>
                            </div>
                            <div class="flex justify-around items-center pb-[20px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M9 0C13.9707 0 18 4.0293 18 9C18 13.9707 13.9707 18 9 18C4.0293 18 0 13.9707 0 9C0 4.0293 4.0293 0 9 0ZM9 3.6C8.7613 3.6 8.53239 3.69482 8.3636 3.8636C8.19482 4.03239 8.1 4.2613 8.1 4.5V9C8.10005 9.23868 8.19491 9.46756 8.3637 9.6363L11.0637 12.3363C11.2334 12.5002 11.4608 12.591 11.6968 12.5889C11.9327 12.5869 12.1585 12.4922 12.3253 12.3253C12.4922 12.1585 12.5869 11.9327 12.5889 11.6968C12.591 11.4608 12.5002 11.2334 12.3363 11.0637L9.9 8.6274V4.5C9.9 4.2613 9.80518 4.03239 9.6364 3.8636C9.46761 3.69482 9.23869 3.6 9 3.6Z"
                                        fill="#455A64" />
                                </svg>
                                <p> {{$shop->delivery_time}}</p>

                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                    viewBox="0 0 18 16" fill="none">
                                    <path
                                        d="M3.75 14.475C3.05381 14.475 2.38613 14.1984 1.89384 13.7062C1.40156 13.2139 1.125 12.5462 1.125 11.85C1.125 11.1538 1.40156 10.4861 1.89384 9.99384C2.38613 9.50156 3.05381 9.225 3.75 9.225C4.44619 9.225 5.11387 9.50156 5.60616 9.99384C6.09844 10.4861 6.375 11.1538 6.375 11.85C6.375 12.5462 6.09844 13.2139 5.60616 13.7062C5.11387 14.1984 4.44619 14.475 3.75 14.475ZM3.75 8.1C2.75544 8.1 1.80161 8.49509 1.09835 9.19835C0.395088 9.90161 0 10.8554 0 11.85C0 12.8446 0.395088 13.7984 1.09835 14.5016C1.80161 15.2049 2.75544 15.6 3.75 15.6C4.74456 15.6 5.69839 15.2049 6.40165 14.5016C7.10491 13.7984 7.5 12.8446 7.5 11.85C7.5 10.8554 7.10491 9.90161 6.40165 9.19835C5.69839 8.49509 4.74456 8.1 3.75 8.1ZM11.1 6.6H14.25V5.25H11.85L10.395 2.7975C10.1775 2.4225 9.75 2.175 9.3 2.175C8.9475 2.175 8.625 2.3175 8.4 2.55L5.625 5.3175C5.3925 5.55 5.25 5.85 5.25 6.225C5.25 6.6975 5.4975 7.095 5.8875 7.3275L8.4 8.85V12.6H9.75V7.725L8.0625 6.4875L9.8025 4.725M14.25 14.475C13.5538 14.475 12.8861 14.1984 12.3938 13.7062C11.9016 13.2139 11.625 12.5462 11.625 11.85C11.625 11.1538 11.9016 10.4861 12.3938 9.99384C12.8861 9.50156 13.5538 9.225 14.25 9.225C14.9462 9.225 15.6139 9.50156 16.1062 9.99384C16.5984 10.4861 16.875 11.1538 16.875 11.85C16.875 12.5462 16.5984 13.2139 16.1062 13.7062C15.6139 14.1984 14.9462 14.475 14.25 14.475ZM14.25 8.1C13.2554 8.1 12.3016 8.49509 11.5983 9.19835C10.8951 9.90161 10.5 10.8554 10.5 11.85C10.5 12.8446 10.8951 13.7984 11.5983 14.5016C12.3016 15.2049 13.2554 15.6 14.25 15.6C14.7425 15.6 15.2301 15.503 15.6851 15.3145C16.14 15.1261 16.5534 14.8499 16.9016 14.5016C17.2499 14.1534 17.5261 13.74 17.7145 13.2851C17.903 12.8301 18 12.3425 18 11.85C18 11.3575 17.903 10.8699 17.7145 10.4149C17.5261 9.95997 17.2499 9.54657 16.9016 9.19835C16.5534 8.85013 16.14 8.57391 15.6851 8.38545C15.2301 8.197 14.7425 8.1 14.25 8.1ZM12 2.7C12.75 2.7 13.35 2.1 13.35 1.35C13.35 0.6 12.75 0 12 0C11.25 0 10.65 0.6 10.65 1.35C10.65 2.1 11.25 2.7 12 2.7Z"
                                        fill="#455A64" />
                                </svg>
                                <p>{{$shop->delivery_charge}}</p>

                                <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41"
                                    viewBox="0 0 41 41" fill="none">
                                    <path d="M0 0H38C39.6569 0 41 1.34315 41 3V41H3C1.34315 41 0 39.6569 0 38V0Z"
                                        fill="#FCEAEB" />
                                    <path
                                        d="M14.5 14.125C14.1353 14.125 13.7856 14.2699 13.5277 14.5277C13.2699 14.7856 13.125 15.1353 13.125 15.5V26.5C13.125 26.8647 13.2699 27.2144 13.5277 27.4723C13.7856 27.7301 14.1353 27.875 14.5 27.875H25.5C25.8647 27.875 26.2144 27.7301 26.4723 27.4723C26.7301 27.2144 26.875 26.8647 26.875 26.5V25.8125C26.875 25.2655 27.0923 24.7409 27.4791 24.3541C27.8659 23.9673 28.3905 23.75 28.9375 23.75C29.4845 23.75 30.0091 23.9673 30.3959 24.3541C30.7827 24.7409 31 25.2655 31 25.8125V26.5C31 27.9587 30.4205 29.3576 29.3891 30.3891C28.3576 31.4205 26.9587 32 25.5 32H14.5C13.0413 32 11.6424 31.4205 10.6109 30.3891C9.57946 29.3576 9 27.9587 9 26.5V15.5C9 14.0413 9.57946 12.6424 10.6109 11.6109C11.6424 10.5795 13.0413 10 14.5 10H15.1875C15.7345 10 16.2591 10.2173 16.6459 10.6041C17.0327 10.9909 17.25 11.5155 17.25 12.0625C17.25 12.6095 17.0327 13.1341 16.6459 13.5209C16.2591 13.9077 15.7345 14.125 15.1875 14.125H14.5ZM22.0625 14.125C21.5155 14.125 20.9909 13.9077 20.6041 13.5209C20.2173 13.1341 20 12.6095 20 12.0625C20 11.5155 20.2173 10.9909 20.6041 10.6041C20.9909 10.2173 21.5155 10 22.0625 10H28.9375C29.4845 10 30.0091 10.2173 30.3959 10.6041C30.7827 10.9909 31 11.5155 31 12.0625V18.9375C31 19.4845 30.7827 20.0091 30.3959 20.3959C30.0091 20.7827 29.4845 21 28.9375 21C28.3905 21 27.8659 20.7827 27.4791 20.3959C27.0923 20.0091 26.875 19.4845 26.875 18.9375V17.04L23.52 20.395C23.129 20.7593 22.6119 20.9577 22.0776 20.9482C21.5432 20.9388 21.0334 20.7223 20.6555 20.3445C20.2777 19.9666 20.0612 19.4568 20.0518 18.9224C20.0423 18.3881 20.2407 17.871 20.605 17.48L23.96 14.125H22.0625Z"
                                        fill="#E32938" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>
        </section>

        <!-- popular kitchen card item end -->

        <!-- Popular kitchen part end -->
    </main>
    <!-- Banner Part End -->

    <!-- Experience Part Start -->
    <section class="mt-[60px] advertise w-auto h-auto">
        <div class="flex container mx-auto lg:flex-row flex-col items-center justify-center">
            <div class="md:w-3/5 text-center lg:text-left">
                <h2 class="text-[#455A64] text-[40px] lg:text-wrap mb-[39px] inter-700 capitalize">
                    Experience the Taste of
                    <span class="text-[#E32938]">Home,</span> Delivered to Your
                    Doorstep!
                </h2>
                <p class="capitalize inter-400 mb-10">
                    where every meal is a masterpiece of homemade excellence. Say
                    goodbye to bland and uninspired meals - our kitchen is here to
                    elevate your dining experience with authentic flavors and comforting
                    dishes that warm the soul.
                </p>
                <button class="btn w-fit bg-[#E32938] text-white border-radius5">
                    Order Now
                </button>
            </div>
            <div class="lg:relative lg:right-24 static">
                <img src="{{ asset('bd-kitten-assets/group image.png') }}" alt="" />
            </div>
        </div>
    </section>
    <!-- Experience Part End -->

    <!-- What Our Customer’s Say Start -->
    <section class="container mx-auto">
        <div class="text-center">
            <h1 class="text-[#455A64] text-4xl inter-700">
                What Our Customer’s Say?
            </h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="38" viewBox="0 0 43 38" fill="none">
                <path
                    d="M38.9688 19H32.25V13.5714C32.25 10.5772 34.6604 8.14286 37.625 8.14286H38.2969C39.4139 8.14286 40.3125 7.23527 40.3125 6.10714V2.03571C40.3125 0.907589 39.4139 0 38.2969 0H37.625C30.2008 0 24.1875 6.07321 24.1875 13.5714V33.9286C24.1875 36.1763 25.9932 38 28.2188 38H38.9688C41.1943 38 43 36.1763 43 33.9286V23.0714C43 20.8237 41.1943 19 38.9688 19ZM14.7812 19H8.0625V13.5714C8.0625 10.5772 10.4729 8.14286 13.4375 8.14286H14.1094C15.2264 8.14286 16.125 7.23527 16.125 6.10714V2.03571C16.125 0.907589 15.2264 0 14.1094 0H13.4375C6.01328 0 0 6.07321 0 13.5714V33.9286C0 36.1763 1.80566 38 4.03125 38H14.7812C17.0068 38 18.8125 36.1763 18.8125 33.9286V23.0714C18.8125 20.8237 17.0068 19 14.7812 19Z"
                    fill="#E32938" />
            </svg>
            <p class="text-[#455A64] text-[28px] inter-400">
                The ordering process is simple, and the delivery is consistently
                prompt. The <br />packaging is eco-friendly, and the food arrives as
                if it's been lovingly prepared <br />
                just for me. I appreciate the transparency in ingredients and the...
            </p>
        </div>
        <div class="absolute right-28">
            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="38" viewBox="0 0 43 38" fill="none">
                <path
                    d="M38.9688 0H28.2188C25.9932 0 24.1875 1.82366 24.1875 4.07143V14.9286C24.1875 17.1763 25.9932 19 28.2188 19H34.9375V24.4286C34.9375 27.4228 32.5271 29.8571 29.5625 29.8571H28.8906C27.7736 29.8571 26.875 30.7647 26.875 31.8929V35.9643C26.875 37.0924 27.7736 38 28.8906 38H29.5625C36.9867 38 43 31.9268 43 24.4286V4.07143C43 1.82366 41.1943 0 38.9688 0ZM14.7812 0H4.03125C1.80566 0 0 1.82366 0 4.07143V14.9286C0 17.1763 1.80566 19 4.03125 19H10.75V24.4286C10.75 27.4228 8.33965 29.8571 5.375 29.8571H4.70312C3.58613 29.8571 2.6875 30.7647 2.6875 31.8929V35.9643C2.6875 37.0924 3.58613 38 4.70312 38H5.375C12.7992 38 18.8125 31.9268 18.8125 24.4286V4.07143C18.8125 1.82366 17.0068 0 14.7812 0Z"
                    fill="#E32938" />
            </svg>
        </div>
        <div class="flex lg:flex-row flex-col items-center justify-center mt-[51px] gap-[14px]">
            <img src="Assets/Ellipse 1.svg" alt="" />
            <h3 class="text-2xl text-[#455A64]">Samuel Scriptsmith</h3>
        </div>
        <p class="text-center text-[#455A64] mt-2">Manager At Voice Shop</p>
    </section>
    <!-- What Our Customer’s Say End -->

    <!-- Accordian Part Start -->
    <section class="container mx-auto mt-[135px] mb-[135px]">
        <h2 class="text-center text-[#455A64] text-4xl inter-700 mb-[60px]">
            Frequently Asked Question
        </h2>
        <div class="join join-vertical w-full">
            <div class="collapse collapse-arrow join-item">
                <input type="radio" name="my-accordion-4" />
                <div class="collapse-title text-2xl inter-700 text-[#455A64]">
                    Can I customize my orders?
                </div>
                <div class="collapse-content">
                    <p class="text-xl text-[#575A5B] inter-400">
                        If you're a passionate home cook interested in sharing your
                        culinary creations, you can apply to become a home chef on our
                        platform. Simply visit our website and follow the application
                        process outlined in the "Become a Chef" section.Take a close look
                        at the requirements and guidelines outlined by the platform for
                        home chefs.
                    </p>
                </div>
            </div>
            <div class="collapse collapse-arrow join-item border-y-2">
                <input type="radio" name="my-accordion-4" />
                <div class="collapse-title text-2xl inter-700 text-[#455A64]">
                    Are the home chefs vetted for quality and safety?
                </div>
                <div class="collapse-content">
                    <p class="text-xl text-[#575A5B] inter-400">
                        If you're a passionate home cook interested in sharing your
                        culinary creations, you can apply to become a home chef on our
                        platform. Simply visit our website and follow the application
                        process outlined in the "Become a Chef" section.Take a close look
                        at the requirements and guidelines outlined by the platform for
                        home chefs.
                    </p>
                </div>
            </div>
            <div class="collapse collapse-arrow join-item">
                <input type="radio" name="my-accordion-4" checked="checked" />
                <div class="collapse-title text-2xl inter-700 text-[#455A64]">
                    How can I become a home chef on BD Kitchen?
                </div>
                <div class="collapse-content">
                    <p class="text-xl text-[#575A5B] inter-400">
                        If you're a passionate home cook interested in sharing your
                        culinary creations, you can apply to become a home chef on our
                        platform. Simply visit our website and follow the application
                        process outlined in the "Become a Chef" section.Take a close look
                        at the requirements and guidelines outlined by the platform for
                        home chefs.
                    </p>
                </div>
            </div>
            <div class="collapse collapse-arrow join-item border-y-2">
                <input type="radio" name="my-accordion-4" />
                <div class="collapse-title text-2xl inter-700 text-[#455A64]">
                    How do I pay for my orders?
                </div>
                <div class="collapse-content">
                    <p class="text-xl text-[#575A5B] inter-400">
                        If you're a passionate home cook interested in sharing your
                        culinary creations, you can apply to become a home chef on our
                        platform. Simply visit our website and follow the application
                        process outlined in the "Become a Chef" section.Take a close look
                        at the requirements and guidelines outlined by the platform for
                        home chefs.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
