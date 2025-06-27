<?php  ?>
<!DOCTYPE html>
<html lang="en"
      data-themeColor="defaultColor"
      data-fontSize="defaultFontSize">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrow Request Form</title>

  <!-- icon & js libs -->
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

  <!-- main shared stylesheet -->
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="image/logo.png">

  <!-- small page-specific css (inherits colour vars from style.css) -->
  <style>
    :root{
      --formBg:  var(--loginContainerBgColor,white);
      --formCol: var(--loginContainerColor,black);
      --btnBg:   var(--loginContainerButtonBgColor,#333);
      --btnCol:  var(--loginContainerButtonColor,#fff);
      --btnBgH:  var(--loginContainerButtonHoverBgColor,#444);
      --shadow:  var(--loginContainerBoxShadow,1px 1px 10px rgba(0,0,0,.25));
    }
    main{display:flex;justify-content:center;align-items:center;padding:70px 0;}
    .form-box{background:var(--formBg);color:var(--formCol);width:100%;max-width:650px;
              border-radius:10px;box-shadow:var(--shadow);}
    .header{padding:20px 0;text-align:center;font-size:24px;font-weight:bold;
            border-bottom:1px solid #ddd;}
    .body{padding:25px 35px;}
    .field{margin-bottom:18px;}
    .field label{display:block;margin-bottom:6px;font-weight:500;}
    .field input,.field textarea{width:100%;padding:12px;border:1px solid #ccc;
                                 border-radius:5px;font-size:15px;}
    button{width:100%;padding:14px;border:none;border-radius:5px;
           background:var(--btnBg);color:var(--btnCol);font-size:16px;cursor:pointer;}
    button:hover{background:var(--btnBgH);}
    @media(max-width:650px){.form-box{width:90%;}}
  </style>

  <!-- quick JS validation -->
  <script>
    function validateBorrow(){
      const phone=document.getElementById('phone').value.trim();
      const s=document.getElementById('borrowDate').value;
      const e=document.getElementById('returnDate').value;
      if(!/^\d{10,15}$/.test(phone)){alert("Phone number must be 10-15 digits.");return false;}
      if(s && e && e<s){alert("Return date can’t be earlier than borrow date.");return false;}
      return true;
    }
  </script>
</head>

<body>

<!-- ─────────── FULL ACCESSIBILITY HEADER (copied from login.php) ─────────── -->
<header>
  <div id="firstHeader">
    <a href="index.php" id="logo"><img src="image/logoTitle.png" alt="logo" id="logoImage"></a>

    <nav>
      <!-- Colour switcher -->
      <div>
        <span class="colorButton">
          <label>Color <box-icon name='chevron-down' class="downArrow"></box-icon></label>
        </span>
        <div class="accessibility colorAccessibility">
          <div class="default option" data-color="defaultColor">Default</div>
          <div class="option" data-color="lightColor">Light</div>
          <div class="option" data-color="darkColor">Dark</div>
        </div>
      </div>

      <!-- Font size switcher -->
      <div>
        <span class="fontSizeButton">
          <label>Font Size <box-icon name='chevron-down' class="downArrow"></box-icon></label>
        </span>
        <div class="accessibility fontSizeAccessibility">
          <div class="option" data-setFontSize="smallFontSize">Small</div>
          <div class="default option" data-setFontSize="defaultFontSize">Default</div>
          <div class="option" data-setFontSize="largeFontSize">Large</div>
          <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
        </div>
      </div>

      <!-- Support menu -->
      <div>
        <span class="supportButton">
          <label>Support <box-icon name='chevron-down' class="downArrow"></box-icon></label>
        </span>
        <div class="accessibility support">
          <span style="color:black;">Follow us on Instagram!</span>
          <div><img src="image/socialMedia/ig_clicked.png" alt="IG"><label>@BookSpare</label></div>
        </div>
      </div>
    </nav>

    <box-icon name='menu' id="burgerIcon"></box-icon>
  </div>

  <!-- mobile burger-menu aside -->
  <aside>
    <div class="accessibility colorAccessibility">
      <div class="default option" data-color="defaultColor">Default</div>
      <div class="option" data-color="lightColor">Light</div>
      <div class="option" data-color="darkColor">Dark</div>
    </div>
    <span class="accessibilityButton colorButton"><label>Color</label></span>

    <div class="accessibility fontSizeAccessibility">
      <div class="option" data-setFontSize="smallFontSize">Small</div>
      <div class="default option" data-setFontSize="defaultFontSize">Default</div>
      <div class="option" data-setFontSize="largeFontSize">Large</div>
      <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
    </div>
    <span class="accessibilityButton fontSizeButton"><label>Font Size</label></span>

    <div class="accessibility support">
      <span style="color:black;">Follow us on Instagram!</span>
      <div><img src="image/socialMedia/ig_clicked.png" alt="IG"><label>@BookSpare</label></div>
    </div>
    <span class="accessibilityButton supportButton"><label>Support</label></span>
  </aside>

  <div id="secondHeader">
        </div>


</header>
<!-- ────────────────────────────────────────────────────────────────────────── -->

<main>
  <form class="form-box"
        action="backendLogic/borrowFormHandle.php"
        method="POST"
        onsubmit="return validateBorrow();">

    <div class="header">Borrow Request Form</div>
    <div class="body">

      <div class="field">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="field">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" required>
      </div>

      <div class="field">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="field">
        <label for="address">Full Address</label>
        <textarea id="address" name="address" rows="3" required></textarea>
      </div>

      <div class="field">
        <label for="borrowDate">Preferred Borrow Date</label>
        <input type="date" id="borrowDate" name="borrowDate" required>
      </div>

      <div class="field">
        <label for="returnDate">Expected Return Date</label>
        <input type="date" id="returnDate" name="returnDate" required>
      </div>

      <div class="field">
        <label for="reason">Reason for Borrowing (optional)</label>
        <textarea id="reason" name="reason" rows="2"></textarea>
      </div>

      <button type="submit">Submit Request</button>
    </div>
  </form>
</main>

<footer>
        <h1>Our Social Media</h1>
        <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
        <p>Copyright &copy; 2025 BookSpare. All right reserved</p>
    </footer>

<script src="script.js"></script>
</body>
</html>
