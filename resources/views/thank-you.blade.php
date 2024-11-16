<!-- resources/views/thank-you.blade.php -->
@extends('user.layout.app')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="p-1 rounded shadow-lg bg-gradient-to-r from-[#E32938] via-[#E32938] to-[#E32938]">
            <div class="flex flex-col items-center p-4 space-y-2 bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 w-28 h-28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#a7ff95] to-[#E32938]">
                    Thank You for Your Order!
                </h1>
               
                <p class="text-lg text-gray-600 pb-5 mt-2">
                    We appreciate your choice and can’t wait for you to enjoy your delicious meal. Stay tuned for updates!
                </p>
                <div class="py-4">
                    <button href="{{ route('home') }}" class="inline-flex items-center px-4  text-white bg-[#E32938] border border-[#E32938] rounded-full hover:bg-[#c62828] focus:outline-none py-4 focus:ring mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        <span class="text-sm font-medium">Return to Home</span>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
@endsection
