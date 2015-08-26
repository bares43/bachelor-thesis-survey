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
});