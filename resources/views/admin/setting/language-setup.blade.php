@extends('layouts.master')

@section('title', $title ?? _trans('setting.Language').' '._trans('setting.Setup'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y" id="content-wrapper">
        {!! breadcrumb( _trans('setting.Language').' '._trans('setting.Setup'), ['#' => _trans('setting.Settings'), 'setting/language' => _trans('setting.Language'), _trans('setting.Setup')]) !!}

        <div class="app-ecommerce row">
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <select id="section-select" class="select2 form-select">
                            <option value="">{{_trans('system.Select File')}}</option>
                            @foreach ($data as $item)
                                <option value="{{ $item }}">{{ textCapitalize(str_replace('.php',' ',basename($item))) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card mb-4">
                    <form method="POST" action="{{route("setting.language.updateFile")}}">
                        @csrf
                        <input type="hidden" id="file-name" name="file-name">
                        <div class="row card-body justify-content-center align-items-center" id="dynamic-content">
                        </div>
                    </form>
                </div>
            </div>

            @endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#section-select').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue) {
                    $("#file-name").val(selectedValue);
                    $.ajax({
                        url: '{{ route('setting.language.readFile') }}',
                        type: 'GET',
                        data: { filePath: selectedValue },
                        success: function(response) {
                            if (response) {
                                addSection(response.content);
                            } else if (response.error) {
                                console.error(response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }else{
                    $('#dynamic-content').empty();
                }
            });
            function addSection(data) {
                $('#dynamic-content').empty();

                $.each(data, function(key, value) {
                    var inputHtml = `
                    <div class="col-6 mb-3 dynamic-fields">
                        <input type="text" class="form-control" name="keys[]" value="${key}" readonly />
                    </div>
                    <div class="col-6 mb-3 dynamic-fields">
                        <input type="text" class="form-control" name="values[]" value="${value}" />
                    </div>`;
                    $('#dynamic-content').append(inputHtml);
                });

                var buttonHtml = `
                <div class="d-flex justify-content-center mt-2 dynamic-fields">
                    <button class="btn btn-primary" id="">
                        <i class="ti-xs me-0"></i>Save
                    </button>
                </div>`;
                $('#dynamic-content').append(buttonHtml);
            }
        });
    </script>
@endpush
