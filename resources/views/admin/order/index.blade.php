@extends('admin.index')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <section class="content-header text-sm">
        <div class="container-fluid">
            <div class="row">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/dashboard') }}" title="{{ config('admin.dashboard.name') }}">
                            {{ config('admin.dashboard.name') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Danh sách đơn hàng
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                @php
                    $total1 = 0;
                    if (count($row1) > 0) {
                        foreach ($row1 as $k1 => $v1) {
                            $total1 += $v1->total_price;
                        }
                    }
                    $total2 = 0;
                    if (count($row2) > 0) {
                        foreach ($row2 as $k2 => $v2) {
                            $total2 += $v2->total_price;
                        }
                    }
                    $total3 = 0;
                    if (count($row3) > 0) {
                        foreach ($row3 as $k3 => $v3) {
                            $total3 += $v3->total_price;
                        }
                    }
                    $total4 = 0;
                    if (count($row4) > 0) {
                        foreach ($row4 as $k4 => $v4) {
                            $total4 += $v4->total_price;
                        }
                    }
                @endphp
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-bag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-primary font-weight-bold text-capitalize text-sm">Mới đặt</span>
                        <p class="info-box-text text-sm mb-0">Số lượng:
                            <span class="text-danger font-weight-bold">{{ count($row1) }}</span>
                        </p>
                        <p class="info-box-text text-sm mb-0">Tổng giá:
                            <span class="text-danger font-weight-bold">
                                {{ number_format($total1, 0, ',', '.') }}đ
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-info font-weight-bold text-capitalize text-sm">Đã xác nhận</span>
                        <p class="info-box-text text-sm mb-0">Số lượng:
                            <span class="text-danger font-weight-bold">
                                {{ count($row2) }}
                            </span>
                        </p>
                        <p class="info-box-text text-sm mb-0">Tổng giá:
                            <span class="text-danger font-weight-bold">
                                {{ number_format($total2, 0, ',', '.') }}đ
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-success font-weight-bold text-capitalize text-sm">Đã giao</span>
                        <p class="info-box-text text-sm mb-0">Số lượng:
                            <span class="text-danger font-weight-bold">
                                {{ count($row3) }}
                            </span>
                        </p>
                        <p class="info-box-text text-sm mb-0">Tổng giá:
                            <span class="text-danger font-weight-bold">
                                {{ number_format($total3, 0, ',', '.') }}đ
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-danger font-weight-bold text-capitalize text-sm">Đã hủy</span>
                        <p class="info-box-text text-sm mb-0">Số lượng:
                            <span class="text-danger font-weight-bold">
                                {{ count($row4) }}
                            </span>
                        </p>
                        <p class="info-box-text text-sm mb-0">Tổng giá:
                            <span class="text-danger font-weight-bold">
                                {{ number_format($total4, 0, ',', '.') }}đ
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::open([
            'name' => 'form-newsletter-list',
            'route' => ['admin.order.destroy'],
            'class' => ['form-newsletter-list', 'form-newsletter-request'],
        ]) !!}
        <div class="card-footer text-sm sticky-top">
            <a data-url="{{ route('admin.order.destroy') }}"
                class="btn btn-sm bg-gradient-danger text-white delete-all-request" id="delete-all">
                <i class="far fa-trash-alt mr-2"></i>Xóa tất cả
            </a>
            <div class="form-inline form-search d-inline-block align-middle ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar text-sm keyword keyword-request" type="text"
                        placeholder="Tìm kiếm" name="keyword"
                        value="{{ !empty(request()->keyword) ? request()->keyword : '' }}"
                        data-url="{{ route('admin.order') }}" />
                    <div class="input-group-append bg-primary rounded-right">
                        <button class="btn btn-navbar text-white btn-newsl-keyword">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm mb-0 rendering">
            <div class="card-header">
                <h3 class="card-title card-title-order d-inline-block align-middle float-none">
                    Danh sách đơn hàng
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-middle" width="5%">
                                <div class="custom-control custom-checkbox my-checkbox">
                                    <input type="checkbox" class="checkall custom-control-input" id="selectall-checkbox" />
                                    <label for="selectall-checkbox" class="custom-control-label"></label>
                                </div>
                            </th>
                            <th class="align-middle">
                                Mã đơn hàng
                            </th>
                            <th class="align-middle" width="15%">
                                Họ tên
                            </th>
                            <th class="align-middle">
                                Ngày đặt
                            </th>
                            <th class="align-middle">
                                Hình thức thanh toán
                            </th>
                            <th class="align-middle">
                                Tổng giá
                            </th>
                            <th class="align-middle">
                                Tình trạng
                            </th>
                            <th class="align-middle text-center">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rows->total() > 0)
                            @foreach ($rows as $k => $row)
                                <tr>
                                    <td class="align-middle">
                                        <div class="custom-control custom-checkbox my-checkbox">
                                            <input type="checkbox" name="checkitem[]"
                                                class="checkitem custom-control-input select-checkbox"
                                                id="select-checkbox-{{ $row->code }}" value="{{ $row->code }}" />
                                            <label for="select-checkbox-{{ $row->code }}"
                                                class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.order.show', ['code' => $row->code]) }}"
                                            class="text-primary" title="{{ $row->code }}">
                                            {{ $row->code }}
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="text-primary text-break"
                                            href="{{ route('admin.order.show', ['code' => $row->code]) }}"
                                            title="{{ $row->fullname }}">
                                            {{ $row->fullname }}
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('H:i:s A d/m/Y') }}
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-info">
                                            {{ $row->title }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-danger font-weight-bold">
                                            {{ number_format($row->total_price, 0, ',', '.') }}đ
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        @if ($row->order_status == 1)
                                            <span class="text-primary">Mới đặt</span>
                                        @elseif($row->order_status == 2)
                                            <span class="text-info">Đã xác nhận</span>
                                        @elseif($row->order_status == 3)
                                            <span class="text-success">Đã giao</span>
                                        @elseif($row->order_status == 4)
                                            <span class="text-danger">Đã hủy</span>
                                        @elseif($row->order_status == 5)
                                            <span class="text-warning">Đang giao hàng</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-md text-nowrap">
                                        <a class="text-primary mr-2"
                                            href="{{ route('admin.order.show', ['code' => $row->code]) }}"
                                            title="Xem">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="text-danger"
                                            href="{{ route('admin.order.delete', ['code' => $row->code]) }}"
                                            title="Xóa" style="cursor: pointer">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12"><span class="text-danger">Danh sách đơn hàng trống</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        {!! Form::close() !!}

        {!! $rows->links() !!}

        {!! Form::open(['name' => 'form_delete_row', 'class' => ['card__body', 'form_delete_row']]) !!}
        @method('DELETE')
        {!! Form::close() !!}
    </section>
@endsection
