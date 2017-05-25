
var vm = new Vue({
    el: "#posts_list_page",
    data: {
        items: [],
        showTable: false,
    },
    created: function(){
        this.getPosts();
    },
    methods: {
        getPosts: function(){
            var self = this,
                uri = "/admin/posts/api";

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