Vue.component('event-parser', {
    props: ['p_url', 'p_alias', 'p_place', 'p_events_path', 'p_title_path', 'p_date_path', 'p_img_path', 'p_link_path', 'p_article_path', 'p_is_active' ],
    data: function(){
        return {
            url: this.p_url,
            alias: this.p_alias,
            place: this.p_place,
            events_path: this.p_events_path,
            title_path: this.p_title_path,
            date_path: this.p_date_path,
            img_path: this.p_img_path,
            link_path: this.p_link_path,
            article_path: this.p_article_path,
            isActive: this.p_is_active,
            testStatus: false,
            testResponse: ""
        };
    },
    template: '\
        <div class="col s12">\
            <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_xl"> \
              <div class="row">\
                 <div class="col s6">   \
                   <div class="row"> \
                     <div class="card-content black-text">\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="alias">\
                                <label class="active">alias</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="url">\
                                <label class="active">url</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="place">\
                                <label class="active">place</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="replaceAt(events_path)">\
                                <label class="active">events_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="replaceAt(title_path)">\
                                <label class="active">title_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="replaceAt(date_path)">\
                                <label class="active">date_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="replaceAt(img_path)">\
                                <label class="active">img_path</label>\
                            </div>\
                        </div>\
                        <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="replaceAt(link_path)">\
                                <label class="active">link_path</label>\
                            </div>\
                        </div>\
                         <div class="input-group">\
                             <div class="input-field col s6">\
                                <input type="text" class="form-control" v-bind:value="replaceAt(article_path)">\
                                <label class="active">article_path</label>\
                            </div>\
                        </div>\
                     </div>\
                   </div>\
                </div>\
                <div class="col s6">\
                    <div class="row">\
                          <div class="card-content black-text">\
                                <span class="card-title">Статус теста</span>\
                                <div v-if="!testStatus" class="__margin-top_xl __padding-left_xxxl">\
                                     <span class="red-text text-darken-2">NONE</span>\
                                </div>\
                                <pre v-if="testStatus" v-html="testResponse" class="__test-size"></pre>\
                          </div>\
                    </div>\
                </div>\
              </div>\
                  <div class="card-action">\
                        <div v-on:click="isActive = !isActive"  class="left __input_margin">\
                            <input type="checkbox" v-bind:value="isActive" v-bind:checked="isActive === true"  class="items-filter"> \
                            <label>активен</label>\
                        </div>\
                        <a class="right orange darken-1 waves-effect waves-light btn">\
                            <i class="material-icons right dp48">sync</i>\
                            &nbsp;&nbsp;Обновить\
                        </a>\
                        <a class="right blue darken-2 waves-effect waves-light btn __margin-right_xl" v-on:click="test">\
                            <i class="material-icons right dp48">build</i>\
                            &nbsp;&nbsp;Протестировать\
                        </a>\
                    </div>\
              </div> \
        </div>\
      \
      ',
    methods: {
        replaceAt: function(str){
           return str.replace("#","@");
        },
        test: function(){
            var self = this,
                uri = "/parser/test/" + self.alias;
            $.get(uri,
                {
                    url: self.url,
                    alias: self.alias,
                    place: self.place,
                    events_path: self.events_path,
                    title_path: self.title_path,
                    date_path: self.date_path,
                    img_path: self.img_path,
                    link_path: self.link_path,
                    article_path: self.article_path
                })
                .done(function(data) {
                    console.log(data.response);
                    if (data.response != 0 || data.response != null || data.response != undefined ){
                        self.testStatus = true;
                        self.testResponse = data.response;
                    }
                })
                .fail(function(error) {
                    self.testStatus = true;
                    self.testResponse = error;
                });
        }
    }
});


var vm = new Vue({
    el: "#parser_page",
    data: {
        testResponse: "",
        testStatus: false,
        parsers: [],
        url: "",
        alias: "",
        place: "",
        events_path: "",
        title_path: "",
        date_path: "",
        img_path: "",
        link_path: "",
        article_path: "",
    },
    created: function(){
        this.getParsers();
    },
    methods: {
        test: function(){
            var self = this,
                uri = "/parser/test" + self.alias;
            $.get(uri,
                {
                    url: self.url,
                    alias: self.alias,
                    place: self.place,
                    events_path: self.events_path,
                    title_path: self.title_path,
                    date_path: self.date_path,
                    img_path: self.img_path,
                    link_path: self.link_path,
                    article_path: self.article_path
                })
                .done(function(data) {
                    console.log(data.response);
                    if (data.response != 0 || data.response != null || data.response != undefined ){
                        self.testStatus = true;
                        self.testResponse = data.response;
                    }
                })
                .fail(function(error) {
                    self.testStatus = true;
                    self.testResponse = error;
                });
        },
        create: function(){
            var self = this,
                uri = "/parser/create";

            $.post(uri,
                {
                    url: self.url,
                    alias: self.alias,
                    place: self.place,
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

                    self.testStatus = true;
                    self.testResponse = error;
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