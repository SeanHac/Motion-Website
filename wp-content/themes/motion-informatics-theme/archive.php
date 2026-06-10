<?php
/**
 * Archive template — used as fallback for news posts archive.
 */
get_header(); ?>

<main id="main-content" class="pt-20">
    <section class="max-w-7xl mx-auto px-6 lg:px-20 py-16">
        <h1 class="text-4xl font-black text-[#131316] dark:text-white mb-12">
            <?php the_archive_title(); ?>
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while (have_posts()) : the_post(); ?>
            <article class="flex flex-col bg-white dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
                <?php if (has_post_thumbnail()) : ?>
                <div class="h-48 overflow-hidden">
                    <?php the_post_thumbnail('mi-card', ['class' => 'w-full h-full object-cover']); ?>
                </div>
                <?php endif; ?>
                <div class="p-6 flex-1 flex flex-col">
                    <span class="text-xs text-gray-400 mb-2"><?php echo get_the_date(); ?></span>
                    <h2 class="text-lg font-bold mb-3 line-clamp-2">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 line-clamp-3"><?php the_excerpt(); ?></p>
                    <div class="mt-auto">
                        <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-primary dark:text-accent-teal flex items-center gap-1 hover:underline">
                            <?php _e('Read More', 'motion-informatics'); ?>
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </a>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
        <div class="mt-12"><?php the_posts_pagination(); ?></div>
    </section>
</main>

<?php get_footer();
