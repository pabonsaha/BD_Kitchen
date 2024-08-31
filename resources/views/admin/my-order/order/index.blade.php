@extends('layouts.master')

@section('title', $title ?? _trans('order.My Order'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('order.My Order').' ' ._trans('order.List'),['#'=>_trans('order.Order').' '. _trans('product.Management'),'##'=>_trans('common.My').' '._trans('order.Order'), 'order'=>_trans('order.My Order').' '._trans('order.List')]) !!}

        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{_trans('order.Order Status')}} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select') }} {{_trans('common.Status')}}</option>
                            @foreach($orderStatus as $status)
                                <option value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{_trans('order.Order ID')}}</th>
                                <th>{{_trans('order.Seller')}}</th>
                                <th>{{_trans('order.No. of Item')}}</th>
                                <th>{{_trans('common.Date')}}</th>
                                <th>{{_trans('common.Status')}}</th>
                                <th>{{_trans('common.Action')}}</th>
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
                    url: '{{ route('myOrder.order.index') }}',
                    data: function (d){
                        d.status = $('#status').val()
                    }
                },
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
                        data: 'status',
                        name: 'orderStatus.name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                dom: '<"card-header d-flex flex-wrap pb-2"' +
                    "<f>" +
                    '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"l>>' +
                    ">t" +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",                order: [2, "desc"], //set any columns order asc/desc
                lengthMenu: [10, 20, 50, 70, 100], //for length of menu
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
