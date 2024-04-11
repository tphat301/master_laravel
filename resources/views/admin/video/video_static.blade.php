@php
  $route = "admin.video.video_static.save";
  $name = "admin.video.".$type.".name";
  $noimage = "resources/images/noimage.png";
  $photoConfig = "admin.video.".$type.".photo";
  $statusConfig = "admin.video.".$type.".status";
  $thumb = "admin.video.".$type.".thumb";
  $title = "admin.video.".$type.".title";
  $desc = "admin.video.".$type.".desc";
  $content = "admin.video.".$type.".content";
  $deletePhoto = "admin.video.".$type.".delete_photo";
  $linkConfig = "admin.video.".$type.".link";
  $helper = new App\Utils\Helpers;
@endphp
@extends('admin.index')

@section('title', config($name))
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
            {{config($name)}}
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    {!! Form::open(['name' => 'form-photo-static', 'route' => [$route, $type, !empty($row) ? $row->id : ''], 'class' => ['form-photo'], 'files' => true]) !!}
      <div class="card-footer text-sm sticky-top">
        @if ($row)
          <a href="{{route("admin.video.".$type.".remake", ['type' => $type, 'id' => $row->id, 'hash' => $row->hash])}}" class="btn btn-sm bg-gradient-secondary">
            <i class="fas fa-redo mr-2"></i>Làm mới
          </a>
        @else
          <button type="submit" name="save" class="btn btn-sm bg-gradient-primary submit-check">
            <i class="far fa-save mr-2"></i>Lưu
          </button>
        @endif
      </div>
      <div class="card card-primary card-outline text-sm">
        <div class="card-header">
          <h3 class="card-title">
            {{config($name)}}
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @if (config($photoConfig) === true)
            <div class="form-group">
              <div class="upload-file">
                <p>
                  Upload hình ảnh:
                </p>
                <label class="upload-file-label mb-2" for="file0">
                  <div class="upload-file-image rounded position-relative mb-3">
                    @if (!empty($row->photo))
                      <img class="rounded img-upload" id="img-preview-static" src="{{url("public/upload/video/$row->photo")}}" alt="{{$row->title}}"/>
                    @else
                      <img class="rounded img-upload" id="img-preview-static" src="{{ url($noimage) }}" alt="No Image"/>
                    @endif
                  </div>
                  <div class="custom-file my-custom-file">
                    <input type="file" class="custom-file-input" name="photo" id="photo" onchange="document.getElementById('img-preview-static').src = window.URL.createObjectURL(this.files[0])"/>
                    <label class="custom-file-label mb-0" data-browse="Chọn" for="photo">
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

          @if (config($linkConfig) === true)
            <div class="form-group">
              <label for="link">
                Link:
              </label>
              <input type="text" class="form-control text-sm" name="link" id="link" placeholder="Link" value="{{ !empty($row->link) ? $row->link : '' }}"/>
              @error("link")
                <small class="text-sm text-danger">
                  {{ $message }}
                </small>
              @enderror
            </div>
          @endif

          @if(!empty($row->link))
          <div class="form-group">
            <label for="link_video">Video preview:</label>
            <div>
              <iframe id="loadVideo" width="250" height='150' src="//www.youtube.com/embed/{{$helper->getYoutube($row->link)}}" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
          @endif

          @if ($statusConfig)
            <div class="form-group">
              @php
                $status = !empty($row->status) ? explode(",", $row->status) : [];
              @endphp
              @foreach (config($statusConfig) as $key => $value)
                <div class="form-group d-inline-block mb-2 mr-2">
                  <label for="{{$key}}-checkbox" class="d-inline-block align-middle mb-0 mr-2">
                    {{$value}}:
                  </label>
                  <div class="custom-control custom-checkbox d-inline-block align-middle">
                    <input type="checkbox" class="custom-control-input {{$key}}-checkbox" name="status[]" id="{{$key}}-checkbox" value="{{$key}}" {{ in_array($key, $status) ? 'checked' : '' }}/>
                    <label for="{{$key}}-checkbox" class="custom-control-label"></label>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

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

                  <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" class="form-control text-sm" name="title" id="title" placeholder="Tiêu đề" value="{{ !empty($row->title) ? $row->title : '' }}"/>
                  </div>

                  @if (config($desc) === true)
                    <div class="form-group">
                      <label for="desc">
                        Mô tả:
                      </label>
                      <textarea class="form-control text-sm " name="desc" id="desc" rows="5" placeholder="Mô tả">{{ !empty($row->desc) ? $row->desc : '' }}</textarea>
                    </div>
                  @endif
                  @if (config($content) === true)
                    <div class="form-group">
                      <label for="content">
                        Nội dung:
                      </label>
                      <textarea class="form-control text-sm " name="content" id="content" rows="5" placeholder="Nội dung">{{ !empty($row->content) ? $row->content : '' }}</textarea>
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
