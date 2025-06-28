$(document).ready(function() {
    $(".colorButton").click(function() {
        $(".colorAccessibility").fadeToggle(300);
        $(".fontSizeAccessibility").fadeOut(300);
        $(".support").fadeOut(300);
        $(".notification").fadeOut(300);
    });

    $(".fontSizeButton").click(function() {
        $(".colorAccessibility").fadeOut(300);
        $(".fontSizeAccessibility").fadeToggle(300);
        $(".support").fadeOut(300);
        $(".notification").fadeOut(300);

    });

    $(".supportButton").click(function() {
        $(".colorAccessibility").fadeOut(300);
        $(".fontSizeAccessibility").fadeOut(300);
        $(".support").fadeToggle(300);
        $(".notification").fadeOut(300);

    });

    $(".notificationButton").click(function() {
        $(".colorAccessibility").fadeOut(300);
        $(".fontSizeAccessibility").fadeOut(300);
        $(".support").fadeOut(300);
        $(".notification").fadeToggle(300);

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

    $("#mainButton").click(function () {
        window.location = "../main.php";
    });

    $("#genreButton").click(function () {
        window.location = "../genre.php";
    });

    // Apply saved theme on load (enhanced)
    function applySavedTheme() {
        const savedTheme = localStorage.getItem("themeColor") || "defaultColor";
        document.documentElement.setAttribute("data-themeColor", savedTheme);
        
        // Highlight the selected option in the dropdown
        $(".colorAccessibility .option").removeClass("default");

        // String interpolation in js
        $(`.colorAccessibility .option[data-color="${savedTheme}"]`).addClass("default");

        if (savedTheme == "darkColor") {
            $("#logoImage").attr("src", "../image/logoTitle_dark.png");
            
        } else {
            $("#logoImage").attr("src", "../image/logoTitle.png");
        }
    }

    // Run this on every page load
    applySavedTheme();

    // Theme selection handler (unchanged)
    document.querySelectorAll(".colorAccessibility .option").forEach(option => {
        option.addEventListener("click", function() {
            const theme = this.getAttribute("data-color");
            document.documentElement.setAttribute("data-themeColor", theme);
            localStorage.setItem("themeColor", theme);
            applySavedTheme(); // Update UI to reflect selection
        });
    });

    function applyFontSize() {
        const savedFontSize = localStorage.getItem("fontSize") || "defaultFontSize";
        document.documentElement.setAttribute("data-fontSize", savedFontSize);

        $(".fontSizeAccessibility .option").removeClass("default");

        // String interpolation in js
        $(`.fontSizeAccessibility .option[data-setFontSize="${savedFontSize}"]`).addClass("default");
    }

    applyFontSize();

    // Theme selection handler (unchanged)
    document.querySelectorAll(".fontSizeAccessibility .option").forEach(option => {
        option.addEventListener("click", function() {
            const theme = this.getAttribute("data-setFontSize");
            document.documentElement.setAttribute("data-fontSize", theme);
            localStorage.setItem("fontSize", theme);
            applyFontSize(); // Update UI to reflect selection
        });
    });

    $(".profile").click(function() {
        window.location = "../profilemyposts.php";
    });
});