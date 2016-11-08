jQuery(document).ready(function ($) {
    
    jQuery("#aw_btn_ok").click(function () {
        setcookie();
        jQuery(".aw_background").fadeOut(600);
    });

    function setcookie() {
        localStorage.controlwa = (localStorage.controlwa || 0);
        localStorage.controlwa++;
    }
    
    if (!localStorage.controlwa) jQuery(".aw_background").fadeIn(600);
    
    jQuery("#aw_btn_cancel").click(function () {
        window.history.back();
    });
});