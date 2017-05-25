
var vm = new Vue({
    el: "#places_page",
    data: {
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
    updated: function () {
            var self = this;
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 59.93661241484262, lng: 30.320205688476562},
                zoom: 12
            });
            google.maps.event.addListener(map, "rightclick", function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                self.position = {
                    lat: lat,
                    lng: lng
                };
                self.coordinates = lat + ", " + lng;
            });
            var marker = new google.maps.Marker({
                position: self.position,
                map: map,
                title: 'Marker right click'
            });

    },
    methods: {
        create: function(){
            var self = this;
            var uri = "/admin/places/create";

            self.deputy = "admin";
            if (self.site == ""){
                self.site = "false";
            }
            if (self.gallery == ""){
                self.gallery = 0;
            } else {
                self.gallery = parseInt(self.gallery);
            }
            $.post(uri,
                {
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