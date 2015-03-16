'use strict';

var app = {
    owl:null,
    preloader:null,
    form:"#search-form",
    searchContainer:"#search-container",
    selected:[],
    user:{},
    init:function(){
        this.initCarousel();
        this.initPreloader();
        $(this.form).on("submit", this.searchForm);
    },
    initCarousel:function(){
        $("#owl-demo").owlCarousel({
            autoPlay: 4000,
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
                        if(app.owl){
                            app.owl.destroy();
                        }
                        app.owl = null;
                        app.user.id = response.userId;
                        app.user.type = response.userType;
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
            error:function(){
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
    showLoading:function(target){
        if(!target){
            target = $(this.searchContainer)[0];
        }
        target.appendChild(this.preloader.el);
    },
    hideLoading:function(target){
        if(!target){
            target = $(this.searchContainer)[0];
        }
        $(target).find(".spinner.loading").remove();
    },
    showModal:function(title, message, acceptButton, agreeCallback){
        var $modal = $('#modal');
        var html = $modal.html()
            .replace("{$title}", title)
            .replace("{$message}", message)
            .replace("{$acceptButton}", acceptButton);
        $modal.html(html).modal('show');
        $modal.off("hidden.bs.modal").on("hidden.bs.modal", function(){
            if(agreeCallback !== undefined){
                agreeCallback();
            }
        });
        $modal = html = undefined;
    },
    showConfirmModal:function(title, message, acceptButton, agreeCallback){
        var $modal = $('#modal-confirm');
        var html = $modal.html()
            .replace("{$title}", title)
            .replace("{$message}", message)
            .replace("{$acceptButton}", acceptButton);
        $modal.html(html).modal('show');
        $(".agree-option").off("click").on("click", function(){
            if(agreeCallback !== undefined){
                agreeCallback();
            }
        });
        $modal = html = undefined;
    },
    initVoting:function(target){
        $(".owl-candidates").owlCarousel({
            autoPlay: 6000,
            items : 5,
            autoHeight: true,
            itemsScaleUp:true
        });

        $(".candidate.item").on("click", function(event){
            app.selectCandidate(event, target);
        });
        
        $("#send-vote").on("click", function(){
            app.showConfirmModal(
                "Confirmación",
                "¿Confirma que desea registrar su voto?",
                "Aceptar",
                function(){
                    app.sendVote();
                }
            );
        });
    },
    sendVote:function(){
        if(app.selected.length === 0){
            app.showModal(
                "Mensaje",
                "Para poder realizar la votación debe escoger al menos un candidato.",
                "Aceptar"
            );
            return;
        }
        $.ajax({
            url:$("#send-vote-url").val().trim(),
            type:"POST",
            dataType:'json',
            data:{
                data:JSON.stringify({
                    userId:app.user.id,
                    userType:app.user.type,
                    selected:app.selected
                })
            },
            beforeSend:function(){
                $("#send-vote").off("click");
                app.showLoading($("#modal-confirm").find(".modal-body")[0]);
            },
            success:function(response){
                app.showModal(
                    "Mensaje",
                    response.message,
                    "Aceptar",
                    function(){
                        location.reload();
                    }
                );
            },
            error:function(){
                app.showModal(
                    "Mensaje",
                    "Ops! parece que hay un problema en el servidor, por favor intentalo nuevamente.",
                    "Aceptar"
                );
            },
            complete:function(){
                app.hideLoading($("#modal-confirm").find(".modal-body")[0]);
                app.user = {};
                app.selected = [];
            }
        });
    },
    selectCandidate:function(event, target){
        var item = app.findObjectUp(event.target, ".item");
        var $item = $(item);
        var attr = $item.attr("target");
        var i = 0;
        var found = false;
        while(i < app.selected.length && !found){
            if(app.selected[i].tag === attr){
                $(".candidate.item[selected][target='" + attr + "']")
                    .removeAttr("selected")
                    .find(".item-mark")
                    .removeClass("slidein")
                    .addClass("slideout");
                found = true;
            }
            i += 1;
        }
        if(found){
            app.selected.splice(i-1, 1);
        }
        app.selected.push({
            tag:attr,
            id:$item.attr("target-id"),
            type:attr.split("-")[1]
        });
        
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