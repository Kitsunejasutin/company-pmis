<?php 
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
?>
    <link rel="stylesheet" href="styles/index.css">
    <title>Landing Page</title>
</head>
<body>
    <div class="container">
        <div class="front-card">
            <div class="card-header">
                <div class="group-name">
                    Welcome to the website
                </div>
                <h6 class="line-on-side text-muted font-small-3">
                </h6>
                <span>Employee LogIn</span>
            </div>
            <div class="card-body">
                <form action="includes/login.php" method="POST" accept-charset="utf-8">
                    <fieldset class="form-group fieldset-border">
                        <i class="fas fa-user-circle"></i>
                        <input type="text" class="card-control no-outline" name="email" placeholder="Your Email" required>
                    </fieldset>
                    <fieldset class="form-group fieldset-border">
                        <i class="fas fa-key"></i>
                        <input type="password" class="card-control no-outline" name="password" placeholder="Your Password" required>
                    </fieldset>
                    <div class="form-group row">
                    <input type="checkbox"><div class="remember-me">Remember Me</div>
                        <div class="forgot"><a href="forgot.php" class="forgot">Forgot Your Password?</a></div>
                    </div>
                    <?php include_once "includes/login_errors.php"; ?>
                    <button class="btn grey" name="login"><span>LogIn</span></button>
                </form>
                <h6 class="line-on-side text-muted font-small-3">
                </h6>
            </div>
        </div>
    </div>
</body>
</html>
