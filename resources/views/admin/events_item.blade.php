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
    <script type="text/javascript">
        initSample();
        var editor = CKEDITOR.replace( 'main' );
        editor.setData('{!! $content !!}');
    </script>
    <script src="/addons/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/addons/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8" ></script>
    <script src="/common/js/materialize-helper.js"></script>
@endsection

@section("vue")
    <script type="text/javascript" src="/front/main/VueLeftMenu.js"></script>
    <script type="text/javascript" src="/common/js/initLeftDialog.js"></script>
    <script type="text/javascript" src="/front/admin/VueEventsItem.js"></script>
    <script>
        $('.chips').material_chip();
        $('.chips-placeholder').material_chip({
            secondaryPlaceholder: '+Тэг',
        });
    </script>
    <script type="text/javascript">
        Vue.nextTick(function (){
            vm.id = '{{ $id }}';
            vm.title = '{{ $title }}';
            vm.place = '{{ $place }}';
            vm.price = '{{ $price }}';
            vm.poster= '{{ $image }}';
            var tags = '{!! $tags !!}';
            vm.link = '{{ $link }}';
            vm.published = parseInt({{ $published }});
            var data = [];
            vm.tags = JSON.parse(tags);
            vm.tags.forEach(function(item, i){
                var chip = {
                    tag: item,
                };
                data.push(chip);
            });
            $('.chips').material_chip({
                data: data,
            });
        });
    </script>
@endsection

@section("view")
    <div id="events_item_page" class="container">
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl ">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" v-model="title">
                                            <label class="active">Название</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text"  v-model="link">
                                            <label class="active">Ссылка</label>
                                        </div>
                                    </div>
                                    <div class="input-group input-daterange">
                                        <div class="input-field col s4">
                                            <input type="text" id="date" class="form-control" value="{{ $date }}">
                                            <label class="active">Дата проведения</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="place">
                                            <label class="active">Место</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="price">
                                            <label class="active">Цена</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s12">
                                            <div v-on:keydown="addTag($event)" v-on:click="removeTag" class="chips chips-placeholder"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--skeditor--->
            <div class="col s12">
                <div id="main">
                    <div>
                        <div class="grid-container">
                            <div class="grid-width-100">
                                <div id="editor">
                                    {{ $content }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="editor-content" class="__hidden">
                        {{  $content }}
                    </div>
                </div>
            </div>
            <!--skeditor--->
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_s">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="file-field input-field col s6">
                                            <div class="btn">
                                                <span>Загрузить постер</span>
                                                <input type="file" name="image"  accept="image/*"  >
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" v-bind:value="poster">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group" >
                                        <div class="file-field input-field col s6">
                                            <img class="responsive-img" v-bind:src="poster">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <div class=" __padding-left_l __padding-top_m">
                                <input type="checkbox" id="published"  v-model="published" />
                                <label for="published">Опубликовано</label>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="__padding-right_l">
                                <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="update">
                                    &nbsp;&nbsp;Обновить
                                    <i class="material-icons right dp48">note_add</i>
                                </a>
                                <a class="right amber darken-3 btn-hovered waves-effect waves-light btn-large" v-on:click="clear">
                                    &nbsp;&nbsp;Очистить
                                    <i class="material-icons right dp48">clear</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection