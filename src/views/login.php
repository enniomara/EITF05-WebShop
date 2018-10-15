<html>
<?php include("head.php"); ?>
<body>
    <?php include("navbar/navbar.php"); ?>
    <?php include('flashMessages.php'); ?>
    <div class="container" style="margin-top: 5%">
        <div class="row">
            <div class="col-md-6">
                <h1>Login:</h1>
                <form action="login.php?action=login" name="login" method="POST">
                    <label for="username">Username:</label> <input type="text" name="username">
                    <br />
                    <label for="password">Password:</label> <input type="password" name="password">
                    <br />

                    <input type="hidden" name="token" value="<?php echo $CSRFToken ?>">
                    <?php
                    if ($showCaptcha) {
                        include("captcha.php");
                    }
                    ?>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <h1>Sign up:</h1>
                <form action="login.php?action=signup" name="signup" method="POST">
                    <label for="username">Username:  <input type="text" name="username"></label>
                    <br />
                    <label for="password">Password: <input type="password" name="password" aria-describedby="passwordHelp"></label>
                    <small id="passwordHelp" class="form-text text-muted">Minimum 7 characters. One upper and one lower case. One number. One special character.</small>
                    <label for="address">Home Address:  <input type="text" name="address"></label>
                    <br />
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <input type="hidden" name="token" value="<?php echo $CSRFToken ?>">
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
