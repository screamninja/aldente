<?php
if (isset($_POST['get_key'])) {
    if (isset($error)) {
        echo "<div style = \"color: red;\">Error: " . $error . "</div></hr>";
    } else {
        echo "<div style = \"color: green;\">Save your UID: " . $uid . "</div></br>";
        echo "<div style = \"color: green;\">Save your Key: " . $key . "</div></hr>";
    }
}
?>
<p><strong>Get your API Key!</strong></p>

<ul>
    <li><a href="/">Main page</a><br></li>
    <li><a href="/api/about">API</a><br></li>
    <li><a href="../account/login">Login page</a><br></li>
    <li><a href="../account/register">Register page</a><br></li>
</ul>

<?php if (isset($_SESSION['logged_user'])) : ?>
    <form action="/api/key" method="post">
        <p>Get Key as: <?php echo $_SESSION['logged_user'] ?></p>
        <button type="submit" name="get_key">Get Key!</button>
    </form>
<?php else : ?>
    <p>For get API key you must be logged!</p></br>
    <ul>
        <li><a href="../account/login">Login page</a><br></li>
        <li><a href="../account/register">Register page</a><br></li>
    </ul>
<?php endif; ?>
