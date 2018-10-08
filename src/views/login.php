<html>
<?php include("head.php"); ?>
<body>
    <?php include("navbar/navbar.php"); ?>
    <h1>Login:</h1>
    <form action="login.php?action=login" name="login" method="POST">
        <label for="username">Username:</label> <input type="text" name="username">
        <br />
        <label for="password">Password:</label> <input type="password" name="password">
        <br />
        <button type="submit">Submit</button>
        <input type="hidden" name="token" value="<?php echo $CSRFToken ?>">
    </form>

    <h1>Sign up:</h1>
    <form action="login.php?action=signup" name="signup" method="POST">
        <label for="username">Username:  <input type="text" name="username"></label>
        <br />
        <label for="password">Password: <input type="password" name="password"></label>
        <br />
        <label for="address">Address:  <input type="text" name="address"></label>
        <br />
        <button type="submit">Submit</button>
        <input type="hidden" name="token" value="<?php echo $CSRFToken ?>">
    </form>

    <?php include("footer.php"); ?>
</body>
</html>
