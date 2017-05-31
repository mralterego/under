
// Создание конструктора
Vue.component('message',{
    template: '\
        <a v-on:click="dialog" title="Сообщения" href="#">\
            <i class="material-icons">mail</i>\
            <span v-if="showMessagesCount" class="new badge">{{ newMessages }}</span>\
        </a>\
      ',
    data: function () {
        return {
            newMessages: 0,
            showMessagesCount: false,
            message: {}
        }
    },
    created: function(){
        var uri = "/user/messages",
            self = this;

        $.get(uri)
            .done(function(data){
                if (data.response.length > 0){
                    self.message = data.response;
                    self.newMessages = data.response.length;
                    self.showMessagesCount = true;
                } else {
                    self.newMessages = 0;
                    self.showMessagesCount = false;
                }
            })
            .fail(function(error) {
                console.log(error);
            });
    },
    methods: {
        dialog: function(){
            this.$emit('dialog');
            wrapperVm.$emit('message', this.message);
        }
    }
});

var wrapperVm = new Vue({
    el: "#nav-mobile",
    data: {
        getter: {
            name: "хуй",
        },
        message: "хуй"
    },
    created: function(){
        this.$on('message', function(msg){
            this.getter.name = msg[0].author;
        });
    },
    methods: {
        openDialog: function(){

            $('#dialog_window').modal('open');
        },
        sendMessage: function(){

        }
    }
});
