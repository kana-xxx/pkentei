<?php get_header(); ?>
<?php get_template_part('inc/breadcrumb'); ?>

<?php while (have_posts()) : the_post(); ?>

  <?php the_content(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>


