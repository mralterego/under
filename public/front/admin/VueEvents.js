
var vm = new Vue({
    el: "#events_page",
    data: {
        title: "",
        place: "",
        price: "",
        tags: "",
        link: "",
        poster: "",
        published: false,
        showPoster: false
    },
    created: function(){

    },
    methods: {
        create: function(){
            var self = this,
                date = self.dateBuilder("date"),
                content = editor.getData(),
                uri = "/admin/events/create";

            $.post(uri,
                {
                    title: self.title,
                    place: self.place,
                    link: self.link,
                    price: self.price,
                    image: self.poster,
                    tags: self.tags,
                    date: date,
                    content: content,
                    published: self.published
                })
                .done(function(data) {
                    console.log(data.response);
                    self.successAction("Событие создано!");
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        clear: function(){
            editor.setData("");
        },
        successAction: function(message){
            Materialize.toast(message, 4000);
        },
        dateBuilder:function(id){
            var date = document.getElementById(id).value;
            if (date == ""){
                return "";
            } else {
                var splited = date.split('.');
                date = splited[2] + "-"  + splited[1]+ "-" + splited[0];
                return date;
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
                        self.successAction("Загружено!");
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        }
    }
});