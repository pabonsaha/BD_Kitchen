@extends('user.layout.app')

@section('content')
    <section class="container mx-auto">
        <div class="flex flex-col lg:flex-row items-center justify-center md:justify-start lg:justify-start">
            <div class="card w-fit h-fit asset-shadow">
                <figure class="px-[12px] py-[12px]">
                    <img src="Assets/Rectangle 45.png" alt="asset1" />
                </figure>
            </div>
            <div>
                <div>
                    <h2 class="text-[#455A64] inter-700 text-[36px] px-[24px] py-[16px]">
                        BengaliSavor
                    </h2>
                </div>
                <div class="flex items-center px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"
                        class="mr-4">
                        <path
                            d="M9 0C13.9707 0 18 4.0293 18 9C18 13.9707 13.9707 18 9 18C4.0293 18 0 13.9707 0 9C0 4.0293 4.0293 0 9 0ZM9 3.6C8.7613 3.6 8.53239 3.69482 8.3636 3.8636C8.19482 4.03239 8.1 4.2613 8.1 4.5V9C8.10005 9.23868 8.19491 9.46756 8.3637 9.6363L11.0637 12.3363C11.2334 12.5002 11.4608 12.591 11.6968 12.5889C11.9327 12.5869 12.1585 12.4922 12.3253 12.3253C12.4922 12.1585 12.5869 11.9327 12.5889 11.6968C12.591 11.4608 12.5002 11.2334 12.3363 11.0637L9.9 8.6274V4.5C9.9 4.2613 9.80518 4.03239 9.6364 3.8636C9.46761 3.69482 9.23869 3.6 9 3.6Z"
                            fill="#455A64" />
                    </svg>
                    <p class="mr-4">30 Min</p>

                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none"
                        class="mr-4">
                        <path
                            d="M3.75 14.475C3.05381 14.475 2.38613 14.1984 1.89384 13.7062C1.40156 13.2139 1.125 12.5462 1.125 11.85C1.125 11.1538 1.40156 10.4861 1.89384 9.99384C2.38613 9.50156 3.05381 9.225 3.75 9.225C4.44619 9.225 5.11387 9.50156 5.60616 9.99384C6.09844 10.4861 6.375 11.1538 6.375 11.85C6.375 12.5462 6.09844 13.2139 5.60616 13.7062C5.11387 14.1984 4.44619 14.475 3.75 14.475ZM3.75 8.1C2.75544 8.1 1.80161 8.49509 1.09835 9.19835C0.395088 9.90161 0 10.8554 0 11.85C0 12.8446 0.395088 13.7984 1.09835 14.5016C1.80161 15.2049 2.75544 15.6 3.75 15.6C4.74456 15.6 5.69839 15.2049 6.40165 14.5016C7.10491 13.7984 7.5 12.8446 7.5 11.85C7.5 10.8554 7.10491 9.90161 6.40165 9.19835C5.69839 8.49509 4.74456 8.1 3.75 8.1ZM11.1 6.6H14.25V5.25H11.85L10.395 2.7975C10.1775 2.4225 9.75 2.175 9.3 2.175C8.9475 2.175 8.625 2.3175 8.4 2.55L5.625 5.3175C5.3925 5.55 5.25 5.85 5.25 6.225C5.25 6.6975 5.4975 7.095 5.8875 7.3275L8.4 8.85V12.6H9.75V7.725L8.0625 6.4875L9.8025 4.725M14.25 14.475C13.5538 14.475 12.8861 14.1984 12.3938 13.7062C11.9016 13.2139 11.625 12.5462 11.625 11.85C11.625 11.1538 11.9016 10.4861 12.3938 9.99384C12.8861 9.50156 13.5538 9.225 14.25 9.225C14.9462 9.225 15.6139 9.50156 16.1062 9.99384C16.5984 10.4861 16.875 11.1538 16.875 11.85C16.875 12.5462 16.5984 13.2139 16.1062 13.7062C15.6139 14.1984 14.9462 14.475 14.25 14.475ZM14.25 8.1C13.2554 8.1 12.3016 8.49509 11.5983 9.19835C10.8951 9.90161 10.5 10.8554 10.5 11.85C10.5 12.8446 10.8951 13.7984 11.5983 14.5016C12.3016 15.2049 13.2554 15.6 14.25 15.6C14.7425 15.6 15.2301 15.503 15.6851 15.3145C16.14 15.1261 16.5534 14.8499 16.9016 14.5016C17.2499 14.1534 17.5261 13.74 17.7145 13.2851C17.903 12.8301 18 12.3425 18 11.85C18 11.3575 17.903 10.8699 17.7145 10.4149C17.5261 9.95997 17.2499 9.54657 16.9016 9.19835C16.5534 8.85013 16.14 8.57391 15.6851 8.38545C15.2301 8.197 14.7425 8.1 14.25 8.1ZM12 2.7C12.75 2.7 13.35 2.1 13.35 1.35C13.35 0.6 12.75 0 12 0C11.25 0 10.65 0.6 10.65 1.35C10.65 2.1 11.25 2.7 12 2.7Z"
                            fill="#455A64" />
                    </svg>
                    <p>Tk 30</p>
                </div>
                <div class="flex justify-between items-center px-[24px] py-[16px]">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M8 0L10.6756 4.31735L15.6085 5.52786L12.3292 9.40665L12.7023 14.4721L8 12.552L3.29772 14.4721L3.67079 9.40665L0.391548 5.52786L5.3244 4.31735L8 0Z"
                                fill="#F4CE00" />
                        </svg>
                        <p class="ml-2 text-[#455A64] inter-400">4.9 (1000+) Reviews</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- card item  -->

    <!-- Popular Part Start -->
    <section class="container mx-auto mt-[60px]">
        <h3 class="text-[32px] inter-700 text-[#455A64] mb-[25px] text-center lg:text-left">
            Popular
        </h3>
        <p class="text-[#455A64] text-[18px] inter-400 mb-10 text-center lg:text-left">
            Most ordered right now.
        </p>
        <div class="grid lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-6">
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular Part End -->

    <!-- Khichuri Part Start -->
    <section class="container mx-auto mt-[40px]">
        <h3 class="text-[32px] inter-700 text-[#455A64] mb-[40px] text-center lg:text-left">
            Khichuri
        </h3>
        <div class="grid lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-6">
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- kichuri Part End -->

    <!-- Dessert Part Start -->
    <section class="container mx-auto mt-[40px]">
        <h3 class="text-[32px] inter-700 text-[#455A64] mb-[40px] text-center lg:text-left">
            Dessert
        </h3>
        <div class="grid lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-6">
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- Dessert Part End -->

    <!-- Beverage Part Start -->
    <section class="container mx-auto mt-[40px]">
        <h3 class="text-[32px] inter-700 text-[#455A64] mb-[40px] text-center lg:text-left">
            Beverage
        </h3>
        <div class="grid lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-6">
            <div
                class="lg:w-[636px] lg:h-[146px] w-full h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between bg-[#fff] border-radius6 asset-shadow px-[20px] py-[20px]">
                <div>
                    <h2 class="text-[#455A64] inter-600 text-2xl py-[8px]">
                        Beef Tehari
                    </h2>
                    <div class="flex">
                        <p class="mr-4 text-[#E32938] text-[18px] inter-400">
                            From tk 136
                        </p>
                        <del class="text-[#455A64] text-[18px] inter-400">Tk 160</del>
                    </div>
                    <p class="py-[8px] inter-400 text-[#455A64] text-[18px] flex-1">
                        One pot meal with special aromatic <br />
                        spices
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="mr-[10px]" src="images/image.png" alt="" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <circle cx="20" cy="20" r="20" fill="#FCEAEB" />
                        <path d="M11 20H20M20 20H29M20 20V11M20 20V29" stroke="#E32938" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- Beverage Part End -->
@endsection
