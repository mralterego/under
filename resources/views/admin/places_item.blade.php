@extends("layouts.adminpanel")


@section("title", "Страница с отдельным местом")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VuePlacesItem.js"></script>
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
            vm.alias = '{{ $alias }}';
            vm.site = '{{ $site }}';
            vm.icon = '{{ $icon }}';
            vm.address = '{{ $address }}';
            vm.worktime =  ' {{ $worktime }}' ;
            vm.coordinates = '{{ $coordinates }}';
            vm.description = '{{ $description }}';
            var tags = '{!! $tags !!}';
            vm.tags = JSON.parse(tags);
            console.log(vm.tags);
            vm.image = '{{ $image }}';
            vm.gallery = '{{ $gallery }}';
            vm.deputy = '{{ $deputy }}';
            vm.published = parseInt({{ $published }});

            var data = [];
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
    <div id="places_item_page" class="container">
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl ">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="title">
                                            <label class="active">Название</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text"  v-model="alias">
                                            <label class="active">Алиас</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="site">
                                            <label class="active">Сайт</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="address">
                                            <label class="active">Адрес</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="worktime">
                                            <label class="active">Время работы</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="coordinates">
                                            <label class="active">Координаты</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s12">
                                            <div v-on:keydown="addTag($event)" v-on:click="removeTag" class="chips chips-placeholder"></div>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s12">
                                            <textarea class="materialize-textarea" v-model="description"></textarea>
                                            <label class="active">описание</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_s">

                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text center __margin-bottom_xl ">
                                    <span class="card-title ">&nbsp;&nbsp;&nbsp;Загрузите заглавное изображение вашего места</span>
                                </div>
                                <div class="input-group" >
                                    <div class="file-field input-field col s6">
                                        <img v-if="showPoster" class="responsive-img" v-bind:src="image">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="file-field input-field col s6">
                                        <div class="btn right __margin-right_xl">
                                            <i class="material-icons right dp48 ">file_download</i>
                                            <span>Загрузить изображение</span>
                                            <input type="file" name="image"  accept="image/*"  v-on:change="uploadImage($event)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text center  __margin-bottom_xl">
                                    <span class="card-title ">&nbsp;&nbsp;&nbsp;&nbsp;Установите свою иконку для маркера в Google Maps</span>
                                </div>
                                <div class="input-group" >
                                    <div class="file-field input-field col s6">
                                        <img class="right"  v-bind:src="icon">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="file-field input-field col s6">
                                        <div class="btn right __margin-right_l">
                                            <i class="material-icons right dp48">file_download</i>
                                            <span>Загрузить иконку</span>
                                            <input type="file" name="image"  accept="image/*"  v-on:change="uploadIcon($event)">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection