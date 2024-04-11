@extends('admin.index')

@section('title', "Thông tin đăng ký liên hệ")

@section('content')
  <section class="content-header text-sm">
    <div class="container-fluid">
      <div class="row">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">
            <a href="{{url('admin/dashboard')}}" title="{{ config('admin.dashboard.name') }}">
              {{ config('admin.dashboard.name') }}
            </a>
          </li>
          <li class="breadcrumb-item active">
            Thông tin đăng ký liên hệ
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card-footer text-sm sticky-top">
      <a class="btn btn-sm bg-gradient-danger" href="{{ route('admin.contact') }}" title="Thoát">
        <i class="fas fa-sign-out-alt mr-2"></i>Thoát
      </a>
    </div>

    <div class="card card-primary card-outline text-sm">
      <div class="card-header">
        <h3 class="card-title">
          Thông tin đăng ký liên hệ
        </h3>
      </div>
      <div class="card-body">
        <div class="form-group-category row">
          @if (!empty($row->fullname))
            <div class="form-group col-md-4">
              <label for="fullname">
                Họ tên:
              </label>
              <input type="text" class="form-control text-sm" name="fullname" id="fullname" placeholder="Họ tên" value="{{$row->fullname}}"/>
            </div>
          @endif
          @if (!empty($row->email))
            <div class="form-group col-md-4">
              <label for="email">
                Email:
              </label>
              <input type="email" class="form-control text-sm" name="email" id="email" placeholder="Email" value="{{$row->email}}"/>
              @error('email')
                <small class="text-sm text-danger">
                  {{ $message }}
                </small>
              @enderror
            </div>
          @endif
          @if (!empty($row->phone))
            <div class="form-group col-md-4">
              <label for="phone">Điện thoại:</label>
              <input type="text" class="form-control text-sm" name="phone" id="phone" placeholder="Điện thoại" value="{{$row->phone}}" />
              @error('phone')
                <small class="text-sm text-danger">
                  {{ $message }}
                </small>
              @enderror
            </div>
          @endif
          @if (!empty($row->address))
            <div class="form-group col-md-4">
              <label for="address">Địa chỉ:</label>
              <input type="text" class="form-control text-sm" name="address" id="address" placeholder="Địa chỉ" value="{{$row->address}}" />
            </div>
          @endif
          @if (!empty($row->subject))
            <div class="form-group col-md-4">
              <label for="subject">Chủ đề:</label>
              <input type="text" class="form-control text-sm" name="subject" id="subject" placeholder="Chủ đề" value="{{$row->subjec}}" />
            </div>
          @endif
          @if (!empty($row->notes))
            <div class="form-group">
              <label for="notes">
                Ghi chú:
              </label>
              <textarea class="form-control text-sm" name="notes" id="notes" rows="5" placeholder="Ghi chú">{!! $row->notes !!}</textarea>
            </div>
          @endif
          @if (!empty($row->content))
            <div class="form-group">
              <label for="content">
                Nội dung:
              </label>
              <textarea name="content" id="content" class="form-control text-sm" cols="30" rows="10" placeholder="Nội dung">{!! !empty($row->content) ? $row->content : '' !!}</textarea>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection
