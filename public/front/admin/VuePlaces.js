
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
        published: false,
        showPoster: true,
    },
    created: function () {

    },
    methods: {
        create: function(){

        },
        getMap: function(){
            var self = this;
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });
            google.maps.event.addListener(map, "rightclick", function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                // populate yor box/field with lat, lng
                self.coordinates = lat + "," + lng;
            });
        }
    }

});