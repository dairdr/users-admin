'use strict';

var app = {
    owl:null,
    preloader:null,
    form:"#search-form",
    searchContainer:"#search-container",
    selected:[],
    init:function(){
        this.initCarousel();
        this.initPreloader();
        $(this.form).on("submit", this.searchForm);
    },
    initCarousel:function(){
        $("#owl-demo").owlCarousel({
            autoPlay: 5000,
            items : 1,
            singleItem: true,
            autoHeight: true,
            itemsScaleUp:true
        });
        this.owl = $(".owl-carousel").data('owlCarousel');
    },
    initPreloader:function(){
        var opts = {
            lines: 11, // The number of lines to draw
            length: 9, // The length of each line
            width: 2, // The line thickness
            radius: 6, // The radius of the inner circle
            corners: 1, // Corner roundness (0..1)
            rotate: 0, // The rotation offset
            direction: 1, // 1: clockwise, -1: counterclockwise
            color: '#000', // #rgb or #rrggbb or array of colors
            speed: 1, // Rounds per second
            trail: 22, // Afterglow percentage
            shadow: false, // Whether to render a shadow
            hwaccel: false, // Whether to use hardware acceleration
            className: 'spinner loading', // The CSS class to assign to the spinner
            zIndex: 2e9, // The z-index (defaults to 2000000000)
            top: '50%', // Top position relative to parent
            left: '90%' // Left position relative to parent
        };
        this.preloader = new Spinner(opts).spin();
    },
    searchForm:function(event){
        event.preventDefault? event.preventDefault(): event.returnValue = false;
        $.ajax({
            url:$("#send-form").val().trim(),
            type:'post',
            data:$(event.target).serialize(),
            dataType:'json',
            beforeSend:function(){
                $(this.form).off();
                app.showLoading();
            },
            success:function(response){
                if(response.state === 'ok'){
                    $(".content-container").fadeOut(500,function(){
                        $(this).hide()
                            .html(response.template)
                            .fadeIn(500);
                        app.owl.destroy();
                        app.initVoting(response.target);
                    });
                }else {
                    app.showModal(
                        "Mensaje",
                        response.message,
                        "Aceptar"
                    );
                }
            },
            error:function(response){
                app.showModal(
                    "Mensaje",
                    "Ops! parece que se ha presentado un error en el sistema, por favor intentalo más tarde :(",
                    "Aceptar"
                );
            },
            complete:function(){
                $(this.form).on("submit", this.searchForm);
                app.hideLoading();
            }
        });
    },
    showLoading:function(){
        var target = $(this.searchContainer)[0];
        target.appendChild(this.preloader.el);
    },
    hideLoading:function(){
        var target = $(this.searchContainer)[0];
        $(target).find(".spinner.loading").remove();
    },
    showModal:function(title, message, acceptButton){
        var $modal = $('#modal');
        var html = $modal.html()
            .replace("{$title}", title)
            .replace("{$message}", message)
            .replace("{$acceptButton}", acceptButton);
        $modal.html(html).modal('show');
        $modal = html = undefined;
    },
    initVoting:function(target){
        $(".owl-candidates").owlCarousel({
            autoPlay: false,
            items : 5,
            autoHeight: true,
            itemsScaleUp:true
        });

        $(".candidate.item").on("click", function(event){
            app.selectCandidate(event, target);
        });
    },
    selectCandidate:function(event, target){
        var item = app.findObjectUp(event.target, ".item");
        var $item = $(item);
        var attr = $item.attr("target");
        var found = false;
        [].forEach.call(app.selected, function(item){
            if(item.tag === attr){
                found = true;
                $(".candidate.item[selected][target='" + attr + "']")
                    .removeAttr("selected")
                    .find(".item-mark")
                    .removeClass("slidein")
                    .addClass("slideout");
                return;
            }
        });
        
        if(!found){
            app.selected.push({
                tag:attr,
                id:$item.attr("target-id"),
                type:attr.split("-")[1]
            });
        }
        
        $item.find(".item-mark")
            .removeClass("slideout")
            .addClass("slidein");
        $item.attr("selected", true);
        item = undefined;
    },
    jQueryContains:function($jq,elem){
        for(var i=0; i<$jq.length;i++){
            if($jq[i]===elem)
                return true;
        }
        return false;
    },
    findObjectUp:function(target, selector){
        var $jq = $(selector);
        var obj = target;
        while(app.jQueryContains($jq,obj) === false){
            if(obj.parentNode){
                obj = obj.parentNode;
            }else{
                return null;
            }
        }
        return obj;
    }
};
app.init();