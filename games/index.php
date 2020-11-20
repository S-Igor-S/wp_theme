<div class = 'container'>
    <?php get_header(); ?>
    <main>
        <?php
        while ( have_posts() ){
            the_post(); 
        }
        ?>
    </main>
    <?php //get_sidebar(); ?>
    <?php get_footer(); ?>
</div>