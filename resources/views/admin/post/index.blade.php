@extends('admin.index')

@section('title', config('admin.post.'.$type.'.name'))

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
            {{ config('admin.post.'.$type.'.name') }}
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    {!! Form::open(['name' => 'form-'.$type.'-list', 'class' => ['form-product-list'], 'method' => 'GET']) !!}
      <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="{{route('admin.post.create',['type' => $type])}}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>

        <a data-url="{{ route('admin.post.destroy',['type' => $type]) }}" class="btn btn-sm bg-gradient-danger text-white delete-all" id="delete-all"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>

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

      <div class="card card-primary card-outline text-sm mb-0 rendering">
        <div class="card-header">
          <h3 class="card-title">
            Danh sách {{config('admin.post.'.$type.'.name')}}
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
                @if (config('admin.post.'.$type.'.photo1') === true)
                  <th class="align-middle">Hình ảnh</th>
                @endif
                <th class="align-middle" style="width:30%">Tiêu đề</th>
                @foreach (config('admin.post.'.$type.'.status') as $key => $value)
                  <th class="align-middle text-center">{{$value}}</th>
                @endforeach
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
                        <input type="hidden" name="hashes[]" value="{{ $row->hash }}"/>
                        <label for="select-checkbox-{{ $row->id }}" class="custom-control-label"></label>
                      </div>
                    </td>
                    <td class="align-middle">
                      <input type="number" class="update-num-post form-control form-control-mini m-auto" min="0" value="{{ $row->num }}" data-type="{{$type}}" data-id="{{ $row->id }}" data-url="{{ route('admin.post.update_number',['type'=>$type]) }}"/>
                    </td>
                    @if (config('admin.post.'.$type.'.photo1') === true)
                      <td class="align-middle">
                        <a href="{{ route('admin.post.show', ['type'=>$type,'id'=>$row->id]) }}" title="{{ $row->title }}">
                          @if (!empty($row->photo1))
                            <img class="rounded img-preview img-fluid" src="{{ url("public/upload/post/$row->photo1")  }}" alt="{{ $row->title }}" width="70" height="50" style="object-fit: contain;"/>
                          @else
                            <img class="rounded img-preview img-fluid" src="{{ url("resources/images/noimage.png")  }}" alt="{{ $row->title }}" width="70" height="50" style="object-fit: contain;"/>
                          @endif
                        </a>
                      </td>
                    @endif
                    <td class="align-middle">
                      <a class="text-dark text-break" href="{{ route('admin.post.show', ['type'=>$type,'id'=>$row->id]) }}" title="{{ $row->title }}">
                        {{ $row->title }}
                      </a>
                    </td>
                    @foreach (config('admin.post.'.$type.'.status') as $key => $value)
                      <td class="align-middle text-center">
                        <div class="custom-control custom-checkbox">
                          @php
                            $status = !empty($row->status) ? explode(",", $row->status) : [];
                          @endphp
                          <input type="checkbox" id="update-status-{{$key}}-{{$k}}" class="update-status-photo custom-control-input" name="{{ $key }}" data-id="{{ $row->id }}" data-type="{{$type}}" data-url="{{route('admin.post.update_status',['type'=>$type])}}" {{ in_array($key, $status) ? 'checked' : '' }} />
                          <label for="update-status-{{$key}}-{{$k}}" class="custom-control-label"></label>
                        </div>
                      </td>
                    @endforeach
                    <td class="align-middle text-center text-md text-nowrap">
                      <a class="text-primary mr-2" href="{{ route('admin.post.show', ['type'=>$type,'id'=>$row->id]) }}" title="Chỉnh sửa">
                        <i class="fas fa-edit"></i>
                      </a>

                      @if(config('admin.post.'.$type.'.copy') === true)
                        <div class="dropdown d-inline-block align-middle">
                          <a href="{{ route('admin.post.copy', ['type'=>$type,'id'=>$row->id]) }}" class="nav-link text-success p-0 pr-2" title="Copy">
                            <i class="far fa-clone"></i>
                          </a>
                        </div>
                      @endif
                      <a class="text-danger" href="{{route('admin.post.delete', ['type' => $type,'id' => $row->id, 'hash' => $row->hash])}}" title="Xóa" style="cursor: pointer">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
              <tr>
                <td colspan="12"><span class="text-danger">Danh sách {{config('admin.post.'.$type.'.name')}} trống</span></td>
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
