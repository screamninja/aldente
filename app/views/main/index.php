<h3>Main page</h3>

<?php if (isset($_SESSION['logged_user'])) : ?>
    <div>You logged as: <?php echo $_SESSION['logged_user'] ?></div>
    <form action="account/logout" method="post">
        <button type="submit" name="do_log_out">Log Out!</button>
    </form>
    <p>Site map:</p>
    <ul>
        <li><a href="/">Main page</a><br></li>
    </ul>
<?php else :?>
    <div>Hello, Guest!</div>
    <p>Site map:</p>
    <ul>
        <li><a href="/">Main page</a><br></li>
        <li><a href="account/login">Login page</a><br></li>
        <li><a href="account/register">Register page</a><br></li>
    </ul>
<?php endif; ?>
<p>News</p>
<?php foreach ($news as $val): ?>
    <h3><?php echo $val['title']?></h3>
    <p><?php echo $val['text']?></p>
    <hr>
<?php endforeach; ?>