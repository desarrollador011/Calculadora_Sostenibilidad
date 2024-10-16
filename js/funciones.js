/**
 * Created by jom on 06-07-2017.
 */

$(document).ready(function(){

    if(typeof($.fn.popover) != 'function'){
        alert ("instalado");
    }

    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    $('[data-toggle="popover"]').popover();

    $('#ayuda').popover({
        container: 'body'
    });
});

$(window).ready(function(){
    resizeIframe();
});
$(window).load(function(){
    resizeIframe();
});


