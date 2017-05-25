
var vm = new Vue({
    el: "#posts_page",
    data: {
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
        create: function(){
            var self = this,
                content = editor.getData(),
                uri = "/admin/posts/create",
                author = "admin";

            if (self.gallery == ""){
                self.gallery = 0;
            } else {
                self.gallery = parseInt(self.gallery);
            }
            console.log(self.gallery);
            $.post(uri,
                {
                    title: self.title,
                    place: self.place,
                    image: self.image,
                    tags: self.tags,
                    rubric: self.rubric,
                    gallery: self.gallery,
                    author: author,
                    content: content,
                    published: self.published
                })
                .done(function(data) {
                    console.log(data.response);
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
        }
    }
});