<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 29/10/12
 * Time: 17.08
 * To change this template use File | Settings | File Templates.
 */
global $user_ID;
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$id_author = $author->ID;

if ( $user_ID != $id_author )
    wp_redirect("/". RP_LOGIN_URL_SLUG);

get_header();

?>
  <section id="container" class="row">
      <div id="content" role="main" class="col-left left">
          <?php

              get_template_part( 'content', 'profile' );
          ?>

      </div><!-- #content -->
      <?php get_sidebar('Sidebar Blog'); ?>
      <div class="clear"></div>
  </section><!-- #container -->

<?php get_footer(); ?>