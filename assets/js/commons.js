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
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
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
var updateFooter = function () {
    var $body = $('body');
    var window_height = $(window).height();
    var body_offset_top = $body.offset().top;
    var body_outer_height = $body.outerHeight();
    var body_height = $body.height();
    var body_bottom = (body_offset_top + body_outer_height) - ((body_outer_height - body_height) / 2);
    var $footer = $(".sticky-footer");
    var footer_height = $footer.outerHeight(true);

    if (!$footer.hasClass('sticky') && window_height > body_bottom) {
        $footer.addClass('sticky');
    }
    else if ($footer.hasClass('sticky') && window_height < body_bottom + footer_height + 1) {
        $footer.removeClass('sticky');
    }
};
updateFooter();