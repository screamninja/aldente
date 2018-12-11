<main>
    <section class="news">
        <h2>NEWS</h2>
        <?php foreach ($news as $val) : ?>
            <div>
                <h3><?php echo $val['title'] ?></h3>
                <p><?php echo $val['text'] ?></p>
                <p class="right"><?php echo 'Posted by ' . $val['author'] . ' on ' . $val['post_date'] ?></p>
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
        <p>If you have questions, wishes or suggestions write to me an <a href="mailto:screamninja@gmail.com">screamninja@gmail.com</a> or telegram <a href="https://telegram.me/screamninja">@screamninja</a>.</p>
    </section>
</main>