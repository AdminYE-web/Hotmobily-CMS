<?php session_start();unset($_SESSION);session_destroy();?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="css/login_css.css" rel="stylesheet" type="text/css" />


<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="CSS/MiStilo.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>
    <body>
        <section class="container-fluid">
            <div class="row justify-content-center  ">

                <div class="col-3 rounded border shadow p-3 mb-5 bg-white " id="col-Login" >
                            <p class="text-center"><strong>Login Admin</strong></p>
                        
                            <form class="login-form"  method="POST" action="checklogin.php">
                                <div class="form-group" id="errorLogin" >
                                </div>
                                <div class="form-group">
                                    <label >Username</label>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>    
                                </div>
                                <div class="form-group">
                                    <label >Password</label>
                                    <input type="password" class="form-control"  id="password" name="password"  placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary float-right">Login</button>                              
                                </div>
                            </form>
                        </div>
                </div>
            </section>
    </body>
</html>


