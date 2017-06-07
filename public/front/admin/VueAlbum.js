
var vm = new Vue({
    el: "#album_page",
    data: {
        title: "",
        description: "",
        poster: "",
        audio: [],
        tags: [],
        published: false,
        showAudio:  false,
        showPoster: false
    },
    created: function(){

    },
    methods: {
        create: function(){
            var self = this,
                uri = "/admin/albums/create";
            $.post(uri,
                {
                    title: self.title,
                    description: self.description,
                    poster: self.poster,
                    audio: JSON.stringify(self.audio),
                    tags: JSON.stringify(self.tags),
                    published: self.published,
                })
                .done(function(data) {
                    console.log(data.response);
                    self.successAction("Альбом добавлен!");
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        uploadAudio: function(event){
            var self = this,
                uri = '/admin/albums/audio';
                var formdata = new FormData();
                formdata.append("audio", event.target.files[0]);
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
                            var name = data.response.name;
                            var path = data.response.path;
                            var audio = {
                                name: name,
                                path: path,
                            };
                            self.audio.push(audio);
                            self.showAudio = true;
                            self.successAction("Трек загружен");
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                }
        },
        successAction: function(message){
            Materialize.toast(message, 4000);
        },
        uploadImage: function(event){
            var self = this,
                uri = '/admin/albums/upload';

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
                        self.poster = data.response;
                        self.showPoster = true;
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        },
        removeTag: function(){
            var self = this;
            $('.chips').on('chip.delete', function(e, chip){
                self.tags = self.countTags(".chip");
            });
        },
        countTags: function(classname){
            var result = [],
                tags = document.querySelectorAll(classname);
            for (var i = 0; i < tags.length; i ++){
                result.push(tags[i].childNodes[0].data);
            }
            return result;
        },
        addTag: function(event){
            var self = this;
            if (event.keyCode == 13){
                $('.chips').on('chip.add', function(e, chip){
                    self.tags = self.countTags(".chip");
                });
            }
        }
    }
});