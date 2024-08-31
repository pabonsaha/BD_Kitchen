@extends('layouts.master')

@section('title', $title ?? _trans('order.Order Claims'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('order.Order Claims'),['#'=> _trans('order.Order').' '. _trans('product.Management'),'##'=>_trans('order.Customer').' '._trans('order.Order'), 'order'=>_trans('order.Order Claims')]) !!}
        <div class="app-ecommerce-category">
            <!-- Order Claims Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{_trans('order.Claim').' '. _trans('common.Status')}} :</strong></label>
                        <select id='claim_status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '. _trans('common.Status')}}</option>
                            @foreach($claimIssues as $issue)
                                <option value="{{$issue->id}}">{{$issue->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>{{_trans('common.Status')}} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '. _trans('common.Status')}}</option>
                            <option value="0">{{_trans('common.Pending')}}</option>
                            <option value="1">{{_trans('common.Accepted')}}</option>
                            <option value="2">{{_trans('common.Closed')}}</option>
                        </select>
                    </div>

                </div>
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{_trans('order.Order ID')}}</th>
                            <th>{{_trans('user.Customer')}}</th>
                            <th>{{_trans('common.Issue Type')}}</th>
                            <th>{{_trans('common.Details')}}</th>
                            <th>{{_trans('common.File')}}</th>
                            <th>{{_trans('common.Status')}}</th>
                            <th>{{_trans('common.Date Time')}}</th>
                            <th>{{_trans('common.Info')}}</th>
                            @if(hasPermission("customer_order_claim_read"))
                                <th>{{_trans('common.Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('order-claim.index') }}',
                    data: function (d) {
                        d.order_id = new URLSearchParams(window.location.search).get('order_id');
                        d.claim_status = $('#claim_status').val()
                        d.status = $('#status').val()
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false
                    },
                    {
                        data: 'order_id',
                        name: 'order_id'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'issue_type',
                        name: 'issue_type'
                    },
                    {
                        data: 'details',
                        name: 'details',
                        render: function (data, type, row) {
                            const truncated = data.length > 100 ? data.substr(0, 100) + '...' :
                                data;
                            return '<div style="width: 200px; white-space: normal; word-wrap: break-word;">' +
                                truncated + '</div>';
                        }
                    },
                    {
                        data: 'file',
                        name: 'file',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'date_time',
                        name: 'date_time',
                    },
                    {
                        data: 'info',
                        name: 'info',
                    },
                    @if(hasPermission("customer_order_claim_read"))
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    @endif
                ],
                order: [2, "desc"], //set any columns order asc/desc
                dom: '<"card-header d-flex flex-wrap pb-2"' +
                    "<f>" +
                    '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"l>>' +
                    ">t" +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",                lengthMenu: [10, 20, 50, 70, 100], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search in order list",
                },
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });


        });
    </script>
@endpush
