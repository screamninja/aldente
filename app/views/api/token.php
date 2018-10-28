<main>
    <br>
<?php

if (isset($_POST['get_token'])) {
    if (isset($error)) {
        echo "<div style = \"color: red;\">$error</div></hr>";
    } elseif (isset($token)) {
        echo "<div style = \"color: green;\">Save your Token: " . $token . "</div></hr>";
    } else {
        echo "<div style = \"color: red;\">Error! No data!</div></hr>";
    }
}

?>
    <p><strong>Get your API Token!</strong></p>

    <p id="notice" style="color: red"></p>

    <?php if (isset($_SESSION['logged_user'])) : ?>
        <form id="token-form" action="/api/token" method="post">
            <p>Get Token as: <?php echo $_SESSION['logged_user'] ?></p>
            <button type="submit" id="get_token" name="get_token">Get Token!</button>
        </form>
    <?php else : ?>
        <p>For get API key you must be logged!</p></br>
    <?php endif; ?>
</main>
