
var vm = new Vue({
    el: "#collectives_list_page",
    data: {
        items: [],
        showTable: false,
    },
    created: function(){
        this.getCollectives();
    },
    methods: {
        getCollectives: function(){
            var self = this,
                uri = "/admin/collectives/api";

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