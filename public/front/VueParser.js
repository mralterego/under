Vue.component('event-parser', {
    data: function(){

    }
});


var vm = new Vue({
    el: "#parser_page",
    data: {
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
        }
    }
});