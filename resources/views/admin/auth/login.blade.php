<?php 
    session_start();
    if (isset($_COOKIE['username']) && isset($_COOKIE['hm_auth'])) {
        header("Location: https://hotmobily.jp/admin/dashboard.php");
        exit;
    }
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="css/login_css.css?d=2" rel="stylesheet" type="text/css" />


<html>
    <head>
        <title>Hotmobily | Admin Panel Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link href="CSS/MiStilo.css" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <style>
            body{
                background: unset!important;
                font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important;
            }

            .dsa{
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .title{
                font-size: 24px !important;
                font-weight: bold !important;
                color: black;
                text-shadow: unset !important;
            }
        </style>
    </head>
    <body>
        <section class="container-fluid">

            <div class="row dsa" style="margin:0;">

                <div style="margin-top: 20px;">
                    <img src="/img/HM_logo2.png" class="img-fluid" alt="" width="250px">
                </div>

                <?php
                    if (isset($_SESSION['success_msg'])) {
                        echo '<div class="col-12 col-sm-6" style="margin-top: 50px;"><div class="alert alert-success" role="alert"><strong>成功!</strong> ' . $_SESSION['success_msg'] . ' </div></div>';
                        unset($_SESSION['success_msg']);
                    }

                    if (isset($_SESSION['error_msg'])) {
                        echo '<div class="col-12 col-sm-6" style="margin-top: 50px;"><div class="alert alert-danger" role="alert"><strong>エラー!</strong> ' . $_SESSION['error_msg'] . ' </div></div>';
                        unset($_SESSION['error_msg']);
                    }
                ?>

                <div class="col-12 col-md-4 rounded border shadow bg-white mt-4" id="col-Login" >
                    <div>
                        <p class="title text-center">Hotmobily - Admin Panel Login</p>
                      <form method="POST" action="{{ route('admin.login.submit') }}">

    @csrf

    <div class="form-group">

        <b>
            <label>
                Email
                <span class="text-danger">*</span>
            </label>
        </b>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="form-control"
            placeholder="Email Address"
            required
        >

    </div>

    <div class="form-group">

        <b>
            <label>
                Password
                <span class="text-danger">*</span>
            </label>
        </b>

        <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Password"
            required
        >

    </div>

    <button
        type="submit"
        class="btn btn-primary float-right"
    >
        Login
    </button>

</form>
                    </div>

                    
                </div>
            </div>
        </section>
    </body>
</html>


