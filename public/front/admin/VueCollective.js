
var vm = new Vue({
    el: "#collective_page",
    data: {
        name: "",
        description: "",
        image: "",
        tags: "",
        social: {
            vk: "",
            fb: "",
            sc: "",
        },
        place: "",
        showPoster: false
    },
    created: function(){

    },
    methods: {
        create: function(){
            var self = this,
                uri = "/admin/collectives/create",
                deputy = document.getElementById('username').innerHTML;

            $.post(uri,
                {
                    name: self.name,
                    description: self.description,
                    image: self.image,
                    tags: self.tags,
                    place: self.place,
                    social: JSON.stringify(self.social),
                    deputy: deputy,
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
                uri = '/admin/collectives/upload';

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