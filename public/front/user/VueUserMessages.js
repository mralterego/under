
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
        this.getUnreadMessages();
    },
    updated: function(){
        var self = this;
        wrapperVm.$on('read', function(){
            self.getUnreadMessages();
        })
    },
    methods: {
        dialog: function(){
            this.$emit('dialog');
            wrapperVm.$emit('message', this.message);
        },
        getUnreadMessages: function(){
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
        }
    }
});

var wrapperVm = new Vue({
    el: "#nav-mobile",
    data: {
        message: "",
        activeMessages: [],
        authors: {
            name: "",
            count: 0,
            messages: [],
        },
        showSenders: false,
        senders: {

        },
    },
    created: function(){
        this.$on('message', function(msg){
            var authors = [];
            console.log(this.authors);
            console.log(msg.length);
              if (msg.length != undefined){
                  this.senders = msg;
                  this.senders.forEach(function(item, i, arr){
                      var name = item.author;
                      var count = 0;
                      var messages = [];
                      for (var j = 0; j < arr.length; j ++ ){
                          if (item.author.indexOf(arr[j].author) == 0){
                              var inner = {
                                  content: arr[j].content,
                                  time: arr[j].created_at
                              };
                              messages.push(inner);
                              count += 1;
                          }
                      }
                      var author = {
                          id: i,
                          name: name,
                          count: count,
                          messages: messages,
                      };
                      authors.push(author);
                  });
                  for (var i in authors) {
                      for (var j = 0; j < authors.length; j ++ ){
                          if (authors[i] != undefined){
                              if (authors[i].name.indexOf(authors[j].name) == 0 && i != j){
                                  authors.splice(j, 1);
                              }
                          }
                      }
                  }
                  this.authors = authors;

                  this.authors.forEach(function(item, i){
                      item.id = i;
                  });
                  this.showSenders = true;
              }

        });
    },
    methods: {
        openDialog: function(){
            $('#dialog_window').modal('open');
        },
        openMessages: function(id, author){
            var uri = '/messages/read';
            this.activeMessages = this.authors[id].messages;

            $.post(uri, {
                    author: author
                }
                ).done(function(data){
                    console.log(data.response);
                    if (data.response > 0){
                        wrapperVm.$emit('read');
                    }
                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        sendMessage: function(){

        }
    }
});
