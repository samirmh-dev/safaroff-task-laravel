@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{--<li class="disabled"><span>&laquo;</span></li>--}}
        @else
            <section style="width: 100%;display: flex;justify-content: flex-start;">
                <div class="clearfix">
                    <a class="btn btn-secondary float-left" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; ƏVVƏLKİ </a>
                </div>
            </section>
        @endif

        {{-- Pagination Elements --}}
        {{--@foreach ($elements as $element)--}}
            {{-- "Three Dots" Separator --}}
            {{--@if (is_string($element))--}}
                {{--<li class="disabled"><span>{{ $element }}</span></li>--}}
            {{--@endif--}}

            {{-- Array Of Links --}}
            {{--@if (is_array($element))--}}
                {{--@foreach ($element as $page => $url)--}}
                    {{--@if ($page == $paginator->currentPage())--}}
                        {{--<li class="active"><span>{{ $page }}</span></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--@endforeach--}}

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <section style="width: 100%;display: flex;justify-content: flex-end;">
                <div class="clearfix">
                    <a class="btn btn-secondary float-right" href="{{ $paginator->nextPageUrl() }}" rel="next">NÖVBƏTİ &rarr;</a>
                </div>
            </section>
        @else
            {{--<li class="disabled"><span>&raquo;</span></li>--}}
        @endif
    </ul>
@endif
