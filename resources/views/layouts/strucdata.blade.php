@if (!empty($seo->get('schema')))
    <script type="application/ld+json">
        {!! htmlspecialchars_decode($seo->get('schema')) !!}
    </script>
@endif
@if (!empty($templeat) && $templeat == 'page')
    <!-- Static -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://google.com/article"
      },
      "headline": "{{$row->name}}",
      "image": [
        "{{!empty($row->photo1) ? asset('upload/page/'.$row->photo1) : url('resources/images/noimage.png')}}"
      ],
      "datePublished": "{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-Y')}}",
      "dateModified": "{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at)->format('d-m-Y')}}",
      "author": {
        "@type": "Person",
        "name": "{{!empty($setting->title) ? $setting->title : ''}}"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Google",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ !empty($logo->photo) ? asset('upload/photo/' . $logo->photo) : url('resources/images/noimage.png')}}"
        }
      },
      "description": "{!! $seo->get('description') !!}"
    }
  </script>
@endif
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{!empty($setting->title) ? $setting->title : ''}}",
    "url": "{{url('/')}}",
    "sameAs": [
      @if (count($socialFooter) > 0)
        @php
            $sum_social = count($socialFooter);
        @endphp
        @foreach ($socialFooter as $key => $value)
        "{{$value->link}}"{{(($key + 1) < $sum_social) ? ',' : ''}}
        @endforeach
      @endif
    ],
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "{{!empty($setting->title) ? $setting->address : ''}}",
      "addressRegion": "Ho Chi Minh",
      "postalCode": "70000",
      "addressCountry": "vi"
    }
  }
</script>
