<?php

use PFW\Lib\Db;

$db = new Db();

$data = $_POST;
if (isset($data['do_signup'])) {
    $errors = array();
    if (trim($data['login']) == '') {
        $errors[] = 'Login is required';
    }
    if (trim($data['email']) == '') {
        $errors[] = 'Email is required';
    }
    if ($data['password'] == '') {
        $errors[] = 'Password is required';
    }
    if ($data['password_2'] != $data['password']) {
        $errors[] = 'Password do not match';
    }
    if (empty($errors)) {
        $db->insert($data);
        echo '<div style = "color: green;">Registration successful!</div><hr>';
    } else {
        echo '<div style = "color: red;">'.array_shift($errors).'</div><hr>';
    }
}
?>

<p><strong>Create your account</strong></p>
<form action="/account/register" method="post">
    <p>Login</p>
    <input type="text" name="login" value="<?php echo $data['login'] ?? ''; ?>">
    <p>Email</p>
    <input type="email" name="email" value="<?php echo @$data['email']; ?>">
    <p>Password</p>
    <input type="password" name="password">
    <p>Repeat Password</p>
    <input type="password" name="password_2">
    <button type="submit" name="do_signup">Sign Up!</button>
</form>
