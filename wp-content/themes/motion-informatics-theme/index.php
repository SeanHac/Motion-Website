<?php
/**
 * Fallback template — redirects to homepage or displays loop.
 */
get_header(); ?>

<main id="main-content" class="max-w-7xl mx-auto px-6 lg:px-20 py-20">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="mb-12">
            <h2 class="text-2xl font-bold mb-4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="text-gray-600 dark:text-gray-400"><?php the_excerpt(); ?></div>
        </article>
    <?php endwhile; else: ?>
        <p class="text-gray-500"><?php _e('No content found.', 'motion-informatics'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer();
