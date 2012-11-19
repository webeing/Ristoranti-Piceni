<?php
/**
 * User: webeing.net
 * Date: 17/10/12
 * Time: 09:59
 * widget per i contents
 */

class Rp_Contents_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function Rp_Contents_Widget() {
        $widget_ops = array( 'classname' => 'widget_rp_contents', 'description' => __( 'Use this widget to list your contents', 'rp' ) );
        $this->WP_Widget( 'widget_rp_contents', __( 'Rp Content', 'rp' ), $widget_ops );
        $this->alt_option_name = 'widget_rp_contents';

        add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        $cache = wp_cache_get( 'widget_rp_contents', 'widget' );

        if ( !is_array( $cache ) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = null;

        if ( isset( $cache[$args['widget_id']] ) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract( $args, EXTR_SKIP );

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'rp', 'rp' ) : $instance['title'], $instance, $this->id_base);

        if ( ! isset( $instance['number'] ) )
            $instance['number'] = '10';

        if ( ! $number = absint( $instance['number'] ) )
            $number = 10;

        if($instance['type']=='rp_eventi'){
        $time = time();
        $rp_args = array(
            'order' => 'ASC',
            'orderby' => 'meta_value',
            'posts_per_page' => $number,
            'post_type' => $instance['type'],
            'meta_query' => array(
                array(
                    'key' => 'rp_start_datetime_saved',
                    'value' => $time,
                    'compare' => '>='
                )
               ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie_evento',
                    'field' => 'id',
                    'terms' => $instance['id_category']
                )
            ),
        );
        }

        if($instance['type']=='locali'){
            $rp_args = array(
                'order' => 'DESC',
                'posts_per_page' => $number,
                'post_type' => $instance['type']

            );
        }

        if($instance['type']=='post'){
            $rp_args = array(
                'order' => 'DESC',
                'posts_per_page' => $number,
                'post_type' => $instance['type']

            );
        }



        $rp = new WP_Query( $rp_args );

        echo $before_widget;
        echo $before_title;
        echo $title; // Can set this with a widget option, or omit altogether
        echo $after_title;
        if ( $rp->have_posts() ) :



            ?>



            <ul>
            <?php while ( $rp->have_posts() ) : $rp->the_post();

                    //var_dump(get_term_by('id', get_the_ID(), 'category', ARRAY_A));
                if ($instance['type'] == 'rp_eventi'){
                ?>
                <li itemscope>
                    <?php $attr= array(
                    'alt' => get_the_title(),
                    'class' => 'alignleft thumb'
                    );
                    the_post_thumbnail( 'small-thumb', $attr );
                    ?>
                    <time datetime="<?php echo get_post_meta(get_the_ID(),'rp_start_datetime_saved',true);?>" itemprop="dataevento">
                      <?php $rp_date_widget_old = get_post_meta(get_the_ID(),'rp_start_datetime_saved',true);
                        $split = explode(" ",$rp_date_widget_old);
                        echo $split[0];
                        ?>

                    </time>


                    <?php if ($rp->query_vars['term_id'] == RP_EVENTI_TERRITORIO_ID) :?>
                    <a title="<?php the_title();?>" href="<?php the_permalink();?>">
                        <span class="tipoevento" itemprop="tipoevento"><?php the_title();?></span>
                    </a>
                    <?php endif; ?>

                    <?php if ($rp->query_vars['term_id'] == RP_EVENTI_SPECIALI_ID) :?>
                    <a title="<?php the_title();?>" href="<?php the_permalink();?>">
                        <span class="tipoevento" itemprop="tipoevento"><?php the_title();?></span>
                    </a>


                    <span class="nomelocale" itemprop="nomelocale">


                    <?php  $rp_id_ristorante = get_post_meta(get_the_ID(),'rp_partner_restaurant_saved',true);
                    $args = array(
                        'post_type' => 'locali',
                        'order'=> 'ASC',
                        'orderby' => 'title',
                        'numberposts' => -1
                    );

                        $rp_ristoranti = get_posts( $args );

                        foreach( $rp_ristoranti as $rp_ristorante ) :
                            $rp_ristorante = get_object_vars($rp_ristorante);

                            if($rp_id_ristorante==$rp_ristorante['ID']){?>

                            Presso: <a href="<?php echo get_permalink($rp_ristorante['ID']);?>"><?php echo $rp_ristorante['post_title']; ?></a>
                        <?php }
                        endforeach;
                    ?>
                    </span>
                    <?php endif; ?>
                </li>
            <?php }

                else{

                ?>

                    <li>
                    <?php $attr= array(
                        'alt' => get_the_title(),
                        'class' => 'alignleft thumb'
                    );
                    the_post_thumbnail( 'small-thumb', $attr );
                    ?>
                    <time datetime="<?php echo get_the_date();?>" itemprop="dataevento">
                        <?php echo get_the_date();?>
                    </time>
                    <a title="<?php the_title();?>" href="<?php the_permalink();?>">
                    <span class="nomelocale" itemprop="nomelocale">
                        <?php the_title()?>
                    </span>
                    </a>
                    </li>

            <?php }

            endwhile; ?>
            </ul>
            <br class="clear"/>
            <a title="<?php echo $instance['label'];?>" href="<?php echo $instance['link'];?>" class="btn"><?php echo $instance['label'];?>»</a>
        <?php
        else:?>
            <span class="tipoevento" itemprop="tipoevento">Non ci sono eventi programmati</span>

            <?php


            wp_reset_postdata();

        endif;
        echo $after_widget;
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set( 'widget_rp_contents', $cache, 'widget' );
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     **/
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        $instance['id_category'] = strip_tags( $new_instance['id_category'] );
        $instance['type'] = strip_tags( $new_instance['type'] );
        $instance['label'] = strip_tags( $new_instance['label'] );
        $instance['link'] = strip_tags( $new_instance['link'] );
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset( $alloptions['widget_rp_contents'] ) )
            delete_option( 'widget_rp_contents' );

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete( 'widget_rp_contents', 'widget' );
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     **/
    function form( $instance ) {
        $title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
        $id_category = isset( $instance['id_category']) ? esc_attr( $instance['id_category'] ) : '';
        $type = isset( $instance['type']) ? esc_attr( $instance['type'] ) : '';
        $label = isset( $instance['label']) ? esc_attr( $instance['label'] ) : '';
        $link = isset( $instance['link']) ? esc_attr( $instance['link'] ) : '';
        ?>
    <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Titolo:', 'rp' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
    <p><label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( 'Tipo post:', 'rp' ); ?></label>
            <?php
            $args=array(
            '_builtin' => false
            );
            $rp_types = get_post_types($args,'names');

            unset($rp_types['wpcf7_contact_form'], $rp_types['rp_slider']);

            $rp_types[]='post';
            $selected = ' selected="selected"';

            ?>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" type="text" value="<?php echo esc_attr( $type ); ?>" >

                <?php foreach( $rp_types as $rp_type ) :

                $sel = ($rp_type == $type) ?  $selected : "";
                ?>
                <option value="<?php echo $rp_type; ?>" <?php echo $sel; ?>><?php echo $rp_type; ?></option>
                <?php endforeach;?>

            </select>
    </p>
    <p><label for="<?php echo esc_attr( $this->get_field_id( 'id_category' ) ); ?>"><?php _e( 'Id Category:', 'rp' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'id_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id_category' ) ); ?>" type="text" value="<?php echo esc_attr( $id_category ); ?>" size="3" /></p>

    <p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Numero dei post da mostrare:', 'rp' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

    <p><label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php _e( 'Label del link:', 'rp' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" /></p>

    <p><label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php _e( 'Link:', 'rp' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></p>

    <?php
    }
}


