
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
        image: "",
        gallery: "",
        deputy: "",
        position: "",
        published: false,
        showPoster: true,
        showModal: false,
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
                    tags: self.tags,
                    image: self.image,
                    gallery: self.gallery,
                    deputy: self.deputy,
                    published: self.published
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
        }
    }
});