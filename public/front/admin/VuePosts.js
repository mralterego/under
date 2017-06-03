
var vm = new Vue({
    el: "#posts_page",
    data: {
        title: "",
        image: "",
        tags: "",
        rubric: "",
        gallery: "",
        rubrics: [
            {
                alias: "",
                name: "",
            }
        ],
        published: false,
        showPoster: false
    },
    created: function(){

    },
    updated: function(){
        $('#select-hidden').material_select();
    },
    beforeCreate: function(){
        var self = this,
            uri = "/admin/rubric/api";
        $.get(uri)
            .done(function(data) {
                self.rubrics = data.response;
                console.log(self.rubrics);
            })
            .fail(function(error) {
                console.log(error);
            });
    },
    methods: {
        create: function(){
            var self = this,
                content = editor.getData(),
                uri = "/admin/posts/create",
                rubric = document.getElementById("select-hidden").value;

            if (self.gallery == ""){
                self.gallery = 0;
            } else {
                self.gallery = parseInt(self.gallery);
            }
            $.post(uri,
                {
                    title: self.title,
                    place: self.place,
                    image: self.image,
                    tags: JSON.stringify(self.tags),
                    rubric: rubric,
                    gallery: self.gallery,
                    content: content,
                    published: self.published
                })
                .done(function(data) {
                    console.log(data.response);
                    self.successAction("Пост создан!");
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
        getRubrics: function(){
            var self = this,
                uri = "/admin/rubric/api";
            $.get(uri)
                .done(function(data) {
                    self.rubrics = data.response;
                    console.log(self.rubrics);
                })
                .fail(function(error) {

                    console.log(error);
                });
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