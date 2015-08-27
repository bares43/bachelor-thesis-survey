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

    $(".homepage-image #image-container").beforeAfter({
        afterLinkText : "Zobrazit wireframe",
        beforeLinkText : "Zobrazit původní stránku"
    });
    $("img[alt=handle]").attr("width",70);
    $("img[alt=handle]").attr("height",32);
    $("img[alt=handle]").attr("src","images/handle.png");
    $("img[alt=handle]").css("left","-35px");
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
        };
    });

    $("[data-focus]").on("click", function(){
        var focus = $($(this).data("focus"));
        focus.focus();
    });

    $(".buttons-group").parent().addClass("btn btn-default").parent().addClass("btn-group").attr("data-toggle","buttons").find("br").remove();

    //$('[data-toggle="tooltip"]').tooltip()

    //var submit_parent = $("input:submit").parent();
    //if(submit_parent.is("td")){
    //    var count_previous = submit_parent.prevAll().length;
    //    if(count_previous > 0) {
    //        submit_parent.prevAll().remove();
    //        submit_parent.attr("colspan", (count_previous + 1));
    //        submit_parent.addClass("submit-wrapper");
    //    }
    //}
});