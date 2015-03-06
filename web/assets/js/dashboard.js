'use strict';

var app = {
    init:function(){
        this.initCarousel();
    },
    initCarousel:function(){
        $("#owl-demo").owlCarousel({
            autoPlay: 5000,
            items : 1,
            singleItem: true,
            autoHeight: true,
            itemsScaleUp:true
        });
    }
};
app.init();