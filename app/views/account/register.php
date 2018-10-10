<?php

if (isset($_POST['do_sign_up'])) {
    if (isset($user)) {
        echo "<div style = \"color: green;\">Registration successful!</div></br>
              <div><a href=\"/\">Main page</a></div><hr>";
    } else {
        echo '<div style = "color: red;">'
            . $error ?? 'Something went wrong... Please contact with our support.'
            . '</div><hr>';
    }
}

?>

<p id="notice" style="color: red"></p>

<h2>Create your account</h2>

<form id="register-form" action="/account/register" method="post">
    <label for="login">Login</label>
    <input type="text" id="login" name="login" value="<?php echo $data['login'] ?? ''; ?>">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo $data['email'] ?? ''; ?>">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <label for="password_2">Repeat Password</label>
    <input type="password" id="password_2" name="password_2">
    <button type="submit" name="do_sign_up">Sign Up!</button>
</form>

<p><a href="/">Go to Main Page</a></p>

<script src="/scripts/ajax.js"></script>