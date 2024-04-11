<header class="header">
  <div class="header-top">
    <div class="wrap-content d-flex flex-wrap justify-content-between align-items-center ">
      <div class="d-flex align-items-center">
        <p class="info-header"><i class="fa-solid fa-envelope"></i> Email: {{$options->email}}</p>
        <p class="info-header ml-2 mr-2"><i class="fa-solid fa-phone"></i> Hotline: {{$helper->formatPhone($options->hotline)}}</p>
      </div>
      <?php
        /*
        <div class="d-flex align-items-center">
          <div class="user-header">
            @guest
              @if (Route::has('login'))
                <a href="{{ route('login') }}" title="Đăng nhận">
                  <i class="fas fa-sign-in-alt"></i>
                  <span>Đăng nhập</span>
                </a>
              @endif
              @if (Route::has('register'))
                <a href="{{ route('register') }}" title="Đăng ký">
                  <i class="fas fa-user-plus"></i>
                  <span>Đăng ký</span>
                </a>
              @endif
              @else
              <div class="user-header">
                <a href="account/thong-tin" title="">
                  <span>
                    {{ Auth::user()->name }}
                  </span>
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Đăng xuất">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Đăng xuất</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            @endguest
          </div>
        </div>
        */
      ?>
    </div>
  </div>
  @if(!empty($slogan->title))
    <div class="header-bottom">
      <div class="wrap-content">
        <p class="slogan-header mb-0 ">
          <marquee>{{$slogan->title}}</marquee>
        </p>
      </div>
    </div>
  @endif
</header>
