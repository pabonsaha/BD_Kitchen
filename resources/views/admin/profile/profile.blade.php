@extends('layouts.master')

@section('title', $title ?? __('Profile'))

@section('content')

    <div class="container-xxl flex-grow-1 container">
        {!! breadcrumb('Profile',['profile'=>'Profile']) !!}
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset(getFilePath($user->avatar)) }}"
                                    height="100" width="100" alt="User avatar" />
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{ $user->name }}</h4>
                                    @if ($user->role_id == 1)
                                        <span class="badge bg-danger">Super Admin</span>
                                    @elseif($user->role_id == 2)
                                        <span class="badge bg-warning">Admin</span>
                                    @elseif($user->role_id == 3)
                                        <span class="badge bg-success">Designer</span>
                                    @else
                                        <span class="badge bg-label-primary">Customer</span>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                            <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-checkbox ti-sm"></i></span>
                                <div>
                                    <p class="mb-0 fw-medium">{{ $user->products_count }}</p>
                                    <small>Total Product</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3 gap-2">
                                <span class="badge bg-label-primary p-2 rounded"><i
                                        class="ti ti-briefcase ti-sm"></i></span>
                                <div>
                                    <p class="mb-0 fw-medium">{{ $user->orders_count }}</p>
                                    <small>Total Order</small>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 small text-uppercase text-muted">Details</p>
                        <div class="info-container">
                            <ul class="list-unstyled">

                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">Email:</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">Status:</span>
                                    @if ($user->active_status == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Deactive</span>
                                    @endif

                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">Role:</span>

                                    @if ($user->role_id == 1)
                                        <span>Super Admin</span>
                                    @elseif($user->role_id == 2)
                                        <span>Admin</span>
                                    @elseif($user->role_id == 3)
                                        <span>Designer</span>
                                    @else
                                        <span>Customer</span>
                                    @endif
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">Contact:</span>
                                    <span>{{ $user->phone }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">Address:</span>
                                    <span>{{ $user->address }}</span>
                                </li>

                            </ul>
                            <div class="d-flex justify-content-center">
                                <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                                    data-bs-toggle="modal">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-overview" aria-controls="navs-overview" aria-selected="false">
                                <i class="ti ti-user me-1"></i> Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                                aria-selected="false">
                                <i class="tf-icons ti ti-lock ti-xs me-1"></i> Sceurity
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-social-links" aria-controls="navs-social-links" aria-selected="false">
                                <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> Social Links
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content p-0 bg-transparent shadow-none">
                        <div class="tab-pane fade show active" id="navs-overview" role="tabpanel">
                            <!-- / Customer cards -->
                            <div class="row text-nowrap">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="card-icon mb-3">
                                                <div class="avatar">
                                                    <div class="avatar-initial rounded bg-label-primary">
                                                        <i class="ti ti-shopping-bag"></i>                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="card-title mb-3">Products</h4>
                                                <div class="d-flex align-items-baseline mb-1 gap-1">
                                                    <h4 class="text-primary mb-0">560</h4>
                                                    <p class="mb-0"> Total Products </p>
                                                </div>
{{--                                                <p class="text-muted mb-0 text-truncate">Account balance for next purchase--}}
{{--                                                </p>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="card-icon mb-3">
                                                <div class="avatar">
                                                    <div class="avatar-initial rounded bg-label-success">
                                                        <i class='ti ti-gift ti-md'></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="card-title mb-3">Total Order</h4>
                                                <div class="d-flex align-items-baseline mb-1 gap-1">
                                                    <h4 class="text-success mb-0">560</h4>
                                                    <p class="mb-0"> Total Order </p>
                                                </div>                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-icon mb-3">
                                                <div class="avatar">
                                                    <div class="avatar-initial rounded bg-label-warning">
                                                        <i class="ti ti-list-numbers"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="card-title mb-3">Total My Order</h4>
                                                <div class="d-flex align-items-baseline mb-1 gap-1">
                                                    <h4 class="text-warning mb-0">15</h4>
                                                    <p class="mb-0">Order</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-icon mb-3">
                                                <div class="avatar">
                                                    <div class="avatar-initial rounded bg-label-info">
                                                        <i class="ti ti-shopping-cart"></i>                                                   </div>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="card-title mb-3">Cart List</h4>
                                                <div class="d-flex align-items-baseline mb-1 gap-1">
                                                    <h4 class="text-info mb-0">21</h4>
                                                    <p class="mb-0">Items in cart</p>
                                                </div>

{{--                                                <p class="text-muted mb-0 text-truncate">Use coupon on next purchase</p>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-icon mb-3">
                                                <div class="avatar">
                                                    <div class="avatar-initial rounded bg-label-danger">
                                                        <i class='ti ti-heart ti-md'></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-info">
                                                <h4 class="card-title mb-3">Wishlist</h4>
                                                <div class="d-flex align-items-baseline mb-1 gap-1">
                                                    <h4 class="text-danger mb-0">21</h4>
                                                    <p class="mb-0">Items in wishlist</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-icon mb-3">
                                                <div class="avatar">
                                                    <div class="avatar-initial rounded bg-label-primary">
                                                        <i class="ti ti-list-details"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="card-title mb-3">Total Portfolio & Inspiration</h4>
                                                <div class="d-flex align-items-baseline mb-1 gap-1">
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-baseline mb-1 gap-1">
                                                            <h4 class="text-primary mb-0">21</h4>
                                                            <p class="mb-0">Portfolio</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-baseline mb-1 gap-1">
                                                            <h4 class="text-primary mb-0">13</h4>
                                                            <p class="mb-0">Inspiration</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- / customer cards -->
                        </div>
                    </div>
                    <div class="tab-content p-0 bg-transparent shadow-none">
                        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                            <div class="card">
                                <h5 class="card-header">Change Password</h5>
                                <div class="card-body">
                                    <form id="passwordFrom" class="row g-3">
                                        <input type="text" id="userID" hidden value="{{ $user->id }}">
                                        <div class="col-md-6">
                                            <div class="form-password-toggle">
                                                <label class="form-label" for="formValidationPass">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input class="form-control" type="password" id="formValidationPass"
                                                        name="formValidationPass"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="multicol-password2" />
                                                    <span class="input-group-text cursor-pointer"
                                                        id="multicol-password2"><i class="ti ti-eye-off"></i></span>
                                                </div>
                                                <span class="text-danger passwordError error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-password-toggle">
                                                <label class="form-label" for="formValidationConfirmPass">Confirm
                                                    Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input class="form-control" type="password"
                                                        id="formValidationConfirmPass" name="formValidationConfirmPass"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="multicol-confirm-password2" />
                                                    <span class="input-group-text cursor-pointer"
                                                        id="multicol-confirm-password2"><i
                                                            class="ti ti-eye-off"></i></span>
                                                </div>
                                                <span class="text-danger confirmPasswordError error"></span>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-social-links" role="tabpanel">
                            <div class="card">
                                <h5 class="card-header">Social Links</h5>
                                <div class="card-body">
                                    <form method="POST" id="social-links-vertical-form">
                                        @csrf
                                        <div class="content-header mb-3">
                                            <small>Enter Your Social Links.</small>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label class="form-label" for="twitter1">Twitter</label>
                                                <input type="text" id="twitter1" name="twitter" class="form-control"
                                                    value="{{ optional($user->shop)->twitter_url }}"
                                                    placeholder="https://twitter.com/abc" />
                                                <span class="text-danger twitterError error"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="facebook1">Facebook</label>
                                                <input type="text" id="facebook1" name="facebook"
                                                    class="form-control"
                                                    value="{{ optional($user->shop)->facebook_url }}"
                                                    placeholder="https://facebook.com/abc" />
                                                <span class="text-danger facebookError error"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="facebook1">Instagram</label>
                                                <input type="text" id="instagram" name="instagram"
                                                    class="form-control"
                                                    value="{{ optional($user->shop)->instagram_url }}"
                                                    placeholder="https://instagram.com/abc" />
                                                <span class="text-danger instagramError error"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="linkedin1">Linkedin</label>
                                                <input type="text" id="linkedin1" name="linkedin"
                                                    class="form-control" value="{{ optional($user->shop)->linkedin }}"
                                                    placeholder="https://linkedin.com/abc" />
                                                <span class="text-danger linkedinError error"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="linkedin1">Youtube</label>
                                                <input type="text" id="youtube" name="youtube" class="form-control"
                                                    value="{{ optional($user->shop)->youtube_url }}"
                                                    placeholder="https://youtube.com/abc" />
                                                <span class="text-danger youtubeError error"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="linkedin1">Tiktok</label>
                                                <input type="text" id="tiktok" name="tiktok" class="form-control"
                                                    value="{{ optional($user->shop)->tiktok_url }}"
                                                    placeholder="https://tiktok.com/abc" />
                                                <span class="text-danger tiktokError error"></span>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-success" type="submit">
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span>
                                                    <i class="ti ti-arrow-up"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--/ User Content -->
        </div>

        <!-- Modal -->
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Edit User Information</h3>
                            <p class="text-muted">Updating user details will receive a privacy audit.</p>
                        </div>
                        <form id="editUserForm" class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserFirstName">Name</label>
                                <input type="text" id="modalEditUserName" name="modalEditUserName"
                                    class="form-control" placeholder="John" value="{{ $user->name }}" />
                                <span class="text-danger usernameError error"></span>

                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserPhone">Phone</label>
                                <input type="text" id="modalEditPhone" name="modalEditPhone" class="form-control"
                                    placeholder="+87554442" value="{{ $user->phone }}" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserEmail">Email</label>
                                <input type="text" value="{{ $user->email }}" id="modalEditUserEmail"
                                    name="modalEditUserEmail" class="form-control" placeholder="example@domain.com"
                                    readonly />
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditTaxID">Address</label>
                                <input type="text" value="{{ $user->address }}" id="modalEditAddress"
                                    name="modalEditTaxID" class="form-control"
                                    placeholder="Richfield Springs, NY 13439" />
                            </div>

                            <div class="col-6">
                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="user-image">Image</label>
                                    <input class="form-control" type="file" name="image" id="modalUserImage" />
                                    <span class="text-danger imageError error"></span>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
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


        <!-- /Modal -->
    </div>


@endsection

@push('scripts')
    <script>
        $(function() {

            $('#passwordFrom').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let user_id = $('#userID').val();
                let password = $("#formValidationPass").val();
                let confirmPassword = $("#formValidationConfirmPass").val();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('user_id', {{ $user->id }});
                formData.append('password', password);
                formData.append('password_confirmation', confirmPassword);


                $('.error').text('');
                $.ajax({
                    url: '{{ route('user.passwordReset') }}',
                    type: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status == 403) {
                            $('.passwordError').text(response.errors?.password ? response.errors
                                ?.password[0] : '');
                            $('.confirmPasswordError').text(response.errors
                                ?.password_confirmation ? response.errors
                                ?.password_confirmation[0] : '');
                        } else if (response.status == 200) {
                            toastr.success(response.message);
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });

            })

            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let user_id = $('#userID').val();
                let name = $("#modalEditUserName").val();
                let phone = $("#modalEditPhone").val();
                let address = $("#modalEditAddress").val();
                var image = $("#modalUserImage").prop('files')[0] ?? '';
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('user_id', {{ $user->id }});
                formData.append('name', name);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('avatar', image);


                $('.error').text('');
                $.ajax({
                    url: '{{ route('user.update') }}',
                    type: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.usernameError').text(response.errors?.name ? response.errors
                                .name[0] : '');
                            $('.imageError').text(response.errors?.avatar ? response
                                .errors.avatar[0] : '');
                        }
                        else if (response.status === 200) {
                            location.reload(); // Refresh the page
                            toastr.success(response.message);
                            $('.btn-close').click();
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });

            })
        });
    </script>

    <script>
        $('#logo-setting-form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();

            let name = $("input[name=name]").val();

            var lightLogo = $('#lightLogoInput').prop('files')[0] ?? '';
            var darkLogo = $('#darkLogoInput').prop('files')[0] ?? '';
            var fevicon = $('#feviconLogoInput').prop('files')[0] ?? '';
            var user_id = {{ $user->id }};

            formData.append('light_logo', lightLogo);
            formData.append('banner', darkLogo);
            formData.append('favicon', fevicon);
            formData.append('user_id', user_id);
            formData.append('_token', "{{ csrf_token() }}");


            $('.error').text('');
            $.ajax({
                url: '{{ route('user.shoplogoUpdate') }}',
                type: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if (response.status == 403) {
                        $('.light_logoError').text(response.errors?.light_logo ? response.errors
                            ?.light_logo[0] : '');
                        $('.dark_logoError').text(response.errors?.dark_logo ? response.errors
                            ?.dark_logo[0] : '');
                        $('.faviconError').text(response.errors?.favicon ? response.errors?.favicon[0] :
                            '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });


        $('#social-links-vertical-form').on('submit', function(e) {
            e.preventDefault();

            $('.error').text('');
            $.ajax({
                url: '{{ route('user.shoplinkUpdate') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    twitter: $('#twitter1').val(),
                    facebook: $('#facebook1').val(),
                    instagram: $('#instagram').val(),
                    linkedin: $('#linkedin1').val(),
                    youtube: $('#youtube').val(),
                    tiktok: $('#tiktok').val(),
                    user_id: {{ $user->id }},

                },
                success: function(response) {
                    if (response.status == 403) {
                        $('.twitterError').text(response.errors?.twitter ? response.errors
                            ?.twitter[0] : '');
                        $('.facebookError').text(response.errors?.facebook ? response.errors
                            ?.facebook[0] : '');
                        $('.instagramError').text(response.errors?.instagram ? response.errors
                            ?.instagram[0] :
                            '');
                        $('.linkedinError').text(response.errors?.linkedin ? response.errors?.linkedin[
                                0] :
                            '');
                        $('.youtubeError').text(response.errors?.youtube ? response.errors?.youtube[0] :
                            '');
                        $('.tiktokError').text(response.errors?.tiktok ? response.errors?.tiktok[0] :
                            '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {

                    toastr.error(error.responseJSON.message);
                }
            });
        });
    </script>


    <script>
        let lightLogoImage = document.getElementById('lightLogo');
        const lightLogofileInput = document.querySelector('.lightLogo-account-file-input'),
            lightLogoresetFileInput = document.querySelector('.lightLogo-account-image-reset');

        if (lightLogoImage) {
            const resetImage = lightLogoImage.src;
            lightLogofileInput.onchange = () => {
                if (lightLogofileInput.files[0]) {
                    lightLogoImage.src = window.URL.createObjectURL(lightLogofileInput.files[0]);
                }
            };
            lightLogoresetFileInput.onclick = () => {
                lightLogofileInput.value = '';
                lightLogoImage.src = resetImage;
            };
        }

        let darkLogoImage = document.getElementById('darkLogo');
        const darkLogofileInput = document.querySelector('.darkLogo-account-file-input'),
            darkLogoresetFileInput = document.querySelector('.darkLogo-account-image-reset');

        if (darkLogoImage) {
            const resetImage = darkLogoImage.src;
            darkLogofileInput.onchange = () => {
                if (darkLogofileInput.files[0]) {
                    darkLogoImage.src = window.URL.createObjectURL(darkLogofileInput.files[0]);
                }
            };
            darkLogoresetFileInput.onclick = () => {
                darkLogofileInput.value = '';
                darkLogoImage.src = resetImage;
            };
        }


        let feviconImage = document.getElementById('feviconLogo');
        const feviconFileInput = document.querySelector('.fevicon-account-file-input'),
            resetFeviconFileInput = document.querySelector('.fevicon-account-image-reset');

        if (feviconImage) {
            const resetImage = feviconImage.src;
            feviconFileInput.onchange = () => {
                if (feviconFileInput.files[0]) {
                    feviconImage.src = window.URL.createObjectURL(feviconFileInput.files[0]);
                }
            };
            resetFeviconFileInput.onclick = () => {
                feviconFileInput.value = '';
                feviconImage.src = resetImage;
            };
        }
    </script>
@endpush
