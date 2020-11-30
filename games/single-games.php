<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class = 'container'>
    <?php
    while (have_posts())
    {
        the_post();
        the_title("<h2>", "</h2>");
        the_content();
        ?>
        <div>
            <p>Release year: <?=get_post_meta(get_the_id(), 'release_year', true)?></p>
            <p>Game genre: <?=get_post_meta(get_the_id(), 'game_genre', true)?></p>
            <?php $term_link = get_term_link(implode(wp_get_post_terms(get_the_id(), 'developer_taxonomy', ['fields' => 'names'])), 'developer_taxonomy'); ?>
            <p>Developer: <a href=<?=$term_link; ?>><?=implode(wp_get_post_terms(get_the_id(), 'developer_taxonomy', ['fields' => 'names']))?></a></p>

        </div>
        <?php
    }
    ?>
</div>
<?php get_footer(); ?>