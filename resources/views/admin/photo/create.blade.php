@php
  $route = "admin.photo.".$type.".save";
  $loop = "admin.photo.".$type.".loop";
  $name = "admin.photo.".$type.".name";
  $thumb = "admin.photo.".$type.".thumb";
  $link = "admin.photo.".$type.".link";
  $photoConfig = "admin.photo.".$type.".photo";
  $status = "admin.photo.".$type.".status";
  $desc = "admin.photo.".$type.".desc";
  $content = "admin.photo.".$type.".content";
  $noimage = "resources/images/noimage.png";
  $totalTempleate = config($loop);
  $direct = "admin.photo.".$type.".index";
@endphp
@extends('admin.index')

@section('title', 'Thêm '. config($name))

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
            Thêm {{config($name)}}
          </li>
        </ol>
      </div>
    </div>
  </section>
  <section class="content">
    {!! Form::open(['name' => 'form-photo', 'route' => [$route, $type], 'class' => ['form-photo'], 'files' => true]) !!}
      <div class="card-footer text-sm sticky-top">
        <button type="submit" name="save" class="btn btn-sm bg-gradient-primary submit-check">
          <i class="far fa-save mr-2"></i>Lưu
        </button>
        <a class="btn btn-sm bg-gradient-danger" href="{{ route($direct) }}" title="Thoát">
          <i class="fas fa-sign-out-alt mr-2"></i>Thoát
        </a>
      </div>
      @if ($totalTempleate > 1)
        @for ($i = 1; $i <= $totalTempleate; $i++)
          <div class="card card-primary card-outline text-sm">
            <div class="card-header">
              <h3 class="card-title">
                {{config($name)}}: {{$i}}
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
                      <div class="upload-file-image rounded mb-3">
                        <img class="rounded img-upload" id="img-preview-{{$i}}" src="{{ url($noimage) }}" alt="No Image"/>
                      </div>
                      <div class="custom-file my-custom-file">
                        <input type="file" class="custom-file-input" name="file{{$i}}" id="file{{$i}}" onchange="document.getElementById('img-preview-{{$i}}').src = window.URL.createObjectURL(this.files[0])"/>
                        <label class="custom-file-label mb-0" data-browse="Chọn" for="file{{$i}}">
                          Chọn file
                        </label>
                      </div>
                    </label>
                    <strong class="d-block text-sm">
                      {{config($thumb)}}
                    </strong>
                  </div>
                  @error("file{{$i}}")
                    <strong class="text-danger">{{ $message }}</strong>
                  @enderror
                </div>
              @endif
              @if (config($link) === true)
                <div class="form-group">
                  <label for="link{{$i}}">
                    Link:
                  </label>
                  <input type="text" class="form-control text-sm" name="dataMultiple[{{$i}}][link]" id="link{{$i}}" placeholder="Link"/>
                </div>
              @endif

              @if ($status)
                <div class="form-group">
                  @foreach (config($status) as $key => $value)
                    <div class="form-group d-inline-block mb-2 mr-2">
                      <label for="{{$key}}-checkbox-{{$i}}" class="d-inline-block align-middle mb-0 mr-2">
                        {{$value}}:
                      </label>
                      <div class="custom-control custom-checkbox d-inline-block align-middle">
                        <input type="checkbox" class="custom-control-input {{$key}}-checkbox-{{$i}}" name="dataMultiple[{{$i}}][status][]" id="{{$key}}-checkbox-{{$i}}" value="{{$key}}"/>
                        <label for="{{$key}}-checkbox-{{$i}}" class="custom-control-label"></label>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              <div class="form-group">
                <label for="num{{$i}}" class="d-inline-block align-middle mb-0 mr-2">
                  Số thứ tự:
                </label>
                <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="dataMultiple[{{$i}}][num]" id="num{{$i}}" placeholder="Số thứ tự"/>
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
                      <div class="form-group">
                        <label for="title{{$i}}">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" name="dataMultiple[{{$i}}][title]" id="title{{$i}}" placeholder="Tiêu đề" value=""/>
                      </div>
                      @if (config($desc) === true)
                        <div class="form-group">
                          <label for="desc{{$i}}">
                            Mô tả:
                          </label>
                          <textarea class="form-control text-sm " name="dataMultiple[{{$i}}][desc]" id="desc{{$i}}" rows="5" placeholder="Mô tả"></textarea>
                        </div>
                      @endif
                      @if (config($content) === true)
                        <div class="form-group">
                          <label for="content{{$i}}">
                            Nội dung:
                          </label>
                          <textarea class="form-control text-sm " name="dataMultiple[{{$i}}][content]" id="content{{$i}}" rows="5" placeholder="Nội dung"></textarea>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endfor
      @endif
    {!! Form::close() !!}
  </section>
@endsection
