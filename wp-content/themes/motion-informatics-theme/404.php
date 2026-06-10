<?php get_header(); ?>

<main id="main-content" class="min-h-screen flex items-center justify-center px-6 pt-20">
    <div class="text-center max-w-lg">
        <div class="text-8xl font-black text-primary/20 dark:text-primary/10 mb-6">404</div>
        <h1 class="text-3xl font-bold text-[#131316] dark:text-white mb-4">
            <?php _e('Page Not Found', 'motion-informatics'); ?>
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8">
            <?php _e('The page you are looking for does not exist or has been moved.', 'motion-informatics'); ?>
        </p>
        <a href="<?php echo home_url('/'); ?>"
           class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-xl font-bold hover:brightness-110 transition-all">
            <span class="material-symbols-outlined">home</span>
            <?php _e('Return to Homepage', 'motion-informatics'); ?>
        </a>
    </div>
</main>

<?php get_footer();
