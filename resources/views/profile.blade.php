<!-- resources/views/profile.blade.php -->
@extends('user.layout.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">User Profile</h1>
        
        <div class="flex items-center space-x-4 mb-6">
            <img class="w-24 h-24 rounded-full" src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150' }}" alt="Profile Picture">
            <div>
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <div class="mt-4">
            <h3 class="text-lg font-semibold mb-2">Contact Information</h3>
            <p><span class="font-medium">Contact Number:</span> {{ $user->contact_number ?? 'Not available' }}</p>
            <p><span class="font-medium">Address:</span> {{ $user->address ?? 'Not available' }}</p>
        </div>

        <div class="mt-6">
            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
