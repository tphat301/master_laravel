@extends('admin.index')

@section('title', 'Thông tin tài khoản')

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
                        Thông tin tài khoản
                    </li>
                </ol>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">
                    Thông tin admin
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-xl-4 col-lg-6 col-md-6">
                        <label for="username">
                            Tài khoản:
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control text-sm" name="username" id="username"
                            placeholder="Tài khoản" value="{{ Auth::guard('admin')->user()->username }}" readonly />
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6">
                        <label for="email">
                            Email:
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control text-sm" name="email" id="email"
                            placeholder="Tài khoản" value="{{ Auth::guard('admin')->user()->email }}" readonly />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
