Vue.component('event-parser', {
    data: function(){
        return {
            showButtons: false
        }
    },
    props: ['p_url', 'p_alias', 'p_events_path', 'p_title_path', 'p_date_path', 'p_img_path', 'p_link_path', 'p_article_path', 'p_is_active' ],
    template: '\
        <div class="col s12">\
            <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_xl"> \
              <div class="row">\
                  <div class="card-content black-text">\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_alias">\
                                <label class="active">alias</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_url">\
                                <label class="active">url</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_events_path">\
                                <label class="active">events_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_title_path">\
                                <label class="active">title_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_date_path">\
                                <label class="active">date_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_img_path">\
                                <label class="active">img_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_link_path">\
                                <label class="active">link_path</label>\
                            </div>\
                        </div>\
                         <div class="input-group">\
                             <div class="input-field col s3">\
                                <input type="text" class="form-control" v-bind:value="p_article_path">\
                                <label class="active">article_path</label>\
                            </div>\
                        </div>\
                     </div>\
                  </div>\
                  <div class="card-action">\
                    <div class="left __input_margin">\
                        <input type="checkbox" v-bind:value="p_is_active" v-bind:checked="p_is_active === true" class="items-filter"> \
                        <label>активен</label>\
                    </div>\
                        <a class="right orange darken-1 waves-effect waves-light btn">\
                            <i class="material-icons right dp48">sync</i>\
                            &nbsp;&nbsp;Обновить\
                        </a>\
                    </div>\
              </div> \
        </div>\
      \
      ',
    methods: {

    }
});


var vm = new Vue({
    el: "#parser_page",
    data: {
        parsers: [],
        url: "",
        alias: "",
        events_path: "",
        title_path: "",
        date_path: "",
        img_path: "",
        link_path: "",
        article_path: "",
        response: {
            error: {
                state: false,
                message: ""
            },
            success: {
                state: false,
                message: ""
            }
        },
    },
    created: function(){
        this.getParsers();
    },
    methods: {
        test: function(){
            var self = this,
                uri = "/parser/test";

            $.get(uri,
                {
                    url: self.url,
                    alias: self.alias,
                    events_path: self.events_path,
                    title_path: self.title_path,
                    date_path: self.date_path,
                    img_path: self.img_path,
                    link_path: self.link_path,
                    article_path: self.article_path
                })
                .done(function(data) {
                    console.log(data.response);
                })
                .fail(function(error) {
                    self.response.success.state = false;
                    self.response.error.state = true;
                    self.response.error.message = "Ошибка: " + error.status + ", " + error.statusText;
                });
        },
        create: function(){
            var self = this,
                uri = "/parser/create";

            $.post(uri,
                {
                    url: self.url,
                    alias: self.alias,
                    events_path: self.events_path,
                    title_path: self.title_path,
                    date_path: self.date_path,
                    img_path: self.img_path,
                    link_path: self.link_path,
                    article_path: self.article_path
                })
                .done(function(data) {
                    console.log(data.response);
                })
                .fail(function(error) {
                    console.log(error);
                    self.response.success.state = false;
                    self.response.error.state = true;
                    self.response.error.message = "Ошибка: " + error.status + ", " + error.statusText;
                });
        },
        getParsers: function(){
            var self = this,
                uri = "/parser/api";
            $.get(uri, function(data) {
                console.log(data);
                self.parsers = data;
            });
        }
    }
});