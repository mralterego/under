
var vm = new Vue({
    el: "#events_list_page",
    data: {
        items: [],
        showTable: false
    },
    created: function(){
        this.getEvents();
    },
    methods: {
        getEvents: function(){
            var self = this,
                uri = "/admin/events/api";

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
