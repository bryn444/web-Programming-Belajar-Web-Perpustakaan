<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">{{ ucfirst(Request::segment(1)) }}</li>
                {{-- @for ($i = 2; $i <= count(Request::segments()); $i++) --}}
                @for ($i = 2; $i <= 3; $i++)
                    @php
                        $segment = Request::segment($i);
                        // Ubah dash "-" menjadi spasi, dan setiap kata menjadi capitalize
                        $formattedSegment = ucwords(str_replace('-', ' ', $segment));
                    @endphp
                    <li class="breadcrumb-item">
                        {{ $formattedSegment }}
                    </li>
                @endfor
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
<hr>