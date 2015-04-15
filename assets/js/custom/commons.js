function logAjaxError(jqXHR,textStatus,errorThrown){
    console.log("XHR ERROR: "+textStatus);
    console.log(errorThrown);
    console.log(jqXHR);
}
function mergeParams(form,addons){
    if (typeof(addons)==='undefined'){
        return form.serialize();
    } else {
        return form.serialize()+"&"+$.param(addons);
    }
}
function killDefault(e){
    if(typeof e === "undefined") {

    } else {
        try{
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
        } catch (err){
            console.log(err);
        }
    }
}
$.fn.extend({
    enable: function() {
        $(this).removeAttr("disabled");
    },
    disable: function() {
        $(this).attr("disabled","disabled");
    },
    setActive: function() {
        $(this).removeClass("disabled").removeClass("completed").removeClass("loading").addClass("active");
    },
    setDisabled: function() {
        $(this).removeClass("active").removeClass("completed").removeClass("loading").addClass("disabled");
    },
    setCompleted: function() {
        $(this).removeClass("active").removeClass("disabled").removeClass("loading").addClass("completed");
    },
    setLoading: function() {
        $(this).removeClass("active").removeClass("disabled").removeClass("completed").addClass("loading");
    },
    setLoadingComplete: function() {
        $(this).removeClass("active").removeClass("disabled").removeClass("completed").removeClass("loading");
    }
});
function replaceURL(url,title){
    if(typeof title === "undefined") {
        title = "";
    }
    window.history.replaceState( {} , title, url );
}
function changeURL(url,title){
    if(typeof title === "undefined") {
        title = "";
    }
    window.history.pushState( {} , title, url );
}