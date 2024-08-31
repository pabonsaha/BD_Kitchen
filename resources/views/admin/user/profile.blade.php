@extends('layouts.master')

@section('title', $title ?? __('Profile'))

@section('content')

    <div class="container-xxl flex-grow-1 container">
        {!! breadcrumb('User Profile', ['user/index' => 'Users', 'user' => 'Profile']) !!}

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
                                        <span class="badge bg-danger">{{_trans('user.Super Admin')}}</span>
                                    @elseif($user->role_id == 2)
                                        <span class="badge bg-warning">{{_trans('user.Admin')}}</span>
                                    @elseif($user->role_id == 3)
                                        <span class="badge bg-success">{{_trans('user.Designer')}}</span>
                                    @else
                                        <span class="badge bg-label-primary">{{_trans('user.Customer')}}</span>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                            @if ($user && $user->role_id !== 4)
                                <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-checkbox ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium">{{ $user->products_count }}</p>
                                        <small>{{_trans('order.Total Product')}}</small>
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex align-items-start mt-3 gap-2">
                                <span class="badge bg-label-primary p-2 rounded"><i
                                        class="ti ti-briefcase ti-sm"></i></span>
                                <div>
                                    <p class="mb-0 fw-medium">{{ $user->orders_count }}</p>
                                    <small>{{_trans('order.Total Order')}}</small>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 small text-uppercase text-muted">{{_trans('common.Details')}}</p>
                        <div class="info-container">
                            <ul class="list-unstyled">

                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">{{_trans('common.Email')}}:</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">{{_trans('common.Status')}}:</span>
                                    @if ($user->active_status == 1)
                                        <span class="badge bg-label-success">{{_trans('common.Active')}}</span>
                                    @else
                                        <span class="badge bg-label-danger">{{_trans('common.Deactive')}}</span>
                                    @endif

                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">{{_trans('role.Role')}}:</span>

                                    @if ($user->role_id == 1)
                                        <span>{{_trans('user.Super Admin')}}</span>
                                    @elseif($user->role_id == 2)
                                        <span>{{_trans('user.Admin')}}</span>
                                    @elseif($user->role_id == 3)
                                        <span>{{_trans('user.Designer')}}</span>
                                    @else
                                        <span>{{_trans('user.Customer')}}</span>
                                    @endif
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">{{_trans('contact.Contact')}}:</span>
                                    <span>{{ $user->phone }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-medium me-1">{{_trans('contact.Address')}}:</span>
                                    <span>{{ $user->address }}</span>
                                </li>

                            </ul>
                            <div class="d-flex justify-content-center">
                                <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                                    data-bs-toggle="modal">{{_trans('common.Edit')}}</a>
                                @if ($user->active_status == 1)
                                    <a href="javascript:;" class="btn btn-label-danger suspend-user">{{_trans('common.Suspended')}}</a>
                                @else
                                    <a href="javascript:;" class="btn btn-label-success suspend-user">{{_trans('common.Activate')}}</a>
                                @endif
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
                                data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                                aria-selected="true">
                                <i class="tf-icons ti ti-user-check ti-xs me-1"></i> {{_trans('common.Account')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                                aria-selected="false">
                                <i class="tf-icons ti ti-lock ti-xs me-1"></i> {{_trans('user.Sceurity')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-messages"
                                aria-controls="navs-pills-justified-messages" aria-selected="false">
                                <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> {{_trans('common.Messages')}}
                            </button>
                        </li>


                        @if ($user && $user->role_id !== 4)
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-setting"
                                    aria-controls="navs-pills-justified-setting" aria-selected="false">
                                    <i class="tf-icons ti ti-settings ti-xs me-1"></i> {{_trans('setting.Shop Setting')}}
                                </button>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content p-0 bg-transparent shadow-none">
                        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                            <!-- Order table -->
                            <div class="card mb-4">
                                <h5 class="card-header pb-0">Order List</h5>

                                <div class="card-datatable table-responsive">
                                    <table class="order-data-table table border-top">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{_trans('order.Order ID')}}</th>
                                                <th>{{_trans('user.Designer')}}</th>
                                                <th>{{_trans('order.No. of Item')}}</th>
                                                <th>{{_trans('common.Date')}}</th>
                                                <th>{{_trans('common.Action')}}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- /Order table -->




                            <!-- Cart table -->

                            <div class="card mb-4">
                                <h5 class="card-header pb-0">{{_trans('order.Cart List')}}</h5>

                                <div class="card-datatable table-responsive">
                                    <table class="cart-data-table table border-top">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{_trans('common.Image')}}</th>
                                                <th>{{_trans('product.Product').' '._trans('common.Name')}}</th>
                                                <th>{{_trans('product.Variation')}}</th>
                                                <th>{{_trans('designer.Designer')}}</th>
                                                <th>{{_trans('common.Action')}}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <!-- /Cart table -->
                            <!-- Wishlist table -->

                            <div class="card mb-4">
                                <h5 class="card-header pb-0">{{_trans('order.WishList')}}</h5>

                                <div class="card-datatable table-responsive">
                                    <table class="wishlist-data-table table border-top">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{_trans('common.Image')}}</th>
                                                <th>{{_trans('product.Product Name')}}</th>
                                                <th>{{_trans('common.Action')}}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @if ($user && $user->role_id !== 4)
                                <div class="card mb-4">
                                    <h5 class="card-header pb-0">{{_trans('product.Product').' '._trans('order.List')}}</h5>
                                    <div class="card-datatable table-responsive">
                                        <table class="product-data-table table border-top">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="form-check-input"></th>
                                                    <th>{{_trans('common.Name')}}</th>
                                                    <th>{{_trans('common.Image')}}</th>
                                                    <th>{{_trans('product.Base Price')}}</th>
                                                    <th>{{_trans('common.Status')}}</th>
                                                    <th width="100px">{{_trans('common.Action')}}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- /Wishlist table -->
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                            <h5 class="card-header">{{_trans('common.Change').' '._trans('common.Password')}}</h5>
                            <div class="card-body">
                                <form id="passwordFrom" class="row g-3">
                                    <input type="text" id="userID" hidden value="{{ $user->id }}">
                                    <div class="col-md-6">
                                        <div class="form-password-toggle">
                                            <label class="form-label" for="formValidationPass">{{_trans('common.Password')}}</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password" id="formValidationPass"
                                                    name="formValidationPass"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="multicol-password2" />
                                                <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                            <span class="text-danger passwordError error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-password-toggle">
                                            <label class="form-label" for="formValidationConfirmPass">{{_trans('common.Confirm').' '._trans('common.Password')}}
                                                </label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password"
                                                    id="formValidationConfirmPass" name="formValidationConfirmPass"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="multicol-confirm-password2" />
                                                <span class="input-group-text cursor-pointer"
                                                    id="multicol-confirm-password2"><i class="ti ti-eye-off"></i></span>
                                            </div>
                                            <span class="text-danger confirmPasswordError error"></span>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">{{_trans('common.Submit')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                            <p>
                                Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                                cupcake gummi bears cake chocolate.
                            </p>
                            <p class="mb-0">
                                Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake.
                                Sweet
                                roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding
                                jelly
                                jelly-o tart brownie jelly.
                            </p>
                        </div>

                        @if ($user && $user->role_id !== 4)
                            <div class="tab-pane fade" id="navs-pills-justified-setting" role="tabpanel">
                                <div class="col-12 mb-4">
                                    <h4 class="text-light fw-medium">{{_trans('setting.Shop Setting')}}</h4>
                                    <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
                                        <div class="bs-stepper-header">
                                            <div class="step" data-target="#system-info-setting">
                                                <button type="button" class="step-trigger">
                                                    <span class="bs-stepper-circle">
                                                        <i class="ti ti-file-description"></i>
                                                    </span>
                                                    <span class="bs-stepper-label">
                                                        <span class="bs-stepper-title">{{_trans('setting.System Info')}}</span>
                                                        <span class="bs-stepper-subtitle">{{_trans('common.Setup').' '._trans('setting.System Info')}}</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#logo-setting">
                                                <button type="button" class="step-trigger">
                                                    <span class="bs-stepper-circle">
                                                        <i class="ti ti-user"></i>
                                                    </span>
                                                    <span class="bs-stepper-label">
                                                        <span class="bs-stepper-title">{{_trans('contact.Site Logo')}}</span>
                                                        <span class="bs-stepper-subtitle">{{_trans('common.Add').' '._trans('contact.Site Logo')}}</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#social-links-vertical">
                                                <button type="button" class="step-trigger">
                                                    <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
                                                    </span>
                                                    <span class="bs-stepper-label">
                                                        <span class="bs-stepper-title">Social Links</span>
                                                        <span class="bs-stepper-subtitle">{{_trans('common.Add').' '._trans('contact.Social Links')}}</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <!-- System Info -->
                                            <div id="system-info-setting" class="content">
                                                <form method="POST" id="system-info-setting-form">
                                                    @csrf
                                                    <div class="content-header mb-3">
                                                        <h6 class="mb-0">{{_trans('common.System').' '._trans('common.Info')}}</h6>
                                                        <small>{{_trans('setting.Enter Your System Info')}}.</small>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-sm-6">
                                                            <label class="form-label" for="shop_name">{{_trans('setting.Shop Name')}}</label>
                                                            <input type="text" id="shop_name" name="shop_name"
                                                                class="form-control" placeholder="House Brand"
                                                                value="{{ optional($user->shop)->shop_name }}" />

                                                            <span class="text-danger shop_nameError error"></span>

                                                        </div>
                                                        <div class="col-sm-12">
                                                            <label class="form-label" for="address">{{_trans('common.Address')}}</label>
                                                            <div class="input-group input-group-merge">
                                                                <textarea name="address" id="address" class="form-control" placeholder="24/A, Road-6, Miami" rows="3">{{ optional($user->shop)->location }}</textarea>

                                                            </div>

                                                            <span class="text-danger addressError error"></span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label" for="phone">{{_trans('common.Phone')}}</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text" id="phone" name="phone"
                                                                    class="form-control" required
                                                                    placeholder="+88754451415"
                                                                    value="{{ optional($user->shop)->phone }}" />
                                                            </div>
                                                            <span class="text-danger phoneError error"></span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label" for="email">{{_trans('common.Email')}}</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="email" id="email" name="email"
                                                                    class="form-control" required
                                                                    value="{{ optional($user->shop)->email }}"
                                                                    placeholder="housebrand@example.com" />
                                                            </div>

                                                            <span class="text-danger emailError error"></span>

                                                        </div>
                                                        <div class="col-sm-12">
                                                            <label class="form-label" for="mapLocation">{{_trans('contact.Map Location')}}</label>
                                                            <div class="input-group input-group-merge">
                                                                <textarea id="map_location" name="map_location" class="form-control" placeholder="Iframe Map Location"
                                                                    rows="3">{{ optional($user->shop)->map_location }}</textarea>
                                                            </div>

                                                            <span class="text-danger map_locationError error"></span>

                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button class="btn btn-primary" type="submit">
                                                                <span
                                                                    class="align-middle d-sm-inline-block d-none me-sm-1">{{_trans('common.Submit')}}</span>
                                                                <i class="ti ti-arrow-up"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Site Logo -->
                                            <div id="logo-setting" class="content">
                                                <form method="POST" id="logo-setting-form"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="content-header mb-3">
                                                        <h6 class="mb-0">{{_trans('setting.Site Logo')}}</h6>
                                                        <small>{{_trans('setting.Enter Your Site Logo.')}}</small>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <div class="card mb-4">
                                                                <h5 class="card-header">{{_trans('common.logo')}}</h5>
                                                                <!-- Account -->
                                                                <div class="card-body">
                                                                    <div
                                                                        class="d-flex align-items-start align-items-sm-center gap-4">
                                                                        <img src="{{ asset('storage/' . optional($user->shop)->logo) }}"
                                                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                                                            alt="user-avatar"
                                                                            class="d-block w-px-100 h-px-100 rounded"
                                                                            id="lightLogo" />

                                                                        <div class="button-wrapper">
                                                                            <label for="lightLogoInput"
                                                                                class="btn btn-primary mb-3 waves-effect waves-light"
                                                                                tabindex="0">
                                                                                <span class="d-none d-sm-block">{{_trans('common.logo')}}</span>
                                                                                <i
                                                                                    class="ti ti-upload d-block d-sm-none"></i>
                                                                                <input type="file" id="lightLogoInput"
                                                                                    name="light_logo"
                                                                                    class=" lightLogo-account-file-input"
                                                                                    hidden=""
                                                                                    accept="image/png, image/jpeg, image/jpg" />
                                                                            </label>
                                                                            <button type="button"
                                                                                class="btn btn-label-secondary  mb-3 waves-effect lightLogo-account-image-reset">
                                                                                <i
                                                                                    class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                                                <span
                                                                                    class="d-none d-sm-block">{{_trans('common.Reset')}}</span>
                                                                            </button>

                                                                            <div class="text-muted">{{ _trans('shop_setting.Allowed JPG, GIF or PNG. Max size of 800KB') }}</div>
                                                                            <span
                                                                                class="text-danger light_logoError error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /Account -->
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="card mb-4">
                                                                <h5 class="card-header">{{_trans('common.Favicon')}}</h5>
                                                                <!-- Account -->
                                                                <div class="card-body">
                                                                    <div
                                                                        class="d-flex align-items-start align-items-sm-center gap-4">

                                                                        <img src="{{ asset('storage/' . optional($user->shop)->favicon) }}"
                                                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                                                            class="d-block w-px-100 h-px-100 rounded"
                                                                            id="feviconLogo" />
                                                                        <div class="button-wrapper">
                                                                            <label for="feviconLogoInput"
                                                                                class="btn btn-primary mb-3 waves-effect waves-light"
                                                                                tabindex="0">
                                                                                <span
                                                                                    class="d-none d-sm-block">{{_trans('common.favicon')}}</span>
                                                                                <i
                                                                                    class="ti ti-upload d-block d-sm-none"></i>
                                                                                <input type="file"
                                                                                    id="feviconLogoInput"
                                                                                    class="fevicon-account-file-input"
                                                                                    name="favicon" hidden=""
                                                                                    accept="image/png, image/jpeg, image/jpg">
                                                                            </label>
                                                                            <button type="button"
                                                                                class="btn btn-label-secondary fevicon-account-image-reset mb-3 waves-effect">
                                                                                <i
                                                                                    class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                                                <span
                                                                                    class="d-none d-sm-block">{{_trans('common.Reset')}}</span>
                                                                            </button>

                                                                            <div class="text-muted">{{ _trans('shop_setting.Allowed JPG, GIF or PNG. Max size of 800KB') }}</div>
                                                                            <span
                                                                                class="text-danger faviconError error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /Account -->
                                                            </div>
                                                        </div>


                                                        <div class="col-8">
                                                            <div class="card mb-4">
                                                                <h5 class="card-header">{{_trans('gallery.Current Banner')}}</h5>
                                                                <!-- Account -->
                                                                <div class="card-body">
                                                                    <img src="{{ asset('storage/' . optional($user->shop)->banner) }}"
                                                                        id="darkLogo"
                                                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                                                        alt="user-avatar"
                                                                        class="d-block w-100 h-px-100 rounded" />

                                                                </div>
                                                                <!-- /Account -->
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="card mb-4">
                                                                <h5 class="card-header">{{_trans('gallery.Banner')}}</h5>
                                                                <!-- Account -->
                                                                <div class="card-body">
                                                                    <div
                                                                        class="d-flex align-items-start align-items-sm-center gap-4">
                                                                        <div class="button-wrapper">
                                                                            <label for="darkLogoInput"
                                                                                class="btn btn-primary  mb-3 waves-effect waves-light"
                                                                                tabindex="0">
                                                                                <span
                                                                                    class="d-none d-sm-block">{{_trans('gallery.Banner')}}</span>
                                                                                <i
                                                                                    class="ti ti-upload d-block d-sm-none"></i>
                                                                                <input type="file" id="darkLogoInput"
                                                                                    class="darkLogo-account-file-input"
                                                                                    name="banner" hidden=""
                                                                                    accept="image/png, image/jpeg, image/jpg">
                                                                            </label>
                                                                            <button type="button"
                                                                                class="btn btn-label-secondary darkLogo-account-image-reset mb-3 waves-effect">
                                                                                <i
                                                                                    class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                                                <span
                                                                                    class="d-none d-sm-block">{{_trans('common.Reset')}}</span>
                                                                            </button>

                                                                            <div class="text-muted">{{ _trans('shop_setting.Allowed JPG, GIF or PNG. Max size of 800KB') }}</div>
                                                                            <span
                                                                                class="text-danger dark_logoError error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /Account -->
                                                            </div>
                                                        </div>

                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button class="btn btn-primary" type="submit">
                                                                <span
                                                                    class="align-middle d-sm-inline-block d-none me-sm-1">{{_trans('common.Submit')}}</span>
                                                                <i class="ti ti-arrow-up"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Social Links -->
                                            <div id="social-links-vertical" class="content">
                                                <form method="POST" id="social-links-vertical-form">
                                                    @csrf
                                                    <div class="content-header mb-3">
                                                        <h6 class="mb-0">{{_trans('contact.Social Links')}}</h6>
                                                        <small>{{_trans('contact.Enter Your Social Links.')}}</small>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-sm-6">
                                                            <label class="form-label" for="twitter1">Twitter</label>
                                                            <input type="text" id="twitter1" name="twitter"
                                                                class="form-control"
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
                                                                class="form-control"
                                                                value="{{ optional($user->shop)->linkedin }}"
                                                                placeholder="https://linkedin.com/abc" />
                                                            <span class="text-danger linkedinError error"></span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label" for="linkedin1">Youtube</label>
                                                            <input type="text" id="youtube" name="youtube"
                                                                class="form-control"
                                                                value="{{ optional($user->shop)->youtube_url }}"
                                                                placeholder="https://youtube.com/abc" />
                                                            <span class="text-danger youtubeError error"></span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label" for="linkedin1">Tiktok</label>
                                                            <input type="text" id="tiktok" name="tiktok"
                                                                class="form-control"
                                                                value="{{ optional($user->shop)->tiktok_url }}"
                                                                placeholder="https://tiktok.com/abc" />
                                                            <span class="text-danger tiktokError error"></span>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button class="btn btn-primary" type="submit">
                                                                <span
                                                                    class="align-middle d-sm-inline-block d-none me-sm-1">{{_trans('common.Submit')}}</span>
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
                        @endif

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
                            <h3 class="mb-2">{{_trans('user.Edit User Information')}}</h3>
                            <p class="text-muted">{{_trans('user.Updating user details will receive a privacy audit.')}}</p>
                        </div>
                        <form id="editUserForm" class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserFirstName">{{_trans('common.Name')}}</label>
                                <input type="text" id="modalEditUserName" name="modalEditUserName"
                                    class="form-control" placeholder="John" value="{{ $user->name }}" />
                                <span class="text-danger usernameError error"></span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserPhone">{{_trans('common.Phone')}}</label>
                                <input type="text" id="modalEditPhone" name="modalEditPhone" class="form-control"
                                    placeholder="+87554442" value="{{ $user->phone }}" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserEmail">{{_trans('common.Email')}}</label>
                                <input type="text" value="{{ $user->email }}" id="modalEditUserEmail"
                                    name="modalEditUserEmail" class="form-control" placeholder="example@domain.com"
                                    readonly />
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditTaxID">{{_trans('contact.Address')}}</label>
                                <input type="text" value="{{ $user->address }}" id="modalEditAddress"
                                    name="modalEditTaxID" class="form-control"
                                    placeholder="Richfield Springs, NY 13439" />
                            </div>

                            <div class="col-6">
                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="user-image">{{_trans('common.Image')}}</label>
                                    <input class="form-control" type="file" name="image" id="modalUserImage" />
                                    <span class="text-danger imageError error"></span>
                                </div>
                            </div>


                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Submit')}}</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    {{_trans('common.Cancel')}}
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

            var table = $('.order-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.orders', $user->id) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'designer.name'
                    },
                    {
                        data: 'items_count',
                        name: 'items_count',
                        searchable: false
                    },
                    {
                        data: 'order_date',
                        name: 'order_date',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [2, "desc"], //set any columns order asc/desc
                lengthMenu: [5, 10, 30, 50], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search in order list",
                },
            });

            var table = $('.cart-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.carts', $user->id) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'thumbnail_img',
                        name: 'thumbnail_img',
                        searchable: false
                    },
                    {
                        data: 'product_name',
                        name: 'product.name'
                    },
                    {
                        data: 'variation',
                        name: 'variation',
                        searchable: false
                    },
                    {
                        data: 'designer',
                        name: 'designer.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [2, "desc"], //set any columns order asc/desc
                lengthMenu: [5, 10, 30, 50], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search in cart list",
                },
            });

            var table = $('.wishlist-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.wishlist', $user->id) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'thumbnail_img',
                        name: 'thumbnail_img',
                        searchable: false
                    },
                    {
                        data: 'product_name',
                        name: 'product.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [2, "desc"], //set any columns order asc/desc
                lengthMenu: [5, 10, 30, 50], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search in Wishlist",
                },
            });
            @if ($user && $user->role_id !== 4)
                var table = $('.product-data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('user.products', $user->id) }}',
                    columns: [{
                            data: '',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'thumbnail_img',
                            name: 'thumbnail_img'
                        },
                        {
                            data: 'unit_price',
                            name: 'unit_price'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    columnDefs: [{
                        targets: 0,
                        className: "control",
                        responsivePriority: 1,
                        render: function() {
                            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                        },
                    }],
                    order: [2, "desc"], //set any columns order asc/desc
                    dom: '<"card-header d-flex flex-wrap pb-2"' +
                        "<f>" +
                        '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"lB>>' +
                        ">t" +
                        '<"row mx-2"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        ">",
                    lengthMenu: [5, 10, 20], //for length of menu
                    language: {
                        sLengthMenu: "_MENU_",
                        search: "",
                        searchPlaceholder: "Search Product",
                    },
                    // Button for offcanvas
                    buttons: [],
                });
            @endif



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
                        } else if (response.status === 200) {
                            toastr.success(response.message);
                            $('.btn-close').click();
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });

            })

            const suspendUser = document.querySelector('.suspend-user');

            // Suspend User javascript
            if (suspendUser) {
                suspendUser.onclick = function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert user!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Change Status',
                        customClass: {
                            confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                            cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: '{{ route('user.changeStatus') }}',
                                method: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    user_id: {{ $user->id }},
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Changed!',
                                        text: response.text,
                                        customClass: {
                                            confirmButton: 'btn btn-success waves-effect waves-light'
                                        }
                                    }).then(function(confirm) {
                                        if (confirm.value) {
                                            location.reload();
                                        }
                                    });
                                },
                                error: function(error) {
                                    console.log(error.responseJSON.message);
                                }
                            });

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Cancelled Change Status:)',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                }
                            });
                        }
                    });
                };
            }

        });
    </script>

    <script>
        $('#system-info-setting-form').on('submit', function(e) {
            e.preventDefault();

            $('.error').text('');
            $.ajax({
                url: '{{ route('user.shopInfoUpdate') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    // element = $('input[name="element_name"]');
                    shop_name: $('#shop_name').val(),
                    address: $('#address').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),
                    map_location: $('#map_location').val(),
                    user_id: {{ $user->id }},
                },
                success: function(response) {
                    if (response.status == 403) {
                        console.log(response.errors.phone[0]);

                        $('.shop_nameError').text(response.errors?.shop_name ? response.errors
                            ?.shop_name[
                                0] : '');
                        $('.siteTitleError').text(response.errors?.siteTitle ? response.errors
                            ?.siteTitle[0] : '');
                        $('.addressError').text(response.errors?.address ? response.errors?.address[0] :
                            '');
                        $('.phoneError').text(response.errors?.phone ? response.errors?.phone[0] : '');
                        $('.emailError').text(response.errors?.email ? response.errors?.email[0] : '');

                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });


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
