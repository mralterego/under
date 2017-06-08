@extends("layouts.main")


@section("title", "Cтраница всех мест")

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
        <h3>Места</h3>
        <div class="row">
            @if (count($places) > 0)
                @foreach($places as $place)
                    <div class="col s4">
                        <div class="__event_block">
                            <div class="card">
                                <div class="card-image">
                                    @if ($place['image'] != "")
                                        <img src="{{ $place['image'] }}">
                                    @endif
                                    <span class="card-title">{!! $place['title'] !!}</span>
                                </div>
                                @if ($place['description'] != "")
                                    <div class=" __margin-bottom_s __margin-top_s __padding-left_s">
                                        {!! $place['description'] !!}
                                    </div>
                                @endif

                                @if ($place['site'] != "false" OR $place['site'] != "")
                                    <div class="card-action">
                                        <a href="{{ $place['site'] }}">ссылка</a>
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