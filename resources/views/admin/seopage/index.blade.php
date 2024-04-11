@php
  $nameConfig = "admin.seopage.".$type.".name";
  $deletePhoto = "admin.seopage.delete_photo";
  $photoConfig = "admin.seopage.".$type.".photo";
  $statusConfig = "admin.seopage.".$type.".status";
  $titleConfig = "admin.seopage.".$type.".title";
  $keywordsConfig = "admin.seopage.".$type.".keywords";
  $descConfig = "admin.seopage.".$type.".description";
  $noimage = "resources/images/noimage.png";
  $thumb = "admin.seopage.".$type.".thumb";
  $route = "admin.seopage.save";
@endphp

@extends('admin.index')

@section('title', config($nameConfig))

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
            {{config($nameConfig)}}
          </li>
        </ol>
      </div>
    </div>
  </section>
  <section class="content">
    <form action="{{ route($route, ['type' => $type, 'id' => !empty($row->id) ? $row->id : '']) }}" class="validation-form" method="POST" enctype="multipart/form-data">
    @csrf
      <div class="card-footer text-sm sticky-top">
        <button type="submit" name="{{!empty($row) ? 'update' : 'save'}}" class="btn btn-sm bg-gradient-primary submit-check">
          <i class="far fa-save mr-2"></i>Lưu
        </button>
        @if ($row)
          <a href="{{route('admin.seopage.remake', ['type' => $type, 'id' => $row->id, 'hash' => $row->hash])}}" class="btn btn-sm bg-gradient-secondary">
            <i class="fas fa-redo mr-2"></i>Làm mới
          </a>
        @endif
      </div>
      <div class="card card-primary card-outline text-sm">
        <div class="card-header">
          <h3 class="card-title">
            {{config($nameConfig)}}
          </h3><br>
          (<span>Lưu ý: Cần làm mới dữ liệu trước khi cập nhật</span>)
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
                      <img class="rounded img-upload image-preview" src="{{ url("public/upload/seopage/$row->photo")  }}" alt="{{ $row->title }}"/>
                      </a>
                    @else
                      <img class="rounded img-upload image-preview" src="{{ url($noimage) }}" alt="No Image"/>
                    @endif
                  </div>
                  <div class="custom-file my-custom-file">
                    <input type="file" class="custom-file-input" name="photo" id="file" onchange="document.querySelector('.image-preview').src = window.URL.createObjectURL(this.files[0])"/>
                    <label class="custom-file-label mb-0" data-browse="Chọn" for="file">
                      Chọn file
                    </label>
                  </div>
                </label>
                <strong class="d-block text-sm">
                  {{config($thumb)}}
                </strong>
              </div>
              @error("photo")
                <strong class="text-danger">{{ $message }}</strong>
              @enderror
            </div>
          @endif

          {{-- Status --}}
          <div class="form-group">
            @php
              $status = !empty($row->status) ? explode(",", $row->status) : [];
            @endphp
            @foreach (config($statusConfig) as $key => $value)
              <div class="form-group d-inline-block mb-2 mr-2">
                <label for="{{$key}}-checkbox" class="d-inline-block align-middle mb-0 mr-2">Hiển thị:</label>
                <div class="custom-control custom-checkbox d-inline-block align-middle">
                  <input type="checkbox" class="custom-control-input {{$key}}-checkbox" name="status[]" id="{{$key}}-checkbox" checked="" value="{{$key}}" {{ in_array($key, $status) ? 'checked' : '' }}/>
                  <label for="{{$key}}-checkbox" class="custom-control-label"></label>
                </div>
              </div>
            @endforeach
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
                      <label for="title">Title:</label>
                      <input type="text" class="form-control text-sm" name="title" id="title" placeholder="Title" value="{{ !empty($row->title) ? $row->title : '' }}"/>
                      @error("title")
                        <strong class="text-danger">{{ $message }}</strong>
                      @enderror
                    </div>
                  @endif

                  {{-- Keywords --}}
                  @if (config($keywordsConfig) === true)
                    <div class="form-group">
                      <label for="keywords">Keywords:</label>
                      <input type="text" class="form-control check-seo keywords-seo text-sm" name="keywords" id="keywords" placeholder="Keywords" value="{{ !empty($row->keywords) ? $row->keywords : '' }}"/>
                    </div>
                  @endif

                  {{-- Description --}}
                  @if (config($descConfig) === true)
                    <div class="form-group">
                      <label for="description">
                        Description:
                      </label>
                      <textarea class="form-control check-seo description-seo text-sm" name="description" id="description" rows="5" placeholder="Description">{!! !empty($row->description) ? $row->description : '' !!}</textarea>
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