function rp_register_widgets() {
    register_widget( 'Rp_Contents_Widget' );
    register_widget( 'Rp_Subpage_Widget' );
}

add_action( 'widgets_init', 'rp_register_widgets' );


/**
 * User: webeing.net
 * Date: 17/10/12
 * Time: 09:59
 * widget per le sottopagine
 */

class Rp_Subpage_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function Rp_Subpage_Widget() {
        $widget_ops = array( 'classname' => 'widget_rp_subpages', 'description' => __( 'Use this widget for Subage', 'rp' ) );
        $this->WP_Widget( 'widget_rp_subpages', __( 'Rp Subage', 'rp' ), $widget_ops );
        $this->alt_option_name = 'widget_rp_subpages';

        add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        $cache = wp_cache_get( 'widget_rp_subpages', 'widget' );

        if ( !is_array( $cache ) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = null;

        if ( isset( $cache[$args['widget_id']] ) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract( $args, EXTR_SKIP );
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'rp', 'rp' ) : $instance['title'], $instance, $this->id_base);

        $rp_args_child_pages = array(
             'child_of' => $instance['page']

        );

        $rp_child_pages = get_pages( $rp_args_child_pages );


        if($rp_child_pages):
            echo $before_widget;
            echo $before_title;
            echo $title; // Can set this with a widget option, or omit altogether
            echo $after_title;
        ?>

        <ul>
            <?php foreach( $rp_child_pages as $rp_child_page ) : ?>

            <li itemscope>

                <a href="<?php echo get_permalink($rp_child_page->ID); ?>" title="<?php echo get_the_title($rp_child_page->ID); ?>">
                    <?php echo get_the_title($rp_child_page->ID); ?>
                </a>
           </li>
                <?php endforeach; ?>
        <ul>
        <br class=clear"/>
        <a title="<?php echo get_the_title($instance['page']);?>" href="<?php echo get_permalink($instance['page']);?>" class="btn dark"><?php echo get_the_title($instance['page']);?> &raquo;</a>
        <?php
           echo $after_widget;

            // Reset the post globals as this query will have stomped on it

            // end check for rpl posts
        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set( 'widget_rp_contents', $cache, 'widget' );
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     **/
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['page'] = strip_tags( $new_instance['page'] );
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset( $alloptions['widget_rp_subpages'] ) )
            delete_option( 'widget_rp_subpages' );

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete( 'widget_rp_subpages', 'widget' );
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     **/
    function form( $instance ) {
        $title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
        $page = isset( $instance['page']) ? esc_attr( $instance['page'] ) : '';
         ?>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Titolo:', 'rp' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'page' ) ); ?>"><?php _e( 'Pagina padre:', 'rp' ); ?></label>
        <?php
            $args = array(
                'parent' => 0,
            );
        $list_page = get_pages($args);
        $selected = ' selected="selected"';

        ?>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page' ) ); ?>" type="text" value="<?php echo esc_attr( $page ); ?>" >

             <?php foreach( $list_page as $rp_page ) :

                $sel = ($rp_page->ID == $page) ?  $selected : "";

                ?>

                <option value="<?php echo $rp_page->ID; ?>"<?php echo $sel; ?>><?php echo $rp_page->post_title; ?></option>
             <?php endforeach;?>
            </select>
        </p>
   <?php
    }
}

?>