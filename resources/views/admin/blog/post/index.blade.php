@extends('layouts.master')

@section('title', $title ?? _trans('blog.Blog') . ' ' . _trans('blog.Post'))

@section('content')


    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('blog.Blog') . ' ' . _trans('blog.Post'), [
            '#' => _trans('blog.Blog'),
            'post' => _trans('blog.Post'),
        ]) !!}
        <div class="app-ecommerce-category">
            <!-- Blog Post List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 "
                    style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{ _trans('common.Status') }}:</strong></label>
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
                                <th>{{ _trans('common.Thumbnail') }}</th>
                                <th>{{ _trans('common.Title') }}</th>
                                <th>{{ _trans('common.Description') }}</th>
                                <th>{{ _trans('common.Active Status') }}</th>
                                <th>{{ _trans('common.Publish Status') }}</th>
                                <th>{{ _trans('product.Tags') }}</th>
                                <th width="50px">{{ _trans('product.Author') }}</th>
                                <th width="100px">{{ _trans('common.Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Blog Post Details Modal -->
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content p-3 md-5">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="text-center mb-2">
                                <h3 class="role-title mb-2"id="detailsTitle"></h3>
                                <hr>
                            </div>

                            <div class="mb-3" id="bannerContainer">
                                <div id="bannerThumbnail"></div>
                            </div>
                            <div class="mb-3" id="videoContainer">
                                <iframe id="videoFrame" width="100%" height="315" frameborder="0"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="mb-3">
                                <p id="detailsTags"></p>
                            </div>
                            <div class="mb-3">
                                <div id="detailsDescription"></div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <p><strong>{{ _trans('product.Author') }}:</strong> <span id="authorName"></span></p>
                                <p><strong>{{ _trans('blog.Post') . ' ' . _trans('common.Time') }}:</strong> <span
                                        id="detailsPostTime"></span></p>
                            </div>
                            <hr>
                            <div class="mb-3" id="detailsContent">
                            </div>

                            <div class="col-12 text-center mt-2">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">{{ _trans('common.Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog Post Details Modal -->
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
                    url: '{{ route('blog.post.index') }}',
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
                        data: 'thumbnail',
                        name: 'thumbnail'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'desc',
                        name: 'desc',
                        render: function(data, type, row) {
                            if (data === null || data === '') {
                                return '<div style="width: 200px; white-space: normal; word-wrap: break-word;"> --- </div>';
                            } else {
                                const truncated = data.length > 100 ? data.substr(0, 100) + '...' :
                                    data;
                                return '<div style="width: 200px; white-space: normal; word-wrap: break-word;">' +
                                    truncated + '</div>';
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'publish_status',
                        name: 'publish_status'
                    },
                    {
                        data: 'tags',
                        name: 'tags'
                    },
                    {
                        data: 'author',
                        name: 'author'
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
                order: [0, "desc"], //set any columns order asc/desc
                dom: '<"card-header d-flex flex-wrap pb-2"' +
                    "<f>" +
                    '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"lB>>' +
                    ">t" +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",
                lengthMenu: [10, 20, 50, 70, 100], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search Post",
                },

                buttons: [
                    @if (hasPermission('blog_post_create'))
                        {
                            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Blog Post</span>',
                            className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                            action: function() {
                                window.location.href = '{{ route('blog.post.create') }}';
                            }
                        },
                    @endif

                ],
            });

            $(document).on("click", ".details-button", function() {
                var postId = $(this).data("id");

                $('#detailsTitle').text('');
                $('#authorName').text('');
                $('#detailsPostTime').text('');
                $('#detailsDescription').text('');
                $('#detailsTags').html('');
                $('#detailsVideoUrl').text('');
                $('#detailsBanner').html('');
                $('#bannerThumbnail').html('');
                $('#detailsContent').html('');
                $('#videoFrame').attr('src', '');
                $('#videoContainer').hide();
                $('#bannerContainer').hide();


                $.ajax({
                    url: '/blog/post/post-details/' + postId,
                    type: 'GET',
                    success: function(response) {

                        $('#detailsTitle').text(response.title);
                        $('#authorName').text(response.created_by);
                        $('#detailsPostTime').text(response.created_at);
                        $('#detailsDescription').text(response.desc);

                        var tags = [];
                        try {
                            tags = JSON.parse(response.tags);
                        } catch (e) {
                            console.error('Error parsing tags JSON:', e);
                            tags = [];
                        }

                        var badgesHtml = '';
                        if (Array.isArray(tags) && tags.length > 0) {
                            badgesHtml = tags.map(function(tag) {
                                return `<span class="badge bg-label-dark me-2">${tag.value}</span>`;
                            }).join('');
                        } else {
                            badgesHtml =
                                '<span class="badge bg-secondary">No tags available</span>';
                        }

                        $('#detailsTags').html(badgesHtml);

                        if (response.video_url) {
                            $('#videoFrame').attr('src', response.video_url);
                            $('#videoContainer').show();
                        }

                        $('#detailsBanner').html(response.banner);
                        console.log(response.banner);
                        if (response.banner && !response.banner.endsWith(
                                'img/placeholder/placeholder.png')) {
                            var bannerHtml =
                                `<img class="" style="width:100%; overflow:hidden;" src="${response.banner}" alt="banner" />`;
                            $('#bannerThumbnail').html(bannerHtml);
                            $('#bannerContainer').show();
                        }

                        $('#itemImageBanner').html('');
                        $('#itemDescription').html('');

                        response.content_details.sort((a, b) => a.serial - b.serial);

                        response.content_details.forEach(function(detail) {
                            if (detail.section_type === "banner_image") {
                                detail.items.forEach(function(item) {
                                    $('#detailsContent').append(
                                        `<div class="mb-3">
                                            <img class="" style="width:100%; overflow:hidden;" src="${item.image}" alt="banner" />
                                        </div>`
                                    );
                                });
                            } else if (detail.section_type === 'description') {
                                detail.items.forEach(function(item) {
                                    $('#detailsContent').append(
                                        `<div class="mb-3">
                                            <p>${item.description}</p>
                                        </div>`
                                    );
                                });
                            }
                        });

                        $('#detailsModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching blog post details:', error);
                        toastr.error(
                            'Failed to fetch blog post details. Please try again later.');
                    }
                });
            });


            $('.filter_dropdown').change(function() {
                table.draw();
            });

            $(document).on("click", ".category_edit_button", function() {

                $id = $(this).attr("data-id");
                $('#edit_status').find('option:selected').attr("selected", false);
                $('#edit_status').trigger('change');
                $.ajax({
                    url: '/blog/category/' + $id,
                    type: 'GET',
                    success: function(response) {
                        $('#special_sections_category_id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $("#edit_status").find('option').removeAttr("selected");
                        $('#edit_status').trigger('change.select2');
                        $('#edit_status').find('option[value="' + response.data.is_active +
                            '"]').attr("selected", "selected");

                        $('#edit_status').trigger('change');
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $(document).on("click", ".category_delete_button", function() {

                let id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        $.ajax({
                            url: '{{ route('blog.category.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
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
                    url: '{{ route('blog.post.changeStatus') }}',
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

            $(document).on("click", ".delete-post", function() {
                let id = $(this).data("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('blog.post.delete') }}',
                            method: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function(response) {
                                table.ajax.reload(null, false);
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
                                toastr.error(error.responseJSON.message);
                            }
                        });
                    }
                });
            });

            function extractYouTubeVideoId(url) {
                var regex =
                    /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
                var match = url.match(regex);
                return match ? match[1] : null;
            }

            $(document).on('change', '.changePublishStatus', function () {
                const postId = $(this).data('id');
                const formData = new FormData();
                formData.append('id', postId);
                formData.append('_token', "{{ csrf_token() }}");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "To publish the post.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Change it',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('blog.post.changePublishStatus') }}',
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    table.ajax.reload(null, false);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function (error) {
                                console.error(error);
                            }
                        });
                    } else {
                        table.ajax.reload(null, false);
                    }

                });
            })


        });
    </script>
@endpush
