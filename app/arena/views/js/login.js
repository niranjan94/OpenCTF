$("#pjax-container").find("*").unbind();
$('.ui.checkbox').checkbox();
$('.dropdown').dropdown();
$('.ui.radio.checkbox').checkbox();
$('.forgot-password').click(function(){
    $('.forgot-password-modal').modal('setting', 'closable', false).modal('show');
});

var $loginForm = $('.ui.form.login');
$loginForm
    .form({
        username: {
            identifier  : 'username',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter desired username'
                }
            ]
        },
        password: {
            identifier  : 'password',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter a password'
                }
            ]
        }
    },{
        inline : false,
        on     : 'change',
        onSuccess: function(e){
            killDefault(e);
            $(".password-error-message").removeClass("message").addClass("hidden").removeClass("not-hidden");
            $loginForm.addClass("loading");
            var params = {step: 'one'};
            $.ajax({
                type: "POST",
                url: api.arena.login,
                data: mergeParams($loginForm,params),
                success: function(result) {
                    if(result.status=="ok"){
                        $(".ui.three.steps > .step:nth-child(1)").setCompleted();
                        $(".ui.three.steps > .step:nth-child(2)").setActive();
                        $(".verify-email-alert").show();
                        replaceURL("/register/verify-email/","Confirm your email");
                        $loginForm.hide();
                    } else if(result.status=="incorrect"){
                        $loginForm.removeClass("loading");
                        $(".password-error-message").addClass("message").removeClass("hidden").addClass("not-hidden");
                    } else {
                        $loginForm.removeClass("loading");
                    }

                },
                error: function(jqXHR,textStatus,errorThrown){
                    logAjaxError(jqXHR,textStatus,errorThrown);
                    $loginForm.removeClass("loading");
                }
            });
        },
        onFailure: function(e){
            $(".password-error-message").removeClass("message").addClass("hidden").removeClass("not-hidden");
        }
    })
;
$(".forgot-password-positive").click(function (e) {
    killDefault(e);
    $(this).setLoading();
});
