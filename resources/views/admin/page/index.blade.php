@php
    $route = 'admin.page.save';
    $name = 'admin.page.' . $type . '.name';
    $sloganConfig = 'admin.page.' . $type . '.slogan';
    $slugConfig = 'admin.page.' . $type . '.slug';
    $photo1Config = 'admin.page.' . $type . '.photo1';
    $thumb1Config = 'admin.page.' . $type . '.thumb1';
    $photo2Config = 'admin.page.' . $type . '.photo2';
    $thumb2Config = 'admin.page.' . $type . '.thumb2';
    $photo3Config = 'admin.page.' . $type . '.photo3';
    $thumb3Config = 'admin.page.' . $type . '.thumb3';
    $photo4Config = 'admin.page.' . $type . '.photo4';
    $thumb4Config = 'admin.page.' . $type . '.thumb4';
    $statusConfig = 'admin.page.' . $type . '.status';
    $titleConfig = 'admin.page.' . $type . '.title';
    $descriptionConfig = 'admin.page.' . $type . '.desc';
    $descriptionTinyConfig = 'admin.page.' . $type . '.desc_tiny';
    $contentConfig = 'admin.page.' . $type . '.content';
    $contentTinyConfig = 'admin.page.' . $type . '.content_tiny';
    $seoConfig = 'admin.page.' . $type . '.seo';
    $titleSeoConfig = 'admin.page.' . $type . '.seo_title';
    $keywordsSeoConfig = 'admin.page.' . $type . '.seo_keyword';
    $descriptionSeoConfig = 'admin.page.' . $type . '.seo_desc';
    $deletePhoto = 'admin.page.delete_photo';
    $noimage = 'resources/images/noimage.png';
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
                        {{ config($name) }}
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route($route, ['type' => $type, 'id' => !empty($row->id) ? $row->id : '']) }}"
            class="validation-form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-footer text-sm sticky-top">
                <button type="submit" name="{{ !empty($row) ? 'update' : 'save' }}"
                    class="btn btn-sm bg-gradient-primary submit-check">
                    <i class="far fa-save mr-2"></i>Lưu
                </button>
                @if ($row)
                    <a href="{{ route('admin.page.remake', ['type' => $type, 'id' => $row->id, 'hash' => $row->hash]) }}"
                        class="btn btn-sm bg-gradient-secondary">
                        <i class="fas fa-redo mr-2"></i>Làm mới
                    </a>
                @endif
            </div>

            <div class="row">
                <div class="col-xl-8">
                    @if (config($slugConfig) === true)
                        <div class="card card-primary card-outline text-sm">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Đường dẫn
                                </h3>
                                <span class="pl-2 text-danger">
                                    (Vui lòng không nhập trùng tiêu đề)
                                </span>
                            </div>
                            <div class="card-body card-slug">
                                <div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="tabs-lang" data-toggle="pill"
                                                    href="javscript:void()" role="tab" aria-selected="true">Tiếng
                                                    Việt</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                            <div class="tab-pane fade show active" id="tabs-sluglang-vi" role="tabpanel"
                                                aria-labelledby="tabs-lang">
                                                <div class="form-gourp mb-0">
                                                    <label class="d-block">
                                                        Đường dẫn mẫu:<span class="pl-2 font-weight-normal"
                                                            id="slugurlpreviewvi"><strong class="text-info"></strong></span>
                                                    </label>
                                                    <input type="text"
                                                        class="slug-seo form-control slug-input no-validate text-sm"
                                                        name="slug" id="slug" placeholder="Đường dẫn mẫu"
                                                        value="{{ !empty($row->slug) ? $row->slug : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
                                            <a class="nav-link active" id="tabs-lang" data-toggle="pill"
                                                href="javscript:void()" role="tab" aria-controls="tabs-lang-vi"
                                                aria-selected="true">
                                                Tiếng Việt
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body card-article">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="tabs-lang-vi" role="tabpanel"
                                            aria-labelledby="tabs-lang">

                                            @if (config($sloganConfig) === true)
                                                <div class="form-group">
                                                    <label for="slogan">
                                                        Slogan:
                                                    </label>
                                                    <input type="text" class="form-control text-sm" name="slogan"
                                                        id="slogan" placeholder="Slogan"
                                                        value="{{ !empty($row->slogan) ? $row->slogan : '' }}" />
                                                </div>
                                            @endif
                                            @if (config($titleConfig) === true)
                                                <div class="form-group">
                                                    <label for="title">
                                                        Tiêu đề:
                                                    </label>
                                                    <input type="text" class="for-seo form-control text-sm"
                                                        name="title" id="title" placeholder="Tiêu đề"
                                                        value="{{ !empty($row->title) ? $row->title : '' }}" required />
                                                    @error('title')
                                                        <small class="text-sm text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if (config($descriptionConfig) === true)
                                                <div class="form-group">
                                                    <label for="desc">
                                                        Mô tả:
                                                    </label>
                                                    <textarea name="desc" class="form-control text-sm {{ config($descriptionTinyConfig) === true ? 'tiny' : '' }}"
                                                        id="desc" cols="30" rows="10" placeholder="Mô tả">{!! !empty($row->desc) ? $row->desc : '' !!}</textarea>
                                                </div>
                                            @endif

                                            @if (config($contentConfig) === true)
                                                <div class="form-group">
                                                    <label for="content">
                                                        Nội dung:
                                                    </label>
                                                    <textarea name="content" class="form-control text-sm {{ config($contentTinyConfig) === true ? 'tiny' : '' }}"
                                                        id="content" cols="30" rows="10" placeholder="Nội dung">{!! !empty($row->content) ? $row->content : '' !!}</textarea>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
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
                                    $status = !empty($row->status) ? explode(',', $row->status) : [];
                                @endphp
                                @foreach (config($statusConfig) as $key => $value)
                                    <div class="form-group d-inline-block mb-2 mr-2">
                                        <label for="{{ $key }}-checkbox"
                                            class="d-inline-block align-middle mb-0 mr-2">{{ $value }}:</label>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle">
                                            <input type="checkbox"
                                                class="custom-control-input {{ $key }}-checkbox" name="status[]"
                                                id="{{ $key }}-checkbox" value="{{ $key }}"
                                                {{ in_array($key, $status) ? 'checked' : '' }} />
                                            <label for="{{ $key }}-checkbox"
                                                class="custom-control-label"></label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Photo 1 --}}
                    @if (config($photo1Config) === true)
                        <div class="card card-primary card-outline text-sm">
                            <div class="card-header">
                                <h3 class="card-title">Hình ảnh 1</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="photoUpload-zone">
                                    <div class="photoUpload-detail" id="photoUpload-preview1">
                                        @if (!empty($row->photo1))
                                            <img class="rounded img-preview img-fluid"
                                                src="{{ url("public/upload/page/$row->photo1") }}"
                                                alt="{{ $row->photo1 }}" />
                                            <a class="delete-photo"
                                                href="{{ route($deletePhoto, ['type' => $type, 'id' => $row->id, 'action' => 'photo1']) }}"
                                                style="cursor: pointer" title="Xóa hình ảnh">
                                                <i class="far fa-trash-alt text-white"></i>
                                            </a>
                                        @else
                                            <img class="rounded img-preview img-fluid" src="{{ url($noimage) }}"
                                                alt="Hình ảnh 1" />
                                        @endif
                                    </div>
                                    <label class="photoUpload-file" id="photo-zone1" for="file-zone1">
                                        <input type="file" name="photo1" id="file-zone1" />
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
                                        <p class="photoUpload-or">hoặc</p>
                                        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
                                    </label>
                                    <div class="photoUpload-dimension">
                                        {{ config($thumb1Config) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Photo 2 --}}
                    @if (config($photo2Config) === true)
                        <div class="card card-primary card-outline text-sm">
                            <div class="card-header">
                                <h3 class="card-title">Hình ảnh 2</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="photoUpload-zone">
                                    <div class="photoUpload-detail" id="photoUpload-preview2">
                                        @if (!empty($row->photo2))
                                            <img class="rounded img-preview img-fluid"
                                                src="{{ url("public/upload/page/$row->photo2") }}"
                                                alt="{{ $row->photo2 }}" />
                                            <a class="delete-photo"
                                                href="{{ route($deletePhoto, ['id' => $row->id, 'action' => 'photo2']) }}"
                                                style="cursor: pointer" title="Xóa hình ảnh">
                                                <i class="far fa-trash-alt text-white"></i>
                                            </a>
                                        @else
                                            <img class="rounded img-preview img-fluid" src="{{ url($noimage) }}"
                                                alt="Hình ảnh 1" />
                                        @endif
                                    </div>
                                    <label class="photoUpload-file" id="photo-zone2" for="file-zone2">
                                        <input type="file" name="photo2" id="file-zone2" />
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
                                        <p class="photoUpload-or">hoặc</p>
                                        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
                                    </label>
                                    <div class="photoUpload-dimension">
                                        {{ config($thumb2Config) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Photo 3 --}}
                    @if (config($photo3Config) === true)
                        <div class="card card-primary card-outline text-sm">
                            <div class="card-header">
                                <h3 class="card-title">Hình ảnh 3</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="photoUpload-zone">
                                    <div class="photoUpload-detail" id="photoUpload-preview3">
                                        @if (!empty($row->photo3))
                                            <img class="rounded img-preview img-fluid"
                                                src="{{ url("public/upload/page/$row->photo3") }}"
                                                alt="{{ $row->photo3 }}" />
                                            <a class="delete-photo"
                                                href="{{ route($deletePhoto, ['id' => $row->id, 'action' => 'photo3']) }}"
                                                style="cursor: pointer" title="Xóa hình ảnh">
                                                <i class="far fa-trash-alt text-white"></i>
                                            </a>
                                        @else
                                            <img class="rounded img-preview img-fluid" src="{{ url($noimage) }}"
                                                alt="Hình ảnh 1" />
                                        @endif
                                    </div>
                                    <label class="photoUpload-file" id="photo-zone3" for="file-zone3">
                                        <input type="file" name="photo3" id="file-zone3" />
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
                                        <p class="photoUpload-or">hoặc</p>
                                        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
                                    </label>
                                    <div class="photoUpload-dimension">
                                        {{ config($thumb3Config) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Photo 4 --}}
                    @if (config($photo4Config) === true)
                        <div class="card card-primary card-outline text-sm">
                            <div class="card-header">
                                <h3 class="card-title">Hình ảnh 4</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="photoUpload-zone">
                                    <div class="photoUpload-detail" id="photoUpload-preview4">
                                        @if (!empty($row->photo4))
                                            <img class="rounded img-preview img-fluid"
                                                src="{{ url("public/upload/page/$row->photo4") }}"
                                                alt="{{ $row->photo4 }}" />
                                            <a class="delete-photo"
                                                href="{{ route($deletePhoto, ['id' => $row->id, 'action' => 'photo4']) }}"
                                                style="cursor: pointer" title="Xóa hình ảnh">
                                                <i class="far fa-trash-alt text-white"></i>
                                            </a>
                                        @else
                                            <img class="rounded img-preview img-fluid" src="{{ url($noimage) }}"
                                                alt="Hình ảnh 1" />
                                        @endif
                                    </div>
                                    <label class="photoUpload-file" id="photo-zone4" for="file-zone4">
                                        <input type="file" name="photo4" id="file-zone4" />
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
                                        <p class="photoUpload-or">hoặc</p>
                                        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
                                    </label>
                                    <div class="photoUpload-dimension">
                                        {{ config($thumb4Config) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SEO --}}
            @if (config($seoConfig) === true)
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
                                            <a class="nav-link active" id="tabs-lang" data-toggle="pill"
                                                href="#tabs-seolang-vi" role="tab" aria-controls="tabs-seolang-vi"
                                                aria-selected="true">SEO</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                        <div class="tab-pane fade show active" id="tabs-seolang-vi" role="tabpanel"
                                            aria-labelledby="tabs-lang">

                                            @if (config($titleSeoConfig) === true)
                                                <div class="form-group">
                                                    <div class="label-seo">
                                                        <label for="titlevi">SEO Title:</label>
                                                    </div>
                                                    <input type="text" class="form-control check-seo title-seo text-sm"
                                                        name="title_seo" id="title_seo" placeholder="SEO Title"
                                                        value="{{ !empty($rowSeo->title_seo) ? $rowSeo->title_seo : '' }}" />
                                                </div>
                                            @endif

                                            @if (config($keywordsSeoConfig) === true)
                                                <div class="form-group">
                                                    <div class="label-seo">
                                                        <label for="keywords_seo">SEO Keywords (tối đa 70 ký tự):</label>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control check-seo keywords-seo text-sm"
                                                        name="keywords" id="keywords_seo" placeholder="SEO Keywords"
                                                        value="{{ !empty($rowSeo->keywords) ? $rowSeo->keywords : '' }}" />
                                                </div>
                                            @endif

                                            @if (config($descriptionSeoConfig) === true)
                                                <div class="form-group">
                                                    <div class="label-seo">
                                                        <label for="description_seo">SEO Description (tối đa 160 ký
                                                            tự):</label>
                                                    </div>
                                                    <textarea class="form-control check-seo description-seo text-sm" name="description_seo" id="description_seo"
                                                        rows="5" placeholder="SEO Description">{!! !empty($rowSeo->description_seo) ? $rowSeo->description_seo : '' !!}</textarea>
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
        </form>
    </section>
@endsection
