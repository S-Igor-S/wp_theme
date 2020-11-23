<div class = 'container'>
    <?php
    get_header();
    while (have_posts())
    {
        the_post();
        the_title("<h2>", "</h2>");
        the_content();
        ?>
        <div>
            <p>Release year: <?=get_post_meta(get_the_id(), 'release_year', true)?></p>
            <p>Game genre: <?=get_post_meta(get_the_id(), 'game_genre', true)?></p>
            <p>Developer: <?=implode(wp_get_post_terms(get_the_id(), 'developer_taxonomy', ['fields' => 'names']))?></p>
        </div>
        <?php
    }
    get_footer();
    ?>
</div>