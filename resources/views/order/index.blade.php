@section('head')
  @parent
  @include('layouts.head')
@endsection

@section('seo')
  @parent
  @include('layouts.seo')
@endsection

@extends('welcome')

@section('title', $titleMain)

@section('breadcrumbs')
  @parent
  @include('layouts.breadcrumb')
@endsection

@section('content')
  <div class="wrap-content padding-top-bottom">
    {!! Form::open(['name' => 'form-cart', 'route' => ['order.checkout'], 'class' => ['form-cart'], 'novalidate' => true]) !!}
      <div class="wrap-cart">
        <div class="row">
          @if (count($carts) > 0)
            <div class="top-cart col-12 col-lg-7">
              <p class="title-cart">Giỏ hàng:</p>
              <div class="list-procart">
                <div class="procart procart-label">
                  <div class="row row-10">
                    <div class="pic-procart col-3 col-md-2 mg-col-10">
                      Hình ảnh
                    </div>
                    <div class="info-procart col-6 col-md-5 mg-col-10">
                      Tên sản phẩm
                    </div>
                    <div class="quantity-procart col-3 col-md-2 mg-col-10">
                      Số lượng
                    </div>
                    <div class="price-procart col-3 col-md-3 mg-col-10">
                      Thành tiền
                    </div>
                  </div>
                </div>
                @foreach ($carts as $k => $v)
                @php
                  $nameId = $helper->generateNameId($v->name, $v->id);
                @endphp
                  <div class="procart cart__main-{{ $v->rowId }} procart-abcfed">
                    <div class="procart-box">
                      <div class="row row-10">
                        <div class="pic-procart col-3 col-md-2 mg-col-10">
                          <a class="text-decoration-none scale-img" href="{{route('product',['slug'=>$nameId])}}" target="_blank" title="{{$v->name}}">
                            <img loading="lazy" src="{{ $v->options->photo ? asset('upload/product/'.$v->options->photo) : url('resources/images/noimage.png') }}" alt="{{!empty($v->name) ? $v->name : 'Noimage'}}"/>
                          </a>
                          <a class="del-procart remove__cart text-decoration-none" data-rowid="{{ $v->rowId }}">
                            <i class="fa fa-times-circle"></i>
                            <span>Xóa</span>
                          </a>
                        </div>
                        <div class="info-procart col-6 col-md-5 mg-col-10">
                          <h3 class="name-procart">
                            <a class="text-decoration-none" href="{{route('product',['slug'=>$nameId])}}" target="_blank" title="{{$v->name}}">
                              {{$v->name}}
                            </a>
                          </h3>
                        </div>
                        <div class="quantity-procart col-3 col-md-2 mg-col-10">
                          <div class="quantity-counter-procart quantity-counter-procart-abcfed">
                            <input type="number" class="qty__cart qty-{{ $v->id }} quantity-procart" min="1" data-price="{{ $v->price }}" data-token="{{ csrf_token() }}" rowId="{{ $v->rowId }}" data-id="{{ $v->id }}" value="{{$v->qty}}"/>
                          </div>
                        </div>
                        <div class="price-procart col-3 col-md-3 mg-col-10">
                          <p class="price-new-cart load-price-new-abcfed subtotal-{{$v->id}}">
                            {{ number_format($v->subtotal, 0,",", ".") }}đ
                          </p>
                          <p class="price-old-cart load-price-abcfed">
                            {{ number_format($v->options->regular_price, 0,",", ".") }}VND
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <a href="{{route('order.destroy')}}" class="cart-destroy" title="Xóa giỏ hàng">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                </svg> Xóa giỏ hàng
              </a>
              <div class="money-procart">
                <div class="total-procart">
                  <p>Tổng tiền:</p>
                  <strong class="total-price load-price-total text-danger">{{ number_format(Cart::total(), 0,",", ".") }} đ</strong>
                </div>
              </div>
            </div>
            <div class="bottom-cart col-12 col-lg-5">
              <div class="section-cart">
                @if (count($payments) > 0)
                    <p class="title-cart">
                        Hình thức thanh toán:
                    </p>
                    <div class="information-cart">
                        @foreach ($payments as $payment)
                        <div class="payments-cart form-check">
                            <input type="radio" class="form-check-input @error('payments') is-invalid @enderror" id="payments-{{$payment->id}}" name="payments" value="{{$payment->id}}" {{session('payments') == $payment->id ? 'checked' : ''}}>
                            <label class="payments-label form-check-label" for="payments-{{$payment->id}}" data-payments="{{$payment->id}}">
                                {{$payment->title}}
                            </label>
                            <div class="payments-info payments-info-{{$payment->id}} transition">
                                {!! htmlspecialchars_decode($payment->desc) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
                <p class="title-cart">Thông tin giao hàng:</p>
                <div class="information-cart">
                  <div class="row row-10">
                    <div class="input-cart col-md-6 mg-col-10">
                      <div class="form-floating-cus">
                        <input type="text" class="form-control text-sm @error('fullname') is-invalid @enderror" id="fullname" name="fullname" placeholder="Họ và tên" value="{{session('fullname')}}"/>
                      </div>
                      @error('fullname')
                        <small class="text-danger text-sm">
                            <strong>{{ $message }}</strong>
                        </small>
                       @enderror
                    </div>
                    <div class="input-cart col-md-6 mg-col-10">
                      <div class="form-floating-cus">
                        <input type="number" class="form-control text-sm @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Điện thoại" value="{{session('phone')}}"/>
                      </div>
                      @error('phone')
                        <small class="text-danger text-sm">
                            <strong>{{ $message }}</strong>
                        </small>
                       @enderror
                    </div>
                  </div>
                  <div class="input-cart">
                    <div class="form-floating-cus">
                      <input type="email" class="form-control text-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{session('email')}}"/>
                    </div>
                    @error('email')
                        <small class="text-danger text-sm">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                  </div>
                  <div class="row row-10">
                    <div class="input-cart col-md-4 mg-col-10 form-floating-cus">
                      <select class="select-city select2 form-select form-control text-sm @error('city') is-invalid @enderror" name="city">
                        <option value="">Tỉnh thành</option>
                        @foreach ($citys as $city)
                          <option value="{{$city->id_city}}" {{session('city') == $city->id_city ? 'selected' : ''}}>
                            {{$city->name_city}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="input-cart col-md-4 mg-col-10 form-floating-cus">
                      <select class="form-control select2 select-district filter-area form-select text-sm @error('district') is-invalid @enderror" name="district">
                        <option value="">Quận huyện</option>
                        @foreach ($districts as $district)
                          <option value="{{$district->id_district}}" {{session('district') == $city->id_city ? 'selected' : ''}}>
                            {{$district->name_district}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="input-cart col-md-4 mg-col-10 form-floating-cus">
                      <select class="select2 select-ward form-select form-control text-sm @error('ward') is-invalid @enderror" name="ward">
                        <option value="">Phường xã</option>
                        @foreach ($wards as $ward)
                          <option value="{{$ward->id_ward}}" {{session('ward') == $city->id_city ? 'selected' : ''}}>
                            {{$ward->name_ward}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="input-cart">
                    <div class="form-floating-cus">
                      <input type="text" class="form-control text-sm @error('address') is-invalid @enderror" id="address" name="address" placeholder="Địa chỉ" value="{{session('address')}}"/>
                    </div>
                    @error('address')
                        <small class="text-danger text-sm">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                  </div>
                  <div class="input-cart">
                    <div class="form-floating-cus">
                      <textarea class="form-control text-sm" id="requirements" name="requirements" placeholder="Yêu cầu khác (không bắt buộc)">{{session('requirements')}}</textarea>
                    </div>
                  </div>
                </div>
                <input type="submit" class="btn btn-primary btn-cart w-100" name="checkout" value="Thanh toán" />
              </div>
            </div>
          @else
            <a href="{{url('/')}}" class="empty-cart text-decoration-none d-block">
              <i class="fa-duotone fa-cart-xmark"></i>
              <p>Không tồn tại sản phẩm trong giỏ hàng</p>
              <span class="btn btn-warning">Về trang chủ</span>
            </a>
          @endif
        </div>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
