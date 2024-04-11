@extends('admin.index')

@section('title', 'Đăng ký nhận tin')

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
                        Đăng ký nhận tin
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        {!! Form::open([
            'name' => 'form-newsletter-list',
            'route' => ['admin.newsletter.sendmail'],
            'class' => ['form-newsletter-list', 'form-newsletter-request'],
            'files' => true,
        ]) !!}
        <div class="card-footer text-sm sticky-top">
            <button type="submit" name="send-mail" class="btn btn-sm bg-gradient-success text-white" id="send-email"
                title="Gửi email">
                <i class="fas fa-paper-plane mr-2"></i>Gửi email
            </button>
            <a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.newsletter.create') }}"
                title="Thêm mới">
                <i class="fas fa-plus mr-2"></i>Thêm mới
            </a>
            <a data-url="{{ route('admin.newsletter.destroy') }}"
                class="btn btn-sm bg-gradient-danger text-white delete-all-request" id="delete-all">
                <i class="far fa-trash-alt mr-2"></i>Xóa tất cả
            </a>
            <div class="form-inline form-search d-inline-block align-middle ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar text-sm keyword keyword-request" type="text"
                        placeholder="Tìm kiếm" name="keyword"
                        value="{{ !empty(request()->keyword) ? request()->keyword : '' }}"
                        data-url="{{ route('admin.newsletter.index') }}" />
                    <div class="input-group-append bg-primary rounded-right">
                        <button class="btn btn-navbar text-white btn-newsl-keyword">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline text-sm mb-0">
            <div class="card-header">
                <h3 class="card-title">
                    Danh sách Đăng ký nhận tin
                </h3>
                <p class="d-block text-secondary w-100 float-left mb-0 mt-1">
                    Chọn email sau đó kéo xuống dưới cùng danh sách này để có thể thiết lập nội dung email muốn gửi đi.
                </p>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-middle" width="5%">
                                <div class="custom-control custom-checkbox my-checkbox">
                                    <input type="checkbox" class="checkall custom-control-input" id="selectall-checkbox" />
                                    <label for="selectall-checkbox" class="custom-control-label"></label>
                                </div>
                            </th>
                            <th class="align-middle text-center" width="10%">STT</th>
                            @if (config('admin.message.newsletter.fullname') === true)
                                <th class="align-middle">Họ tên</th>
                            @endif
                            @if (config('admin.message.newsletter.email') === true)
                                <th class="align-middle">Email</th>
                            @endif
                            @if (config('admin.message.newsletter.phone') === true)
                                <th class="align-middle">Điện thoại</th>
                            @endif
                            @if (config('admin.message.newsletter.file_attach') === true)
                                <th class="align-middle">Download</th>
                            @endif
                            <th class="align-middle">Ngày tạo</th>
                            @if (config('admin.message.newsletter.confirm_status') === true)
                                <th class="align-middle">Tình trạng</th>
                            @endif
                            <th class="align-middle text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rows->total() > 0)
                            @foreach ($rows as $k => $row)
                                <tr>
                                    <td class="align-middle">
                                        <div class="custom-control custom-checkbox my-checkbox">
                                            <input type="checkbox" name="checkitem[]"
                                                class="checkitem custom-control-input select-checkbox"
                                                id="select-checkbox-{{ $row->id }}" value="{{ $row->id }}" />
                                            <label for="select-checkbox-{{ $row->id }}"
                                                class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number"
                                            class="update-num-newsletter form-control form-control-mini m-auto"
                                            min="0" value="{{ $row->num }}" data-token="{{ csrf_token() }}"
                                            data-id="{{ $row->id }}"
                                            data-url="{{ route('admin.newsletter.update_number') }}" />
                                    </td>

                                    @if (config('admin.message.newsletter.fullname') === true)
                                        <td class="align-middle">
                                            <a href="{{ route('admin.newsletter.show', [$row->id]) }}"
                                                class="text-dark text-break" title="{{ $row->fullname }}">
                                                {{ $row->fullname }}
                                            </a>
                                        </td>
                                    @endif

                                    @if (config('admin.message.newsletter.email') === true)
                                        <td class="align-middle">
                                            <a href="{{ route('admin.newsletter.show', [$row->id]) }}"
                                                class="text-dark text-break" title="{{ $row->email }}">
                                                {{ $row->email }}
                                            </a>
                                        </td>
                                    @endif

                                    @if (config('admin.message.newsletter.phone') === true)
                                        <td class="align-middle">
                                            {{ $row->phone }}
                                        </td>
                                    @endif

                                    @if (config('admin.message.newsletter.file_attach') === true)
                                        <td class="align-middle">
                                            @if (!empty($row->file_attach))
                                                <a class="btn btn-sm bg-gradient-primary text-white d-inline-block p-1 rounded"
                                                    href="{{ asset('upload/newsletter_file_attach/' . $row->file_attach) }}"
                                                    target="_blank" title="Download tập tin"><i
                                                        class="fas fa-download mr-2"></i>Download tập tin</a>
                                            @else
                                                <a class="bg-gradient-secondary text-white d-inline-block p-1 rounded"
                                                    href="#" title="Tập tin trống"><i
                                                        class="fas fa-download mr-2"></i>Tập tin trống</a>
                                            @endif

                                        </td>
                                    @endif

                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('H:i:s A d/m/Y') }}
                                    </td>

                                    @if (config('admin.message.newsletter.confirm_status') === true)
                                        <td class="align-middle">
                                            @if ($row->confirm_status == 1)
                                                Đã xem
                                            @elseif($row->confirm_status == 2)
                                                Đã liên hệ
                                            @elseif($row->confirm_status == 3)
                                                Đã thông báo
                                            @else
                                                Đang chờ duyệt...
                                            @endif
                                        </td>
                                    @endif

                                    <td class="align-middle text-center text-md text-nowrap">
                                        <a class="text-primary mr-2"
                                            href="{{ route('admin.newsletter.show', [$row->id]) }}" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="text-danger delete-row"
                                            data-url="{{ route('admin.newsletter.delete', ['id' => $row->id]) }}"
                                            title="Xóa" style="cursor: pointer">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12"><span class="text-danger">Danh sách đăng ký nhận tin trống</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {!! $rows->links() !!}

        <div class="card card-primary card-outline text-sm mb-0 mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    Gửi email đến danh sách được chọn
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="subject">
                        Tiêu đề:
                    </label>
                    <input type="text" name="subject" id="subject" class="form-control text-sm"
                        placeholder="Tiêu đề" />
                </div>
                @if (config('admin.message.newsletter.file') === true)
                    <div class="form-group">
                        <label class="d-inline-block align-middle mb-1 mr-2">
                            Upload tập tin:
                        </label>
                        <strong class="d-block mt-2 mb-2 text-sm">
                            {{ config('admin.message.newsletter.file_upload') }}
                        </strong>
                        <div class="custom-file my-custom-file">
                            <input type="file" class="custom-file-input" name="file" id="file" />
                            <label for="file" class="custom-file-label">
                                Chọn file
                            </label>
                        </div>
                    </div>
                @endif
                @if (config('admin.message.newsletter.content') === true)
                    <div class="form-group">
                        <label for="content">
                            Nội dung thông tin:
                        </label>
                        <textarea class="form-control {{ config('admin.message.newsletter.content_tiny') === true ? 'tiny' : '' }}"
                            name="content" id="content" rows="5" placeholder="Nội dung thông tin"></textarea>
                    </div>
                @endif
            </div>
        </div>
        {!! Form::close() !!}

        {!! Form::open(['name' => 'form_delete_row', 'class' => ['card__body', 'form_delete_row', 'd-none']]) !!}
        @method('DELETE')
        {!! Form::close() !!}
    </section>
@endsection
