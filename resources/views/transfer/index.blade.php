<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CDN Boostrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <!-- Font Awesome 6.5.1 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Thông báo</title>
</head>

<body>
  <style type="text/css">
    body {
      background: #eee
    }

    #alert {
      background: #fff;
      padding: 20px;
      margin: 30px auto;
      border-radius: 3px;
      -webkit-box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
      -moz-box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
      box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
      margin-top: 100px;
      text-align: center;
      width: 100%;
      max-width: 400px;
    }

    #alert .fas {
      font-size: 60px;
    }

    #alert .rlink {
      margin: 10px 0px;
    }

    #alert .title {
      text-transform: uppercase;
      font-weight: bold;
      margin: 10px;
    }

    .fasuccess {
      color: #5cb85c;
    }

    .fadanger {
      color: #D9534F;
      font-size: 50px;
    }

    #process-bar {
      width: 0%;
      -webkit-transition: all 0.3s !important;
      transition: all 0.3s !important;
    }

    @font-face {
      font-family: 'Font Awesome 5 Brands';
      font-style: normal;
      font-weight: normal;
      font-display: auto;
      src: url("assets/fonts/awesome/fa-brands-400.woff2") format("woff2"), url("assets/fonts/awesome/fa-brands-400.woff") format("woff");
    }

    .fab {
      font-family: 'Font Awesome 5 Brands';
    }

    @font-face {
      font-family: 'Font Awesome 5 Free';
      font-style: normal;
      font-weight: 400;
      font-display: auto;
      src: url("assets/fonts/awesome/fa-regular-400.woff2") format("woff2"), url("assets/fonts/awesome/fa-regular-400.woff") format("woff");
    }

    .far {
      font-family: 'Font Awesome 5 Free';
      font-weight: 400;
    }

    @font-face {
      font-family: 'Font Awesome 5 Free';
      font-style: normal;
      font-weight: 900;
      font-display: auto;
      src: url("assets/fonts/awesome/fa-solid-900.woff2") format("woff2"), url("assets/fonts/awesome/fa-solid-900.woff") format("woff");
    }

    .fa,
    .fas {
      font-family: 'Font Awesome 5 Free';
      font-weight: 900;
    }

    .fa,
    .fas,
    .far,
    .fal,
    .fab {
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      line-height: 1;
    }

    .fa-envelope-open:before {
      content: "\f2b6";
    }

    .fa-phone:before {
      content: "\f095";
    }

    .fa-map-marker-alt:before {
      content: "\f3c5";
    }

    .fa-shopping-cart:before {
      content: "\f07a";
    }

    .fa-bars:before {
      content: "\f0c9";
    }

    .fa-calendar-alt:before {
      content: "\f073";
    }

    .fa-search:before {
      content: "\f002";
    }

    .fa-exclamation-triangle:before {
      content: "\f071";
    }

    .fa-check-circle:before {
      content: "\f058";
    }

    .fa-user:before {
      content: "\f007";
    }

    .fa-sign-out-alt:before {
      content: "\f2f5";
    }

    .fa-minus:before {
      content: "\f068";
    }

    .fa-plus:before {
      content: "\f067";
    }
  </style>

  <?php if (!empty($status)) { ?>
    <div id="alert">
      <i class="<?= $status === "success" ? "fas fa-check-circle fasuccess" : "fa-solid fa-circle-exclamation fadanger" ?>"></i>
      <div class="title">Thông báo</div>
      <div class="message alert <?= $status === "success" ? "alert-success" : "alert-danger" ?>"><?= $message ?> <?= $status === "success" ? "thành công" : "thất bại" ?></div>
      <div class="rlink">(<a href="<?= !empty($url) ? $url : "" ?>">Click vào đây nếu không muốn đợi lâu</a>)</div>
      <div class="progress">
        <div id="process-bar" data-href="<?= !empty($url) ? $url : "" ?>" class="progress-bar progress-bar-striped <?= $status === "success" ? "progress-bar-success" : "progress-bar-danger" ?> active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>
  <?php } ?>

  <script type="text/javascript">
    const processBar = document.getElementById("process-bar");
    let percentWidth = 0;
    setInterval(function() {
      percentWidth += 1;
      processBar.style.width = percentWidth + '%';
      if (percentWidth === 100) {
        window.location.href = processBar.dataset.href;
      }
    }, 40);
  </script>
</body>

</html>
