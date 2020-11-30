<?php
//CSS && JS

add_action('wp_enqueue_scripts', 'load_scripts');

function load_scripts()
{
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-1.11.0.min.js');
    wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.2.1.min.js');

    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/assets/js/bootstrap.js');
    wp_enqueue_style('bootstrap-css', get_template_directory_uri().'/assets/css/bootstrap.css');

    wp_enqueue_style('custom-css', get_template_directory_uri().'/assets/css/style.css');
    // wp_enqueue_style('default-css', get_stylesheet_uri());

    wp_enqueue_style('slick-css', get_template_directory_uri().'/assets/slick/slick.css');
    wp_enqueue_style('slick-theme', get_template_directory_uri().'/assets/slick/slick-theme.css');

    wp_enqueue_script('slick-js', get_template_directory_uri().'/assets/slick/slick.js');
}

//Sidebar

add_action( 'widgets_init', 'my_register_sidebars' );

function my_register_sidebars() {
    /* Register the 'primary' sidebar. */
    register_sidebar(
        array(
            'id'            => 'page',
            'name'          => __( 'Pages Sidebar' ),
            'description'   => __( '' ),
            'before_widget' => '<div id="page_widget_id" class="page_widget_cl">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="page_widget_title">',
            'after_title'   => '</h3>',
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
}

//Nav menu

add_action( 'init', 'register_my_menus' );

function register_my_menus() {
    register_nav_menus(
      array(
        'nav-menu' => __( 'Nav Menu' ),
        'extra-menu' => __( 'Extra Menu' )
       )
     );
}

//New post

add_action( 'init', 'register_post_games' );

function register_post_games()
{
    $labels = array(
        'name' => _x( 'Games', 'post type general name' ),
        'singular_name' => _x( 'Game', 'post type singular name' ),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
    );
    register_post_type('Games', $args);
}

//Meta boxes

add_action('add_meta_boxes', 'wp_game_genre_meta_box');
add_action('save_post', 'save_game_genre_meta_box');

function wp_game_genre_meta_box()
{
    add_meta_box(
        'genre_id',
        'Game genre',
        'render_game_genre_meta_box',
        'Games',
        'side',
    );
}
?>

<?php
function render_game_genre_meta_box($post)
{
    $game_genre = get_post_meta( $post->ID, 'game_genre', true );
?>
    <label for="game_genre"></label>
    <select name = 'game_genre' id = 'game_genre'>
        <option value = 'Action' <?php selected($game_genre, 'Action') ?>>Action</option>
        <option value = 'Action-adventure' <?php selected($game_genre, 'Action-adventure') ?>>Action-adventure</option> 
        <option value = 'Adventure' <?php selected($game_genre, 'Adventure') ?>>Adventure</option> 
        <option value = 'Role-playing' <?php selected($game_genre, 'Role-playing') ?>>Role-playing</option> 
        <option value = 'Simulation' <?php selected($game_genre, 'Simulation') ?>>Simulation</option> 
        <option value = 'Strategy' <?php selected($game_genre, 'Strategy') ?>>Strategy</option> 
        <option value = 'Sports' <?php selected($game_genre, 'Sports') ?>>Sports</option> 
        <option value = 'MMO' <?php selected($game_genre, 'MMO') ?>>MMO</option>        
    </select>
<?php
}
?>

<?php

function save_game_genre_meta_box( $post_id ) {
    if ( array_key_exists( 'game_genre', $_POST ) ) {
        update_post_meta(
            $post_id,
            'game_genre',
            $_POST['game_genre'],
        );
    }
}

add_action('add_meta_boxes', 'wp_release_year_meta_box');
add_action('save_post', 'save_release_year_meta_box');

function wp_release_year_meta_box()
{
    add_meta_box(
        'year_id',
        'Release year',
        'render_release_year_meta_box',
        'Games',
        'side',
    );
}
?>

<?php
function render_release_year_meta_box($post)
{
    $release_year = get_post_meta( $post->ID, 'release_year', true );
?>
    <label for="release_year"></label>
    <input type = 'number' min = '1961' max = '2020' name = 'release_year' id = 'release_year' value = <?php echo $release_year ?>>
<?php
}
?>

<?php

function save_release_year_meta_box( $post_id ) {
    if ( array_key_exists( 'release_year', $_POST ) ) {
        update_post_meta(
            $post_id,
            'release_year',
            $_POST['release_year'],
        );
    }
}

//Taxonomy

add_action('init', 'register_developer_taxonomy');

function register_developer_taxonomy()
{
    register_taxonomy( 'developer_taxonomy', 'games', [ 
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Developer',
			'singular_name'     => 'Developer',
			'search_items'      => 'Search developer',
			'all_items'         => 'All developers',
			'view_item '        => 'View developer',
			'edit_item'         => 'Edit developer',
			'update_item'       => 'Update developer',
			'add_new_item'      => 'Add New developer',
			'new_item_name'     => 'New developer Name',
			'menu_name'         => 'Developers',
		],
	] );
}

add_shortcode('games_gallery_shortcode', 'wp_games_gallery_shortcode');

function wp_games_gallery_shortcode()
{
    ?>
    <div class='slick_slider'>
    <?php
	while (have_posts())
	{
	?>
            <div class='single_post'>
                <?php
		        the_post();
                the_title("<h2 class='post_title'><a href=".get_permalink().">", "</a></h2>");
                $media = get_attached_media('image', get_the_id());
                $media = array_shift( $media );
                ?>
                <img src=<?=$media->guid ?> alt='poster for'.<? the_title()?> height='450px' width='300px;'>
	            <div class='meta_data'>
		            <p>Release year: <?=get_post_meta(get_the_id(), 'release_year', true)?></p>
		            <p>Game genre: <?=get_post_meta(get_the_id(), 'game_genre', true)?></p>
                    <?php 
                    // if (isset(implode(wp_get_post_terms(get_the_id(), 'developer_taxonomy', ['fields' => 'names']))))
                    $term_link = get_term_link(implode(wp_get_post_terms(get_the_id(), 'developer_taxonomy', ['fields' => 'names'])), 'developer_taxonomy');
                    
                    ?>
                    <p>Developer: <a href=<?=$term_link; ?>><?=implode(wp_get_post_terms(get_the_id(), 'developer_taxonomy', ['fields' => 'names']))?></a></p>
                </div>
            </div>
        <?php
	}
    ?>
    </div>
    <script>
        jQuery(function($)
        {
            $('.slick_slider').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3
            });

        });
    </script>
    <?php
}

