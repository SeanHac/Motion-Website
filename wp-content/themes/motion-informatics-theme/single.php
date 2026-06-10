<?php
/**
 * Single post template — used for News articles.
 */
get_header(); ?>

<main id="main-content" class="pt-16 md:pt-20">
    <?php while (have_posts()) : the_post(); ?>

    <!-- Article Hero -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-20 pt-6 pb-10 md:py-16">
        <div class="mb-4 md:mb-6">
            <?php
            $tags = get_the_terms(get_the_ID(), 'post_tag');
            if ($tags && !is_wp_error($tags)) {
                echo mi_news_badge($tags[0]->name);
            }
            ?>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black leading-tight mb-4 md:mb-6"
            style="color:#131316;">
            <?php the_title(); ?>
        </h1>
        <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-400 mb-6 md:mb-8">
            <span><?php echo get_the_date(); ?></span>
            <span>·</span>
            <span><?php the_author(); ?></span>
        </div>
        <?php if (has_post_thumbnail()) : ?>
        <div class="rounded-xl md:rounded-2xl overflow-hidden mb-6 md:mb-12 aspect-video">
            <?php the_post_thumbnail('mi-hero', ['class' => 'w-full h-full object-cover']); ?>
        </div>
        <?php endif; ?>
        <div class="prose prose-base sm:prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
            <?php the_content(); ?>
        </div>
    </section>

    <!-- Back to News -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-20 pb-12 md:pb-20">
        <a href="<?php echo get_post_type_archive_link('post'); ?>"
           class="inline-flex items-center gap-2 text-primary dark:text-accent-teal font-bold hover:underline">
            <span class="material-symbols-outlined">arrow_back</span>
            <?php _e('Back to News & Insights', 'motion-informatics'); ?>
        </a>
    </section>

    <?php endwhile; ?>
</main>

<?php get_footer();
