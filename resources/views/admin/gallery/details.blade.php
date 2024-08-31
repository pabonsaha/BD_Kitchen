@extends('layouts.master')

@section('title', $title ?? _trans('gallery.Gallery').' '._trans('common.Details'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y pb-1" id="content-wrapper">
        <form method="post" action="{{ route('gallery.details.store') }}" enctype="multipart/form-data">
            @csrf
            {!! breadcrumb('Gallery Images',['gallery/list'=>'Gallery','gallery'=>'Gallery Images']) !!}
            <input type="text" name="gallery_id" hidden value="{{ $gallery->id }}">
            <div id="galley_container">
                @foreach ($gallery->details as $detail)
                    <div class="card mb-2 section">
                        <input type="text" name="data[{{$loop->iteration-1}}][id]" value="{{ $detail->id }}" hidden>

                        <div class="row card-body justify-content-center align-items-center">
                            <div class="col-12 border-end">

                                <div class="row position-relative  mt-2" style="height: 150px">
                                    <div class="col-5 border-end">
                                        <label for="">{{_trans('common.Title')}}</label>
                                        <input class="form-control mb-4" value="{{$detail->title}}" name='data[{{$loop->iteration-1}}][title]' id="" />
                                        <label for="">{{_trans('common.Details')}}</label>
                                        <input class="form-control" value="{{$detail->details}}" name='data[{{$loop->iteration-1}}][description]' id="" />
                                    </div>
                                    <div class="col-2 border-end d-flex justify-content-center align-items-center position-relative"
                                        style="height: 100%">
                                        <div
                                            class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                            <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                            <span style="font-size:1rem !important">{{_trans('pages.Input image')}}</span>
                                        </div>
                                        <input
                                            class="opacity-0 position-absolute top-50 start-50 translate-middle p-3"
                                            type="file" name="data[{{$loop->iteration-1}}][image]" onchange="loadFile(event)" />
                                    </div>
                                    <div class="col-5" style="height: 100%">
                                        <img id='preview_img' class=" preview_img"
                                            src="{{ getFilePath($detail->image) }}"
                                            style="height: 100%; max-Width:100%" alt="Current profile photo" />
                                    </div>

                                </div>

                            </div>

                        </div>
                        <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i
                                class="ti ti-trash"></i></button>
                    </div>
                @endforeach


            </div>


            @if(hasPermission('create_image'))
                <div class="row justify-content-end mb-2">
                    <div class="col-2">
                        <button type="button" id="add_image" class="btn btn-primary w-100"><i
                                class="ti ti-plus ti-xs me-0 me-sm-2"></i>{{_trans('gallery.Add Image')}}</button>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-3">
                        <button type="submit" id="save" class="btn btn-primary w-100">{{_trans('common.Save')}}</button>
                    </div>
                </div>
            @endif


        </form>




    </div>

@endsection


@push('scripts')
    <script>
        let count = {{count($gallery->details)}};
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

        $('#add_image').on('click', function() {
            let s =
                `
            <div class="card mb-2 section" >


                <div class="row card-body justify-content-center align-items-center">
                    <div class="col-12 border-end">

                        <div class="row position-relative mt-2" style="height: 150px">
                            <div class="col-5 border-end">
                                <label for="">Title</label>
                                <input class="form-control mb-4" value="" name='data[${count}][title]' id="" />
                                <label for="">Details</label>
                                <input class="form-control" value="" name='data[${count}][description]' id="" />
                            </div>
                            <div class="col-2 border-end d-flex justify-content-center align-items-center position-relative"
                                style="height: 100%">
                                <div
                                    class="branner_input_placeholder position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center">
                                    <i class="ti ti-plus ti-xs" style="font-size:2rem !important"></i>
                                    <span style="font-size:1rem !important">Input image</span>
                                </div>
                                <input name='data[${count}][image]'
                                    class="opacity-0 position-absolute top-50 start-50 translate-middle p-3" type="file"
                                    onchange="loadFile(event)" />
                                <input type="text" name="id" value="" hidden>
                            </div>
                            <div class="col-5" style="height: 100%">
                                <img id='preview_img' class=" preview_img" src="{{ asset('assets/img/backgrounds/5.jpg') }}"
                                    style="height: 100%; max-Width:100%" alt="Current profile photo" />
                            </div>

                        </div>

                    </div>

                </div>
                <button type="button" class="btn text-danger position-absolute deleteSection" style="right: 0%"><i
                        class="ti ti-trash"></i></button>
            </div>
            `;

            $('#galley_container').append(s);
            count++;
        });
    </script>
@endpush