add_shortcode('gallery_shortcode', 'wp_gallery_shortcode');

function wp_gallery_shortcode()
{
    ?>
    <div class='slick_slider'>
    <?php
	while (have_posts())
	{
	?>
            <div class='single_post'>
                <?php
		        the_post();
                the_title("<h2 class='post_title'><a href=".get_permalink().">", "</a></h2>");
                $media = get_attached_media('image', get_the_id());
                if (!empty($media))
                {
                    $media = array_shift( $media );
                ?>
                <img src=<?=$media->guid ?> alt='poster for'.<? the_title()?> height='450px' width='300px;'>
                <?php
                }
                ?>

            </div>
        <?php
	}
    ?>
    </div>
    <script>
        jQuery(function($)
        {
            $('.slick_slider').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3
            });

        });
    </script>
    <?php
}

add_shortcode('weather_shortcode', 'wp_weather_shortcode');

function wp_weather_shortcode()
{
    ?>
    <div class="weather">
    <h2>Погода в городе<?php echo $data->name; ?></h2>
    <p>Погода: <?php echo $data->main->temp_min; ?>°C</p>
    <p>Влажность: <?php echo $data->main->humidity; ?>%</p>
    <p>Ветер: <?php echo $data->wind->speed; ?><км/ч</p>
    </div>
    <?php
}
?>