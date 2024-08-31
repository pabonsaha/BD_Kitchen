@extends('layouts.master')

@section('title', $title ?? _trans('order.Order Claims').' '. _trans('common.Details'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('order.Order Claims').' '. _trans('common.Details'), ['#' => _trans('order.Order').' '. _trans('product.Management'),'##'=>_trans('order.Customer').' '._trans('order.Order'), '/order-claim'=>_trans('order.Order Claims'), 'claim_details' => _trans('order.Order Claims').' '. _trans('common.Details')]) !!}
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="mb-3 fw-bold">{{_trans('order.Claim').' '. _trans('common.Details')}}</h6>
                                <table>
                                    <tbody>

                                    <tr>
                                        <td class="pe-4">{{_trans('common.Status')}}:</td>
                                        @if($orderClaim->status == 0)
                                            <td> <span class="badge bg-label-warning">{{_trans('common.Pending')}}</span></td>
                                        @elseif($orderClaim->status == 1)
                                        <td> <span class="badge bg-label-success">{{_trans('common.Accepted')}}</span></td>
                                        @else
                                            <td> <span class="badge bg-label-danger">{{_trans('common.Closed')}}</span></td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td class="pe-4">{{_trans('common.Issue Type')}}:</td>
                                        <td> <span class="badge bg-label-info">{{$orderClaim->orderClaimIssueType->name}}</span></td>
                                    </tr>

                                    <tr>
                                        <td class="pe-4">{{_trans('common.Date Time')}}:</td>
                                        <td> {{dateFormat($orderClaim->date_time)}}</td>
                                    </tr>

                                    <tr>
                                        <td class="pe-4">{{_trans('common.Update').' '. _trans('common.Status')}} :</td>
                                        <td>
                                            <select id="status" name="status" class="select2 form-select2" data-placeholder="Select Plan Type">
                                                <option value="0" {{ $orderClaim->status == 0 ? 'selected' : '' }}>{{_trans('common.Pending')}}</option>
                                                <option value="1" {{ $orderClaim->status == 1 ? 'selected' : '' }}>{{_trans('common.Accepted')}}</option>
                                                <option value="2" {{ $orderClaim->status == 2 ? 'selected' : '' }}>{{_trans('common.Closed')}}</option>
                                            </select>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <h6 class="mb fw-bold">{{_trans('order.Order Info')}}</h6>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Order Code')}}:</td>
                                        <td class="fw-medium">{{@$orderClaim->order->code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Order Date')}}:</td>
                                        <td>{{ dateFormat($orderClaim->order->order_date) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">{{_trans('order.Order Status')}}:</td>
                                        <td> <span class="badge bg-label-success">{{ $orderClaim->order->orderStatus->name }}</span></td>
                                    </tr>

                                    <tr>
                                        <td class="pe-4">{{_trans('common.Payment status')}}:</td>
                                        <td class="fw-medium"> <span class="badge bg-label-success">Paid</span></td>
                                    </tr>

                                    <tr>
                                        <td class="pe-4">{{_trans('order.Total Order Amount')}}:</td>
                                        <td>{{ getPriceFormat($orderClaim->order->grand_total_amount) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">

                    <div class="p-sm-3 p-0 mt-3">
                        <h4 class="mb-3 fw-bold">{{_trans('common.Subject')}}: {{$orderClaim->subject}}</h4>
                        <h6 class="mb-3 fw-bold">{{_trans('common.Message')}}: </h6>

                        {{$orderClaim->details}}

                    </div>

                    <div class="p-sm-3 p-0 mt-3">
                        <h6 class="mb-3 fw-bold">{{_trans('common.File/Attachment')}}: </h6>
                        @if($orderClaim->file)
                            {!!getFileElement(getFilePath($orderClaim->file)) !!}
                        @endif
                    </div>

                    <hr class="m-0">

                    <!-- Chat History -->
                    <div class="container-xxl flex-grow-1 container-p-y ">
                        <div class="app-chat card overflow-hidden">
                            <div class="row g-0">
                                <div class="col app-chat-history bg-body ">
                                    <div class="chat-history-wrapper">
                                        <div class="chat-history-header border-bottom">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex overflow-hidden align-items-center">
                                                    <i
                                                        class="ti ti-menu-2 ti-sm cursor-pointer d-lg-none d-block me-2"
                                                        data-bs-toggle="sidebar"
                                                        data-overlay
                                                        data-target="#app-chat-contacts"></i>
                                                    <div class="flex-shrink-0 avatar">
                                                        <img
                                                            src="{{getFilePath($orderClaim->user->avatar)}}"
                                                            alt="Avatar"
                                                            class="rounded-circle"
                                                            data-bs-toggle="sidebar"
                                                            data-overlay
                                                            data-target="#app-chat-sidebar-right"/>
                                                    </div>
                                                    <div class="chat-contact-info flex-grow-1 ms-2">
                                                        <h6 class="m-0">{{$orderClaim->user->name}}</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="dropdown d-flex align-self-center">
                                                        <button
                                                            class="btn p-0"
                                                            type="button"
                                                            id="chat-header-actions"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                             aria-labelledby="chat-header-actions">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                Contact</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Mute
                                                                Notifications</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Block
                                                                Contact</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Clear
                                                                Chat</a>
                                                            <a class="dropdown-item"
                                                               href="javascript:void(0);">Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="chat-history-body bg-body">
                                            <ul class="list-unstyled chat-history">
                                                @foreach($allMessages as $message)
                                                    <li class="chat-message {{ $message->user_id == auth()->id() ? 'chat-message-right' : '' }}">
                                                        <div class="d-flex overflow-hidden">
                                                            @if($message->user_id != auth()->id())
                                                                <div class="user-avatar flex-shrink-0 me-3">
                                                                    <div class="avatar avatar-sm">
                                                                        <img src="{{ getFilePath($message->user->avatar) }}" alt="Avatar" class="rounded-circle" />
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="chat-message-wrapper flex-grow-1">
                                                                <div class="chat-message-text">
                                                                    <p class="mb-0">{{ $message->details }}</p>
                                                                </div>
                                                                @if($message->file)
                                                                    <div class="file-attachment mt-2">
                                                                        <a href="{{ getFilePath($message->file) }}" download>
                                                                            {!! getFileElement(getFilePath($message->file)) !!}
                                                                        </a>
                                                                    </div>
                                                                @endif

                                                                <div class="text-{{ $message->user_id == auth()->id() ? 'end' : 'start' }} text-muted mt-1">
                                                                    <i class="ti ti-checks ti-xs me-1 {{ $message->user_id == auth()->id() ? 'text-success' : '' }}"></i>
                                                                    <small>{{ dateFormatwithTime($message->created_at) }}</small>
                                                                </div>
                                                            </div>

                                                            @if($message->user_id == auth()->id())
                                                                <div class="user-avatar flex-shrink-0 ms-3">
                                                                    <div class="avatar avatar-sm">
                                                                        <img src="{{ getFilePath(auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle" />
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- Chat message form -->
                                        @if(hasPermission('customer_order_claim_reply'))
                                            <div class="chat-history-footer shadow-sm">
                                                <form action="{{ route('order-claim-reply.store') }}" method="POST" enctype="multipart/form-data"
                                                      class="form-send-message d-flex justify-content-between align-items-center">
                                                    @csrf
                                                    <input name="order_claim_id" value="{{$orderClaim->id}}" type="text" hidden>

                                                    <input
                                                        class="form-control message-input border-0 me-3 shadow-none"
                                                        placeholder="Type your message here" name="message"/>
                                                    <div class="message-actions d-flex align-items-center">
                                                        <label for="attach-doc" class="form-label mb-0">
                                                            <i class="ti ti-photo ti-sm cursor-pointer mx-3"></i>
                                                            <input type="file" name="file" id="attach-doc" hidden/>
                                                        </label>
                                                        <button class="btn btn-primary d-flex send-msg-btn">
                                                            <i class="ti ti-send me-md-1 me-0"></i>
                                                            <span class="align-middle d-md-inline-block d-none">Send</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- /Chat History -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Invoice -->

            <div class="col-12 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title m-0">{{_trans('order.Customer details')}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <div class="avatar me-2">
                                <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-body text-nowrap">
                                    <h6 class="mb-0">{{ optional($orderClaim->order->user)->name }}</h6>
                                </a>
                                <small class="text-muted">{{_trans('order.Customer ID')}}: #58909</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <h6>{{_trans('common.Contact info')}}</h6>

                        </div>
                        <p class="mb-1">{{_trans('common.Email')}}: {{ optional($orderClaim->order->user)->email }}</p>
                        <p class="mb-0">{{_trans('common.Mobile')}}: {{ optional($orderClaim->order->user)->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(function () {

            @if(hasPermission('order_claim_status_update'))
            $(document).on('change', '#status', function () {
                const status = $(this).val();
                const orderClaimId = {{$orderClaim->id}};

                console.log(status, orderClaimId);
                const formData = new FormData();
                formData.append('claimIssueStatus', status)
                formData.append('orderClaimId', orderClaimId)
                formData.append('_token', "{{ csrf_token() }}");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "To change the status of this.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Update it',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('order-claim.statusChange') }}',
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    window.location.reload();
                                }
                            },
                            error: function (error) {
                                toastr.error(error);
                            }
                        })
                    } else {
                        window.location.reload();
                    }
                });


            });
            @endif

        });
    </script>
@endpush
