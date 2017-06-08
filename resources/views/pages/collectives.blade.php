@extends("layouts.main")


@section("title", "Cтраница всех коллективов")

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
        <h3>Коллективы, промо-группы, лейблы</h3>
        <div class="row">
            @if (count($collectives) > 0)
                @foreach($collectives as $collective)
                    <div class="col s4">
                        <div class="__event_block">
                            <div class="card">
                                <div class="card-image">
                                    @if ($collective['image'] != "")
                                        <img src="{{ $collective['image'] }}">
                                    @endif
                                    <span class="card-title">{{ $collective['name'] }}</span>
                                </div>
                                @if ($collective['description'] != "")
                                    <div class=" __margin-bottom_s __margin-top_s __padding-left_s">
                                        {!! $collective['description'] !!}
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