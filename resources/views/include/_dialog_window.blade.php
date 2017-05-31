<div id="dialog_window" class="modal">
    <div class="modal-content">
        <h4 class="black-text">Диалог с <span class="purple-text text-darken-4">@{{getter.name}}</span></h4>
        <div class="dialog-field">
            <div class="row">
                <div class="col s12">
                    <p>A bunch of text</p>
                </div>
            </div>
        </div>
        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <textarea class="materialize-textarea" v-model="message"></textarea>
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