<div class = 'container'>
    <?php
    get_header();
    while (have_posts())
    {
        the_title("<h2>", "</h2>");
        the_content();
        the_post();
        ?>
        <div>
            <p>Release year: <?=get_post_meta(get_the_id(), 'release_year', true)?></p>
            <p>Game genre: <?=get_post_meta(get_the_id(), 'game_genre', true)?></p>
        </div>
        <?php
    }
    get_footer();
    ?>
</div>