@extends('admin.index')

@section('title', 'Dashboard')

@section('content')
    <div class="content mb-3">
        <div class="container-fluid">
            <h5 class="pt-3 pb-2">
                Bảng điều khiển
            </h5>
            <div class="row mb-2 text-sm">
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="my-info-box info-box" href="{{ route('admin.setting') }}" title="Cấu hình website">
                        <span class="my-info-box-icon info-box-icon bg-primary"><i class="fas fa-cogs"></i></span>
                        <div class="info-box-content text-dark">
                            <span class="info-box-text text-capitalize">Cấu hình website</span>
                            <span class="info-box-number">Xem thêm</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="my-info-box info-box" href="{{ route('login_info') }}" title="Tài khoản">
                        <span class="my-info-box-icon info-box-icon bg-danger"><i class="fas fa-user-cog"></i></span>
                        <div class="info-box-content text-dark">
                            <span class="info-box-text text-capitalize">Tài khoản</span>
                            <span class="info-box-number">Xem thêm</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="my-info-box info-box" href="{{ route('admin.password.request') }}" title="Đổi mật khẩu">
                        <span class="my-info-box-icon info-box-icon bg-success"><i class="fas fa-key"></i></span>
                        <div class="info-box-content text-dark">
                            <span class="info-box-text text-capitalize">Đổi mật khẩu</span>
                            <span class="info-box-number">Xem thêm</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="my-info-box info-box" href="{{ route('admin.contact') }}" title="Thư liên hệ">
                        <span class="my-info-box-icon info-box-icon bg-info"><i class="fas fa-address-book"></i></span>
                        <div class="info-box-content text-dark">
                            <span class="info-box-text text-capitalize">Thư liên hệ</span>
                            <span class="info-box-number">Xem thêm</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content pb-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Thống kê truy cập {{ $month }}/{{ $year }}
                    </h5>
                </div>
                <div class="card-body">
                    <form class="form-filter-charts row align-items-center mb-1" name="form-chart"
                        action="{{ route('admin.dashboard') }}" method="GET" name="form-thongke">
                        @csrf
                        <div class="row">
                            <div class="col-md-2" style="padding-right: 0;">
                                <div class="form-group">
                                    <select class="form-control select2" name="month">
                                        <option value="">
                                            Chọn tháng
                                        </option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            @php
                                                if (!empty(request()->year)) {
                                                    if ($i == request()->month) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                } else {
                                                    if ($i == date('m')) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $i }}" {{ $selected }}>
                                                Tháng {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control select2" name="year">
                                        <option value="">
                                            Chọn năm
                                        </option>
                                        @for ($i = 2000; $i <= date('Y') + 20; $i++)
                                            @php
                                                if (!empty(request()->month)) {
                                                    if ($i == request()->year) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                } else {
                                                    if ($i == date('Y')) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $i }}" {{ $selected }}>
                                                Năm {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2 p-0">
                                <button type="submit" name="btn-chart" class="btn btn-primary">
                                    Thống kê
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
