@extends('admin.index')

@section('title', 'Thông tin đơn hàng ' . $rowInfo->code)

@section('content')
    <section class="content">
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
                            Thông tin đơn hàng {{ $rowInfo->code }}
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <form action="{{ route('admin.order.update', ['code' => $rowInfo->code]) }}" name="order-form-detail" method="POST">
            @csrf
            <div class="card-footer text-sm sticky-top">
                <button type="submit" name="update" class="btn btn-sm bg-gradient-primary">
                    <i class="far fa-save mr-2"></i>Lưu
                </button>
                <a class="btn btn-sm bg-gradient-danger" href="{{ route('admin.order') }}" title="Thoát">
                    <i class="fas fa-sign-out-alt mr-2"></i>Thoát
                </a>
            </div>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Thông tin chính</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Mã đơn hàng:</label>
                        <p class="text-primary">{{ $rowInfo->code }}</p>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Hình thức thanh toán:</label>
                        @if ($rowInfo->order_status == 1)
                            <p class="text-primary">Mới đặt</p>
                        @elseif($rowInfo->order_status == 2)
                            <p class="text-info">Đã xác nhận</p>
                        @elseif($rowInfo->order_status == 3)
                            <p class="text-success">Đã giao</p>
                        @elseif($rowInfo->order_status == 4)
                            <p class="text-danger">Đã hủy</p>
                        @elseif($rowInfo->order_status == 5)
                            <p class="text-warning">Đang giao hàng</p>
                        @endif
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Họ tên:</label>
                        <p class="font-weight-bold text-uppercase text-success">
                            {{ $rowInfo->fullname }}
                        </p>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Điện thoại:</label>
                        <p>
                            {{ $rowInfo->phone }}
                        </p>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Email:</label>
                        <p>{{ $rowInfo->email }}</p>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Địa chỉ:</label>
                        <p>
                            {{ $rowInfo->address }}
                        </p>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Ngày đặt:</label>
                        <p> {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rowInfo->created_at)->format('H:i:s A d/m/Y') }}
                        </p>
                    </div>
                    <div class="form-group col-12">
                        <label for="requirements">Yêu cầu khác:</label>
                        <textarea class="form-control text-sm" name="requirements" id="requirements" rows="5" placeholder="Yêu cầu khác">{{ !empty($rowInfo->requirements) ? $rowInfo->requirements : '' }}</textarea>
                    </div>
                    <div class="form-group col-12">
                        <label for="order_status" class="mr-2">Tình trạng:</label>
                        <select id="order_status" name="order_status"
                            class="form-control custom-select text-sm @error('order_status') is-invalid @enderror">
                            <option value="">Chọn tình trạng</option>
                            <option value="1" {{ $rowInfo->order_status == 1 ? 'selected' : '' }}>Mới đặt</option>
                            <option value="2" {{ $rowInfo->order_status == 2 ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="3" {{ $rowInfo->order_status == 3 ? 'selected' : '' }}>Đã giao</option>
                            <option value="4" {{ $rowInfo->order_status == 4 ? 'selected' : '' }}>Đã hủy</option>
                            <option value="5" {{ $rowInfo->order_status == 5 ? 'selected' : '' }}>Đang giao hàng
                            </option>
                        </select>
                    </div>
                    @error('order_status')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group col-12">
                        <label for="notes">Ghi chú:</label>
                        <textarea class="form-control text-sm" name="notes" id="notes" rows="5" placeholder="Ghi chú">{{ !empty($rowInfo->notes) ? $rowInfo->notes : '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết đơn hàng</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="align-middle text-center" width="10%">STT</th>
                                <th class="align-middle">Hình ảnh</th>
                                <th class="align-middle" style="width:30%">Tên sản phẩm</th>
                                <th class="align-middle text-center">Đơn giá</th>
                                <th class="align-middle text-right">Số lượng</th>
                                <th class="align-middle text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($rowDetail) > 0)
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($rowDetail as $v)
                                    @php
                                        $total += $v->sale_price * $v->quantity;
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-center">1</td>
                                        <td class="align-middle">
                                            <a title="{{ !empty($v->photo1) ? $v->title : 'noimage' }}">
                                                <img class="rounded img-preview"
                                                    src="{{ !empty($v->photo1) ? asset('upload/product/' . $v->photo1) : url('resources/images/noimage.png') }}"
                                                    alt="{{ !empty($v->photo1) ? $v->title : 'noimage' }}" />
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <p class="text-primary mb-1">{{ $v->title }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="price-cart-detail">
                                                <span class="price-new-cart-detail">
                                                    {{ number_format($v->sale_price, 0, ',', '.') }}đ
                                                </span>
                                                <span class="price-old-cart-detail">
                                                    {{ number_format($v->regular_price, 0, ',', '.') }}đ
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-right">{{ $v->quantity }}</td>
                                        <td class="align-middle text-right">
                                            <div class="price-cart-detail">
                                                <span class="price-new-cart-detail">
                                                    {{ number_format($v->sale_price, 0, ',', '.') }}đ
                                                </span>
                                                <span class="price-old-cart-detail">
                                                    {{ number_format($v->regular_price, 0, ',', '.') }}đ
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            @endif
                            <tr>
                                <td colspan="5" class="title-money-cart-detail">Tổng giá trị đơn hàng:</td>
                                <td colspan="1" class="cast-money-cart-detail">
                                    {{ number_format($total, 0, ',', '.') }}đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </section>
@endsection
