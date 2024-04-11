@extends('admin.index')

@section('title', $row->title_tag)

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
            {{ $row->title_tag }}
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="content">
    {!! Form::open(['name' => 'form-tag-product-detail', 'route' => ['admin.tag_product.update', $row->id_tag], 'class' => ['form-product-detail'], 'files' => true]) !!}
    @method('PUT')
      <div class="card-footer text-sm sticky-top">
        <button type="submit" name="save" class="btn btn-sm bg-gradient-primary submit-check">
          <i class="far fa-save mr-2"></i>Lưu
        </button>
        <a class="btn btn-sm bg-gradient-danger" href="{{ route('admin.tag_product') }}" title="Thoát">
          <i class="fas fa-sign-out-alt mr-2"></i>Thoát
        </a>
      </div>

      <div class="row">
        <div class="col-xl-8">
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
                      <a class="nav-link active">
                        Tiếng Việt
                      </a>
                    </li>
                  </ul>
                </div>

                <div class="card-body card-article">
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-lang-vi" role="tabpanel" aria-labelledby="tabs-lang">

                      <div class="form-group">
                        <label for="title">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" name="title" id="title" value="{{ $row->title_tag }}" placeholder="Tiêu đề"/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4">
          {{-- Info --}}
          <div class="card card-primary card-outline text-sm">
            <div class="card-header">
              <h3 class="card-title">Thông tin</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            {{-- Status --}}
            <div class="card-body">
              <div class="form-group">
                @php
                  $status = !empty($row->status_tag) ? explode(",", $row->status_tag) : [];
                @endphp
                @foreach (config('admin.product.tag.status') as $key => $value)
                  <div class="form-group d-inline-block mb-2 mr-2">
                    <label for="{{$key}}-checkbox" class="d-inline-block align-middle mb-0 mr-2">{{$value}}:</label>
                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                      <input type="checkbox" class="custom-control-input {{$key}}-checkbox" name="status[]" id="{{$key}}-checkbox" value="{{$key}}" {{ in_array($key, $status) ? 'checked' : '' }}/>
                      <label for="{{$key}}-checkbox" class="custom-control-label"></label>
                    </div>
                  </div>
                @endforeach
              </div>

              <div class="row">
                {{-- Number --}}
                <div class="form-group col-md-6">
                  <label for="num" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                  <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="num" id="num" placeholder="Số thứ tự" value="{{ $row->num_tag }}"/>
                </div>
              </div>
            </div>
          </div>

          {{-- Photo --}}
          @if (config('admin.product.tag.photo') === true)
            <div class="card card-primary card-outline text-sm">
              <div class="card-header">
                <h3 class="card-title">Hình ảnh</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="photoUpload-zone">
                  <div class="photoUpload-detail" id="photoUpload-preview1">
                    @if (!empty($row->photo))
                      <img class="rounded img-preview img-fluid" src="{{ url("public/upload/tag_product/$row->photo")  }}" alt="{{ $row->title_tag }}"/>
                      <a class="delete-photo" href="{{ route('admin.tag_product.delete_photo', ['id' => $row->id_tag, 'action' => 'photo']) }}" style="cursor: pointer" title="Xóa hình ảnh">
                        <i class="far fa-trash-alt text-white"></i>
                      </a>
                    @else
                      <img class="rounded img-preview img-fluid" src="{{ url("resources/images/noimage.png")  }}" alt="{{ $row->title_tag }}"/>
                    @endif
                  </div>
                  <label class="photoUpload-file" id="photo-zone1" for="file-zone1">
                    <input type="file" name="photo" id="file-zone1"/>
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
                    <p class="photoUpload-or">hoặc</p>
                    <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
                  </label>
                  <div class="photoUpload-dimension">
                    {{ config('admin.product.tag.thumb') }}
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>

      {{-- SEO --}}
      @if (config('admin.product.tag.seo') === true)
        <div class="card card-primary card-outline text-sm">
          <div class="card-header">
            <h3 class="card-title">Nội dung SEO</h3>
            <div class="build-seo bg-gradient-success py-2 px-3 rounded  float-right submit-check">
              <i class="far fa-save mr-2"></i>Tạo SEO
            </div>
          </div>
          <div class="card-body">
            <div class="card-seo">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="tabs-lang" data-toggle="pill" href="#tabs-seolang-vi" role="tab" aria-controls="tabs-seolang-vi" aria-selected="true">SEO</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                    <div class="tab-pane fade show active" id="tabs-seolang-vi" role="tabpanel" aria-labelledby="tabs-lang">

                      @if (config('admin.product.tag.seo_title') === true)
                        <div class="form-group">
                          <div class="label-seo">
                            <label for="titlevi">SEO Title:</label>
                          </div>
                          <input type="text" class="form-control check-seo title-seo text-sm" name="title_seo" id="title_seo" placeholder="SEO Title" value="{{ !empty($rowSeo->title_seo) ? $rowSeo->title_seo : '' }}"/>
                        </div>
                      @endif

                      @if (config('admin.product.tag.seo_keyword') === true)
                        <div class="form-group">
                          <div class="label-seo">
                            <label for="keywords_seo">SEO Keywords (tối đa 70 ký tự):</label>
                          </div>
                          <input type="text" class="form-control check-seo keywords-seo text-sm" name="keywords" id="keywords_seo" placeholder="SEO Keywords" value="{{ !empty($rowSeo->keywords) ? $rowSeo->keywords : '' }}"/>
                        </div>
                      @endif

                      @if (config('admin.product.tag.seo_desc') === true)
                        <div class="form-group">
                          <div class="label-seo">
                            <label for="description_seo">SEO Description (tối đa 160 ký tự):</label>
                          </div>
                          <textarea class="form-control check-seo description-seo text-sm" name="description_seo" id="description_seo" rows="5" placeholder="SEO Description">{!! !empty($rowSeo->description_seo) ? $rowSeo->description_seo : '' !!}</textarea>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    {!! Form::close() !!}
  </section>
@endsection
