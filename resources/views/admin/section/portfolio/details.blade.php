@extends('layouts.master')

@section('title', $title ?? _trans('portfolio.Portfolio').' '._trans('portfolio.Details'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y" id="content-wrapper">
        {!! breadcrumb(_trans('portfolio.Portfolio').' '._trans('portfolio.Details'),['section/portfolioAndInspiration/1/index'=>_trans('portfolio.Portfolio').' & '._trans('portfolio.Inspiration'),'portfolio'=>_trans('portfolio.Portfolio').' '._trans('portfolio.Details')]) !!}

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{_trans('portfolio.Select Section For Portfolio Details')}}</h5>
            </div>
            <div class="row card-body justify-content-center align-items-center">
                <div class="col-8 ecommerce-select2-dropdown">
                    <select id="design_input" class="select2 form-select" data-placeholder="Select Section">
                        <option value="">{{_trans('common.Select').' '._trans('common.Section')}}</option>
                        <option value="description">{{_trans('common.Description')}}</option>
                        <option value="image_gallary">Images Gallary</option>
                        <option value="image_gallary_with_details">{{_trans('potfolio.Gallery With Details')}}</option>
                        <option value="banner_image">{{_trans('potfolio.Landscape Banner')}}</option>
                    </select>
                </div>

                @if(hasPermission('add_portfolio_section'))
                    <div class="col-4">
                        <button class="btn btn-primary" id="add_section"> <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>{{_trans('common.Add').' '._trans('common.Section')}}
                            </button>
                    </div>
                @endif
            </div>
        </div>


        @foreach ($section->details as $detail)
            @if ($detail->section_type == 'image_gallary_with_details')
                <div class="card mb-4 section" data-id="image_gallary_with_details">
                    <div class="card-header d-flex flex-row justify-content-start align-items-center">
                        <h5 class="card-title mb-0">{{_trans('portfolio.Image Gallery With Details')}}</h5>
                        <input type="text" value="{{ $detail->id }}" hidden>

                        <button type="button" class="btn btn-primary ms-2 image_gallary_with_description_add_button"><i
                                class="ti ti-plus ti-xs"></i></button>

                    </div>
                    <div class="row card-body justify-content-center align-items-center">
                        <div class="col-9 border-end gallaryImageWithDetailsContainer">
                            @foreach ($detail->items as $item)
                                <div class="row position-relative gallaryImageWithDetailsCard mt-2 border-bottom"
                                    style="height: 150px">
                                    <div class="col-6 border-end">
                                        <label for="">{{_trans('common.Title')}}</label>
                                        <input class="form-control mb-4" value="{{ $item->title }}" name='title'
                                            id="" />
                                        <label for="">{{_trans('common.Descripiton').' / '._trans('common.Amount')}}</label>
                                        <input class="form-control" value="{{ $item->description }}" name='description'
                                            id="" />
                                    </div>
                                    <div class="col-3 border-end d-flex justify-content-center align-items-center position-relative"
                                        style="height: 100%">
                                        <div
                                            class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                            <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                            <span style="font-size:1rem !important">{{_trans('common.Input').' '. _trans('common.Image')}}</span>
                                        </div>
                                        <input name='image'
                                            class="opacity-0 position-absolute top-50 start-50 translate-middle p-3"
                                            type="file" onchange="loadFile(event)" />
                                        <input type="text" name="id" value="{{ $item->id }}" hidden>
                                    </div>
                                    <div class="col-3" style="height: 100%">
                                        <img id='preview_img' class=" preview_img" style="height: 100%; max-Width:100%"
                                            src="{{ getFilePath($item->image) }}" alt="Current profile photo" />
                                    </div>
                                    <button type="button" class="btn text-danger position-absolute deleteSection"
                                        style="right: 0%; width:50px;"><i class="ti ti-trash"></i></button>


                                </div>
                            @endforeach
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i
                            class="ti ti-trash"></i></button>
                </div>
            @endif
            @if ($detail->section_type == 'description')
                @foreach ($detail->items as $item)
                    <div class="card mb-4 section" data-id="description">
                        <input type="text" value="{{ $detail->id }}" hidden>
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{_trans('common.Description')}}</h5>
                        </div>
                        <div class="row card-body justify-content-center align-items-center">
                            <div>
                                <label class="form-label">{{_trans('common.Description')}}</label>
                                <div class="form-control p-0 pt-1">
                                    <div class="toolbar border-0 border-bottom">
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
                                    <div class="editor border-0 pb-4 editor" id="description">
                                        {!! $item->description !!}
                                    </div>
                                </div>
                                <span class="text-danger descriptionError error"></span>
                            </div>
                        </div>
                        <button type="button" class="btn text-danger position-absolute deleteSection"
                            style="right: 0%"><i class="ti ti-trash"></i></button>
                    </div>
                @endforeach
            @endif
            @if ($detail->section_type == 'image_gallary')
                <div class="card mb-4 section" data-id="image_gallary">
                    <div class="card-header d-flex flex-row justify-content-start align-items-center">
                        <h5 class="card-title mb-0">{{_trans('portfolio.Image Gallary')}}</h5>
                        <input type="text" value="{{ $detail->id }}" hidden>

                        <button type="button" class="btn btn-primary ms-2 image_gallary_add_button"><i
                                class="ti ti-plus ti-xs"></i></button>

                    </div>
                    <div class="row card-body justify-content-center align-items-center">
                        <div class="col-8 border-end gallaryImageContainer">
                            @foreach ($detail->items as $item)
                                <div class="row  position-relative mb-2 border-bottom p-1 card" style="height: 150px">
                                    <div class="col-6 border-end d-flex justify-content-center align-items-center position-relative"
                                        style="height: 100%">

                                        <div
                                            class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                            <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                            <span style="font-size:1rem !important">{{_trans('common.Input').' '. _trans('common.Image')}}</span>
                                        </div>
                                        <input name="image_gallary[${count}]"
                                            class="opacity-0 position-absolute top-50 start-50 translate-middle p-5"
                                            type="file" onchange="loadFile(event)" />
                                    </div>
                                    <div class="col-6" style="height: 100%">
                                        <img id='preview_img' class="ms-2 preview_img"
                                            style="height: 100%; max-Width:100%" src="{{ getFilePath($item->image) }}"
                                            alt="Current profile photo" />
                                        <input type="text" value="{{ $item->id }}" hidden>
                                    </div>
                                    <button type="button" class="btn text-danger position-absolute deleteSection"
                                        style="right: 0%;width:50px;"><i class="ti ti-trash"></i></button>
                                </div>
                            @endforeach

                        </div>
                        <div class="col-4">

                        </div>

                    </div>
                    <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i
                            class="ti ti-trash"></i></button>

                </div>
            @endif
            @if ($detail->section_type == 'banner_image')
                @foreach ($detail->items as $item)
                    <div class="card mb-4 section" data-id="banner_image">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Landscape Banner</h5>
                            <input type="text" value="{{ $detail->id }}" hidden>
                        </div>
                        <div class="row card-body justify-content-center align-items-center" style="height: 200px">
                            <div class="col-6 border-end d-flex justify-content-center align-items-center position-relative"
                                style="height: 100%">
                                <div
                                    class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                    <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                    <span style="font-size:1rem !important">{{_trans('common.Input').' '. _trans('common.Image')}}</span>
                                </div>
                                <input name="banner[${count}]"
                                    class="opacity-0 position-absolute top-50 start-50 translate-middle p-5"
                                    type="file" onchange="loadFile(event)" />
                            </div>
                            <div class="col-6" style="height: 100%">
                                <img id='preview_img' class="ms-2 preview_img" style="height: 100%; max-Width:100%"
                                    src="{{ getFilePath($item->image) }}" alt="Current profile photo" />
                            </div>
                        </div>
                        <button type="button" class="btn text-danger position-absolute deleteSection"
                            style="right: 0%"><i class="ti ti-trash"></i></button>
                    </div>
                @endforeach
            @endif
        @endforeach



    </div>

    @if(hasPermission('add_portfolio_section'))
        <div class="row justify-content-center">
            <div class="col-3">
                <button type="button" id="save" class="btn btn-primary w-100">{{_trans('common.Save')}}</button>
            </div>
        </div>
    @endif
