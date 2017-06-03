
var vm = new Vue({
    el: "#rubrics_page",
    data: {
        name: "",
        alias: "",
        items: [],
        showTable: false,
    },
    created: function(){
        this.getRubrics();
    },
    updated: function(){

    },
    methods: {
        getRubrics: function(){
            var self = this,
                uri = "/admin/rubric/api";
            $.get(uri)
                .done(function(data) {
                    console.log(data.response);
                    self.items = data.response;
                    self.showTable = true;
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        create: function(){
            var self = this,
                uri = "/admin/rubric/create";

            $.post(uri, {
                    name: self.name,
                    alias: self.alias,
                })
                .done(function(data) {
                    console.log(data.response);
                    self.getRubrics();
                    self.showTable = true;
                })
                .fail(function(error) {

                    console.log(error);
                });
        },
        remove: function(event){
            var self = this,
                uri = "/admin/rubric/remove",
                id = event.target.parentElement.parentElement.parentElement.id;
                $.post(uri, {
                    id: id,
                })
                .done(function(data) {
                    console.log(data.response);
                    self.getRubrics();
                    self.showTable = true;
                })
                .fail(function(error) {
                    console.log(error);
                });
        }
    }
});