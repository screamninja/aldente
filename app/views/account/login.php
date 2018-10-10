<?php

if (isset($_SESSION['logged_user'])) {
    header('location: /');
    exit;
}

if (isset($data['do_login'])) {
    if (!empty($errors)) {
        echo '<div style = "color: red;">' . array_shift($errors) . '</div><hr>';
    } else {
        header('Location: /');
    }
}

?>

<p id="notice" style="color: red"></p>

<h2>Login to Your Account</h2>

<form id="login-form" action="/account/login" method="post">
    <label for="login">Login</label>
    <input type="text" id="login" name="login">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <button type="submit" id="do_login" name="do_login">Login!</button>
</form>

<p><a href="/">Go to Main Page</a></p>

<script src="/scripts/ajax.js"></script>