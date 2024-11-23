@extends('admin.layouts.master')

@section('title',$title ?? _trans('common.Dashboard'))

@section('content')

    {{-- @include('assets.admin.layouts.breadcrumb' , ['title' => @$title], ['breadcrumb'=>'dashboard']) --}}
    <!-- Website Analytics -->
    <div class="row mb-3">
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class='ti ti-truck ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{$totalOrder}}</h4>
                    </div>
                    <p class="mb-1">Delivered</p>

                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class='ti ti-alert-triangle ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{$processedOrder}}</h4>
                    </div>
                    <p class="mb-1">Processed Order</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-danger"><i class='ti ti-git-fork ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{$cancelOrder}}</h4>
                    </div>
                    <p class="mb-1">Canceled Order</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-info"><i
                                    class='ti ti-clock ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{$deliveredOrder}}</h4>
                    </div>
                    <p class="mb-1">Delivered Order</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xxl-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="badge p-2 bg-label-success mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
                    <h5 class="card-title mb-1">Total Sale</h5>
                    <p class="text-heading mb-3 mt-1">{{getPriceFormat($totalSale)}}</p>

                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="badge p-2 bg-label-primary mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
                    <h5 class="card-title mb-1">Total Sale</h5>
                    <p class="card-subtitle ">Last Month</p>
                    <p class="text-heading mb-3 mt-1">{{getPriceFormat($totalSaleCurrentMonth)}}</p>

                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
                    <h5 class="card-title mb-1">Total Sale</h5>
                    <p class="card-subtitle ">Current Year</p>
                    <p class="text-heading mb-3 mt-1">{{getPriceFormat($totalSaleCurrentYear)}}</p>

                </div>
            </div>
        </div>
    </div>
    <!--/ Website Analytics -->

@endsection
