<div id="rate">
    <div class="all_rate right">
        @{{ allRate }} / 10
    </div>
    <div class="rating">
        <a v-for="item in rate" v-on:click="setStars(item.mark)" v-on:mouseleave="unsetStars" v-on:mouseenter="colorStars(item.mark)" :id="item.mark"><span class="yellow-text __rate_icons"><i class="material-icons">@{{ item.name }}</i></span></a>
    </div>
</div>