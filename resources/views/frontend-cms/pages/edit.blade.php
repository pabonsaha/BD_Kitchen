@extends('layouts.master')

@section('title', $title ?? 'Edit ' . $data->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('common.Edit').' '._trans('pages.Page'), ['#' => 'Frontend CMS', '/cms/pages' => 'Pages', _trans('common.Edit').' '._trans('pages.Page')]) !!}
        <div class="app-ecommerce">
            <form method="post" id="pageUpdateForm">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">{{_trans('common.Update')}} {{ $data->title }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">{{_trans('pages.Page').' '._trans('common.Title')}}</label>
                                    <input required type="text" class="form-control" value="{{ $data->title }}"
                                        name="title" id="title" aria-label="Page title" placeholder="page title" />
                                    <input id="page_id" hidden type="text" value="{{ $data->id }}">
                                    <span class="text-danger titleError error"></span>
                                </div>

                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="category-org">
                                        <span> {{_trans('frontendCMS.Footer').' '._trans('frontendCMS.Widget')}}</span>
                                    </label>
                                    <select id="footer_widget" name="footer_widget" class="select2 form-select"
                                        data-placeholder="Select Category">
                                        @foreach ($footer_widget as $widget)
                                            <option value="{{ $widget->id }}"
                                                {{ $data->footer_widget_id == $widget->id ? 'selected' : '' }}>
                                                {{ $widget->title }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                {{-- Short Description --}}
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label">{{_trans('common.Short Description')}}</label>
                                        <textarea required id="short_desc" class="form-control" placeholder="short description" name="short_description"
                                            cols="30" rows="5">{{ $data->short_desc }}</textarea>
                                        <span class="text-danger shortDescError error"></span>
                                    </div>
                                </div>

                                <!-- Page Content -->
                                <div class="mb-4">
                                    <label class="form-label">{{_trans('frontendCMS.Content')}}</label>
                                    <div class="form-control p-0 pt-1">
                                        <div class="comment-toolbar border-0 border-bottom">
                                            <div class="d-flex justify-content-start">
                                                <span class="ql-formats">
                                                    <select class="ql-font"></select>
                                                    <select class="ql-size"></select>
                                                </span>
                                                <span class="ql-formats me-0">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-italic"></button>
                                                    <button class="ql-underline"></button>

                                                    <button class="ql-strike"></button>
                                                    <button class="ql-list" value="ordered"></button>
                                                    <button class="ql-list" value="bullet"></button>
                                                    <button class="ql-link"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <select class="ql-color"></select>
                                                    <select class="ql-background"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-script" value="sub"></button>
                                                    <button class="ql-script" value="super"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-header" value="1"></button>
                                                    <button class="ql-header" value="2"></button>
                                                    <button class="ql-blockquote"></button>
                                                    <button class="ql-code-block"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="product-editor border-0 pb-4" id="content">{!! $data->content !!}
                                        </div>
                                    </div>
                                    <span class="text-danger descriptionError error"></span>
                                </div>


                                @if ($data->slug === 'team')
                                    @include('frontend-cms.pages.team')
                                @endif

                                @if ($data->slug === 'about-us')
                                    @include('frontend-cms.pages.about-us')
                                @endif




                                <!-- Status -->
                                <div class="mb-4 ecommerce-select2-dropdown">
                                    <label class="form-label">{{_trans('common.Select').' '._trans('common.Status')}}</label>
                                    <select id="status" name="status" class="select2 form-select"
                                        data-placeholder="Select status">
                                        <option value="1" {{ $data->active_status == 1 ? 'selected' : '' }}>{{_trans('common.Active')}}
                                        </option>
                                        <option value="0" {{ $data->active_status == 0 ? 'selected' : '' }}>{{_trans('common.Deactive')}}
                                        </option>
                                    </select>
                                    <span class="text-danger statusError error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <button type="button" id="pageUpdateButton" class="btn btn-primary col-4">{{_trans('common.Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#pageUpdateButton').click(function(e) {
                e.preventDefault();

                var formData = new FormData();

                let page_id = $('#page_id').val();
                let title = $("input[name=title]").val();
                let footer_widget = $("#footer_widget option:selected").val();
                let status = $("#status option:selected").val();

                let short_desc = $("textarea[name=short_description]").val();
                let content = $("#content").children().first().html();

                formData.append('title', title);
                formData.append('footer_widget', footer_widget);
                formData.append('id', page_id);
                formData.append('short_desc', short_desc);
                formData.append('content_data', content);
                formData.append('status', status);
                formData.append('_token', "{{ csrf_token() }}");

                let cards = $('#gallaryImageWithDetailsContainer').find('.gallaryImageWithDetailsCard');

                cards.each(function(index, card) {
                    let inputs = $(card).find('input');
                    inputs.each(function(key, input) {

                        var name = $(input).attr('name');
                        console.log(name);
                        if (name == 'title') {
                            formData.append(
                                `sectionItems[${index}][title]`, $(
                                    input).val());
                        }
                        if (name == 'description') {
                            formData.append(
                                `sectionItems[${index}][description]`,
                                $(
                                    input).val());
                        }
                        if (name == 'image') {
                            formData.append(
                                `sectionItems[${index}][image]`,
                                $(
                                    input).prop('files')[0] ?? '');
                        }
                        if (name == 'id') {
                            formData.append(
                                `sectionItems[${index}][id]`,
                                $(
                                    input).val() ?? null);
                        }

                    });

                });


                $('.error').text('')
                $.ajax({
                    url: '{{ route('cms.pages.update') }}',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.titleError').text(response.errors?.title ? response.errors
                                .title[0] : '');
                            $('.shortDescError').text(response.errors?.short_desc ? response
                                .errors.short_desc[0] : '');
                        } else if (response.status === 200) {
                            toastr.success(response.message);
                            $('#closeUpdateModal').click();
                            table.ajax.reload(null, false);
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
