@extends("layouts.post")


@section("title", "Cтраница поста")

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
            @if ($post['image'] != "")
                <div class="head_block">
                    <img class="responsive-img" src="{{ $post['image'] }}">
                </div>
            @endif
            <div class="article">
                <h3>{{ $post['title'] }}</h3>
                <span id="hidden-id" class="__hidden">{{ $post['id'] }}</span>
                <span>Дата: </span><span>{{ $post['created_at'] }}</span>
                <article>
                    {!! $post['content'] !!}
                </article>
            </div>
        </div>
    </div>

@endsection