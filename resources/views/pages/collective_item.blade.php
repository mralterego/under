@extends("layouts.main")


@section("title", "Cтраница коллектива")

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
            @if ($colletive['image'] != "")
                <div class="head_block">
                    <img class="responsive-img" src="{{ $collective['image'] }}">
                </div>
            @endif
            <div class="article">
                <h3>{{ $collective['name'] }}</h3>
                <span id="hidden-id" class="__hidden">{{ $collective['id'] }}</span>
                @if ($collective['description'] != "")
                    <article>
                        {!! $collective['description'] !!}
                    </article>
                @endif
            </div>
        </div>
    </div>

@endsection