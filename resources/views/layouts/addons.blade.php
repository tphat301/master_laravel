<div>
  <a class="cart-fixed text-decoration-none" href="{{route('order.index')}}" title="Giỏ hàng">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag-dash-fill" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M6 9.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
    </svg>
    <span class="count-cart">{{Cart::count()}}</span>
  </a>
</div>
<a class="btn-zalo btn-frame text-decoration-none" target="_blank" href="https://zalo.me/{{preg_replace('/[^0-9]/', '', $options->zalo)}}">
  <div class="animated infinite zoomIn kenit-alo-circle"></div>
  <div class="animated infinite pulse kenit-alo-circle-fill"></div>
  <i><img class="loaded" src="{{ url('resources/images/zl.png') }}" alt="Zalo"></i>
</a>
<a class="btn-phone btn-frame text-decoration-none" href="tel:{{preg_replace('/[^0-9]/', '', $options->phone)}}">
  <div class="animated infinite zoomIn kenit-alo-circle"></div>
  <div class="animated infinite pulse kenit-alo-circle-fill"></div>
  <i><img class="lazy" alt="Hotline" src="{{ url('resources/images/hl.png') }}"></i>
</a>
<a id="button_back_to_top"></a>
