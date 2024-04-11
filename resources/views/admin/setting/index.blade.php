@extends('admin.index')

@section('title', config('admin.setting.name'))

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
                        {{ config('admin.setting.name') }}
                    </li>
                </ol>
            </div>
        </div>
    </section>
    <section class="content">
        <form action="{{ route('admin.setting.save', ['id' => !empty($row->id) ? $row->id : '']) }}" class="validation-form"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-footer text-sm sticky-top">
                <button type="submit" name="{{ !empty($row) ? 'update' : 'save' }}"
                    class="btn btn-sm bg-gradient-primary submit-check">
                    <i class="far fa-save mr-2"></i>Lưu
                </button>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">{{ config('admin.setting.name') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="tabs-lang" data-toggle="pill"
                                                href="javascript:void()" role="tab" aria-selected="true">Tiếng Việt</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body card-article">
                                    <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="tabs-lang">

                                            @if (config('admin.setting.title') === true)
                                                <div class="form-group">
                                                    <label for="title">Tên công ty:</label>
                                                    <input type="text" class="form-control text-sm" name="title"
                                                        id="title" value="{{ !empty($row->title) ? $row->title : '' }}"
                                                        placeholder="Tên công ty" />
                                                    @error('title')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if (config('admin.setting.address') === true)
                                                <div class="form-group">
                                                    <label for="address">Địa chỉ:</label>
                                                    <input type="text" class="form-control text-sm" name="address"
                                                        id="address"
                                                        value="{{ !empty($row->address) ? $row->address : '' }}"
                                                        placeholder="Địa chỉ" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if (config('admin.setting.worktime') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="worktime">Thời gian làm việc:</label>
                                        <input type="text" class="form-control text-sm" name="options[worktime]"
                                            id="worktime" placeholder="Thời gian làm việc"
                                            value="{{ !empty($options->worktime) ? $options->worktime : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.email') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control text-sm" name="options[email]"
                                            id="email" placeholder="Email"
                                            value="{{ !empty($options->email) ? $options->email : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.hotline') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="hotline">Hotline:</label>
                                        <input type="number" class="form-control text-sm" name="options[hotline]"
                                            id="hotline" placeholder="Hotline"
                                            value="{{ !empty($options->hotline) ? $options->hotline : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.phone') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="phone">Điện thoại:</label>
                                        <input type="number" class="form-control text-sm" name="options[phone]"
                                            id="phone" placeholder="Điện thoại"
                                            value="{{ !empty($options->phone) ? $options->phone : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.zalo') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="zalo">Zalo:</label>
                                        <input type="number" class="form-control text-sm" name="options[zalo]"
                                            id="zalo" placeholder="Zalo"
                                            value="{{ !empty($options->zalo) ? $options->zalo : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.oaidzalo') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="oaidzalo">OAID Zalo::</label>
                                        <input type="text" class="form-control text-sm" name="options[oaidzalo]"
                                            id="oaidzalo" placeholder="OAID Zalo:"
                                            value="{{ !empty($options->oaidzalo) ? $options->oaidzalo : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.website') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="website">Website:</label>
                                        <input type="text" class="form-control text-sm" name="options[website]"
                                            id="website" placeholder="Website"
                                            value="{{ !empty($options->website) ? $options->website : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.fanpage_facebook') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="fanpage">Fanpage:</label>
                                        <input type="text" class="form-control text-sm" name="options[fanpage]"
                                            id="fanpage" placeholder="Fanpage"
                                            value="{{ !empty($options->fanpage) ? $options->fanpage : '' }}" />
                                    </div>
                                @endif

                                @if (config('admin.setting.link_ggmap') === true)
                                    <div class="form-group col-md-4 col-sm-6">
                                        <label for="link_ggmap">Link google map:</label>
                                        <input type="text" class="form-control text-sm" name="options[link_ggmap]"
                                            id="link_ggmap" placeholder="Link google map"
                                            value="{{ !empty($options->link_ggmap) ? $options->link_ggmap : '' }}" />
                                    </div>
                                @endif
                            </div>
                            @if (config('admin.setting.iframe_ggmap') === true)
                                <div class="form-group">
                                    <label for="iframe_ggmap">Tọa độ google map iframe: <a
                                            class="text-sm font-weight-normal ml-1" href="https://www.google.com/maps"
                                            target="_blank" title="Lấy mã nhúng google map">(Lấy mã nhúng)</a></label>
                                    <textarea class="form-control text-sm" name="options[iframe_ggmap]" id="iframe_ggmap" rows="5"
                                        placeholder="Iframe google map:">{!! !empty($options->iframe_ggmap) ? $options->iframe_ggmap : '' !!}</textarea>
                                </div>
                            @endif

                            @if (config('admin.setting.mastertool') === true)
                                <div class="form-group">
                                    <label for="mastertool">
                                        Google Webmaster Tool:
                                    </label>
                                    <textarea class="form-control text-sm" name="mastertool" id="mastertool" rows="5"
                                        placeholder="Google Webmaster Tool:">{!! !empty($row->mastertool) ? $row->mastertool : '' !!}</textarea>
                                </div>
                            @endif

                            @if (config('admin.setting.analytics') === true)
                                <div class="form-group">
                                    <label for="analytics">
                                        Google Analytic:
                                    </label>
                                    <textarea class="form-control text-sm" name="analytics" id="analytics" rows="5"
                                        placeholder="Google Analytic:">{!! !empty($row->analytics) ? $row->analytics : '' !!}</textarea>
                                </div>
                            @endif

                            @if (config('admin.setting.headjs') === true)
                                <div class="form-group">
                                    <label for="headjs">
                                        Head JS:
                                    </label>
                                    <textarea class="form-control text-sm" name="headjs" id="headjs" rows="5" placeholder="Head JS:">{!! !empty($row->headjs) ? $row->headjs : '' !!}</textarea>
                                </div>
                            @endif

                            @if (config('admin.setting.bodyjs') === true)
                                <div class="form-group">
                                    <label for="bodyjs">
                                        Body JS:
                                    </label>
                                    <textarea class="form-control text-sm" name="bodyjs" id="bodyjs" rows="5" placeholder="Body JS:">{!! !empty($row->bodyjs) ? $row->bodyjs : '' !!}</textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
