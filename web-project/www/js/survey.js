/**
 * Created by janba_000 on 25. 8. 2015.
 */

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

    function wireframeReverseSetOption(option){
        $("img[data-select-image]").removeClass("selected-image");
        $("img[data-select-image="+option+"]").addClass("selected-image");

        $("a[data-select-image]").removeClass("btn-primary").addClass("btn-default");
        $("a[data-select-image="+option+"]").addClass("btn-primary").removeClass("btn-default");

        console.log(option);
        var radio = $("input[name='wf'][value="+option+"]");
        console.log("input[name='wf'][value="+option+"]");
        console.log(radio);

        $("input[name='wf']").not(radio).removeAttr("checked").parent().removeClass("active");
        radio.attr("checked",true).parent().addClass("active");
    }

    $("[data-select-image]").on("click", function(){
        var current = $(this).data("select-image");
        wireframeReverseSetOption(current);
    });

    $("input[name='wf']").on("change", function(){
        if($(this).is(":checked")){
            var current = $(this).val();
            wireframeReverseSetOption(current);
        }
    });

    $("[data-focus]").on("click", function(){
        var focus = $($(this).data("focus"));
        focus.focus();
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