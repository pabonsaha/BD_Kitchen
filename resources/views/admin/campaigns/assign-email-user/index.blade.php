@extends('layouts.master')

@section('title', $title ?? _trans('marketing.Assign User Emails'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('marketing.Assign User Emails'), ['#' => _trans('marketing.Marketing'), 'Assign User Emails' => _trans('marketing.Assign User Emails')]) !!}
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">

                    <div class="p-sm-3 p-0">
                        <h6 class="mb-1 fw-bold">{{_trans('common.Title')}}: </h6>
                        {{ $campaign->title }}
                    </div>

                    <div class="p-sm-3 p-0">
                        <h6 class="mb-1 fw-bold">{{_trans('common.Message')}}: </h6>
                        {!! $campaign->message !!}
                    </div>

                    <div class="p-sm-3 p-0 mb-3">
                        <h6 class="mb-1 fw-bold">{{_trans('marketing.File/Attachment')}}: </h6>

                        {!! getFileElement(getFilePath($campaign->attachment)) !!}

                    </div>
                </div>
                {{--  --}}
                <div class="card invoice-preview-card mt-2">
                    <div class="p-sm-3 p-0">
                        <h6 class="mb-1 fw-bold">{{_trans('common.Select').' '._trans('common.Email')}}: </h6>
                    </div>
                    <hr class="m-0">

                    <div class="row p-sm-3 p-0">
                        <!-- First Dropdown -->
                        <div class="col-md-6 ecommerce-select2-dropdown">
                            <label for="typeList" class="form-label mb-1 d-flex justify-content-between align-items-center">
                                <span>{{_trans('common.Select').' '._trans('common.Type')}}</span>
                            </label>
                            <select id="typeList" name="typeList" class="select2 form-select"
                            data-placeholder="Select Category">
                            <option value="" selected disabled>{{_trans('common.Select').' '._trans('common.Type')}}</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                            <option value="subscribers">{{_trans('subscriber.Subscribers')}}</option>
                            <option value="contact_requests">{{_trans('marketing.Contact Requests')}}</option>
                        </select>
                        </div>
                        <!-- Second Dropdown -->
                        <div class="col-md-6 ecommerce-select2-dropdown">
                            <label for="emailList"
                                class="form-label mb-1 d-flex justify-content-between align-items-center">
                                <span>{{_trans('common.Email').' '._trans('common.List')}}</span>
                            </label>
                            <select id="emailList" name="emailList" class="select2 form-select"
                                data-placeholder="Select Email" style="display:none;">
                                <option value="" selected disabled>{{_trans('common.Select').' '._trans('common.Email')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
            </div>
            <!-- Selected Emails -->
            <div class="col-12 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title m-0">{{_trans('marketing.Selected Emails')}}</h6>
                    </div>
                    <hr class="m-0">
                    <div class="card-body" id="selectedEmails">
                        @foreach (json_decode($campaign->emails ?? '[]', true) as $email)
                            <div class="form-check mb-2 email-item" data-email="{{ $email }}">
                                <input class="form-check-input" type="checkbox" id="emailCheck_{{ $email }}"
                                    value="{{ $email }}" checked>
                                <label class="form-check-label"
                                    for="emailCheck_{{ $email }}">{{ $email }}</label>
                            </div>
                        @endforeach
                        <p id="noEmailsSelectedText" class="text-muted"
                            @if (!empty(json_decode($campaign->emails ?? '[]', true))) style="display:none;" @endif>
                            <span class="text-danger">{{_trans('marketing.No emails are selected')}}.</span>
                        </p>
                    </div>
                </div>
                <button id="sendButton" type="submit" class="btn btn-primary data-submit waves-effect waves-light"
                    @if (empty(json_decode($campaign->emails ?? '[]', true))) disabled @endif>{{_trans('common.Save')}}</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            function addOrRemoveEmail(email, action) {
                let selectedEmails = $('#selectedEmails');
                let existingEmails = selectedEmails.find('.email-item').map(function() {
                    return $(this).data('email');
                }).get();

                if (action === 'add') {
                    if (existingEmails.includes(email)) {
                        return;
                    }
                    selectedEmails.append('<div class="form-check mb-2 email-item" data-email="' + email +
                        '">' +
                        '<input class="form-check-input" type="checkbox" id="emailCheck_' + email +
                        '" value="' + email + '" checked>' +
                        '<label class="form-check-label" for="emailCheck_' + email + '">' + email + '</label>' +
                        '</div>');
                } else if (action === 'remove') {
                    selectedEmails.find('.email-item[data-email="' + email + '"]').remove();
                }

                updateSelectedEmailsUI();
            }

            function updateSelectedEmailsUI() {
                let selectedEmails = $('#selectedEmails');
                let emailItems = selectedEmails.find('.email-item');
                let noEmailsSelectedText = $('#noEmailsSelectedText');
                let sendButton = $('#sendButton');

                if (emailItems.length > 0) {
                    noEmailsSelectedText.hide();
                    sendButton.prop('disabled', false);
                } else {
                    noEmailsSelectedText.show();
                    sendButton.prop('disabled', true);
                }
            }

            $('#typeList').on('change', function() {
                let type = $(this).val();
                if (type) {
                    $.ajax({
                        url: "{{ route('marketing.get-users-by-type') }}",
                        method: 'GET',
                        data: {
                            type: type
                        },
                        success: function(response) {
                            let emailList = $('#emailList');
                            emailList.empty();
                            emailList.append(
                                '<option value="" selected disabled>Select Email</option>');
                            if (type === 'subscribers' || type === 'contact_requests' || type) {
                                emailList.append('<option value="all">Select All</option>');
                            }
                            response.forEach(function(email) {
                                emailList.append('<option value="' + email + '">' +
                                    email + '</option>');
                            });
                            emailList.show();
                        }
                    });
                }
            });

            $('#emailList').on('change', function() {
                let selectedEmail = $(this).val();
                if (selectedEmail === 'all') {
                    let type = $('#typeList').val();
                    if (type) {
                        $.ajax({
                            url: "{{ route('marketing.get-users-by-type') }}",
                            method: 'GET',
                            data: {
                                type: type
                            },
                            success: function(response) {
                                response.forEach(function(email) {
                                    addOrRemoveEmail(email, 'add');
                                });
                            }
                        });
                    }
                } else if (selectedEmail) {
                    addOrRemoveEmail(selectedEmail, 'add');
                }
            });

            $('#selectedEmails').on('change', 'input[type="checkbox"]', function() {
                let email = $(this).val();
                if (!this.checked) {
                    addOrRemoveEmail(email, 'remove');
                } else {
                    addOrRemoveEmail(email, 'add');
                }
            });

            $('#sendButton').on('click', function(e) {
                e.preventDefault();
                // Collect selected emails
                let selectedEmails = $('#selectedEmails').find('.email-item').map(function() {
                    return $(this).data('email');
                }).get();
                // update selected emails for campaign
                $.ajax({
                    url: "{{ route('marketing.updateEmailcampaignEmails', ['id' => $campaign->id]) }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        emails: selectedEmails
                    },
                    success: function(response) {
                        toastr.success(response.message);

                        window.location.href = "{{ route('marketing.campaign.index') }}";
                    },
                    error: function(xhr, status, error) {
                        console.error('Error launching campaign:', error);
                    }
                });
            });

        });
    </script>
@endpush
