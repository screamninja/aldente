<?php

if (isset($_SESSION['logged_user'])) {
    header('location: /');
    exit;
}

?>

<p id="notice" style="color: red"></br></p>

<h2>Login to Your Account</h2>

<form id="auth" enctype="application/x-www-form-urlencoded" action="/ajax/login" method="post">
    <label for="auth-login">Login</label>
    <input type="text" name="login" id="auth-login">
    <label for="auth-password">Password</label>
    <input type="password" name="password" id="auth-password">
    <button type="submit" name="do_login" id="do_login">Login!</button>
</form>

<p><a href="/">Go to Main Page</a></p>

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
        xhr.open('POST', '/ajax/login', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState==4 && xhr.status==200) {
                var data = JSON.parse(xhr.responseText);
                if (data['error']) {
                    document.getElementById('notice').innerHTML = data['error'];
                } else {
                    alert('Welcome, ' + data['user'] + '!');
                    location.replace('http://php.fw');
                }
            }
        };
        xhr.send(user);
    }
</script>
