
var vm = new Vue({
    el: "#homepage",
    data: {
        social: {
            vk: "",
            fb: "",
            sc: "",
            site: "",
        },
        users: [],
        showUsersField: false,
    },
    created: function () {

    },
    methods: {
        openField: function(){
            this.showUsersField = true;
            console.log(this.showUsersField);
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
        }
    }
});