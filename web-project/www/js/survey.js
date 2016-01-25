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
            $(this).val("Opravdu přejít k otázkám");
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
        radio.prop("checked",true).parent().addClass("active");

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

    $(".survey-wireframe-reverse [data-select-image]").on("click", function(){
        var current = $(this).data("select-image");
        wireframeReverseSetOption(current);
    });

    $(".survey-wireframe-reverse input[name='id_pages']").on("change", function(){
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

    $('[data-toggle="tooltip"]').tooltip();


    $(document).on("click",".change-state",function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var link = $(this);
        $.get(
            link.attr("href"),
            {
                id_subquestion : link.data("id"),
                state : link.data("state")
            },
            function(data){
                link.parent().replaceWith(data);
            }
        );
    });

    $('textarea, input:text, input[type=email]').on("keydown",function (e) {
        if (e.ctrlKey && e.keyCode == 13) {
            $(this).closest("form").submit();
        }
    });

    $(document).on("click","#page-results tr.data", function(){
        var groups = [
            {
                color : "#3397C7",
                count : 0,
                name : 1
            },
            {
                color : "#00ff33",
                count : 0,
                name : 2
            },
            {
                color : "#666699",
                count : 0,
                name : 3
            },
            {
                color : "#993399",
                count : 0,
                name : 4
            },
            {
                color : "#cccc00",
                count : 0,
                name : 5
            }
        ]
        var tr = $(this);
        if(tr.is(".highlighted")){
            var current_group_name = tr.data("group");
            var next = false;
            tr.removeClass("highlighted");
            tr.removeAttr("data-group");
            tr.css("background-color","white");
            $.each(groups, function(i,group){
                if(next){
                    tr.data("group", group.name);
                    tr.css("background-color", group.color);
                    tr.addClass("highlighted");
                    next = false;
                }
                if(group.name === current_group_name) next = true;
            });
        }else{
            tr.addClass("highlighted");
            var color = groups[0];
            tr.data("group",color.name);
            tr.css("background-color",color.color);
        }
        var table = tr.closest("table");
        table.closest("div").find(".selected-count").remove();
        var total_count = 0;
        table.find("tr.highlighted").each(function(i,row){
           total_count++;
            var group_name = $(row).data("group");
            $.each(groups, function(i,group){
               if(group.name === group_name){
                   group.count++;
               }
            });
        });
        if(total_count > 0){
            table.before($("<span></span>").text("Vybráno položek: "+total_count).addClass("selected-count total").css({
                "margin-left":"7px",
                "margin-right":"7px"
            }));
        }
        $.each(groups, function(i,group){
            if(group.count > 0){
                table.before($("<span></span>").addClass("selected-count group").text(group.count).css({
                    display: "inline-block",
                    backgroundColor: group.color,
                    color : "white",
                    width: "20px",
                    textAlign : "center"
                }));
            }
        });
    });
});

$(function () {
    $.nette.init();

    $.nette.ext("#page-results form",{
        before : function(a,b){
            var button = $(b.nette.el);
            var loader = $("<span></span>").addClass("progress");
            button.after(loader);
        }
    })
});