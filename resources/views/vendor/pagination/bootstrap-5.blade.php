{{-- <style>
    .page-link {
        border: none !important;
        background: transparent;
    }

    .page-item.active .page-link {
        background-color: #1c3b2b !important;
        color: white !important;
    }

    .page-item.disabled .page-link {
        color: #ccc !important;
    }
</style> --}}
@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center align-items-center gap-2">

            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li class="page-item ">
                    <span class="page-link border-0 text-muted">
                        <i data-feather="chevron-left"></i> Kembali
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 text-success" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i data-feather="chevron-left"></i> Kembali
                    </a>
                </li>
            @endif

            {{-- Page Number Links --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link text-muted bg-transparent border-0">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link text-white"
                                    style="background-color: #1c3b2b; border-radius: 4px;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link text-muted bg-transparent border-0"
                                    href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-0 text-success" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        Selanjutnya <i data-feather="chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item ">
                    <span class="page-link border-0 text-muted">
                        Selanjutnya <i data-feather="chevron-right"></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
