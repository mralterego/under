
var vm = new Vue({
    el: "#events_page",
    data: {
        title: "",
        place: "",
        price: "",
        link: "",
        poster: "",
        showPoster: false
    },
    created: function(){

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
                uri = "/admin/event/create";

            $.post(uri,
                {

                })
                .done(function(data) {
                    console.log(data.response);
                })
                .fail(function(error) {
                    console.log(error);
                });
        },

        uploadImage: function(event){
            var self = this,
                uri = '/admin/events/upload';

            var formdata = new FormData();
            formdata.append("image", event.target.files[0]);

            if (event.target.files.length > 0){
                $.ajax({
                    url: uri,
                    data: formdata,
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data.response);
                        self.poster = data.response;
                        self.showPoster = true;
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }

        },
    }
});