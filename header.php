<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

<title></title>

</head>

<body>
    <header>
        <div id="firstHeader">
            <a href="/BookReview_BorrowingSystem/main.php" id="logo"><img src="/BookReview_BorrowingSystem/image/logoTitle.png" alt="logo" id="logoImage"></a>

            <nav>
                <div>
                    <span class="colorButton"><label for="color">Color<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility colorAccessibility">
                        <div class="default option" data-color="defaultColor">Default</div>
                        <div class="option" data-color="lightColor">Light</div>
                        <div class="option" data-color="darkColor">Dark</div>
                    </div>
                </div>

                <div>
                    <span class="fontSizeButton"><label for="fontSize">Font Size<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility fontSizeAccessibility">
                        <div class="option" data-setFontSize="smallFontSize">Small</div>
                        <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                        <div class="option" data-setFontSize="largeFontSize">Large</div>
                        <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
                    </div>
                </div>
                <div>
                    <span class="supportButton"><label for="support">Support<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility support">
                        <span style="color: black;">Follow Us At Instagram!</span>
                        <div>
                            <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                            <label for="bookSpare">@BookSpare</label>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="profile">
                        <?php echo $user['username']; ?>
                        <a>
                        <?php echo $user['username'][0]; ?>
                        </a>
                    </span>
                </div>

            </nav>
            <box-icon name='menu' id="burgerIcon" size="10"></box-icon>
        </div>
        <aside>
            <div id="profile">
                <span class="profile">
                    <?php echo $user['username']; ?>
                    <a>
                        <?php echo $user['username'][0]; ?>
                    </a>
                </span>
            </div>
            <span id="mainButton"><label for="color">Main</label></span>
            <span id="mainButton"><label for="color" id="genreButton">Genre</label></span>

            <div class="accessibility colorAccessibility">
                <div class="default option" data-color="defaultColor">Default</div>
                <div class="option" data-color="lightColor">Light</div>
                <div class="option" data-color="darkColor">Dark</div>
            </div>
            <span class="colorButton"><label for="color">Color</label></span>

            <div class="accessibility fontSizeAccessibility">
                <div class="option" data-setFontSize="smallFontSize">Small</div>
                <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                <div class="option" data-setFontSize="largeFontSize">Large</div>
                <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
            </div>
            <span class="fontSizeButton"><label for="fontSize">Font Size</label></span>

            <div class="accessibility support">
                <span style="color: black;">Follow Us At Instagram!</span>
                <div>
                    <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                    <label for="bookSpare">@BookSpare</label>
                </div>
            </div>
            <span class="supportButton"><label for="support">Support</label></span>
        </aside>
        <div id="secondHeader">
            <nav>
                <a href="/BookReview_BorrowingSystem/main.php"><label for="main">Main</label></a>
                <a href="/BookReview_BorrowingSystem/genre.php"><label for="genre">Genre</label></a>
            </nav>
            <nav>
                <box-icon name='search-alt'></box-icon>
                <input type="text" placeholder="Search by book name/ thread">
            </nav>
            <nav>
                <a href="/BookReview_BorrowingSystem/logout.php"><label for="main">Logout</label></a>
            </nav>
        </div>
    </header>

</body>

</html>