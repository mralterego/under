@extends("layouts.main")


@section("title", "Cтраница события")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/main/VueLeftMenu.js"></script>
    <script type="text/javascript" src="/common/js/initLeftDialog.js"></script>
    <script>
    </script>
@endsection

@section("view")

    <div class="row">
        <div class="col s12">
            @if ($event['image'] != "")
                <div class="head_block">
                    <img class="responsive-img" src="{{ $event['image'] }}">
                </div>
            @endif
            <div class="article">
                <h3>{{ $event['title'] }}</h3>
                <span id="hidden-id" class="__hidden">{{ $event['id'] }}</span>
                <span>Дата: </span><span>{{ $event['date'] }}</span>
                @if ($event['content'] != "")
                    <article>
                        {!! $event['content'] !!}
                    </article>
                @endif
            </div>
        </div>
    </div>

@endsection