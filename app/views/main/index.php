<h3>Main page</h3>

<p>Site map:</p>

<ul>
    <li><a href="/">Main page</a><br></li>
    <li><a href="account/login">Login page</a><br></li>
    <li><a href="account/register">Register page</a><br></li>
</ul>

<p>News</p>
<?php foreach ($news as $val): ?>
    <h3><?php echo $val['title']?></h3>
    <p><?php echo $val['text']?></p>
    <hr>
<?php endforeach; ?>