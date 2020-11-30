<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class = 'container'>
    <?php
    while (have_posts())
    {
        the_post();
        the_title("<h2>", "</h2>");
        the_content();
    }
    ?>
</div>
<?php get_footer(); ?>