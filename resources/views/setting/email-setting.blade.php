@extends('layouts.master')

@section('title', $title ?? _trans('common.Email').' '._trans('setting.Settings'))

@section('content')
    <div class="row g-4 justify-content-between align-items-end mt-0">
        {!! breadcrumb(_trans('common.Email').' '._trans('setting.Settings'),['#'=>_trans('setting.System').' '._trans('setting.Settings'),'/setting/email-setting'=>_trans('common.Email').' '._trans('setting.Settings')]) !!}
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion" id="collapsibleSection">
                <div class="card accordion-item">
                    <div id="collapseDeliveryAddress" class="accordion-collapse collapse show"
                        data-bs-parent="#collapsibleSection">
                        <div class="accordion-body">
                            @if(hasPermission('send_test_email'))
                                <button data-bs-target="#testMailModal" data-bs-toggle="modal" class="btn btn-primary mb-2 text-nowrap text-right">
                                 {{_trans('setting.Test Email')}}
                                </button>
                            @endif
                            <form action="{{ route('setting.email-setting.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-fullname"> {{_trans('setting.Email Engine Type')}}</label>
                                        <input type="text" id="collapsible-fullname" name="email_engine_type"
                                            class="form-control" placeholder="John Doe" value="{{ optional($email_setting)->email_engine_type }}" />
                                        @error('email_engine_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-name">{{_trans('common.From').' '._trans('common.Name')}}</label>
                                        <input type="text" id="collapsible-name" class="form-control"
                                            placeholder="Janifer House" name="from_name" value="{{optional($email_setting)->from_name}}" aria-label="Janifer House" />
                                        @error('from_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="collapsible-address">{{_trans('common.From').' '._trans('common.Email')}}</label>
                                        <input type="email" id="collapsible-pincode" class="form-control"
                                            placeholder="test@mail.com" name="from_email" value="{{optional($email_setting)->from_email}}" />
                                        @error('from_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-pincode">{{_trans('setting.Mail Driver')}}</label>
                                        <input type="text" id="collapsible-pincode" class="form-control"
                                            placeholder="658468" name="mail_driver" value="{{optional($email_setting)->mail_driver}}" />
                                        @error('mail_driver')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-landmark">{{_trans('setting.Mail Host')}}</label>
                                        <input type="text" id="collapsible-landmark" class="form-control"
                                            placeholder="Nr. Wall Street" name="mail_host" value="{{optional($email_setting)->mail_host}}" />
                                        @error('mail_host')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-landmark">{{_trans('setting.Mail Port')}}</label>
                                        <input type="text" id="collapsible-landmark" class="form-control"
                                            placeholder="Nr. Wall Street" name="mail_port" value="{{optional($email_setting)->mail_port}}" />
                                        @error('mail_port')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-city">{{_trans('common.Mail').' '._trans('common.User').' '._trans('common.Name')}}</label>
                                        <input type="text" id="collapsible-city" name="mail_username"
                                            class="form-control" placeholder="Jackson" value="{{optional($email_setting)->mail_username}}" />
                                            @error('mail_username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-city">{{_trans('common.Mail').' '._trans('common.Password')}} </label>
                                        <input type="text" id="collapsible-city" name="mail_password"
                                            class="form-control" placeholder="Jackson" value="{{optional($email_setting)->mail_password}}" />
                                        @error('mail_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="collapsible-city">{{_trans('setting.Mail Encryption')}}</label>
                                        <input type="text" id="collapsible-city" name="mail_encryption"
                                            class="form-control" placeholder="Jackson" value="{{optional($email_setting)->mail_encryption}}" />
                                        @error('mail_encryption')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if(hasPermission('email_settings_update'))
                                        <div class="row justify-content-center mt-4">
                                            <button type="submit" id="addProduct" class="btn btn-primary col-4">{{_trans('common.Submit')}}</button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Send Test Mail -->
    <div id="testMailModal" class="modal fade" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('common.Send').' '._trans('setting.Test Email')}}</h3>
                    </div>
                    <form class="row g-3" action="{{route('setting.email-setting.sendTestEmail')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mb-2">
                            <label class="form-label">{{_trans('setting.Subject')}}</label>
                            <input type="text" name="subject" class="form-control"
                                   placeholder="Enter subject" tabindex="-1" required/>
                            @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">{{_trans('setting.To Email')}}</label>
                            <input type="email" name="to_email" class="form-control"
                                   placeholder="Enter email" tabindex="-1" required/>
                            @error('to_email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Message Body -->
                        <div>
                            <label class="form-label">{{_trans('setting.Message')}}</label>
                            <textarea name="message" class="form-control" cols="30" rows="7" placeholder="Email body" required></textarea>
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Submit')}}</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{_trans('common.Cancel')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Send Test Mail -->

@endsection


@push('scripts')
@endpush
