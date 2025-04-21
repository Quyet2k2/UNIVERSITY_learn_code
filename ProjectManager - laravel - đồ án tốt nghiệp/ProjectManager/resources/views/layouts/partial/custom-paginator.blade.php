@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Nút "Trước" --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Hiển thị 3 số trang gần nhất + dấu `...` nếu có nhiều hơn --}}
        @foreach (range(1, $paginator->lastPage()) as $page)
            @if ($page == 1 || $page == $paginator->lastPage() || abs($page - $paginator->currentPage()) < 2)
                <li class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @elseif ($page == 2 || $page == $paginator->lastPage() - 1)
                <li class="disabled"><span>...</span></li>
            @endif
        @endforeach

        {{-- Nút "Tiếp" --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