@endsection


@push('scripts')
    <script>
        let count = 0;

        $('#add_section').on('click', function() {
            let value = $('#design_input').val();
            let s = '';
            if (value == 'description') {
                s = descriptionHTML();
                $('#content-wrapper').append(s);

                const editor = document.querySelector(`.editor${count}`);
                console.log(editor, 'this is editor');

                if (editor) {
                    new Quill(editor, {
                        modules: {
                            toolbar: `.toolbar${count}`
                        },
                        placeholder: 'Description',
                        theme: 'snow'
                    });
                }

            } else if (value == 'banner_image') {
                s = bannerHTML();
                $('#content-wrapper').append(s);
            } else if (value == 'image_gallary') {
                s = imageGallaryHTML();
                $('#content-wrapper').append(s);
            } else if (value == 'image_gallary_with_details') {
                s = imageWithDetailsHTML();
                $('#content-wrapper').append(s);
            }

            count++;

        });

        $(document).on("click", ".image_gallary_add_button", function() {
            console.log($(this).parent().siblings('div').eq(0));
            $(this).parent().siblings('div').eq(0).children('.gallaryImageContainer').append(
                imageGallaryImageContainerDesignHTML());
        });
        $(document).on("click", ".image_gallary_with_description_add_button", function() {
            console.log($(this).parent().siblings('div').eq(0));
            $(this).parent().siblings('div').eq(0).children('.gallaryImageWithDetailsContainer').append(
                imageGallaryWithDetailsContainerDesignHTML());
        });




        function descriptionHTML() {
            return `<div class="card mb-4 section" data-id="description">
            <div class="card-header">
                <h5 class="card-title mb-0">Description</h5>
            </div>
            <div class="row card-body justify-content-center align-items-center">
                <div>
                    <label class="form-label">Description</label>
                    <div class="form-control p-0 pt-1">
                        <div class="toolbar${count} border-0 border-bottom">
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
                        <div class="editor${count} border-0 pb-4 editor" id="description"></div>
                    </div>
                    <span class="text-danger descriptionError error"></span>
                </div>
            </div>
            <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i class="ti ti-trash"></i></button>
        </div>`;
        }

        function bannerHTML() {
            return `<div class="card mb-4 section" data-id="banner_image">
            <div class="card-header">
                <h5 class="card-title mb-0">Landscape Banner</h5>
                <input type="text" value="" hidden>
            </div>
            <div class="row card-body justify-content-center align-items-center" style="height: 200px">
                <div class="col-6 border-end d-flex justify-content-center align-items-center position-relative" style="height: 100%">
                    <div class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                        <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                        <span style="font-size:1rem !important">Input image</span>
                    </div>
                    <input name="banner[${count}]" class="opacity-0 position-absolute top-50 start-50 translate-middle p-5" type="file" onchange="loadFile(event)" />
                </div>
                <div class="col-6" style="height: 100%">
                    <img id='preview_img' class="ms-2 preview_img" style="height: 100%; max-Width:100%"
                        src="{{ asset('assets/img/backgrounds/5.jpg') }}"
                        alt="Current profile photo" />
                </div>
            </div>
            <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i class="ti ti-trash"></i></button>
        </div>`;
        }

        function imageGallaryHTML() {
            return `<div class="card mb-4 section" data-id="image_gallary">
            <div class="card-header d-flex flex-row justify-content-start align-items-center">
                <h5 class="card-title mb-0">Image Gallary</h5>
                <input type="text" value="" hidden>
                <button type="button" class="btn btn-primary ms-2 image_gallary_add_button"><i class="ti ti-plus ti-xs"></i></button>

            </div>
            <div class="row card-body justify-content-center align-items-center">
                <div class="col-8 border-end gallaryImageContainer">
                    <div class="row  position-relative card" style="height: 150px">
                        <div class="col-6 border-end d-flex justify-content-center align-items-center position-relative"
                            style="height: 100%">
                            <div
                                class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                <span style="font-size:1rem !important">Input image</span>
                            </div>
                            <input name="image_gallary[${count}]"
                                class="opacity-0 position-absolute top-50 start-50 translate-middle p-5" type="file"
                                onchange="loadFile(event)" />
                        </div>
                        <div class="col-6" style="height: 100%">
                            <img id='preview_img' class="ms-2 preview_img" style="height: 100%; max-Width:100%"
                                src="{{ asset('assets/img/backgrounds/5.jpg') }}" alt="Current profile photo" />
                        </div>
                        <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%;width:50px;"><i class="ti ti-trash"></i></button>
                    </div>

                </div>
                <div class="col-4">

                </div>

            </div>
            <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i class="ti ti-trash"></i></button>

        </div>`;
        }

        function imageGallaryImageContainerDesignHTML() {
            return `<div class="row mt-2  position-relative card" style="height: 150px">
                        <div class="col-6 border-end d-flex justify-content-center align-items-center position-relative"
                            style="height: 100%">
                            <div
                                class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                <span  style="font-size:1rem !important">Input image</span>
                            </div>
                            <input name="image_gallary[${count}]"
                                class="opacity-0 position-absolute top-50 start-50 translate-middle p-5" type="file"
                                onchange="loadFile(event)" />
                        </div>
                        <div class="col-6" style="height: 100%">
                            <img id='preview_img' class="ms-2 preview_img" style="height: 100%; max-Width:100%"
                                src="{{ asset('assets/img/backgrounds/5.jpg') }}" alt="Current profile photo" />
                        </div>

                        <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%;width:50px;"><i class="ti ti-trash"></i></button>

                    </div>`;
        }

        function imageWithDetailsHTML() {
            return `<div class="card mb-4 section" data-id="image_gallary_with_details">
                <div class="card-header d-flex flex-row justify-content-start align-items-center">
                    <h5 class="card-title mb-0">Image Gallary With Details</h5>
                    <input type="text" name="id" value="" hidden>

                    <button type="button" class="btn btn-primary ms-2 image_gallary_with_description_add_button"><i
                            class="ti ti-plus ti-xs"></i></button>

                </div>
                <div class="row card-body justify-content-center align-items-center">
                    <div class="col-9 border-end gallaryImageWithDetailsContainer">
                        <div class="row position-relative gallaryImageWithDetailsCard" style="height: 150px">
                            <div class="col-6 border-end">
                                <label for="">Title</label>
                                <input class="form-control mb-4" name='title' id=""/>
                                <label for="">Descripiton/Amount</label>
                                <input class="form-control" name='description' id=""/>
                            </div>
                            <div class="col-3 border-end d-flex justify-content-center align-items-center position-relative"
                                style="height: 100%">
                                <div
                                    class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                    <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                    <span  style="font-size:1rem !important">Input image</span>
                                </div>
                                <input name='image'
                                    class="opacity-0 position-absolute top-50 start-50 translate-middle p-3" type="file"
                                    onchange="loadFile(event)" />
                                    <input type="text" name="id" value="" hidden>

                            </div>
                            <div class="col-3" style="height: 100%">
                                <img id='preview_img' class=" preview_img" style="height: 100%; max-Width:100%"
                                    src="{{ asset('assets/img/backgrounds/5.jpg') }}" alt="Current profile photo" />
                            </div>
                            <button type="button" class="btn text-danger position-absolute deleteSection"  style="right: 0%; width:50px;"><i class="ti ti-trash"></i></button>


                        </div>
                    </div>
                    <div class="col-3">
                    </div>
                </div>
                <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i class="ti ti-trash"></i></button>
            </div>`;
        }

        function imageGallaryWithDetailsContainerDesignHTML() {
            return `<div class="row mt-2 border-top position-relative gallaryImageWithDetailsCard" style="height: 150px">
                            <div class="col-6 border-end">
                                <label for="">Title</label>
                                <input class="form-control mb-4"  name='title' id=""/>
                                <label for="">Descripiton/Amount</label>
                                <input class="form-control"  name='description'  id=""/>
                            </div>
                            <div class="col-3 border-end d-flex justify-content-center align-items-center position-relative"
                                style="height: 100%">
                                <div
                                    class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                    <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                    <span style="font-size:1rem !important">Input image</span>
                                </div>
                                <input
                                    class="opacity-0 position-absolute top-50 start-50 translate-middle p-3" name='image' type="file"
                                    onchange="loadFile(event)" />
                                    <input type="text" name="id" value="" hidden>
                            </div>
                            <div class="col-3" style="height: 100%">
                                <img id='preview_img' class=" preview_img" style="height: 100%; max-Width:100%"
                                    src="{{ asset('assets/img/backgrounds/5.jpg') }}" alt="Current profile photo" />
                            </div>
                            <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%;width:50px;"><i class="ti ti-trash"></i></button>
                        </div>`;
        }



        $(document).on("click", ".deleteSection", function() {

            let button = $(this);
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

                    Swal.fire({
                        icon: 'error',
                        title: 'Deleted!',
                        text: 'Section Removed',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect waves-light'
                        }
                    });
                    console.log($(this));
                    $(button).parent().remove();
                }
            });
        });

        var loadFile = function(event) {

            var input = event.target;
            var file = input.files[0];
            var type = file.type;

            console.log(event.currentTarget.parentNode.nextElementSibling.children[0]);

            var output = event.currentTarget.parentNode.nextElementSibling.children[0];


            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $('#save').on('click', function() {

            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");

            $('.section').each(function(index, section) {
                let sectionName = $(section).data('id');
                if (sectionName == 'description') {
                    let description = $($(section).find('.editor')[0]).children().first().html();
                    let sectionID = $($(section).find('input')[0]).val() ?? null;
                    formData.append(`section[${index}][id]`, sectionID);

                    formData.append(`section[${index}][name]`, 'description');
                    formData.append(`section[${index}][description]`, description);
                } else if (sectionName == 'banner_image') {
                    let sectionID = $($(section).find('input')[0]).val() ?? null;
                    formData.append(`section[${index}][id]`, sectionID);
                    let image = $($(section).find('input')[1]).prop('files')[0] ?? '';
                    formData.append(`section[${index}][name]`, 'banner_image');
                    formData.append(`section[${index}][image]`, image);
                } else if (sectionName == 'image_gallary') {
                    let cards = $(section).find('.card');
                    let sectionID = $($(section).find('input')[0]).val() ?? null;
                    console.log(sectionID);
                    formData.append(`section[${index}][sectionID]`, sectionID);
                    formData.append(`section[${index}][name]`, 'image_gallary');
                    cards.each(function(key, card) {
                        let data = $(card).find('input');
                        let image = $(data[0]).prop('files')[0] ?? '';
                        formData.append(`section[${index}][image][${key}]`, image);
                        formData.append(`section[${index}][id][${key}]`, $(data[1]).val() ?? null);
                    });
                } else if (sectionName == 'image_gallary_with_details') {

                    formData.append(`section[${index}][name]`, 'image_gallary_with_details');
                    formData.append(`section[${index}][id]`, $($(section).find('input')[0]).val());
                    let cards = $(section).find('.gallaryImageWithDetailsCard');

                    cards.each(function(cardKey, card) {
                        let inputs = $(card).find('input');
                        inputs.each(function(key, input) {

                            var name = $(input).attr('name');
                            console.log(name);
                            if (name == 'title') {
                                formData.append(
                                    `section[${index}][cards][${cardKey}][title]`, $(
                                        input).val());
                            }
                            if (name == 'description') {
                                formData.append(
                                    `section[${index}][cards][${cardKey}][description]`,
                                    $(
                                        input).val());
                            }
                            if (name == 'image') {
                                formData.append(
                                    `section[${index}][cards][${cardKey}][image]`,
                                    $(
                                        input).prop('files')[0] ?? '');
                            }
                            if (name == 'id') {
                                formData.append(
                                    `section[${index}][cards][${cardKey}][id]`,
                                    $(
                                        input).val() ?? null);
                            }

                        });

                    });
                }
            });

            $.ajax({
                url: '{{ route('section.portfolioAndInspiration.details.store', $section->id) }}',
                type: 'POST',
                data: formData,
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    window.location.href = "{{ route('section.portfolioAndInspiration.index', 1) }}";
                },
                error: function(error) {}
            });

        });

        function initQuill() {
            let toolsBars = document.querySelectorAll('.toolbar');
            let editor = document.querySelectorAll('.editor');
            editor.forEach(function(value, index) {
                const editorElement = value;
                const toolbarElement = toolsBars[index];
                console.log(value, 'this is editor');

                if (editorElement) {
                    new Quill(editorElement, {
                        modules: {
                            toolbar: toolbarElement,
                        },
                        placeholder: 'Description',
                        theme: 'snow'
                    });
                }

            });

            console.log(toolsBars);
            console.log(editor);
        }
        initQuill();
    </script>
@endpush
