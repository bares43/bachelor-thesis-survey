/**
 * Created by janba_000 on 25. 8. 2015.
 */

var question_noty_shown = false;
$(document).ready(function(){
    $("#frm-personalForm").find("[name=nonvalidate]").on("click", function(e){
        var appeal = $("#validation-appeal");
        if(!appeal.is(":visible")){
            e.preventDefault();
            e.stopImmediatePropagation();
            appeal.show();
            $(this).val("Opravdu nechci sdělovat svoje údaje");
        }
    });

    $("#homepage-image #image-container").beforeAfter({
        afterLinkText : "Zobrazit wireframe",
        beforeLinkText : "Zobrazit původní stránku"
    });
    var image_handle = $("img[alt=handle]");
    image_handle.attr("width",70);
    image_handle.attr("height",32);
    image_handle.attr("src","images/handle.png");
    image_handle.css("left","-35px");
    image_handle.css("top","179px");
    $(".balinks a").addClass("btn btn-default");

    $("select.fancy").fancySelect({
        optionTemplate : function(option){
            var div = $("<div></div>");
            div.append($("<span></span>").text(option.text()).addClass("fancy-text").attr("title", option.text()));
            return div.html();
        }
    });

    $("img.elevate-zoom").elevateZoom({
        zoomType : "inner",
        cursor : "pointer"
    });

    function createNoty(text){
        noty({
            text: text,
            theme:'survey',
            layout: 'top'
        });
    }


    function wireframeReverseSetOption(option){
        $("img[data-select-image]").removeClass("selected-image");
        $("img[data-select-image="+option+"]").addClass("selected-image");

        $("a[data-select-image]").removeClass("btn-primary").addClass("btn-default");
        $("a[data-select-image="+option+"]").addClass("btn-primary").removeClass("btn-default");

        var radio = $("input[name='id_pages'][value="+option+"]");

        $("input[name='id_pages']").not(radio).removeAttr("checked").parent().removeClass("active");
        radio.attr("checked",true).parent().addClass("active");

        if(!question_noty_shown){
            question_noty_shown = true;
            setTimeout(function(){
                wireframeReverseSelected();
            },2000);
        }
    }

    function wireframeReverseSelected(){
        $.noty.closeAll();

        setTimeout(function(){
            createNoty("Nezapomeňte odpověď odeslat klikem na tlačítko \"Pokračovat v dotazníku\".");
            $('html, body').animate({
                scrollTop: $("footer").offset().top
            }, 1200);
            $("input:submit[name=continue]").focus();
        },1000);
    }

    $("[data-select-image]").on("click", function(){
        var current = $(this).data("select-image");
        wireframeReverseSetOption(current);
    });

    $("#frm-wireframeReverseForm input[name='id_pages']").on("change", function(){
        if($(this).is(":checked")){
            var current = $(this).val();
            wireframeReverseSetOption(current);
        }
    });

    $("[data-focus]").on("click", function(){
        $('html, body').animate({
            scrollTop: $("footer").offset().top
        }, 1200);
        var selector = $(this).data("focus");
        if(selector !== undefined && selector.length > 0){
            var focus = $(selector);
            focus.focus();
        }
    });

    $(".buttons-group").parent().addClass("btn btn-default").parent().addClass("btn-group").attr("data-toggle","buttons").find("br").remove();

    if($("input:hidden[name='seconds']").length === 1){
        var seconds = 0;
        setInterval(function(){
            ++seconds;
            $("input:hidden[name='seconds']").val(seconds);
        },1000);
    }
});