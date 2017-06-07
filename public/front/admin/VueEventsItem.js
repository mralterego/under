
var vm = new Vue({
    el: "#events_item_page",
    data: {
        id: "",
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
        update: function(){
            var self = this,
                date = self.dateBuilder("date"),
                content = editor.getData(),
                uri = "/admin/events/update";

            $.get(uri,
                {
                    id: self.id,
                    title: self.title,
                    place: self.place,
                    link: self.link,
                    price: self.price,
                    image: self.poster,
                    tags: JSON.stringify(self.tags),
                    date: date,
                    content: content,
                    published: self.published
                })
                .done(function(data) {
                    console.log(data.response);
                    self.successAction("Обновлено!");
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        clear: function(){
            editor.setData("");
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

        }
    }
});