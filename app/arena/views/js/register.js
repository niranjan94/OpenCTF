$("#pjax-container").find("*").unbind();
$('.ui.checkbox').checkbox();
$('.dropdown').dropdown();
$('.ui.radio.checkbox').checkbox();
function openTos(){
    $("#tos-content").html("");
    $('.modal')
        .modal('show')
    ;
}