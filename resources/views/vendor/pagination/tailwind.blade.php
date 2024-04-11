@if ($paginator->hasPages())
  <div class="card-footer text-sm">
    <ul class="pagination flex-wrap justify-content-center mb-0">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item">
          <a class="page-link"> Trang {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }} </a>
        </li>
      @else
        <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link">«</a></li>
      @endif
      @if($paginator->currentPage() > 3)
        <li class="page-item"><a href="{{ $paginator->url(1) }}" class="page-link">1</a></li>
      @endif
      @if($paginator->currentPage() > 4)
        <li class="page-item"><a class="page-link">...</a></li>
      @endif

      @foreach(range(1, $paginator->lastPage()) as $i)
        @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
          @if ($i == $paginator->currentPage())
            <li class="page-item active"><a class="page-link">{{ $i }}</a></li>
          @else
            <li class="page-item"><a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a></li>
          @endif
        @endif
      @endforeach
      @if($paginator->currentPage() < $paginator->lastPage() - 3)
        <li class="page-item"><a class="page-link">...</a></li>
      @endif
      @if($paginator->currentPage() < $paginator->lastPage() - 2)
        <li class="page-item"><a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link">{{ $paginator->lastPage() }}</a></li>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">»</a></li>
      @else
        <li class="page-item"><a class="page-link">»</a></li>
      @endif
    </ul>
  </div>
@endif
