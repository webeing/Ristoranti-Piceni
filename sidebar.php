<?php
    /**
     * The Sidebar containing the main widget area.
     */
?>
<aside id="sidebar" class="right" role="complementary">

    <div id="mg-box" class="widget">
        <?php
            $args = array (
                'p'=>'33',
                'post_type'=>'page'
            );
            query_posts($args);

        if (have_posts()) : while (have_posts()) : the_post();
            ?>

        <h3 class="title"><?php the_title(); ?></h3>
        <div class="content">
            <?php the_post_thumbnail('', array('class' => 'alignleft')); ?>
            <?php the_excerpt(); ?>
            <!--<a class="btn" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Scopri come fare &raquo;</a>-->
            <div class="clear"></div>
        </div>

        <?php endwhile; endif; ?>
        <?php wp_reset_query(); ?>
    </div><!--#mg-box -->

    <?php dynamic_sidebar( 'Sidebar Blog' ); ?>

    <div id="risto-box" class="widget">
        <?php
        $args = array (
            'p'=>'35',
            'post_type'=>'page'
        );
        query_posts($args);

        if (have_posts()) : while (have_posts()) : the_post();
            ?>

            <h3 class="title"><?php the_title(); ?></h3>
            <div class="content">
                <?php //the_post_thumbnail('', array('class' => 'alignleft')); ?>
                <img width="100" height="100" title="ristoratore-icon" alt="ristoratore-icon" class="alignleft wp-post-image" src="http://rp.essereweb.net/wp-content/uploads/2012/10/ristoratore-icon.png">
                <?php the_excerpt(); ?>
                <a class="btn" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Inserisci il tuo locale &raquo;</a>
                <div class="clear"></div>
            </div>

            <?php endwhile; endif; ?>
        <?php wp_reset_query(); ?>
    </div><!--#risto-box -->

    <div id="piceno-box" class="widget">
        <?php
        $args = array (
            'p'=>'38',
            'post_type'=>'page'
        );
        query_posts($args);

        if (have_posts()) : while (have_posts()) : the_post();
            ?>

            <!--<h3 class="title"><?php the_title(); ?></h3>-->
            <div class="content">
                <?php //the_post_thumbnail('', array('class' => 'alignleft')); ?>
                <?php echo get_the_excerpt(); ?>
                <a class="btn" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Scopri di pi&ugrave; &raquo;</a>
                <div class="clear"></div>
            </div>

            <?php endwhile; endif; ?>
        <?php wp_reset_query(); ?>
    </div><!--#piceno-box -->

</aside><!-- #sidebar .widget-area -->