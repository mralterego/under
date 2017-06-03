
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
        users: [],
        authors: {
            name: "",
            count: 0,
            messages: [],
        },
        senders: {},
        selectedGetter: "",
        showSenders: false,
        showGetterName: false,
        showScroll: false,

    },
    created: function(){
        this.getUsers();
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
            this.selectedGetter = author;
            this.showGetterName = true;
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
        successAction: function(message){
            Materialize.toast(message, 4000);
        },
        checkHeight: function(classname){
            var field = document.querySelectorAll(classname)[0];
            var height = field.offsetHeight;
            return height;
        },
        getUsers: function(){
            var uri = "/user/users",
                self = this;

            $.get(uri)
                .done(function(data){
                    console.log(data.response);
                    self.users =  data.response;
                    var height = self.checkHeight(".__usersfield");
                    if (height >  298){
                        self.showScroll = true;
                    }

                })
                .fail(function(error) {
                    console.log(error);
                });
        },
        selectGetter: function(name){
            var self = this;
            self.selectedGetter = name;
            self.showGetterName = true;
            document.querySelectorAll(".__dialog-field .materialize-textarea")[0].focus();

        },
        sendMessage: function(){
            var self = this,
                uri = "/messages/create",
                author = document.getElementById("username").innerText;
                $.post(uri, {
                    author: author,
                    getter: self.selectedGetter,
                    content: self.message,
                })
                .done(function(data){
                    console.log(data.response);
                    self.message = "";
                    document.querySelectorAll(".__dialog-field label")[0].className = "";
                    self.successAction("Успешно отправлено!");
                })
                .fail(function(error) {
                    console.log(error);
                });

        },
        closeModal: function(){
            $('#dialog_window').modal('close');
        }
    }
});
