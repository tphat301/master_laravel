@extends('admin.index')

@section('title', 'Thêm'.config("admin.place.".$type.".name"))

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
            Thêm {{config("admin.place.".$type.".name")}}
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    <form action="{{ route("admin.place.".$type.".save", ['type' => $type]) }}" class="validation-form" method="POST">
      @csrf
      <div class="card-footer text-sm sticky-top">
        <button type="submit" name="save" class="btn btn-sm bg-gradient-primary submit-check">
          <i class="far fa-save mr-2"></i>Lưu
        </button>
        <a class="btn btn-sm bg-gradient-danger" href="{{ route("admin.place.".$type.".index", ['type' => $type]) }}" title="Thoát">
          <i class="fas fa-sign-out-alt mr-2"></i>Thoát
        </a>
      </div>
      <div class="card card-primary card-outline text-sm">
        <div class="card-header">
          <h3 class="card-title">Nội dung</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="tabs-lang" data-toggle="pill" href="javscript:void()" role="tab" aria-controls="tabs-lang-vi" aria-selected="true">
                    Tiếng Việt
                  </a>
                </li>
              </ul>
            </div>

            <div class="card-body card-article">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="tabs-lang-vi" role="tabpanel" aria-labelledby="tabs-lang">
                  <div class="form-group">
                    <label for="name_{{$type}}">Tên {{config("admin.place.".$type.".name")}}:</label>
                    <input type="text" class="form-control text-sm" name="name_{{$type}}" id="name_{{$type}}" placeholder="Tên {{config("admin.place.".$type.".name")}}"/>
                    @error("name_$type")
                      <small class="text-sm text-danger">
                        {{ $message }}
                      </small>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card card-primary card-outline text-sm">
        <div class="card-header">
          <h3 class="card-title">Thông tin</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="card-body">
            <div class="form-group col-md-4">
              <label for="num" class="d-inline-block align-middle mb-0 mr-2">
                Số thứ tự:
              </label>
              <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="num" id="num" value="0"/>
            </div>
            @if ($type == 'district' || $type == 'city')
              <div class="form-group col-md-4">
                <label for="code_city" class="d-inline-block align-middle mb-0 mr-2">
                  Mã tỉnh,thành phố:
                </label>
                <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="code_city" id="code_city"/>
                @error("code_city")
                  <small class="text-sm text-danger">
                    {{ $message }}
                  </small>
                @enderror
              </div>
            @endif
            @if ($type == 'district' || $type == 'ward')
              <div class="form-group col-md-4">
                <label for="code_district" class="d-inline-block align-middle mb-0 mr-2">
                  Mã quận huyện:
                </label>
                <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="code_district" id="code_district"/>
                @error("code_district")
                  <small class="text-sm text-danger">
                    {{ $message }}
                  </small>
                @enderror
              </div>
            @endif
          </div>
        </div>
      </div>
    </form>
  </section>
@endsection
