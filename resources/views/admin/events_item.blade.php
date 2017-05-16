@extends("layouts.adminpanel")


@section("title", "Отдельная Страница события")

@section("head")
    <link rel="stylesheet" href="/addons/datepicker/css/bootstrap-datepicker3.min.css">
    <!--editor assets-->
    <script type="text/javascript" src="/addons/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/addons/ckeditor/sample.js"></script>
    <link rel="stylesheet" href="/addons/ckeditor/css/samples.css">
    <link rel="stylesheet" href="/addons/ckeditor/css/neo.css">
    <!--end editor assets-->
@endsection

@section("foot")
    <script src="/common/js/ckeditor-helper.js"></script>
    <script src="/addons/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/addons/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8" ></script>
    <script src="/common/js/materialize-helper.js"></script>
@endsection

@section("vue")
    <script type="text/javascript" src="/front/VueEventsItem.js"></script>
@endsection

@section("view")
    <div id="events_item_page" class="container">
    </div>
@endsection