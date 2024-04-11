@if (count($slideshow) > 0)
  <div class="slideshow">
    <div class="owl-page owl-carousel owl-theme" data-xsm-items="1:0" data-sm-items="1:0" data-md-items="1:0" data-lg-items="1:0" data-xlg-items="1:0" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="0" data-touchdrag="0" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="5000" data-dots="0" data-animations="animate__fadeInDown, animate__backInUp, animate__rollIn, animate__backInRight, animate__zoomInUp, animate__backInLeft, animate__rotateInDownLeft, animate__backInDown, animate__zoomInDown, animate__fadeInUp, animate__zoomIn" data-nav="1" data-navtext="<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-left' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='5' y1='12' x2='9' y2='16' /><line x1='5' y1='12' x2='9' y2='8' /></svg>|<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-right' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='15' y1='16' x2='19' y2='12' /><line x1='15' y1='8' x2='19' y2='12' /></svg>" data-navcontainer=".control-slideshow">
      @foreach ($slideshow as $v)
        <div class="slideshow-item" owl-item-animation>
          <a class="slideshow-image" href="{{ $v->link }}" target="_blank" title="">
            @if (!empty($v->photo))
              <picture>
                <source media="(max-width: 500px)" srcset="{{ asset('upload/photo/'.$v->photo) }}">
                <img src="{{ asset('upload/photo/'.$v->photo) }}" alt="{{ $v->title }}"/>
              </picture>
            @else
              <picture>
                <source media="(max-width: 500px)" srcset="{{ url('resources/images/noimage.png') }}">
                <img src="{{ url('resources/images/noimage.png') }}" alt="Slideshow"/>
              </picture>
            @endif
          </a>
        </div>
      @endforeach
    </div>
    <div class="control-slideshow control-owl transition"></div>
  </div>
@endif
