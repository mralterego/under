@extends("layouts.adminpanel")


@section("title", "Страница с парсерами")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")

@endsection

@section("view")
    <div class="container">
        <h2 class="center">Настройки парсеров</h2>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_xl">
                    <div class="row">
                        <div class="card-content black-text">
                            <span class="card-title">&nbsp;&nbsp;DOT Parser</span>
                            <div class="input-group">
                                <div class="input-field col s6">
                                    <input type="text" class="form-control">
                                    <label>url откуда парсить</label>
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" class="form-control">
                                    <label>dom путь к событиям</label>
                                </div>
                                <div class="input-field col s3">
                                    <input type="text" class="form-control">
                                    <label>заголовок</label>
                                </div>
                                <div class="input-field col s2">
                                    <input type="text" class="form-control">
                                    <label>ссылка</label>
                                </div>
                                <div class="input-field col s2">
                                    <input type="text" class="form-control">
                                    <label>дата</label>
                                </div>
                                <div class="input-field col s3">
                                    <input type="text" class="form-control">
                                    <label>изображение</label>
                                </div>
                                <div class="input-field col s2">
                                    <input type="text" class="form-control">
                                    <label>текст</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a class="right waves-effect waves-light btn btn-margined" >
                            <i class="material-icons right dp48">find_in_page</i>
                            &nbsp;&nbsp;Применить
                        </a>
                    </div>
                </div>
            </div>
            <div class="col s12">

            </div>
        </div>
    </div>
@endsection