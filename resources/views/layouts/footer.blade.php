<div class="footer">
  <div class="footer-article">
    <div class="wrap-content padding-top-bottom d-flex flex-wrap justify-content-between">
      <div class="footer-news">
        <p class="name-company">
          {{$footer->title}}
        </p>
        <div class="footer-info">
          {!! htmlspecialchars_decode($footer->content) !!}
        </div>
        @if (count($socialFooter) > 0)
          <ul class="social social-footer list-unstyled d-flex align-items-center ">
            @foreach ($socialFooter as $k => $v)
              <li class="d-inline-block align-top">
                <a href="{{$v->link}}" class="me-2" target="_blank" title="{{$v->title}}">
                  @if (!empty($v->photo))
                    <img loading="lazy" class="w-100" src="{{asset('upload/photo/'.$v->photo)}}" alt="{!!$v->title!!}"/>
                  @else
                    <img loading="lazy" class="w-100" width="35" height="35" src="{{url('resources/images/noimage.png')}}" alt="Noimage"/>
                  @endif
                </a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
      @if (count($policy) > 0)
        <div class="footer-news">
          <p class="footer-title">
            Chính sách hỗ trợ
          </p>
          <ul class="footer-ul d-flex flex-wrap justify-content-between">
            @foreach ($policy as $v)
              @php
                $nameId = $helper->generateNameId($v->title, $v->id);
              @endphp
              <li>
                <a href="{{route('policy',['slug'=>$nameId])}}" class="text-decoration-none" title="{{$v->title}}">{{$v->title}}</a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="footer-news">
        <p class="footer-title">
          Fanpage facebook
        </p>
        <div id="fanpage-facebook">
          @if (!$helper->isGoogleSpeed())
            <div class="fb-page" data-href="{{$options->fanpage}}" data-tabs="timeline" data-width="300" data-height="200" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
              <blockquote cite="{{$options->fanpage}}" class="fb-xfbml-parse-ignore">
                <a href="{{$options->fanpage}}">Facebook</a>
              </blockquote>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="footer-powered">
    <div class="wrap-content">
      <div class="footer-copyright text-center">
      {{!empty($copyright->title) ? $copyright->title : ''}}
    </div>
    </div>
  </div>
</div>
<div id="footer-map">
  @if (!$helper->isGoogleSpeed())
  {!! htmlspecialchars_decode($options->iframe_ggmap) !!}
  @endif
</div>
