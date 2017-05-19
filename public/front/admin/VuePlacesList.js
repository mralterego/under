
var vm = new Vue({
    el: "#places_list_page",
    data: {
        items: [],
        showTable: false,
    },
    created: function(){
        this.getPlaces();
    },
    methods: {
        getPlaces: function(){
            var self = this,
                uri = "/admin/places/api";

            $.get(uri)
                .done(function(data) {
                    console.log(data.response);
                    self.showTable = true;
                    self.items = data.response;
                })
                .fail(function(error) {
                    self.showTable = false;
                    console.log(error);
                });
        }
    }
});