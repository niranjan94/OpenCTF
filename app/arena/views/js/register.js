$("#pjax-container").find("*").unbind();
$('.ui.checkbox').checkbox();
$('.dropdown').dropdown();
$('.ui.radio.checkbox').checkbox();
function openTos(e){
    /*$("#tos-content").html("");*/
    $('.modal').modal('show');
}

$.fn.form.settings.rules.username = function(value) {
    return true;
};

$('.ui.form.step-1')
    .form({
        gender: {
            identifier  : 'gender',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please select your gender'
                }
            ]
        },
        firstName: {
            identifier  : 'first-name',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter your first name'
                }
            ]
        },
        lastName: {
            identifier  : 'last-name',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter your last name'
                }
            ]
        },
        about: {
            identifier  : 'about',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Tell us about yourself'
                }
            ]
        },
        username: {
            identifier  : 'username',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter desired username'
                },
                {
                    type   : 'username',
                    prompt : 'That username is already taken'
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
        },
        email: {
            identifier  : 'email',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter your email address'
                },
                {
                    type   : 'email',
                    prompt : 'A valid email address is required'
                }
            ]
        },
        terms: {
            identifier : 'agree-tos',
            rules: [
                {
                    type   : 'checked',
                    prompt : 'You must agree to the terms and conditions'
                }
            ]
        }
    }, {
        inline : true,
        on     : 'change'
    })
;