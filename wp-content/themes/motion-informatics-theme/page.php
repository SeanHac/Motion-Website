<?php
/**
 * Generic page template fallback.
 */
get_header(); ?>

<main id="main-content" class="max-w-7xl mx-auto px-6 lg:px-20 py-20 pt-28">
    <?php while (have_posts()) : the_post(); ?>
        <article class="prose prose-lg dark:prose-invert max-w-none">
            <h1 class="text-4xl font-black text-primary dark:text-white mb-8"><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer();
