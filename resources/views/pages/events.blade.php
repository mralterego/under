@extends("layouts.main")


@section("title", "Cтраница всех событий")

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
    <div class="container">
        <h3>События</h3>
        <div class="row">
            @if (count($events) > 0)
                @foreach($events as $event)
                    <div class="col s4">
                        <div class="__event_block">
                            <div class="card">
                                <div class="card-image">
                                    @if ($event['image'] != "")
                                        <img src="{{ $event['image'] }}">
                                    @endif
                                    <span class="card-title">{!! $event['title'] !!}</span>
                                </div>
                                @if ($event['place'] != "")
                                    <div class=" __margin-bottom_s __margin-top_s __padding-left_s">
                                        <span>Место</span>: <span class="green-text">{{ $event['place']  }}</span>
                                    </div>
                                @endif
                                <div class="blue-text __margin-bottom_s __margin-top_s __padding-left_s">
                                    <span>{{ $event['date_formatted']  }}</span>
                                </div>
                                @if ($event['content'] != "")
                                    <div class="card-content">

                                        {!! $event['content'] !!}
                                    </div>
                                @endif
                                @if ($event['link'] != "")
                                    <div class="card-action">
                                        <a href="{{ $event['link'] }}">ссылка</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection