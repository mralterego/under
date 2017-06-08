@extends("layouts.main")


@section("title", "Cтраница всех постов")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")

    <script type="text/javascript" src="/front/main/VueLeftMenu.js"></script>
    <script type="text/javascript" src="/common/js/initLeftDialog.js"></script>

@endsection

@section("view")
    <div class="container">
        <h3>Посты</h3>
        <div class="row">
            @if (count($posts) > 0)
                @foreach($posts as $post)
                    <div class="col s4">
                        <div class="__event_block">
                            <div class="card">
                                <div class="card-image">
                                    @if ($post['image'] != "")
                                        <img src="{{ $post['image'] }}">
                                    @endif
                                    <span class="card-title">{!! $post['title'] !!}</span>
                                </div>
                                @if ($post['content'] != "")
                                    <div class=" __margin-bottom_s __margin-top_s __padding-left_s">
                                        {!! $post['content'] !!}
                                    </div>
                                @endif
                                <div class="card-action black-text">
                                    <a href="/posts/{{ $post['rubric'] }}/{{ $post['id'] }}">ссылка</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection