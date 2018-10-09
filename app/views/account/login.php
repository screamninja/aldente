<?php

if (isset($_SESSION['logged_user'])) {
    header('location: /');
    exit;
}

?>

<p id="notice" style="color: red"></p>

<h2>Login to Your Account</h2>

<form id="login-form" enctype="application/x-www-form-urlencoded" action="/ajax/login" method="post">
    <label for="login">Login</label>
    <input type="text" name="login" id="login">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <button type="submit" name="do_login" id="do_login">Login!</button>
</form>

<p><a href="/">Go to Main Page</a></p>

<script src="/scripts/ajax.js"></script>