function showServerError(timeout){
    if(typeof e === "undefined") {
        timeout = 5000;
    }
    $.snackbar({content: "There was an error connecting to the server. Please try again later", timeout: timeout})
        .css("background-color","#ffe8e6").css("color","#d95c5c");
}
function showUnknownError(timeout){
    if(typeof e === "undefined") {
        timeout = 5000;
    }
    $.snackbar({content: "There was an error. Please try again later", timeout: timeout})
        .css("background-color","#ffe8e6").css("color","#d95c5c");
}
