
var vm = new Vue({
    el: "#rate",
    data: {
        rate: [
            { mark: 1, name: "star_border" },
            { mark: 2, name: "star_border" },
            { mark: 3, name: "star_border" },
            { mark: 4, name: "star_border" },
            { mark: 5, name: "star_border" },
            { mark: 6, name: "star_border" },
            { mark: 7, name: "star_border" },
            { mark: 8, name: "star_border" },
            { mark: 9, name: "star_border" },
            { mark: 10, name: "star_border" },
        ],
        allRate: 0,
        activated: false,
        showCommonRate: false
    },
    created: function () {
        this.getRate();
    },
    updated: function(){

    },
    methods: {
        getRate: function(){
            var self = this,
                uri = "/rating/post",
                postId = document.getElementById("hidden-id").innerText;
            $.get(uri, {
                postId: postId
            }).done(function(data){
                console.log(data.response);
                self.allRate = data.response;
                self.colorStars(self.allRate);
            }).fail(function(error){
                console.log(error);
            });
        },
        successAction: function(message){
            Materialize.toast(message, 4000);
        },
        colorStars: function(mark){
            this.rate.forEach(function(item, i){
                if (mark > i){
                    item.name = "star";
                } else {
                    item.name = "star_border";
                }
            });
        },
        unsetStars:  function(){
            if (this.activated = false){
                this.rate.forEach(function(item, i){
                    item.name = "star_border";
                });
            }
        },
        setStars: function(mark){
            var self = this;
            self.activated = true;
            self.colorStars(mark);
            var uri = "/user/rating",
                postId = document.getElementById("hidden-id").innerText;
            $.post(uri, {
                rate: mark,
                postId: postId,
            }).done(function(data){
                console.log(data.response);
                self.getRate();
                self.successAction("Оценка учтена!");
            }).fail(function(error){
                console.log(error);
            });
        }
    }

});
