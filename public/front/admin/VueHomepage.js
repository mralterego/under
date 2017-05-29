
var vm = new Vue({
    el: "#homepage",
    data: {
        social: {
            vk: "",
            fb: "",
            sc: "",
            site: "",
        }
    },
    created: function () {

    },
    methods: {
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