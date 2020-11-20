<?php
add_action('wp_enqueue_scripts', 'load_bootstrap');

function load_bootstrap()
{
    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/assets/js/bootstrap.js');
    wp_enqueue_style('bootstrap-css', get_template_directory_uri().'/assets/css/bootstrap.css');
    wp_enqueue_style('default-css', get_template_directory_uri().'/assets/css/style.css');
}

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

add_action('add_meta_boxes', 'wp_game_genre_meta_box');
add_action('save_post', 'save_game_genre_meta_box');

function wp_game_genre_meta_box()
{
    add_meta_box(
        'genre_id',
        'Game genre',
        'html_game_genre_meta_box',
        'Games',
        'side',
    );
}
?>

<?php
function html_game_genre_meta_box($post)
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
        'html_release_year_meta_box',
        'Games',
        'side',
    );
}
?>

<?php
function html_release_year_meta_box($post)
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

add_action('init', 'register_taxonomies');

function register_taxonomies()
{
    register_taxonomy(
        'Game genre',
        'Games',
    );
}

// function themename_widgets_init() 
// {
//     register_sidebar( array(
//         'name'          => __( 'Primary Sidebar', 'theme_name' ),
//         'id'            => 'sidebar-1',
//         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</aside>',
//         'before_title'  => '<h3 class="widget-title">',
//         'after_title'   => '</h3>',
//     ) );
// }
?>