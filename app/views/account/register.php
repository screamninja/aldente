<?php
if (isset($data['do_sign_up'])) {
    if (empty($errors)) {
        echo "<div style = \"color: green;\">Registration successful!</div></br><div><a href=\"/\">Main page</a><br></div><hr>";
    } else {
        echo '<div style = "color: red;">' . array_shift($errors) . '</div><hr>';
    }
}
?>
<p><strong>Create your account</strong></p>
<form action="/account/register" method="post">
    <p>Login</p>
    <input type="text" name="login" value="<?php echo $data['login'] ?? ''; ?>">
    <p>Email</p>
    <input type="email" name="email" value="<?php echo $data['email'] ?? ''; ?>">
    <p>Password</p>
    <input type="password" name="password">
    <p>Repeat Password</p>
    <input type="password" name="password_2">
    <button type="submit" name="do_sign_up">Sign Up!</button>
</form>
