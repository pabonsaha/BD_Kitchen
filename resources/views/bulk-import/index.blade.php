@extends('layouts.master')

@section('title', $title ?? _trans('product.Bulk') .' '._trans('product.Import'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb('Bulk Import',['#'=>_trans('product.Product').' '._trans('product.Management'),'bulk-import'=>_trans('product.Bulk') .' '._trans('product.Import')]) !!}

        <div class="card mb-3">
            <div class="card-header">
                <h5>{{_trans('product.Product Bulk Upload')}}</h5>
            </div>
            <div class="card-body">
                <h6 class="text-primary">{{_trans('product.Step:1')}}</h6>
                <ol>
                    <li>{{_trans('product.Download the skeleton file and fill it with proper data.')}}</li>
                    <li>{{_trans('product.You can download the example file to understand how the data must be filled.')}}</li>
                    <li>{{_trans('product.Once you have downloaded and filled the skeleton file, upload it in the form below and submit.')}}</li>
                    <li>{{_trans("product.After uploading products you need to edit them and set product's images and choices.")}}</li>
                </ol>
                <a href="{{ route('bulkImport.productExport') }}" class="btn btn-primary">{{_trans('product.Download Demo CSV')}}</a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="text-primary">{{_trans('product.Step:2')}}</h6>
                <ol>
                    <li>{{_trans('product.Category and Brand should be in numerical id.')}}</li>
                    <li>{{_trans('product.You can download the pdf to get Category and Brand id.')}}</li>
                </ol>
                <a href="{{ route('bulkImport.categoryExport') }}" class="btn btn-primary">{{_trans('product.Download Category')}}</a>
                <a href="{{ route('bulkImport.brandExport') }}" class="btn btn-primary">{{_trans('product.Download Brand')}}</a>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('bulkImport.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h6 class="text-primary">{{_trans('product.Upload Product List File')}}</h6>
                    <h6 class="text-primary">{{_trans('common.Note')}}:</h6>
                    <ol>
                        <li>{{_trans("product.'discount_type' is takes 0, 1 or 2. 1 refer to percentage and 2 refer to fixed. Other wise keep value 0.")}}</li>
                        <li>{{_trans("product.'discount' field take absulate numerical value.")}}</li>
                        <li>{{_trans("product.'is_published' field takes 1 or 0. For published keep 1 and for unpublished 0.")}}</li>
                        <li>{{_trans("product.'tag' field takes coma separate value. examaple format: tag1,tag2,tag3.")}}</li>
                    </ol>
                    <div class="col-8 mb-2">
                        <input type="file" class="form-control" name="productListFile">
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>{{_trans('product.Whoops!')}}</strong> {{_trans('product.There were some problems with your input.')}}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button class="btn btn-primary" type="submit">{{_trans('common.Upload')}}</button>
                </form>
            </div>
        </div>


    </div>


@endsection
