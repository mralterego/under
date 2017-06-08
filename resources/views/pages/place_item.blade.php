@extends("layouts.main")


@section("title", "Cтраница места")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/main/VueRate.js"></script>
    <script type="text/javascript" src="/front/main/VueLeftMenu.js"></script>
    <script type="text/javascript" src="/common/js/initLeftDialog.js"></script>
    <script>
    </script>
@endsection

@section("view")

    <div class="row">
        <div class="col s12">
            @if ($place['image'] != "")
                <div class="head_block">
                    <img class="responsive-img" src="{{ $place['image'] }}">
                </div>
            @endif
            <div class="article">
                <h3>{{ $place['title'] }}</h3>
                <span id="hidden-id" class="__hidden">{{ $place['id'] }}</span>
                @if ($place['worktime'] != "")
                    <span>Время работы:</span> <span>{{ $place['worktime'] }}</span>
                @endif
                @if ($place['site'] != "")
                    <span>Cайт:</span> <span>{{ $place['site'] }}</span>
                @endif
                @if ($place['description'] != "")
                    <article>
                        {!! $place['description'] !!}
                    </article>
                @endif
            </div>
        </div>
    </div>

@endsection