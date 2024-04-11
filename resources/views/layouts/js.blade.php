<script type="text/javascript">
  var urlBase = "{{config('app.url')}}";
</script>
<!-- Js Fb Comment -->
<div id="fb-root"></div>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<script src="{{url('resources/js/jquery.min.js')}}"></script>
@if (!$helper->isGoogleSpeed())
  <script src="https://sp.zalo.me/plugins/sdk.js"></script>
  <script src="{{url('resources/js/fotorama.js')}}"></script>
  <script async src="https://static.addtoany.com/menu/page.js"></script>
  <script src="{{url('resources/js/magiczoomplus.js')}}"></script>
  <script src="{{url('resources/js/fancybox.umd.js')}}"></script>
  <script src="{{url('resources/js/confirm.js')}}"></script>
  <script src="{{url('resources/admin/select2/select2.full.js')}}"></script>
@endif
<script src="{{url('resources/js/toc.js')}}"></script>
<script src="{{url('resources/js/bootstrap.js')}}"></script>
<script src="{{url('resources/js/owl.carousel.js')}}"></script>
<script src="{{url('resources/js/photobox.js')}}"></script>
<script src="{{url('resources/js/slick.js')}}"></script>
<script src="{{url('resources/js/mmenu.js')}}"></script>
<script src="{{url('resources/js/aos.js')}}"></script>
<script src="{{url('resources/js/app-main.js')}}"></script>
<script type="text/javascript">
  var csrfToken = $('[name="csrf_token"]').attr('content');
  setInterval(refreshToken, 3600000); // 1 hour
  function refreshToken(){
    $.get('refresh-csrf').done(function(data){
        csrfToken = data; // the new token
    })
  }
</script>

<!-- Strucdata data -->
@include('layouts.strucdata')

<!-- Addons -->
@include('layouts.addons')

<!-- Bodyjs -->
{!! !empty($setting->bodyjs) ? $setting->bodyjs : '' !!}

