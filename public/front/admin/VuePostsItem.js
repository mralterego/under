
var vm = new Vue({
    el: "#posts_page_item",
    data: {
        id: "",
        title: "",
        image: "",
        tags: "",
        rubric: "",
        gallery: "",
        published: false,
        showPoster: false
    },
    created: function(){

    },
    methods: {
        update: function(){
            var self = this,
                content = editor.getData(),
                uri = "/admin/posts/update";

            if (self.gallery == ""){
                self.gallery = 0;
            } else {
                self.gallery = parseInt(self.gallery);
            }
            console.log(self.gallery);
            console.log(self.tags);
            $.post(uri,
                {
                    id: self.id,
                    title: self.title,
                    place: self.place,
                    image: self.image,
                    tags: JSON.stringify(self.tags),
                    rubric: self.rubric,
                    gallery: self.gallery,
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
        successAction: function(message){
            Materialize.toast(message, 4000);
        },
        uploadImage: function(event){
            var self = this,
                uri = '/admin/posts/upload';

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
                        self.image = data.response;
                        self.showPoster = true;
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        },
        uploadGallery: function(event) {
            var self = this,
                uri = '/post/gallery/upload/' + self.id;
            var formdata = new FormData();

            for (var i = 0; i < event.target.files.length; i++){
                formdata.append("images[]", event.target.files[i]);
            }

            if (event.target.files.length > 0){
                $.ajax({
                    url: uri,
                    data: formdata,
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
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
        },
    }
});