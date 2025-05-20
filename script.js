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
            $("aside").animate({
                marginLeft: "100%"
            }, "slow", function() {
                // This runs AFTER the animation finishes
                $("aside").removeClass("visible");
            });
        } else {
            $("aside").addClass("visible").animate({
                marginLeft: "65%"
            }, "slow");
        }
    });

    // Apply saved theme on load (enhanced)
    function applySavedTheme() {
        const savedTheme = localStorage.getItem("theme") || "defaultColor";
        document.documentElement.setAttribute("data-theme", savedTheme);
        
        // Highlight the selected option in the dropdown
        $(".colorAccessibility .option").removeClass("default");

        // String interpolation in js
        $(`.colorAccessibility .option[data-value="${savedTheme}"]`).addClass("default");

        if (savedTheme == "darkColor") {
            $("header box-icon").attr("color", "white");
        } else {
            $("header box-icon").attr("color", "black");
        }
    }

    // Run this on every page load
    applySavedTheme();

    // Theme selection handler (unchanged)
    document.querySelectorAll(".colorAccessibility .option").forEach(option => {
        option.addEventListener("click", function() {
            const theme = this.getAttribute("data-value");
            document.documentElement.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
            applySavedTheme(); // Update UI to reflect selection
        });
    });
});