@php
  $deletePhoto = "admin.photo.".$type.".delete_photo";
  $photoConfig = "admin.photo.".$type.".photo";
  $linkConfig = "admin.photo.".$type.".link";
  $statusConfig = "admin.photo.".$type.".status";
  $titleConfig = "admin.photo.".$type.".title";
  $descConfig = "admin.photo.".$type.".desc";
  $contentConfig = "admin.photo.".$type.".content";
  $routeUpdate = "admin.photo.".$type.".update";
  $noimage = "resources/images/noimage.png";
  $thumb = "admin.photo.".$type.".thumb";
  $direct = "admin.photo.".$type.".index";
@endphp

@extends('admin.index')

@section('title', $row->title)

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
            @if ($row->title)
              {{$row->title}}
            @else
              Chi tiết dữ liệu
            @endif
          </li>
        </ol>
      </div>
    </div>
  </section>
  <section class="content">
    {!! Form::open(['name' => 'form-photo', 'route' => [$routeUpdate, $row->id, $type], 'class' => ['form-product-detail'], 'files' => true]) !!}
    @method('PUT')
      <div class="card-footer text-sm sticky-top">
        <button type="submit" name="save" class="btn btn-sm bg-gradient-primary submit-check">
          <i class="far fa-save mr-2"></i>Lưu
        </button>
        <a class="btn btn-sm bg-gradient-danger" href="{{route($direct)}}" title="Thoát">
          <i class="fas fa-sign-out-alt mr-2"></i>Thoát
        </a>
      </div>
      <div class="card card-primary card-outline text-sm">
        <div class="card-header">
          <h3 class="card-title">
            @if ($row->title)
              {{$row->title}}
            @else
              Chi tiết dữ liệu
            @endif
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">

          {{-- Photo --}}
          @if (config($photoConfig) === true)
            <div class="form-group">
              <div class="upload-file">
                <p>Upload hình ảnh:</p>
                <label class="upload-file-label mb-2" for="file0">
                  <div class="upload-file-image rounded mb-3 position-relative">
                    @if (!empty($row->photo))
                      <img class="rounded img-upload image-preview" src="{{ url("public/upload/photo/$row->photo")  }}" alt="{{ $row->title }}"/>
                      <a class="delete-photo" href="{{ route($deletePhoto, ['id' => $row->id, 'action' => 'photo', 'type' => $type]) }}" style="cursor: pointer" title="Xóa hình ảnh">
                        <i class="far fa-trash-alt text-white"></i>
                      </a>
                    @else
                      <img class="rounded img-upload image-preview" src="{{ url($noimage) }}" alt="No Image"/>
                    @endif
                  </div>
                  <div class="custom-file my-custom-file">
                    <input type="file" class="custom-file-input" name="file" id="file" onchange="document.querySelector('.image-preview').src = window.URL.createObjectURL(this.files[0])"/>
                    <label class="custom-file-label mb-0" data-browse="Chọn" for="file">
                      Chọn file
                    </label>
                  </div>
                </label>
                <strong class="d-block text-sm">
                  {{config($thumb)}}
                </strong>
              </div>
            </div>
          @endif

          {{-- Link --}}
          @if (config($linkConfig) === true)
            <div class="form-group">
              <label for="link">
                Link:
              </label>
              <input type="text" class="form-control text-sm" name="link" id="link" placeholder="Link" value="{{ !empty($row->link) ? $row->link : '' }}"/>
            </div>
          @endif

          {{-- Status --}}
          <div class="form-group">
            @php
              $status = !empty($row->status) ? explode(",", $row->status) : [];
            @endphp
            @foreach (config($statusConfig) as $key => $value)
              <div class="form-group d-inline-block mb-2 mr-2">
                <label for="{{$key}}-checkbox" class="d-inline-block align-middle mb-0 mr-2">{{$value}}:</label>
                <div class="custom-control custom-checkbox d-inline-block align-middle">
                  <input type="checkbox" class="custom-control-input {{$key}}-checkbox" name="status[]" id="{{$key}}-checkbox" value="{{$key}}" {{ in_array($key, $status) ? 'checked' : '' }}/>
                  <label for="{{$key}}-checkbox" class="custom-control-label"></label>
                </div>
              </div>
            @endforeach
          </div>

          <div class="form-group">
            <label for="num" class="d-inline-block align-middle mb-0 mr-2">
              Số thứ tự:
            </label>
            <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="num" id="num" placeholder="Số thứ tự" value="{{ !empty($row->num) ? $row->num : 0 }}"/>
          </div>

          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="tabs-lang" data-toggle="pill" href="#tabs-lang-vi-0" role="tab" aria-controls="tabs-lang-vi-0" aria-selected="true">
                    Tiếng Việt
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                <div class="tab-pane fade show active" id="tabs-lang-vi-0" role="tabpanel" aria-labelledby="tabs-lang">

                  {{-- Title --}}
                  @if (config($titleConfig) === true)
                    <div class="form-group">
                      <label for="title">Tiêu đề:</label>
                      <input type="text" class="form-control text-sm" name="title" id="title" placeholder="Tiêu đề" value="{{ !empty($row->title) ? $row->title : '' }}"/>
                    </div>
                  @endif

                  {{-- Desc --}}
                  @if (config($descConfig) === true)
                    <div class="form-group">
                      <label for="desc">Mô tả:</label>
                      <textarea class="form-control text-sm" name="desc" id="desc" rows="5" placeholder="Mô tả">{{ !empty($row->desc) ? $row->desc : '' }}</textarea>
                    </div>
                  @endif

                  {{-- Content --}}
                  @if (config($contentConfig) === true)
                    <div class="form-group">
                      <label for="cotnent">
                        Nội dung:
                      </label>
                      <textarea class="form-control text-sm" name="content" id="cotnent" rows="5" placeholder="Nội dung">{{ !empty($row->content) ? $row->content : '' }}</textarea>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    {!! Form::close() !!}
  </section>
@endsection
