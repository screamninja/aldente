<?php
if (isset($_POST['ajax_switch_on'])) {
    unset($_SESSION['ajax_switch_off']);
}

if (isset($_POST['do_sign_up'])) {
    if (isset($user)) {
        echo "<div style = \"color: green;\">Registration successful!</div></br>
              <div><a href=\"/\">Main page</a></div><hr>";
    } else {
        foreach ($error as $errors) {
            echo '<div style = "color: red;">' . array_shift($error) . '</div>';
        }
        echo '<hr>';
    }
}

?>

<main>
    <p id="notice" style="color: red"></p>

    <h2>Create your account</h2>

    <div class="form">
        <form id="register-form" action="/account/register" method="post">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" value="<?php echo $data['login'] ?? ''; ?>"><br>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $data['email'] ?? ''; ?>"><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br>
            <label for="password_2">Repeat Password</label>
            <input type="password" id="password_2" name="password_2"><br>
            <button type="submit" name="do_sign_up">Sign Up!</button>
        </form>
    </div>

    <br>

    <?php if (isset($_SESSION['ajax_switch_off'])) : ?>
        <form id="ajax-switch-on" action="/account/register" method="post">
            <button type="submit" id="ajax_switch_on" name="ajax_switch_on">Turn on AJAX!</button>
        </form>
    <?php else : ?>
        <script src="/scripts/ajax.js"></script>
        <form id="ajax-switch-off" action="/account/register" method="post">
            <button type="submit" id="ajax_switch_off" value="register" name="ajax_switch_off">Turn off AJAX!</button>
        </form>
    <?php endif; ?>
</main>