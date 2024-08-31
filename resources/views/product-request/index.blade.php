@extends('layouts.master')

@section('title', $title ?? __('Cart'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb('Product Request List', ['#' => 'Order Management','##'=>_trans('order.Customer').' '._trans('order.Order'), 'cart' => 'Product Request List']) !!}

        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{_trans('user.Customer').' '._trans('user.Name')}}</th>
                                <th>{{_trans('product.Product').' '._trans('user.Name')}}</th>
                                <th>{{_trans('product.Variants')}}</th>
                                <th>{{_trans('product.Price')}}</th>
                                <th>{{_trans('common.Qty')}}</th>
                                <th>{{_trans('common.Actions')}}</th>
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
                ajax: '{{ route('productRequest.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name',
                        searchable: false
                    },
                    {
                        data: 'variation',
                        name: 'variation',
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                        searchable: false
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
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

            $(document).on("click", ".product_request_approve_button", function() {

                let id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve it!',
                    customClass: {
                        confirmButton: 'btn btn-success me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        $.ajax({
                            url: '{{ route('productRequest.approve') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                product_request_id: id,
                            },
                            success: function(response) {
                                table.ajax.reload(null, false)
                                Swal.fire({
                                    icon: response.icon,
                                    title: 'Deleted!',
                                    text: response.text,
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            },
                            error: function(error) {
                                console.log(error.responseJSON.message);
                                // handle the error case
                            }
                        });
                    }
                });
            });
            $(document).on("click", ".product_request_cancel_button", function() {

                let id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Cancel it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        $.ajax({
                            url: '{{ route('productRequest.cancel') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                product_request_id: id,
                            },
                            success: function(response) {
                                table.ajax.reload(null, false)
                                Swal.fire({
                                    icon: response.icon,
                                    title: 'Deleted!',
                                    text: response.text,
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            },
                            error: function(error) {
                                console.log(error.responseJSON.message);
                                // handle the error case
                            }
                        });
                    }
                });
            });


        });
    </script>
@endpush
