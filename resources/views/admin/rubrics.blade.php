@extends("layouts.adminpanel")


@section("title", "Рубрики")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VueRubrics.js"></script>

@endsection

@section("view")
    <div id="rubrics_page" class="container">
        <h4 class="center __margin-top_xxl">Рубрики</h4>
        <div class="row">
            <div class="col s12">
                <table class="centered bordered __margin-top_xxl __border __margin-bottom_xxl">
                    <thead>
                    <tr>
                        <th><h6>ID</h6></th>
                        <th><h6>Название</h6></th>
                        <th><h6>Alias</h6></th>
                        <th><h6>Операции</h6></th>
                    </tr>
                    <tr>
                        <th>

                        </th>
                        <th>
                            <div class="input-group">
                                <div class="input-field">
                                    <input type="text" v-model="name">
                                    <label class="active">Название</label>
                                </div>
                            </div>
                        </th>
                        <th>
                            <div class="input-group">
                                <div class="input-field">
                                    <input type="text" v-model="alias">
                                    <label class="active">Псевдоним</label>
                                </div>
                            </div>
                        </th>
                        <th>
                            <a v-on:click="create" class="btn-floating btn-large green"><i class="material-icons dp48">create</i></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody v-if="showTable" >
                        <template  v-for="(item, key) in items" >
                            <tr class="hovered-row"  :id="item.id">
                                <td>id@{{ item.id }}</td>
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.alias }}</td>
                                <td>
                                    <a v-on:click="remove($event)"  class="btn-floating btn-large red">
                                        <i class="material-icons dp48">clear</i>
                                    </a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection