@extends("layouts.main")


@section("title", "Главная страница")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/main/VueMain.js"></script>
    <script type="text/javascript" src="/front/main/VueLeftMenu.js"></script>
    <script type="text/javascript" src="/common/js/initLeftDialog.js"></script>
@endsection

@section("view")
    <div id="main_page" class="container">
        <div class="row">
            <div class="col s7">
                <h3 class="center __margin-top_l">Что-где происходит</h3>
                <div class="row">
                    @if (count($events) > 0)
                        @foreach($events as $event)
                            <div class="col s6">
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
            <div class="col s3">
            </div>
            <div class="col s2">
            </div>
        </div>
    </div>
@endsection