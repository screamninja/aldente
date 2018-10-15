<?php
if (isset($_POST['ajax_switch_on'])) {
    unset($_SESSION['ajax_switch_off']);
}

if (isset($_SESSION['logged_user'])) {
    header('location: /');
    exit;
}

if (isset($data['do_login'])) {
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div style = "color: red;">' . array_shift($error) . '</div><hr>';
        }
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

<?php if (isset($_SESSION['ajax_switch_off'])) : ?>
    <form id="ajax-switch-on" action="/account/login" method="post">
        <button type="submit" id="ajax_switch_on" name="ajax_switch_on">Turn on AJAX!</button>
    </form>
<?php else : ?>
    <script src="/scripts/ajax.js"></script>
    <form id="ajax-switch-off" action="/account/login" method="post">
        <button type="submit" id="ajax_switch_off" value="login" name="ajax_switch_off">Turn off AJAX!</button>
    </form>
<?php endif; ?>
