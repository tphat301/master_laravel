<div class="toolbar">
  <ul>
    <li>
      <a class="text-decoration-none " id="goidien" href="tel:{{preg_replace('/[^0-9]/', '', $options->phone)}}" title="title">
        <img src="{{url('resources/images/icon-t1.png')}}" alt="Phone" loading="lazy"><br>
        <span>Gọi ngay</span>
      </a>
    </li>
    <li>
      <a class=" text-decoration-none " id="chatzalo" href="https://zalo.me/{{preg_replace('/[^0-9]/', '', $options->zalo)}}" title="title">
        <img src="{{url('resources/images/zl.png')}}" alt="Zalo" loading="lazy"><br>
        <span>
          Zalo chat
        </span>
      </a>
    </li>
    <li>
      <a class=" text-decoration-none " id="chatfb" href="{{$options->fanpage}}" title="title">
        <img src="{{url('resources/images/icon-t4.png')}}" alt="Facebook" loading="lazy"><br>
        <span>Facebook chat</span>
      </a>
    </li>
    <li>
      <a class=" text-decoration-none " id="chiduong" href="{{$options->link_ggmap}}" title="title">
        <img src="{{url('resources/images/chiduong.png')}}" alt="Chỉ đường" loading="lazy"><br>
        <span>Chỉ đường</span>
      </a>
    </li>
  </ul>
</div>
