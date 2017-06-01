<div id="dialog_window" class="modal">
    <div class="modal-content">
        <h4 class="black-text">Диалоговое окно</h4>
        <div class="dialog-field">
            <div class="row">
                <div class="col s4 __border_right">
                    <div class="senders">
                        <div class="collection">
                            <a v-on:click="openMessages(author.id, author.name)" href="#!" class="collection-item" v-for="author in authors">@{{ author.name }}<span class="badge right new ">@{{ author.count }}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col s8">
                    <p class="__message black-text __margin-top_xs __margin-bottom_xs" v-for="message in activeMessages"><span class="blue-text text-darken-5" >@{{ message.time }}</span>: @{{ message.content }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <textarea class="materialize-textarea black-text" v-model="message"></textarea>
                        <label>Ваше сообщение</label>
                    </div>
                </div>
            </form>
        </div>

        <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="sendMessage">
            &nbsp;&nbsp;Отправить
            <i class="material-icons right dp48">send</i>
        </a>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close black-text"><i class="material-icons right dp48">clear</i></a>
    </div>
</div>