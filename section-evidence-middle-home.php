<?php 
/*
* The template for displaying section slider
*/
?>

<!-- start area event-co -->
<section id="event-co" class="row">
	<!-- area special-event -->
	<!-- qui inserirei un widget per visualizzare la lista degli eventi -->
    <?php dynamic_sidebar( 'Home Special Event' ); ?>
	<!-- end area special-event -->

<!-- Newsarea -->
<section id="latest-blog" class="right">
    <div class="content_title">
        <h2 class="title">Notizie dal Blog</h2>
    </div>
    <br/>
    <?php
    $args = array(
        'post_type' => 'post',
        'status' => 'publish',
        'category_name' => 'blog',
        'posts_per_page' => 5
        //'order' => 'ASC'
    );
    query_posts($args);
    if (have_posts()): ?>
        <div class="news-service clear">
            <?php
            while ( have_posts() ) : the_post();
                get_template_part('content','archive');
            endwhile;
            ?>
        </div>
        <?php
    endif;
    wp_reset_query();
    ?>

    <?php
    // Get the ID of a given category
    $category_id = get_cat_ID( 'blog' );
    // Get the URL of this category
    $category_link = get_category_link( $category_id );
    ?>

    <div class="title_action">
        <a class="btn brown" href="<?php echo esc_url( $category_link ); ?>">Leggi tutte le notizie &raquo;</a>
    </div>

</section>
<div class="clear"></div>
	
</section>
<!-- end area event-co -->
