<?php
/**
 * Template Name: Insights Hub
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-16 md:pt-20">
<div class="relative flex flex-col overflow-x-hidden">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-4 lg:px-10 py-4 md:py-8 w-full">
    <div class="relative overflow-hidden rounded-xl min-h-[220px] md:min-h-[280px] flex items-end p-6 md:p-12 shadow-xl group" style="background-color:#3f3e6f;">
        <div class="absolute inset-0 z-10" style="background:linear-gradient(to top, #3f3e6f, rgba(63,62,111,0.4), transparent);" aria-hidden="true"></div>
        <?php if (has_post_thumbnail()) :
            the_post_thumbnail('mi-hero', ['class'=>'absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay transition-transform duration-700 group-hover:scale-105', 'aria-hidden'=>'true']);
        else : ?>
            <img src="<?php echo get_template_directory_uri() . '/assets/images/news-hero-bg.jpg'; ?>"
                 alt=""
                 class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay transition-transform duration-700 group-hover:scale-105"
                 aria-hidden="true"
                 loading="eager">
        <?php endif; ?>
        <div class="relative z-20 max-w-2xl">
            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold text-white mb-3 md:mb-4 uppercase tracking-widest">
                <?php echo esc_html(mi_field('news_hero_badge', false, 'Resource Center')); ?>
            </span>
            <h1 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-3 md:mb-4">
                <?php the_title(); ?>
            </h1>
            <p class="text-white/80 text-base md:text-lg max-w-lg leading-relaxed">
                <?php echo esc_html(get_the_excerpt() ?: mi_field('news_hero_fallback_desc', false, 'Advancing neuromuscular rehabilitation through data-driven informatics and cutting-edge medical research.')); ?>
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     SEARCH + FILTERS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-4 lg:px-10 pb-4 w-full" aria-label="<?php _e('Filter and search content', 'motion-informatics'); ?>">
    <div class="space-y-6">
        <!-- Search input -->
        <form role="search" class="flex flex-col md:flex-row gap-4" action="<?php echo home_url('/'); ?>" method="get">
            <div class="flex-1 relative">
                <label for="news-search" class="sr-only"><?php _e('Search resources', 'motion-informatics'); ?></label>
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true">search</span>
                <input id="news-search" name="s" type="search"
                       class="w-full h-14 pl-12 pr-4 bg-white dark:bg-gray-900 border-none rounded-xl shadow-sm focus:ring-2 placeholder:text-gray-400 text-base dark:text-white outline-none"
                       style="--tw-ring-color:rgba(63,62,111,0.2);"
                       placeholder="<?php echo esc_attr(mi_field('news_search_placeholder', false, 'Search resources, whitepapers, and clinical data...')); ?>"
                       value="<?php echo get_search_query(); ?>">
                <input type="hidden" name="post_type" value="post">
            </div>
        </form>

        <!-- Category filters (pulled from native WP Tags) -->
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-sm font-semibold mr-2 text-gray-500 uppercase tracking-tighter"><?php echo esc_html(mi_field('news_filter_label', false, 'Filter:')); ?></span>
            <?php
            $current_type = isset($_GET['tag']) ? sanitize_title(wp_unslash($_GET['tag'])) : '';
            $current_url  = get_permalink();
            ?>
            <a href="<?php echo esc_url($current_url); ?>"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all shadow-md <?php echo !$current_type ? 'text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'; ?>"
               <?php if (!$current_type) echo 'style="background-color:#3f3e6f;"'; ?>>
                <?php echo esc_html(mi_field('news_filter_all', false, 'All')); ?>
            </a>
            <?php
            $news_types = get_terms(['taxonomy'=>'post_tag','hide_empty'=>false]);
            if ($news_types && !is_wp_error($news_types)) :
                foreach ($news_types as $type) :
                    $is_active = ($current_type === $type->slug);
            ?>
            <a href="<?php echo esc_url(add_query_arg('tag', $type->slug, $current_url)); ?>"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all <?php echo $is_active ? 'text-white shadow-md' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'; ?>"
               <?php if ($is_active) echo 'style="background-color:#3f3e6f;"'; ?>>
                <?php echo esc_html($type->name); ?>
            </a>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     FEATURED RESOURCE
═══════════════════════════════════════════════════════════════════════════ -->
<?php
// Query for featured posts
$featured_args = [
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => [['key'=>'_mi_featured','value'=>'1','compare'=>'=']],
];
$featured_query = new WP_Query($featured_args);

// If no featured post, get the latest
if (!$featured_query->have_posts()) {
    $featured_query = new WP_Query(['posts_per_page'=>1,'post_status'=>'publish']);
}
?>
<?php if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
<section class="max-w-7xl mx-auto px-4 lg:px-10 mb-12 w-full" aria-labelledby="featured-heading">
    <h2 id="featured-heading" class="text-2xl font-bold mb-6 flex items-center gap-2 text-[#131316] dark:text-white">
        <span class="material-symbols-outlined" style="color:#3f3e6f;" aria-hidden="true">auto_awesome</span>
        <?php echo esc_html(mi_field('news_featured_heading', false, 'Featured Resource')); ?>
    </h2>
    <div>
        <!-- Main featured card -->
        <article class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="grid md:grid-cols-2">
                <?php if (has_post_thumbnail()) : ?>
                <div class="h-64 md:h-full overflow-hidden">
                    <?php the_post_thumbnail('mi-card', ['class'=>'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']); ?>
                </div>
                <?php endif; ?>
                <div class="p-8 flex flex-col justify-center">
                    <div class="flex items-center gap-2 mb-4">
                        <?php
                        $types = get_the_terms(get_the_ID(), 'post_tag');
                        if ($types && !is_wp_error($types)) {
                            echo mi_news_badge($types[0]->name);
                        }
                        ?>
                        <span class="text-gray-400 text-xs"><?php echo get_the_date(); ?></span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 dark:text-white transition-colors group-hover:text-[#3f3e6f]">
                        <?php the_title(); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 leading-relaxed">
                        <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="flex items-center gap-2 font-bold text-sm hover:underline" style="color:#3f3e6f;">
                        <?php echo esc_html(mi_field('news_read_analysis', false, 'Read the full analysis')); ?>
                        <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                    </a>
                </div>
            </div>
        </article>
    </div>
</section>
<?php endwhile; wp_reset_postdata(); endif; ?>

<!-- ═══════════════════════════════════════════════════════════════════════════
     MAIN CONTENT GRID
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-4 lg:px-10 pb-16 w-full">
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $search = get_search_query();
    $news_args = [
        'post_type'      => 'post',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    if ($current_type) $news_args['tag'] = $current_type;
    if ($search) $news_args['s'] = $search;
    $news_query = new WP_Query($news_args);
    ?>

    <?php if ($news_query->have_posts()) : ?>
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 list-none" role="list">
        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
        <li>
            <article class="flex flex-col bg-white dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow h-full">
                <div class="h-48 relative overflow-hidden">
                    <?php if (has_post_thumbnail()) :
                        the_post_thumbnail('mi-card', ['class'=>'w-full h-full object-cover']);
                    else : ?>
                        <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(to bottom right, rgba(63,62,111,0.1), rgba(45,157,168,0.1));">
                            <span class="material-symbols-outlined text-4xl" style="color:rgba(63,62,111,0.3);" aria-hidden="true">article</span>
                        </div>
                    <?php endif; ?>
                    <div class="absolute top-4 left-4">
                        <?php
                        $types = get_the_terms(get_the_ID(), 'post_tag');
                        if ($types && !is_wp_error($types)) {
                            echo mi_news_badge($types[0]->name);
                        }
                        ?>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <time class="text-xs text-gray-400 mb-2" datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date(); ?> · <?php the_author(); ?>
                    </time>
                    <h3 class="text-lg font-bold mb-3 line-clamp-2 dark:text-white">
                        <a href="<?php the_permalink(); ?>" class="transition-colors hover:text-[#3f3e6f]">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 line-clamp-3 flex-1">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>
                    <div class="mt-auto">
                        <a href="<?php the_permalink(); ?>" class="text-sm font-bold flex items-center gap-1 hover:underline" style="color:#3f3e6f;">
                            <?php echo esc_html(mi_field('news_read_more', false, 'Read More')); ?>
                            <span class="material-symbols-outlined text-sm" aria-hidden="true">chevron_right</span>
                        </a>
                    </div>
                </div>
            </article>
        </li>
        <?php endwhile; ?>
    </ul>
    <?php else : ?>
    <div class="py-20 text-center">
        <span class="material-symbols-outlined text-6xl text-gray-200 dark:text-gray-700 mb-4 block" aria-hidden="true">search_off</span>
        <p class="text-gray-500 dark:text-gray-400"><?php echo esc_html(mi_field('news_no_results', false, 'No articles found. Try a different search or filter.')); ?></p>
    </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($news_query->max_num_pages > 1) : ?>
    <nav class="mt-16 flex items-center justify-center gap-4" aria-label="<?php _e('News pagination', 'motion-informatics'); ?>">
        <?php
        echo paginate_links([
            'total'     => $news_query->max_num_pages,
            'current'   => $paged,
            'prev_text' => '<span class="material-symbols-outlined" aria-hidden="true">chevron_left</span>',
            'next_text' => '<span class="material-symbols-outlined" aria-hidden="true">chevron_right</span>',
            'type'      => 'list',
            'before_page_number' => '<span class="size-10 rounded-lg border border-gray-200 dark:border-gray-800 inline-flex items-center justify-center text-sm font-medium transition-all" style="--hover-bg:#3f3e6f;">',
            'after_page_number'  => '</span>',
        ]);
        ?>
    </nav>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</section>

</div>
</main>

<?php get_footer();
