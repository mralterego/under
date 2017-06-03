
var vm = new Vue({
    el: "#albums_list_page",
    data: {
        items: [],
        showTable: false,
    },
    created: function(){
        this.getAlbums();
    },
    methods: {
        getAlbums: function(){
            var self = this,
                uri = "/admin/albums/api";
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