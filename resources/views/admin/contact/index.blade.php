@extends('admin.index')

@section('title', 'Danh sách liên hệ')

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
            Danh sách liên hệ
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    {!! Form::open(['name' => 'form-newsletter-list', 'route' => ['admin.contact.destroy'], 'class' => ['form-newsletter-list', 'form-newsletter-request']]) !!}
      <div class="card-footer text-sm sticky-top">
        <a data-url="{{ route('admin.contact.destroy') }}" class="btn btn-sm bg-gradient-danger text-white delete-all-request" id="delete-all">
          <i class="far fa-trash-alt mr-2"></i>Xóa tất cả
        </a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar text-sm keyword keyword-request" type="text" placeholder="Tìm kiếm" name="keyword" value="{{!empty(request()->keyword) ? request()->keyword : ''}}" data-url="{{route('admin.contact')}}"/>
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
          <h3 class="card-title">
            Danh sách liên hệ
          </h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="align-middle" width="5%">
                  <div class="custom-control custom-checkbox my-checkbox">
                    <input type="checkbox" class="checkall custom-control-input" id="selectall-checkbox"/>
                    <label for="selectall-checkbox" class="custom-control-label"></label>
                  </div>
                </th>
                <th class="align-middle text-center" width="10%">STT</th>
                <th class="align-middle">Họ tên</th>
                <th class="align-middle">Email</th>
                <th class="align-middle">Điện thoại</th>
                <th class="align-middle">Ngày tạo</th>
                <th class="align-middle text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @if ($rows->total() > 0)
                @foreach ($rows as $k => $row)
                  <tr>
                    <td class="align-middle">
                      <div class="custom-control custom-checkbox my-checkbox">
                        <input type="checkbox" name="checkitem[]" class="checkitem custom-control-input select-checkbox" id="select-checkbox-{{ $row->id }}" value="{{ $row->id }}"/>
                        <label for="select-checkbox-{{ $row->id }}" class="custom-control-label"></label>
                      </div>
                    </td>
                    <td class="align-middle">
                      <input type="number" class="update-num-newsletter form-control form-control-mini m-auto" min="0" value="{{ $row->num }}" data-token="{{ csrf_token() }}" data-id="{{ $row->id }}" data-url="{{ route('admin.contact.update_number') }}"/>
                    </td>
                    <td class="align-middle">
                      <a class="text-dark text-break" href="{{ route('admin.contact.show', ['id'=>$row->id]) }}" title="{{ $row->fullname }}">
                        {{ $row->fullname }}
                      </a>
                    </td>
                    <td class="align-middle">
                      {{ $row->email }}
                    </td>
                    <td class="align-middle">
                      {{$row->phone}}
                    </td>
                    <td class="align-middle">
                      {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('H:i:s A d/m/Y') }}
                    </td>
                    <td class="align-middle text-center text-md text-nowrap">
                      <a class="text-primary mr-2" href="{{ route('admin.contact.show', ['id'=>$row->id]) }}" title="Xem">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a class="text-danger" href="{{route('admin.contact.delete', ['id' => $row->id])}}" title="Xóa" style="cursor: pointer">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
              <tr>
                <td colspan="12"><span class="text-danger">Danh sách liên hệ trống</span></td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    {!! Form::close() !!}

    {!! $rows -> links() !!}

    {!! Form::open(['name' => 'form_delete_row', 'class' => ['card__body','form_delete_row']]) !!}
      @method('DELETE')
    {!! Form::close() !!}
  </section>
@endsection
