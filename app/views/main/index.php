<p>Main page</p>

<?php foreach ($news as $val): ?>
    <h3><?php echo $val['title']?></h3>
    <p><?php echo $val['text']?></p>
    <hr>
<?php endforeach; ?>