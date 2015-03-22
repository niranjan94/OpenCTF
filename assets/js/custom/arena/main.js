$.pjax.defaults.timeout = 5000;
$(document).pjax('a', '#pjax-container',{
    'maxCacheLength': 0
});
$("body").niceScroll({
    cursorwidth:"10px",
    cursorborderradius: "0px",
    cursoropacitymin: 0.5
});
$(document).on('pjax:end', function() {
    try{
        ga('send', 'pageview', window.location.pathname);
    } catch(err){
        console.log(err);
    }
    try{
        $.globalEval($("#old-javascript-holder").html().replace("<!--", "").replace("-->", ""));
    } catch(err){
        console.log(err);
    }
    try {
        $.globalEval($("#javascript-holder").html().replace("<!--", "").replace("-->", ""));
    } catch (err){
        console.log(err);
    }
    try{
        $("body").getNiceScroll().resize();
    } catch (err){
        console.log(err);
    }
    try{
        $("body").getNiceScroll().resize();
    } catch (err){
        console.log(err);
    }
    setTimeout(function(){
        try{
            $("body").getNiceScroll().resize();
        } catch (err){
            console.log(err);
        }
    },800);
});

$( document ).on('pjax:error', function(event, xhr, textStatus, errorThrown, options) {
    event.preventDefault();
    $('#pjax-container').html(xhr.responseText);
});