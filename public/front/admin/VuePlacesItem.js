
var vm = new Vue({
    el: "#places_item_page",
    data: {
        id: "",
        title: "",
        alias: "",
        site: "",
        address: "",
        worktime: "",
        coordinates: "",
        description: "",
        tags: "",
        icon: "",
        image: "",
        gallery: "",
        deputy: "",
        position: "",
        published: false,
        showPoster: true,
        showModal: false,
    },
    created: function(){

    },
    methods: {
        update: function(){
            var self = this,
                uri = "/admin/places/update";

            $.get(uri,
                {
                    id: self.id,
                    title: self.title,
                    alias: self.alias,
                    site: self.site,
                    address: self.address,
                    worktime: self.worktime,
                    coordinates: self.coordinates,
                    description: self.description,
                    tags: JSON.stringify(self.tags),
                    image: self.image,
                    gallery: self.gallery,
                    deputy: self.deputy,
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
        uploadImage: function(event){
            var self = this,
                uri = '/admin/places/upload';

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
                        self.image = data.response;
                        self.showPoster = true;
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
        uploadIcon: function(event){
            var self = this,
                uri = '/admin/places/icon';

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
                        self.icon = data.response;
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        },

        uploadGallery: function(event) {
            var self = this,
                uri = '/place/gallery/upload/' + self.id;
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
        }
    }
});