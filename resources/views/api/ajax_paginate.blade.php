@foreach ($prdHot as $v)
  @php
    $nameId = $helper->generateNameId($v->title, $v->id);
  @endphp
  <div class="prdhot-item">
    <div class="prdhot-img">
      <a href="{{route('product',['slug'=>$nameId])}}" class="scale-img" title="{!!$v->title!!}">
        <img loading="lazy" class="w-100" src="{{!empty($v->photo1) ? asset('upload/product/'.$v->photo1) : url('resources/images/noimage.png')}}" alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}"/>
      </a>
    </div>
    <h3 class="prdhot-name">
      <a href="{{route('product',['slug'=>$nameId])}}" class="text-split" title="{!!$v->title!!}">
        {!! $v->title !!}
      </a>
    </h3>
    <p class="prdhot-price">
      @if (!empty($v->discount))
        <span class="sale-price">
          {{ number_format($v->sale_price, 0,",",".").'đ' }}
        </span>
        <span class="regular-price">
          {{ number_format($v->regular_price, 0,",",".").'đ' }}
        </span>
        <span class="discount">
          {{'-'.$v->discount.'%'}}
        </span>
      @else
        <span class="sale-price">{{!empty($v->sale_price) ? number_format($v->sale_price, 0,",",".") : 'Liên hệ'}}</span>
      @endif
    </p>
    @if (!empty($v->sale_price))
      <p class="prdhot-cart">
        <a href="{{route('order.add',['id' => $v->id])}}" class="btn-cart text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z"/>
          </svg>
        </a>
      </p>
    @endif
  </div>
@endforeach
