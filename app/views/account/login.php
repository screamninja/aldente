<?php

if (isset($data['do_login'])) {
    if (!empty($errors)) {
        echo '<div style = "color: red;">' . array_shift($errors) . '</div><hr>';
    } else {
        ?>
        <script>
            alert("Welcome, <?php echo $data['login'] ?? ''; ?>");
            location.replace('http://php.fw');
        </script>
        <?php
    }
}


?>
<p><strong>Login to Your Account</strong></p>
<form id="auth" enctype="application/x-www-form-urlencoded" action="/account/login" method="post">
    <label for="auth-login">Login</label>
    <input type="text" name="login" id="auth-login"><br>
    <label for="auth-password">Password</label>
    <input type="password" name="password" id="auth-password">
    <button type="submit" name="do_login" id="do_login">Login!</button>
</form>

<script>
    var loginForm = document.getElementById('auth');
    loginForm.addEventListener('submit', login);

    function login(e) {
        e.preventDefault();

        var login = document.getElementById('auth-login').value;
        var password = document.getElementById('auth-password').value;
        var do_login =  '';

        var user = "login=" + encodeURIComponent(login) + "&" + "password=" + encodeURIComponent(password) + "&"
        + "do_login=";

        var xhr = new XMLHttpRequest();

        xhr.open('POST', '/account/login', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(user);
    }
</script>