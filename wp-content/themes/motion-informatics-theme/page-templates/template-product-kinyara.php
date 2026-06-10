<?php
/**
 * Template Name: Product — Kinyara
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-20">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO — COMING SOON
═══════════════════════════════════════════════════════════════════════════ -->
<section class="relative min-h-[640px] flex items-center justify-center overflow-hidden" aria-labelledby="kinyara-heading">
    <div class="absolute inset-0 -z-10" style="background:radial-gradient(circle at top left, rgba(45,157,168,0.12), transparent 55%), radial-gradient(circle at bottom right, rgba(63,62,111,0.12), transparent 55%);" aria-hidden="true"></div>

    <div class="max-w-4xl mx-auto px-6 text-center py-24">

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-8"
             style="background-color:rgba(45,157,168,0.1);border:1px solid rgba(45,157,168,0.2);color:#2D9DA8;">
            <span class="relative flex h-2 w-2" aria-hidden="true">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color:#2D9DA8;"></span>
                <span class="relative inline-flex rounded-full h-2 w-2" style="background-color:#2D9DA8;"></span>
            </span>
            <?php _e('Coming Soon', 'motion-informatics'); ?>
        </div>

        <!-- Product name -->
        <h1 id="kinyara-heading" class="text-6xl md:text-8xl font-black leading-tight tracking-tight mb-6">
            <span class="text-[#3f3e6f] dark:text-white">Kinyara</span><sup style="font-size:0.35em;vertical-align:super;color:#2D9DA8;">®</sup>
        </h1>

        <!-- Tagline -->
        <p class="text-xl md:text-2xl text-gray-500 dark:text-gray-400 font-medium max-w-2xl mx-auto mb-12 leading-relaxed">
            <?php echo esc_html(mi_field('kinyara_tagline', false, 'Our next-generation neuromuscular rehabilitation platform. Full specifications and clinical data coming soon.')); ?>
        </p>

        <!-- Decorative divider -->
        <div class="h-1 w-24 mx-auto mb-12 rounded-full" style="background:linear-gradient(90deg,#3f3e6f,#2D9DA8);" aria-hidden="true"></div>

        <!-- Description -->
        <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto leading-relaxed mb-12">
            <?php echo esc_html(mi_field('kinyara_desc', false, 'The Kinyara product specification document is currently being finalized. Please check back shortly or contact our team for preliminary information.')); ?>
        </p>

        <!-- CTA buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <?php $contact_page = get_page_by_path('contact'); ?>
            <a href="<?php echo $contact_page ? esc_url(get_permalink($contact_page)) : '#'; ?>"
               class="h-14 px-10 text-white font-bold rounded-xl shadow-lg hover:scale-[1.03] transition-all inline-flex items-center justify-center gap-2"
               style="background-color:#3f3e6f;">
                <span class="material-symbols-outlined text-base" aria-hidden="true">mail</span>
                <?php _e('Request Information', 'motion-informatics'); ?>
            </a>
            <?php $stimel_page = get_page_by_path('stimel-03'); ?>
            <a href="<?php echo $stimel_page ? esc_url(get_permalink($stimel_page)) : '#'; ?>"
               class="h-14 px-10 font-bold rounded-xl border-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all inline-flex items-center justify-center"
               style="border-color:#2D9DA8;color:#2D9DA8;">
                <?php _e('View STIMEL-03®', 'motion-informatics'); ?>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     WHAT TO EXPECT
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 bg-gray-50 dark:bg-[#16161c]/50" aria-labelledby="kinyara-expect-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="font-bold uppercase tracking-widest text-xs mb-3" style="color:#2D9DA8;">
                <?php _e('What to Expect', 'motion-informatics'); ?>
            </p>
            <h2 id="kinyara-expect-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white">
                <?php echo esc_html(mi_field('kinyara_expect_heading', false, 'Built on the Motion Informatics Platform')); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $pillars = [
                ['icon' => 'neurology',      'title' => 'BioRhythmIQ Technology',     'desc' => 'EMG-guided, intent-triggered stimulation built on our proven BioRhythmIQ adaptive platform.'],
                ['icon' => 'clinical_notes', 'title' => 'FDA Regulatory Pathway',      'desc' => 'Designed from the ground up to meet Class II medical device standards and clinical requirements.'],
                ['icon' => 'groups',         'title' => 'Clinical-Grade Performance',  'desc' => 'Engineered for deployment across hospital, rehabilitation, and home care environments.'],
            ];
            foreach ($pillars as $i => $p) :
            ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all"
                 data-animate style="transition-delay:<?php echo $i * 100; ?>ms">
                <div class="size-12 rounded-xl flex items-center justify-center mb-6" style="background-color:rgba(45,157,168,0.1);color:#2D9DA8;" aria-hidden="true">
                    <span class="material-symbols-outlined text-2xl"><?php echo esc_html($p['icon']); ?></span>
                </div>
                <h3 class="font-bold text-lg text-[#3f3e6f] dark:text-white mb-2"><?php echo esc_html($p['title']); ?></h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed"><?php echo esc_html($p['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CONTACT CTA
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 text-white" style="background-color:#3f3e6f;" aria-label="<?php _e('Contact us about Kinyara', 'motion-informatics'); ?>">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-black mb-4"><?php _e('Be the First to Know', 'motion-informatics'); ?></h2>
        <p class="text-white/80 mb-8 text-lg">
            <?php _e('Contact our team to receive the Kinyara specification document as soon as it becomes available.', 'motion-informatics'); ?>
        </p>
        <?php $contact_page2 = get_page_by_path('contact'); ?>
        <a href="<?php echo $contact_page2 ? esc_url(get_permalink($contact_page2)) : '#'; ?>"
           class="h-14 px-12 inline-flex items-center justify-center rounded-xl font-bold text-white hover:scale-[1.05] transition-all"
           style="background-color:#2D9DA8;">
            <?php _e('Contact Us', 'motion-informatics'); ?>
        </a>
    </div>
</section>

</main>

<?php get_footer();
