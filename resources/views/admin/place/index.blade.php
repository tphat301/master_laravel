@php
  $name = "admin.place.".$type.".name";
  $create = "admin.place.".$type.".create";
  $delete = "admin.place.".$type.".delete";
  $deleteAll = "admin.place.".$type.".destroy";
  $statusConfig = "admin.place.".$type.".status";
  $show = "admin.place.".$type.".show";
  $updateNumber = "admin.place.".$type.".update_number";
@endphp

@extends('admin.index')

@section('title', config($name))

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
            {{ config($name)}}
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    {!! Form::open(['name' => 'form-place-list', 'class' => ['form-product-list'], 'method' => 'GET']) !!}
      <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="{{route($create, ['type' => $type])}}" title="Thêm mới">
          <i class="fas fa-plus mr-2"></i>Thêm mới
        </a>

        <a data-url="{{ route($deleteAll, ['type' => $type]) }}" class="btn btn-sm bg-gradient-danger text-white delete-all" id="delete-all">
          <i class="far fa-trash-alt mr-2"></i>Xóa tất cả
        </a>

        <div class="form-inline form-search d-inline-block align-middle ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar text-sm keyword" type="text" placeholder="Tìm kiếm" name="keyword" value="{{!empty(request()->keyword) ? request()->keyword : ''}}"/>
            <div class="input-group-append bg-primary rounded-right">
              <button class="btn btn-navbar text-white" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer form-group-category text-sm bg-light row">
        @if ($type == 'district')
          <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <select id="id_parent1" name="id_parent1" class="form-control filter-category-rendering select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
              <option value="{{ request()->fullUrlWithQuery(['code_city' => '']) }}">
                {{ config('admin.place.city.name') }}
              </option>
              @foreach ($rowSelect as $v)
                <option value="{{ request()->fullUrlWithQuery(['code_city' => $v->code_city]) }}" {{ request()->code_city ==  $v->code_city ? 'selected' : ''}}>
                  {{ $v->name_city }}
                </option>
              @endforeach
            </select>
          </div>
        @endif
        @if ($type == 'ward')
          <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <select id="id_parent1" name="id_parent1" class="form-control filter-category-rendering select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
              <option value="{{ request()->fullUrlWithQuery(['code_city' => '']) }}">
                {{ config('admin.place.district.name') }}
              </option>
              @foreach ($rowSelect as $v)
                <option value="{{ request()->fullUrlWithQuery(['code_district' => $v->code_district]) }}" {{ request()->code_district ==  $v->code_district ? 'selected' : ''}}>
                  {{ $v->name_district }}
                </option>
              @endforeach
            </select>
          </div>
        @endif
      </div>

      {{-- Data item --}}
      <div class="card card-primary card-outline text-sm mb-0 rendering">
        <div class="card-header">
          <h3 class="card-title">
            Danh sách {{config($name)}}
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
                <th class="align-middle" >Tiêu đề</th>
                <th class="align-middle text-center" width="10%">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @if ($rows->total() > 0)
                @foreach ($rows as $k => $row)
                @php
                  $id = 'id_'.$type;
                  $name = 'name_'.$type;
                @endphp
                  <tr>
                    <td class="align-middle">
                      <div class="custom-control custom-checkbox my-checkbox">
                        <input type="checkbox" name="checkitem[]" class="checkitem custom-control-input select-checkbox" id="select-checkbox-{{ $row->$id }}" value="{{ $row->$id }}"/>
                        <label for="select-checkbox-{{ $row->$id }}" class="custom-control-label"></label>
                      </div>
                    </td>
                    <td class="align-middle">
                      <input type="number" class="update-num-photo form-control form-control-mini m-auto" min="0" value="{{ $row->num }}" data-id="{{ $row->$id }}" data-type="{{$type}}" data-url="{{ route($updateNumber) }}"/>
                    </td>
                    <td class="align-middle">
                      <a class="text-dark text-break" href="{{ route($show, ['id' => $row->$id, 'type' => $type]) }}" title="{{ $row->$name }}">
                        {{ $row->$name }}
                      </a>
                    </td>
                    <td class="align-middle text-center text-md text-nowrap">
                      <a class="text-primary mr-2" href="{{ route($show, ['id' => $row->$id, 'type' => $type]) }}" title="Chỉnh sửa">
                        <i class="fas fa-edit"></i>
                      </a>

                      <a class="text-danger delete-row" data-url="{{route($delete, ['id' => $row->$id, 'type' => $type])}}" title="Xóa" style="cursor: pointer">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
              <tr>
                <td colspan="12"><span class="text-danger">Danh sách {{ config($name) }} trống</span></td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    {!! Form::close() !!}

    {{-- Phân trang --}}
    {!! $rows -> links() !!}

    {!! Form::open(['name' => 'form_delete_row', 'class' => ['card__body','form_delete_row', 'd-none']]) !!}
      @method('DELETE')
    {!! Form::close() !!}
  </section>
@endsection

