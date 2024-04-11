@section('head')
  @parent
  @include('layouts.head')
@endsection

@section('seo')
  @parent
  @include('layouts.seo')
@endsection

@extends('welcome')
@section('title', !empty($titleMain) ? $titleMain : "Liên hệ")

@section('breadcrumbs')
  @parent
  @include('layouts.breadcrumb')
@endsection

@section('content')
  <div class="wrap-content padding-top-bottom">
    <div class="title-main">
      <span>
        {{!empty($titleMain) ? $titleMain : "Liên hệ"}}
      </span>
    </div>
    <div class="content-main">
      <div class="contact-article row">
        <div class="contact-text col-lg-6">
          {!! htmlspecialchars_decode($contact->content) !!}
        </div>
        {!! Form::open(['name' => 'form-contact', 'route' => ['contact.stored'], 'class' => ['contact-form','validation-contact','col-lg-6'], 'novalidate' => true]) !!}
          <div class="row-20 row">
            <div class="contact-input col-sm-6 col-20">
              <div class="form-floating-cus">
                <input type="text" name="dataContact[fullname]" class="form-control text-sm @error('fullname') is-invalid @enderror" id="fullname-contact" placeholder="Họ tên" value="{{session('fullname')}}">
              </div>
              @error('fullname')
                <span class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="contact-input col-sm-6 col-20">
              <div class="form-floating-cus">
                <input type="number" name="dataContact[phone]" class="form-control text-sm @error('phone') is-invalid @enderror" id="phone-contact" placeholder="Điện thoại" value="{{session('phone')}}">
              </div>
              @error('phone')
                <span class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="contact-input col-sm-6 col-20">
              <div class="form-floating-cus">
                <input type="text" class="form-control text-sm @error('address') is-invalid @enderror" id="address-contact" name="dataContact[address]" placeholder="Địa chỉ" value="{{session('address')}}"/>
              </div>
              @error('address')
                <span class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="contact-input col-sm-6 col-20">
              <div class="form-floating-cus">
                <input type="email" class="form-control text-sm @error('email') is-invalid @enderror" id="email-contact" name="dataContact[email]" placeholder="Email" value="{{session('email')}}"/>
              </div>
              @error('email')
                <span class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="contact-input">
            <div class="form-floating-cus">
              <input type="text" class="form-control text-sm @error('subject') is-invalid @enderror" id="subject-contact" name="dataContact[subject]" placeholder="Chủ đề" value="{{session('subject')}}"  />
            </div>
          </div>
          <div class="contact-input">
            <div class="form-floating-cus">
              <textarea class="form-control text-sm @error('content') is-invalid @enderror" id="content-contact" name="dataContact[content]" placeholder="Nội dung" required>{{session('content')}}</textarea>
            </div>
          </div>
          <input type="submit" class="btn btn-primary" name="submit-contact" value="Gửi" />
        {!! Form::close() !!}
      </div>
    </div>
    <div class="contact-map">
      @if (!$helper->isGoogleSpeed())
        {!! htmlspecialchars_decode($options->iframe_ggmap) !!}
      @endif
    </div>
  </div>
@endsection
