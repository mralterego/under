
var vm = new Vue({
    el: "#homepage",
    data: {
        author: {
            id: "",
            name: "",
        },
        getter: {
            id: "",
            name: "",
        },
        social: {
            vk: "",
            fb: "",
            sc: "",
            site: "",
        },
        message: "",
        users: [],
        getMessage: false,
        showUsersField: false,
        showScroll: false,
    },
    created: function () {

    },
    updated: function(){

    },
    methods: {
        openField: function(){
            this.showUsersField = true;
        },
        update: function () {
            var uri = "/home/update";
            $.post(uri,
                {
                    social: JSON.stringify(this.social),
                })
                .done(function(data) {
                    console.log(data.response);
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        getUsers: function(){
            var uri = "/user/users",
                self = this;

            $.get(uri)
                .done(function(data){
                    self.users =  data.response;

                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        selectGetter: function(event){
            var self = this,
                name = event.target.innerText,
                id = event.target.id,
                label = document.querySelectorAll(".user-search label")[0];

            self.getter.id = id;
            self.getter.name = name;
            self.users = [];
            label.className = " active";
            $('#message_window').modal('open');

        },
        sendMessage:  function(){
            var self = this,
                uri = "/messages/create";
                $.post(uri, {
                        author: self.author.name,
                        getter: self.getter.name,
                        content: self.message,
                    })
                    .done(function(data){
                        console.log(data.response);
                    })
                    .fail(function(error) {
                        console.log(error);
                    });


        },
        checkHeight: function(classname){
            var field = document.querySelectorAll(classname)[0];
            var height = field.offsetHeight;
            return height;
        },
        search: function(event){
            var uri = "/user/search",
                self = this,
                keyword = event.target.value,
                height = self.checkHeight(".__select_users");
                if (height >  298){
                    self.showScroll = true;
                }
                if (keyword.length > 2){
                    self.users = [];
                    $.get(uri, {
                            keyword: keyword
                       })
                        .done(function(data){
                            self.users =  data.response;

                        })
                        .fail(function(error) {
                            console.log(error);
                        });
                }

        }
    }
});