<?php include("header.php"); ?>
        <h1>Login:</h1>
        <form action="login.php?action=login" name="login" method="POST">
            <label for="username">Username:</label> <input type="text" name="username">
            <br />
            <label for="password">Password:</label> <input type="password" name="password">
            <br />
            <button type="submit">Submit</button>
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
        </form>
<?php include("footer.php"); ?>
