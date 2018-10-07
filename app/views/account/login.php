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

<p><a href="/">Go to Main Page</a> </p>
<script>
    var loginForm = document.getElementById('auth');
    loginForm.addEventListener('submit', login);

    function login(e) {
        e.preventDefault();

        return new Promise(function (resolve, reject) {
            var login = document.getElementById('auth-login').value;
            var password = document.getElementById('auth-password').value;
            var do_login = '';

            var user = 'login=' + encodeURIComponent(login) + '&' + 'password=' + encodeURIComponent(password) + '&'
                + 'do_login=';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/account/login', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    resolve(xhr.response);
                } else {
                    reject(Error('Error code:' + xhr.statusText));
                }
            };
            xhr.onerror = function() {
                reject(Error('There was a network error.'));
            };
            xhr.send(user);
        });
    }
</script>

<!--<script>-->
<!--    var loginForm = document.getElementById('auth');-->
<!--    loginForm.addEventListener('submit', login);-->
<!---->
<!--    function login(e) {-->
<!--        e.preventDefault();-->
<!---->
<!--        var login = document.getElementById('auth-login').value;-->
<!--        var password = document.getElementById('auth-password').value;-->
<!--        var do_login =  '';-->
<!---->
<!--        var user = "login=" + encodeURIComponent(login) + "&" + "password=" + encodeURIComponent(password) + "&"-->
<!--        + "do_login=";-->
<!---->
<!--        var xhr = new XMLHttpRequest();-->
<!---->
<!--        xhr.open('POST', '/account/login', true);-->
<!--        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');-->
<!--        xhr.send(JSON.stringify(user));-->
<!--        xhr.addEventListener('load', function() {-->
<!--            console.log(xhr.responseType);-->
<!--        });-->
<!--    }-->
<!--</script>-->