<?php get_header(); ?>	

<div>
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
	    </div>
		<hr>
        <?php
	}
    ?>
</div>

<?php get_footer(); ?>