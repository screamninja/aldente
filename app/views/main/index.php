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
    <aside class="ad">
        <h2>ADVERTISING</h2>
        <img src="images/code.png" alt="advertising">
    </aside>
    <section class="info">
        <h2>INFO</h2>
        <p>Info. Info. Info. Info. Info. Info. </p>
    </section>
</main>