@extends('layouts.master')

@section('title', $title ?? _trans('order.Cart'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('order.Cart').' '. _trans('order.List'),['#'=>_trans('order.Order').' '. _trans('product.Management'),'##'=>_trans('order.Customer').' '._trans('order.Order'),'cart'=>_trans('order.Cart').' '. _trans('order.List')]) !!}

        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{_trans('order.Client Name')}}</th>
                                <th>{{_trans('order.No. of Item')}}</th>
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
                ajax: '{{ route('cart.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'users.name'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [2, "desc"], //set any columns order asc/desc
                lengthMenu: [10, 20, 50, 70, 100], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search in cart list",
                },
            });


        });
    </script>
@endpush
