
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
        tags: [],
        image: "",
        icon: "",
        gallery: "",
        deputy: "",
        position: {
            lat: 0,
            lng: 0,
        },
        published: false,
        showPoster: true,
        showModal: false,
    },
    updated: function () {
        this.setMarker();
    },
    created: function(){

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
                    tags: JSON.stringify(self.tags),
                    image: self.image,
                    icon: self.icon,
                    gallery: self.gallery,
                    deputy: self.deputy,
                    published: self.published
                })
                .done(function(data) {
                    console.log(data.response);
                    self.successAction("Место добавлено!");
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        successAction: function(message){
            Materialize.toast(message, 4000);
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
        setMarker: function(){
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
                    lng: lng,
                };
                self.coordinates = lat + ", " + lng;
            });
            var marker = new google.maps.Marker({
                position: self.position,
                map: map,
                title: self.title,
                draggable: true,
            });

            if (self.icon.length > 0) {
                marker.setMap(null);
                var shape = {
                    coords: [1, 1, 1, 34, 32, 33, 34, 1],
                    type: 'poly'
                };
                var image = {
                    url: self.icon,
                    size: new google.maps.Size(40, 44),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 44)
                };
                marker = new google.maps.Marker({
                    position: self.position,
                    icon: image,
                    shape: shape,
                    map: map,
                    title: self.title,
                    draggable: true,
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