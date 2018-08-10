<?php
if (isset($data['do_login'])) {
    if (!empty($errors)) {
        echo '<div style = "color: red;">' . array_shift($errors) . '</div><hr>';
    }
}
?>
<p><strong>Login to Your Account</strong></p>
<form action="/account/login" method="post">
    <p>Login</p>
    <input type="text" name="login" value="<?php echo $data['login'] ?? ''; ?>">
    <p>Password</p>
    <input type="password" name="password">
    <button type="submit" name="do_login">Login!</button>
</form>