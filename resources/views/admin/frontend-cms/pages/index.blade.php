@extends('layouts.master')

@section('title', $title ?? _trans('pages.Pages'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('pages.Pages'), [
            '#' => _trans('frontendCMS.Frontend') . ' ' . _trans('frontendCMS.CMS'),
            'page' => _trans('pages.Pages'),
        ]) !!}

        <div class="app-ecommerce-category">
            <!-- Widget List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 "
                    style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{ _trans('common.Status') }} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{ _trans('common.Select') . ' ' . _trans('common.Status') }}</option>
                            <option value="1">{{ _trans('common.Active') }}</option>
                            <option value="0">{{ _trans('common.Deactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input"></th>
                                <th>{{ _trans('common.Title') }}</th>
                                <th>{{ _trans('frontendCMS.Footer') . ' ' . _trans('frontendCMS.Widget') }} </th>
                                <th>{{ _trans('common.Short Description') }}</th>
                                <th>{{ _trans('frontendCMS.Content') }}</th>
                                <th>{{ _trans('common.User') }}</th>
                                <th>{{ _trans('common.Status') }}</th>
                                <th width="50px">{{ _trans('common.Info') }}</th>
                                <th width="100px">{{ _trans('common.Action') }}</th>
                            </tr>
                        </thead>
                    </table>
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
                        url: '{{ route('cms.pages.index') }}',
                        data: function(d) {
                            d.status = $('#status').val()
                        }
                    },
                    columns: [{
                            data: '',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'footer_name',
                            name: 'footer_name'
                        },
                        {
                            data: 'short_desc',
                            name: 'short_desc'
                        },

                        {
                            data: 'content',
                            name: 'content',
                            render: function(data, type, row) {
                                if (data !== null) {
                                    // Strip HTML tags from the data
                                    const plainText = $('<div>').html(data).text();
                                    const truncated = plainText.length > 100 ? plainText.substr(0,
                                        100) + '...' : plainText;

                                    return '<div data-bs-toggle="tooltip" data-bs-placement="right" title="' +
                                        truncated +
                                        '" style="width: 220px; white-space: normal; word-wrap: break-word;">' +
                                        truncated + '</div>';
                                } else {
                                    return '<div style="width: 220px; white-space: normal; word-wrap: break-word;">No description available</div>';
                                }
                            }
                        },
                        {
                            data: 'user_name',
                            name: 'user_name'
                        },
                        {
                            data: 'status',
                            name: 'active_status'
                        },
                        {
                            data: 'info',
                            name: 'info'
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
                    "fnDrawCallback": function() {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    },
                    dom: '<"card-header d-flex flex-wrap pb-2"' +
                        "<f>" +
                        '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"l>>' +
                        ">t" +
                        '<"row mx-2"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        ">",
                    lengthMenu: [10, 20, 50, 70, 100], //for length of menu
                    language: {
                        sLengthMenu: "_MENU_",
                        search: "",
                        searchPlaceholder: "Search Page",
                    },
                    // Button for offcanvas
                    buttons: [],
                });

                $('.filter_dropdown').change(function() {
                    table.draw();
                });

                $(document).on('change', '.changeStatus', function() {
                    var checkbox = $(this);
                    var isChecked = checkbox.prop('checked');
                    var statusTextElem = checkbox.closest('.form-check').find('.statusText');
                    var statusText = isChecked ? 'Active' : 'Inactive';
                    var badgeClass = isChecked ? 'badge bg-label-success' : 'badge bg-label-danger';

                    statusTextElem.removeClass().addClass(badgeClass).text(statusText);

                    var formData = new FormData();
                    formData.append('id', checkbox.data('id'));
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        url: '{{ route('cms.pages.changeStatus') }}',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success(response.message);
                            }
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                });

            });
        </script>
    @endpush
