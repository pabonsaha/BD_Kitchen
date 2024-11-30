<!-- resources/views/profile.blade.php -->
@extends('user.layout.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white  border border-red-100 shadow rounded-lg p-6">
            <!-- User Profile Section -->
            <div>
                <h1 class="text-2xl font-bold mb-4">User Profile</h1>

                <div class="flex items-center space-x-4 mb-6">
                    <img class="w-24 h-24 rounded-full"
                         src="{{ getFilePath($user->avatar) }}" alt="Profile Picture">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Edit Button -->
                <button id="editProfileBtn"
                        class="rounded-md bg-[#E32938] py-2 px-4 text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-[#c62828] focus:shadow-none active:bg-[#c62828] hover:bg-[#c62828] active:shadow-none">
                    Edit Profile
                </button>

                <!-- Modal Structure for Profile Edit -->
                <div id="profileModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-60"></div>
                        </div>

                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="relative items-center flex justify-center text-white h-20 bg-[#E32938]">
                                <h3 class="text-2xl">Edit Profile</h3>
                            </div>
                            <div class="flex flex-col gap-4 p-6">
                                <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form mb-4">
                                        <label for="name" class="block text-sm font-medium text-black">Name</label>
                                        <input id="name"
                                               class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                               required value="{{ $user->name }}" type="text" name="name">
                                        @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="email" class="block text-sm font-medium text-black">Email</label>
                                        <input id="email"
                                               class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                               required disabled value="{{ $user->email }}" type="email" name="email">
                                        @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="contact_number" class="block text-sm font-medium text-black">Contact
                                            Number</label>
                                        <input id="contact_number"
                                               class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                               required value="{{ $user->phone }}" type="text" name="phone">
                                        @error('contact_number')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="address"
                                               class="block text-sm font-medium text-black">Address</label>
                                        <input id="address"
                                               class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                               required value="{{ $user->address }}" type="text" name="address">
                                        @error('address')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="profile_photo" class="block text-sm font-medium text-black">Profile
                                            Photo</label>
                                        <input id="profile_photo"
                                               class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                               type="file" name="avatar">
                                        @error('avatar')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                            class="w-full rounded-md bg-[#E32938] py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-[#c62828] focus:shadow-none active:bg-[#c62828] hover:bg-[#c62828] active:shadow-none">
                                        Update
                                        Profile
                                    </button>
                                </form>
                            </div>
                            <div class="p-6 pt-0">
                                <button type="button"
                                        class="close-btn w-full rounded-md bg-[#E32938] py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-[#c62828] focus:shadow-none active:bg-[#c62828] hover:bg-[#c62828] active:shadow-none">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Get the modal
                var profileModal = document.getElementById("profileModal");

                // Get the button that opens the modal
                var editProfileBtn = document.getElementById("editProfileBtn");

                // Get the close button
                var closeBtns = profileModal.querySelectorAll(".close-btn");

                // When the user clicks the button, open the modal
                editProfileBtn.onclick = function () {
                    profileModal.classList.remove("hidden");
                }

                // When the user clicks on close buttons, close the modal
                closeBtns.forEach(function (closeBtn) {
                    closeBtn.onclick = function () {
                        profileModal.classList.add("hidden");
                    }
                });

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == profileModal) {
                        profileModal.classList.add("hidden");
                    }
                }
            </script>


            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Contact Information</h3>
                <p><span class=" text-black font-medium">Name:</span> {{ $user->name ?? 'Not available' }}</p>
                <p><span class=" text-black font-medium">Contact Number:</span> {{ $user->phone ?? 'Not available' }}
                </p>
                <p><span class=" text-black font-medium">Address:</span> {{ $user->address ?? 'Not available' }}</p>
            </div>


            {{-- //Shipping Address  --}}
            <div class="">
                <p class="capitalize inter-700 text-xl text-wrap mb-4 mt-[40px]">Shipping Address</p>

                <!-- Default Shipping Address Card -->
                <div class="flex flex-wrap justify-start space-x-4">
                    @foreach($shippingAdddresses as $shippingAdddress)

                        <div
                            class="text-start address-card  bg-white border border-gray-200 rounded-lg shadow p-4 dark:border-gray-700 dark:bg-gray-800 mb-4 flex items-center">
                            <input type="radio" name="address" class="mr-2"
                                   @if($shippingAdddress->is_default == 1) checked @endif >
                            <div class="relative">
                                @if($shippingAdddress->is_default != 1)
                                    <p data-id="{{$shippingAdddress->id}}"
                                       class="absolute top-0 right-0 text-red-500 cursor-pointer remove_address">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="lucide lucide-trash-2">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            <line x1="10" x2="10" y1="11" y2="17"/>
                                            <line x1="14" x2="14" y1="11" y2="17"/>
                                        </svg>
                                    </p>
                                @endif
                                <p class="text-black dark:text-gray-400">Name: {{$shippingAdddress->name}}</p>
                                <p class="text-black dark:text-gray-400">Phone: {{$shippingAdddress->phone}}</p>
                                <p class="text-black dark:text-gray-400">Street
                                    Address: {{$shippingAdddress->street_address}}</p>
                                <p class="text-black dark:text-gray-400">City: {{$shippingAdddress->state}}</p>
                            </div>
                        </div>
                    @endforeach


                </div>


                <!-- Button to Open Modal -->
                <button id="addAddressBtn"
                        class="px-6 flex items-center btn text-[#E32938] border border-solid border-[#E3293880] bg-[#FCEAEB]"
                        type="button">
                    Add Address
                </button>

                <!-- Modal Structure -->
                <div id="addressModal" class="fixed z-[999] inset-0 overflow-y-auto hidden">
                    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-60"></div>
                        </div>

                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="relative items-center flex justify-center text-white h-20 bg-[#E32938]">
                                <h3 class="text-2xl">Add Address</h3>
                            </div>
                            <div class="flex flex-col gap-4 p-6">
                                <form method="post" action="{{route('shippingAddress.store')}}">
                                    @csrf
                                    <div class="form mb-4">
                                        <label for="Name" class="block text-sm font-medium text-black">Name</label>
                                        <input
                                            class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                            required value="{{ old('name') }}" type="text"
                                            name="shipping_addresses_name">
                                        @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="Phone Number" class="block text-sm font-medium text-black">Phone
                                            Number</label>
                                        <input
                                            class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                            required type="tel" value="{{ old('phone') }}"
                                            name="shipping_addresses_phone">
                                        @error('phone')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="Street Address" class="block text-sm font-medium text-black">Street
                                            Address</label>
                                        <input
                                            class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                            required value="{{ old('street_address') }}" type="text"
                                            name="shipping_addresses_street_address">
                                        @error('street_address')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form mb-4">
                                        <label for="City" class="block text-sm font-medium text-black">City</label>
                                        <input
                                            class="inputForm mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#c62828] hover:border-gray-400 shadow-sm"
                                            required value="{{ old('city') }}" type="text"
                                            name="shipping_addresses_city">
                                        @error('city')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                            class="w-full rounded-md bg-[#E32938] py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-[#c62828] focus:shadow-none active:bg-[#c62828] hover:bg-[#c62828] active:shadow-none">
                                        Submit
                                    </button>
                                </form>
                            </div>
                            <div class="p-6 pt-0">
                                <button type="button"
                                        class="close w-full rounded-md bg-[#E32938] py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-[#c62828] focus:shadow-none active:bg-[#c62828] hover:bg-[#c62828] active:shadow-none">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // Get the modal
                var modal = document.getElementById("addressModal");

                // Get the button that opens the modal
                var btn = document.getElementById("addAddressBtn");

                // Get the <span> element that closes the modal
                var closeBtn = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal
                btn.onclick = function () {
                    modal.classList.remove('hidden');
                }

                // When the user clicks on <span> (x), close the modal
                closeBtn.onclick = function () {
                    modal.classList.add('hidden');
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.classList.add('hidden');
                    }
                }
            </script>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let productsID = [];
        $(document).on('click', '.remove_address', function (e) {
            e.preventDefault();
            let addressID = $(this).data("id");
            $.ajax({
                url: '{{ route('shippingAdddresses.destroy') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    addressID: addressID,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (error) {
                    console.log(error.responseJSON.message);
                    // handle the error case
                }
            });

        });
        </script>
@endpush
