<?php
/**
 * Template Name: Product — Kinyara
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-20">
<div class="relative flex flex-col overflow-x-hidden">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-[1280px] mx-auto w-full px-6 py-12 md:py-24" aria-labelledby="ky-heading">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Text -->
        <div class="flex flex-col gap-6 order-2 lg:order-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider w-fit" style="background-color:rgba(45,157,168,0.1);border:1px solid rgba(45,157,168,0.2);color:#2D9DA8;">
                <?php echo esc_html(mi_field('ky_badge', false, 'In Development')); ?>
            </div>
            <div>
                <h1 id="ky-heading" class="text-5xl md:text-6xl font-black leading-[1.1] tracking-tight text-[#3f3e6f] dark:text-white mb-2">
                    <?php echo esc_html(mi_field('ky_heading', false, 'Axionis–Kynara')); ?>
                </h1>
                <p class="text-xl font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo esc_html(mi_field('ky_subheading', false, 'The Future of Predictive Neurorehabilitation')); ?>
                </p>
            </div>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-[540px] leading-relaxed">
                <?php echo esc_html(mi_field('ky_desc', false, 'Axionis–Kynara is a next-generation neurorehabilitation platform designed to transform the way patients recover from stroke, spinal cord injury, traumatic brain injury, and other neurological disorders. By combining AI, AR, FES, NMES, real-time biofeedback, and BioRhythmIQ® technology, Axionis-Kynara delivers a new level of personalized rehabilitation that adapts continuously to each patient\'s neurological condition and recovery progress.')); ?>
            </p>

            <!-- Capability tags -->
            <?php
            $ky_tags_raw  = get_post_meta(get_the_ID(), 'ky_tags_json', true);
            $ky_tags_rows = $ky_tags_raw ? json_decode($ky_tags_raw, true) : null;
            ?>
            <?php if (empty($ky_tags_rows)) { $ky_tags_rows = [['tag'=>'AI'],['tag'=>'AR'],['tag'=>'FES'],['tag'=>'NMES'],['tag'=>'BioRhythmIQ®']]; } ?>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($ky_tags_rows as $ky_tag_row) :
                    $ky_tag = is_array($ky_tag_row) ? ($ky_tag_row['tag'] ?? '') : '';
                    if (!$ky_tag) continue;
                ?>
                <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-300"><?php echo esc_html($ky_tag); ?></span>
                <?php endforeach; ?>
            </div>

            <div class="flex flex-wrap gap-4 pt-2">
                <a href="#video"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm w-fit transition-all hover:-translate-y-0.5"
                   style="background-color:rgba(45,157,168,0.1);color:#2D9DA8;">
                    <span class="material-symbols-outlined text-base" aria-hidden="true">play_circle</span>
                    <?php echo esc_html(mi_field('ky_video_btn_text', false, 'Watch the video')); ?>
                </a>
            </div>
        </div>

        <!-- Image -->
        <div class="relative order-1 lg:order-2">
            <div class="w-full aspect-square md:aspect-[4/3] bg-[#0d0d14] rounded-3xl overflow-hidden shadow-2xl">
                <?php $ky_poster = mi_field('ky_image') ?: get_template_directory_uri() . '/assets/images/kinyara-placeholder.jpg'; ?>
                <img src="<?php echo esc_url($ky_poster); ?>"
                     alt="<?php echo esc_attr(mi_field('ky_image_alt', false, 'Axionis–Kynara — predictive neurorehabilitation platform')); ?>"
                     class="w-full h-full object-cover"
                     loading="eager"
                     onerror="this.style.display='none'">
            </div>
            <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-full blur-3xl -z-10" style="background-color:rgba(45,157,168,0.15);" aria-hidden="true"></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     VIDEO
═══════════════════════════════════════════════════════════════════════════ -->
<section id="video" class="py-20 bg-gray-50 dark:bg-[#16161c]/50" aria-labelledby="ky-video-heading">
    <div class="max-w-[1280px] mx-auto px-6">
        <p class="text-xs font-bold uppercase tracking-widest mb-6" style="color:#2D9DA8;">
            <?php echo esc_html(mi_field('ky_video_label', false, 'Video')); ?>
        </p>
        <?php
        $ky_video = mi_field('ky_hero_video');
        $ky_yt_id = $ky_video ? mi_youtube_id($ky_video) : '';
        ?>
        <div class="rounded-2xl overflow-hidden shadow-xl bg-gray-900 aspect-video">
            <?php if ($ky_yt_id) : ?>
            <iframe class="w-full h-full"
                    src="https://www.youtube.com/embed/<?php echo esc_attr($ky_yt_id); ?>"
                    title="<?php esc_attr_e('Axionis–Kynara video', 'motion-informatics'); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                    loading="lazy"></iframe>
            <?php elseif ($ky_video) : ?>
            <video class="w-full h-full object-cover" controls preload="metadata">
                <source src="<?php echo esc_url($ky_video); ?>" type="video/mp4">
                <?php _e('Your browser does not support video playback.', 'motion-informatics'); ?>
            </video>
            <?php else : ?>
            <div class="w-full h-full flex items-center justify-center text-gray-500 text-sm">
                <?php _e('Video coming soon', 'motion-informatics'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     DIFFERENTIATOR
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 bg-white dark:bg-[#16161c]" aria-labelledby="ky-diff-heading">
    <div class="max-w-[1280px] mx-auto px-6">
        <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#2D9DA8;">
            <?php echo esc_html(mi_field('ky_diff_label', false, 'Differentiator')); ?>
        </p>
        <h2 id="ky-diff-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white mb-6">
            <?php echo esc_html(mi_field('ky_diff_heading', false, 'Predictive, not reactive')); ?>
        </h2>
        <blockquote class="rounded-2xl p-8 max-w-3xl"
                    style="background-color:rgba(63,62,111,0.06);border-left:4px solid #3f3e6f;">
            <p class="text-lg italic text-[#3f3e6f] dark:text-gray-200 leading-relaxed">
                <?php echo esc_html(mi_field('ky_diff_quote', false, 'Unlike conventional rehabilitation systems that respond only after movement occurs, Axionis-Kynara is being developed to decode patient intent in real time and deliver predictive stimulation before movement is fully expressed.')); ?>
            </p>
        </blockquote>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CORE FEATURES — FEATURE / BENEFIT
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gray-50 dark:bg-[#16161c]/50" aria-labelledby="ky-features-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('ky_features_label', false, 'Core Features — Feature / Benefit')); ?>
            </p>
            <h2 id="ky-features-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white">
                <?php _e('What Makes Axionis–Kynara Different', 'motion-informatics'); ?>
            </h2>
        </div>

        <ul class="grid grid-cols-1 md:grid-cols-3 gap-6 list-none" role="list">
            <?php
            $ky_features_raw = get_post_meta(get_the_ID(), 'ky_features_json', true);
            $ky_features     = $ky_features_raw ? json_decode($ky_features_raw, true) : null;
            if (empty($ky_features)) {
                $ky_features = [
                    ['icon'=>'psychology',  'title'=>'AI Engine',        'feature'=>'Analyzes EMG signals, fatigue, and recovery trends',                  'benefit'=>'Therapy that continuously adjusts to your current capabilities'],
                    ['icon'=>'view_in_ar',  'title'=>'AR Rehabilitation','feature'=>'Interactive therapeutic activities with real-time visual feedback', 'benefit'=>'Higher engagement, stronger neuroplasticity'],
                    ['icon'=>'monitor_heart','title'=>'BioRhythmIQ®',    'feature'=>'Predictive stimulation aligned to individual neural patterns',       'benefit'=>'Faster rebuilding of motor pathways'],
                ];
            }
            foreach ($ky_features as $f) :
            ?>
            <li class="group p-8 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-800 shadow-sm hover:shadow-lg transition-all duration-300">
                <span class="material-symbols-outlined text-4xl mb-4 block group-hover:scale-110 transition-transform" style="color:#2D9DA8;" aria-hidden="true"><?php echo esc_html($f['icon'] ?? 'star'); ?></span>
                <h3 class="font-bold text-lg text-[#3f3e6f] dark:text-white mb-4"><?php echo esc_html($f['title'] ?? ''); ?></h3>
                <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color:#2D9DA8;"><?php _e('Feature', 'motion-informatics'); ?></p>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-4"><?php echo esc_html($f['feature'] ?? ''); ?></p>
                <p class="text-xs font-bold uppercase tracking-wider mb-1 text-[#3f3e6f] dark:text-gray-300"><?php _e('Your benefit', 'motion-informatics'); ?></p>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed"><?php echo esc_html($f['benefit'] ?? ''); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     WHO IS KYNARA FOR?
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-[#16161c]" aria-labelledby="ky-audience-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 id="ky-audience-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white">
                <?php echo esc_html(mi_field('ky_audience_label', false, 'Who Is Kynara For?')); ?>
            </h2>
        </div>

        <ul class="grid grid-cols-1 md:grid-cols-3 gap-6 list-none" role="list">
            <?php
            $ky_audiences_raw = get_post_meta(get_the_ID(), 'ky_audiences_json', true);
            $ky_audiences     = $ky_audiences_raw ? json_decode($ky_audiences_raw, true) : null;
            if (empty($ky_audiences)) {
                $ky_audiences = [
                    ['icon'=>'trending_up',      'title'=>'Investors',            'desc'=>'Large addressable market, differentiated technology, and a proven track record.'],
                    ['icon'=>'handshake',        'title'=>'Influencers & Partners','desc'=>'Early partnership ahead of launch on a scalable platform.'],
                    ['icon'=>'medical_services', 'title'=>'Clinicians',           'desc'=>'Advisory network with real influence and a voice in development.'],
                ];
            }
            foreach ($ky_audiences as $a) :
            ?>
            <li class="group p-8 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-800 shadow-sm hover:shadow-lg transition-all duration-300">
                <span class="material-symbols-outlined text-4xl mb-4 block group-hover:scale-110 transition-transform" style="color:#2D9DA8;" aria-hidden="true"><?php echo esc_html($a['icon'] ?? 'star'); ?></span>
                <h3 class="font-bold text-lg text-[#3f3e6f] dark:text-white mb-3"><?php echo esc_html($a['title'] ?? ''); ?></h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed"><?php echo esc_html($a['desc'] ?? ''); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CTA — BE PART OF THE FUTURE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 text-white" style="background-color:#3f3e6f;" aria-labelledby="ky-cta-heading">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 id="ky-cta-heading" class="text-4xl font-black mb-4">
            <?php echo esc_html(mi_field('ky_cta_heading', false, 'Be part of the future')); ?>
        </h2>
        <p class="text-white/80 text-lg mb-12 max-w-2xl mx-auto">
            <?php echo esc_html(mi_field('ky_cta_desc', false, 'Kynara is currently in development. Join us early.')); ?>
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
            <?php
            $ky_cta_cards_raw = get_post_meta(get_the_ID(), 'ky_cta_cards_json', true);
            $ky_cta_cards     = $ky_cta_cards_raw ? json_decode($ky_cta_cards_raw, true) : null;
            if (empty($ky_cta_cards)) {
                $ky_cta_cards = [
                    ['label'=>'Investors & Partners', 'title'=>'Investors & Partners', 'btn_text'=>'Request our Deck',          'url'=>'mailto:gary@motioninformatics.ai'],
                    ['label'=>'Clinicians',           'title'=>'Clinicians',           'btn_text'=>'Join our Advisory Network', 'url'=>'#'],
                ];
            }
            foreach ($ky_cta_cards as $card) :
                $card_url = $card['url'] ?? '#';
            ?>
            <div class="rounded-2xl p-8 text-left" style="background-color:rgba(255,255,255,0.08);">
                <p class="text-xs font-bold uppercase tracking-widest mb-4" style="color:#2D9DA8;"><?php echo esc_html($card['label'] ?? ''); ?></p>
                <a href="<?php echo esc_url($card_url); ?>"
                   class="inline-flex items-center gap-2 font-bold hover:gap-3 transition-all"
                   style="color:#fff;">
                    <?php echo esc_html($card['btn_text'] ?? ''); ?>
                    <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</div>
</main>

<?php get_footer();
