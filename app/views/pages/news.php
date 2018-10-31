<?php

// TODO: add html and content in news.php

?>

<main>
    <section class="news">
        <h2>NEWS</h2>
        <?php foreach ($news as $val) : ?>
            <div>
                <h3><?php echo $val['title'] ?></h3>
                <p><?php echo $val['text'] ?></p>
                <hr>
            </div>
        <?php endforeach; ?>
    </section>
</main>
