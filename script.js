$(document).ready(function() {
    $(".colorButton").click(function() {
        $(".colorAccessibility").fadeToggle(300);
        $(".fontSizeAccessibility").fadeOut(300);
        $(".support").fadeOut(300);
    });

    $(".fontSizeButton").click(function() {
        $(".colorAccessibility").fadeOut(300);
        $(".fontSizeAccessibility").fadeToggle(300);
        $(".support").fadeOut(300);
    });

    $(".supportButton").click(function() {
        $(".colorAccessibility").fadeOut(300);
        $(".fontSizeAccessibility").fadeOut(300);
        $(".support").fadeToggle(300);
    });

    $("#burgerIcon").click(function() {
        if ($("aside").hasClass("visible")) {
            $("aside").fadeOut(300, function() {
                $("aside").removeClass("visible");
            });
        } else {
            $("aside").addClass("visible").hide().fadeIn(300);
        }
    });
});