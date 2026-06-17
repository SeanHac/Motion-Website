<?php
/**
 * Template Name: Product — STIMEL-03
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-20">
<div class="relative flex flex-col overflow-x-hidden">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-[1280px] mx-auto w-full px-6 py-12 md:py-24" aria-labelledby="s3-heading">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Text -->
        <div class="flex flex-col gap-8 order-2 lg:order-1">
            <h1 id="s3-heading" class="text-5xl md:text-6xl font-black leading-[1.1] tracking-tight text-[#3f3e6f] dark:text-white">
                <?php echo esc_html(mi_field('s3_heading1', false, 'STIMEL-03®: Accelerating Recovery with')); ?>
                <span style="color:#2D9DA8;"> <?php echo esc_html(mi_field('s3_heading_accent', false, 'Tailored Stimulation')); ?></span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-[540px] leading-relaxed">
                <?php echo esc_html(mi_field('s3_desc', false, 'An FDA-cleared, EMG-driven neuromuscular stimulation system integrating Functional Electrical Stimulation (FES), Neuromuscular Electrical Stimulation (NMES), and real-time biofeedback into a single adaptive rehabilitation solution. Powered by BioRhythmIQ technology, Stimel-03 captures electromyographic signals, analyzes neuromotor intent in real time, and delivers precisely timed stimulation to reinforce correct motor activation patterns.')); ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="<?php echo esc_url(mi_field('s3_btn1_url', false, '#')); ?>"
                   class="mi-product-primary-btn flex min-w-[180px] items-center justify-center rounded-xl h-14 px-8 text-white text-base font-bold shadow-lg hover:-translate-y-0.5 transition-all"
                   style="background-color:#3f3e6f;">
                    <?php echo esc_html(mi_field('s3_btn1_text', false, 'Schedule a Demo')); ?>
                </a>
                <a href="<?php echo esc_url(mi_field('s3_btn2_url', false, '#')); ?>"
                   class="flex min-w-[180px] items-center justify-center rounded-xl h-14 px-8 border-2 border-gray-200 dark:border-gray-700 dark:text-white text-base font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-all"
                   style="color:#3f3e6f;">
                    <?php echo esc_html(mi_field('s3_btn2_text', false, 'Consult Clinical Papers')); ?>
                </a>
            </div>
        </div>

        <!-- Product Hero Video -->
        <div class="relative order-1 lg:order-2">
            <div class="w-full aspect-video bg-[#0d0d14] rounded-3xl overflow-hidden shadow-2xl">
                <?php
                $s3_video  = mi_field('s3_hero_video');
                $s3_poster = mi_field('s3_image') ?: get_template_directory_uri() . '/assets/images/stimel03-hero-ai.png';
                ?>
                <video
                    class="w-full h-full object-cover"
                    autoplay muted loop playsinline
                    poster="<?php echo esc_url($s3_poster); ?>">
                    <source src="<?php echo esc_url($s3_video ?: get_template_directory_uri() . '/assets/videos/stimel03-hero.mp4'); ?>" type="video/mp4">
                </video>
                <!-- Floating UI element -->
                <?php if (mi_field('s3_show_floating', false, true)) : ?>
                <div class="absolute top-6 left-6 p-4 rounded-xl bg-white/90 dark:bg-black/80 backdrop-blur shadow-sm border border-white/20">
                    <div class="text-[10px] font-bold uppercase mb-1" style="color:#2D9DA8;"><?php echo esc_html(mi_field('s3_floating_label', false, 'Pulse Intensity')); ?></div>
                    <div class="text-xl font-black text-[#3f3e6f] dark:text-white" aria-live="polite"><?php echo esc_html(mi_field('s3_floating_value', false, '84.2 mA')); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-full blur-3xl -z-10" style="background-color:rgba(45,157,168,0.1);" aria-hidden="true"></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     KEY BENEFITS GRID
═══════════════════════════════════════════════════════════════════════════ -->
<section class="bg-white dark:bg-[#16161c]/50 py-20" aria-label="<?php echo esc_attr(mi_field('s3_benefits_aria', false, 'Key Benefits')); ?>">
    <div class="max-w-[1280px] mx-auto px-6">
        <?php
        $benefits_raw = get_post_meta(get_the_ID(), 's3_benefits_json', true);
        $benefits = ($benefits_raw) ? json_decode($benefits_raw, true) : null;
        if (!$benefits) $benefits = function_exists('get_field') ? get_field('s3_benefits') : null;
        if (!$benefits) {
            $benefits = [
                ['icon'=>'bolt',           'title'=>'Accelerated Motor Recovery',        'desc'=>'EMG-triggered stimulation reinforces voluntary intent in real time, driving faster functional gains and measurable improvement in activities of daily living.'],
                ['icon'=>'neurology',      'title'=>'Active Neuroplasticity Engagement', 'desc'=>'Synchronization of brain intent, visual biofeedback, and electrical stimulation strengthens motor pathways and supports durable neural rewiring.'],
                ['icon'=>'tune',           'title'=>'Personalized Patient-Specific Therapy','desc'=>'Individual EMG thresholds and adaptive stimulation parameters reduce fatigue, prevent over-stimulation, and align therapy with each patient\'s neuromuscular status.'],
                ['icon'=>'accessibility', 'title'=>'Early & Chronic Stage Applicability','desc'=>'High-sensitivity EMG detection enables intervention even when visible movement is minimal, supporting early post-stroke care and long-term rehabilitation.'],
            ];
        }
        ?>
        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 list-none" role="list">
            <?php foreach ($benefits as $benefit) : ?>
            <li class="group p-8 rounded-2xl border border-gray-100 dark:border-gray-800 transition-all duration-300" style="--hover-border:rgba(45,157,168,0.5);">
                <span class="material-symbols-outlined text-4xl mb-4 block group-hover:scale-110 transition-transform" style="color:#2D9DA8;" aria-hidden="true"><?php echo esc_html($benefit['icon'] ?? 'star'); ?></span>
                <h3 class="text-xl font-bold text-[#3f3e6f] dark:text-white mb-2"><?php echo esc_html($benefit['title'] ?? ''); ?></h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed"><?php echo esc_html($benefit['desc'] ?? ''); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     KEY DIFFERENTIATORS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 bg-gray-50 dark:bg-[#16161c]/30" aria-labelledby="diff-heading">
    <div class="max-w-[1280px] mx-auto px-6">
        <div class="text-center mb-12" data-animate>
            <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('s3_diff_badge', false, 'Why Stimel-03')); ?>
            </p>
            <h2 id="diff-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white">
                <?php echo esc_html(mi_field('s3_diff_heading', false, 'Key Differentiators')); ?>
            </h2>
        </div>
        <?php
        $diffs_raw = get_post_meta(get_the_ID(), 's3_differentiators_json', true);
        $diffs = ($diffs_raw) ? json_decode($diffs_raw, true) : null;
        if (!$diffs) $diffs = function_exists('get_field') ? get_field('s3_differentiators') : null;
        if (!$diffs) {
            $diffs = [
                ['icon'=>'neurology',     'title'=>'BioRhythmIQ-Guided Therapy',           'desc'=>'EMG-guided, intent-triggered stimulation fires only when the patient\'s voluntary signal reaches the calibrated threshold — reinforcing correct motor recruitment.'],
                ['icon'=>'sync',          'title'=>'Real-Time Timing Alignment',            'desc'=>'Stimulation is synchronized with neuromotor intent, not delivered on a fixed schedule — converting passive stimulation into active neuromuscular re-education.'],
                ['icon'=>'trending_up',   'title'=>'Measurable Progress Tracking',          'desc'=>'Session data is tracked longitudinally, enabling clinicians to quantify improvement and adapt protocols with objective evidence.'],
                ['icon'=>'accessibility', 'title'=>'Early Intervention Capability',         'desc'=>'High-sensitivity EMG detection captures ultra-low voluntary signals, enabling intervention even when visible movement is absent.'],
                ['icon'=>'clinical_notes','title'=>'Clinically Differentiated Revenue',     'desc'=>'FDA-cleared, patent-based biofeedback technology combined with recurring electrode consumption supports sustainable clinical deployment and distributor scalability.'],
                ['icon'=>'favorite',      'title'=>'Improved Engagement & Adherence',       'desc'=>'Real-time visual feedback transforms therapy into an interactive process, increasing patient motivation, compliance, and session effectiveness.'],
            ];
        }
        ?>
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 list-none" role="list">
            <?php foreach ($diffs as $i => $diff): ?>
            <li class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all flex gap-4"
                data-animate style="transition-delay:<?php echo $i*70; ?>ms">
                <div class="size-10 rounded-lg flex-shrink-0 flex items-center justify-center mt-1" style="background-color:rgba(45,157,168,0.1);color:#2D9DA8;" aria-hidden="true">
                    <span class="material-symbols-outlined text-xl"><?php echo esc_html($diff['icon'] ?? 'star'); ?></span>
                </div>
                <div>
                    <h3 class="font-bold text-[#3f3e6f] dark:text-white mb-1"><?php echo esc_html($diff['title'] ?? ''); ?></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed"><?php echo esc_html($diff['desc'] ?? ''); ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

        <!-- ═══════════════════════════════════════════════════════════════
             VIDEOS — AFTER KEY DIFFERENTIATORS (nested in same container)
        ═══════════════════════════════════════════════════════════════ -->
        <?php
        $diff_videos_raw = get_post_meta(get_the_ID(), 's3_videos_diff_json', true);
        $diff_videos = ($diff_videos_raw) ? json_decode($diff_videos_raw, true) : null;
        if (is_array($diff_videos)) {
            $has_any_url = false;
            foreach ($diff_videos as $_v) { if (!empty($_v['url'])) { $has_any_url = true; break; } }
            if (!$has_any_url) $diff_videos = null;
        }
        ?>
        <?php if (!empty($diff_videos)) : ?>
        <div class="mt-12 grid grid-cols-1 <?php echo (count($diff_videos) > 1) ? 'lg:grid-cols-2' : ''; ?> gap-8">
            <?php foreach ($diff_videos as $vid) :
                $vurl = $vid['url'] ?? '';
                if (!$vurl) continue;
                $yt_id = mi_youtube_id($vurl);
            ?>
            <div class="rounded-2xl overflow-hidden shadow-xl bg-gray-900 aspect-video">
                <?php if ($yt_id) : ?>
                <iframe class="w-full h-full"
                        src="https://www.youtube.com/embed/<?php echo esc_attr($yt_id); ?>"
                        title="<?php esc_attr_e('Product video', 'motion-informatics'); ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        loading="lazy"></iframe>
                <?php else : ?>
                <video class="w-full h-full object-cover" controls preload="metadata">
                    <source src="<?php echo esc_url($vurl); ?>" type="video/mp4">
                    <?php _e('Your browser does not support video playback.', 'motion-informatics'); ?>
                </video>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     ADAPTIVE BIOFEEDBACK FEATURE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 max-w-[1280px] mx-auto px-6" aria-labelledby="biofeedback-heading">
    <div class="flex flex-col lg:flex-row gap-16 items-center">
        <!-- Image left -->
        <div class="w-full lg:w-1/2 order-2 lg:order-1">
            <?php $bio_image = mi_field('s3_bio_image'); ?>
            <div class="relative rounded-2xl overflow-hidden shadow-xl aspect-video bg-[#0d0d14]">
                <img src="<?php echo esc_url($bio_image ?: get_template_directory_uri() . '/assets/images/stimel03-hero-ai.png'); ?>"
                     alt="<?php echo esc_attr(mi_field('s3_bio_image_alt', false, 'STIMEL-03® device showing real-time biofeedback')); ?>"
                     class="w-full h-full object-cover"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='<?php echo esc_js(get_template_directory_uri() . '/assets/images/stimel03-hero-ai.png'); ?>'">
            </div>
        </div>

        <!-- Text right -->
        <div class="w-full lg:w-1/2 order-1 lg:order-2">
            <p class="font-bold tracking-widest text-sm uppercase mb-4" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('s3_bio_badge', false, 'Precision Technology')); ?>
            </p>
            <h2 id="biofeedback-heading" class="text-4xl font-black text-[#3f3e6f] dark:text-white mb-6 leading-tight">
                <?php echo esc_html(mi_field('s3_bio_heading', false, 'Adaptive Biofeedback')); ?>
            </h2>
            <div class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                <?php echo wp_kses_post(mi_field('s3_bio_desc', false, 'BioRhythmIQ technology captures patient-specific electromyographic signals and displays them in real time. The dynamic EMG threshold algorithm recalibrates continuously based on performance and fatigue — once the patient\'s muscle activation reaches a dynamically calibrated threshold, stimulation fires to reinforce correct motor execution. Passive stimulation becomes active neuromuscular re-education.')); ?>
            </div>
            <?php
            $bullets_raw = get_post_meta(get_the_ID(), 's3_bio_bullets_json', true);
            $bullets = ($bullets_raw) ? json_decode($bullets_raw, true) : null;
            if (!$bullets) $bullets = function_exists('get_field') ? get_field('s3_bio_bullets') : null;
            if (!$bullets) {
                $bullets = [
                    ['bullet'=>'Real-time surface EMG detection of voluntary motor intent'],
                    ['bullet'=>'Intent-triggered stimulation synchronized with patient effort'],
                    ['bullet'=>'Patient-specific threshold calibration and adaptive delivery to reduce fatigue'],
                ];
            }
            ?>
            <ul class="space-y-4 list-none" role="list">
                <?php foreach ($bullets as $b) : ?>
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined flex-shrink-0" style="color:#2D9DA8;" aria-hidden="true">check_circle</span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo esc_html($b['bullet'] ?? ''); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CLOSED-LOOP PRECISION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gray-50 dark:bg-[#16161c]/30" aria-labelledby="closed-loop-heading">
    <div class="max-w-[1280px] mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <!-- Text left -->
            <div class="w-full lg:w-1/2">
                <p class="font-bold tracking-widest text-sm uppercase mb-4" style="color:#2D9DA8;">
                    <?php echo esc_html(mi_field('s3_loop_badge', false, 'Autonomous Recovery')); ?>
                </p>
                <h2 id="closed-loop-heading" class="text-4xl font-black text-[#3f3e6f] dark:text-white mb-6 leading-tight">
                    <?php echo esc_html(mi_field('s3_loop_heading', false, 'Closed-Loop Precision')); ?>
                </h2>
                <div class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    <?php echo wp_kses_post(mi_field('s3_loop_desc', false, 'Stimel-03 delivers measurable clinical outcomes: ADL improvement (FIM) of +50.6% vs +20.7% in controls; hand function (Fugl-Meyer) +67.4% vs +34.8%; stroke severity (NIHSS) −48.7% vs −26.2%. Recovery is 2.3× faster than controls, with fewer sessions. The system detects ultra-low EMG signals, enabling early intervention even when visible movement is minimal.')); ?>
                </div>
                <?php
                $stats_raw = get_post_meta(get_the_ID(), 's3_stats_json', true);
                $stats = ($stats_raw) ? json_decode($stats_raw, true) : null;
                if (!$stats) $stats = function_exists('get_field') ? get_field('s3_stats') : null;
                if (!$stats) {
                    $stats = [
                        ['value'=>'99.9%','label'=>'Adjustment Accuracy'],
                        ['value'=>'<5ms', 'label'=>'Feedback Loop Speed'],
                    ];
                }
                ?>
                <dl class="grid grid-cols-2 gap-4">
                    <?php foreach ($stats as $stat) : ?>
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <dt class="text-xs text-gray-500 font-bold uppercase tracking-tighter"><?php echo esc_html($stat['label'] ?? ''); ?></dt>
                        <dd class="text-2xl font-black" style="color:#2D9DA8;"><?php echo esc_html($stat['value'] ?? ''); ?></dd>
                    </div>
                    <?php endforeach; ?>
                </dl>
            </div>
            <!-- Image right -->
            <div class="w-full lg:w-1/2">
                <?php $loop_image = mi_field('s3_loop_image'); ?>
                <div class="relative rounded-2xl overflow-hidden border-4 border-white dark:border-gray-800 shadow-2xl aspect-video bg-gray-200 dark:bg-gray-800">
                    <?php if ($loop_image) : ?>
                        <img src="<?php echo esc_url($loop_image); ?>"
                             alt="<?php echo esc_attr(mi_field('s3_loop_image_alt', false, 'Closed-loop feedback system diagram')); ?>"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/stimel-closed-loop.jpg'; ?>"
                             alt="<?php echo esc_attr(mi_field('s3_loop_image_alt', false, 'Closed-loop feedback system diagram')); ?>"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     TECHNICAL SPECIFICATIONS TABLE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 max-w-[1024px] mx-auto px-6" aria-labelledby="specs-heading">
    <div class="text-center mb-16">
        <h2 id="specs-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white mb-4">
            <?php echo esc_html(mi_field('s3_specs_heading', false, 'Technical Specifications')); ?>
        </h2>
        <p class="text-gray-500 dark:text-gray-400"><?php echo esc_html(mi_field('s3_specs_desc', false, 'Standard performance metrics for clinical evaluation.')); ?></p>
    </div>

    <?php
    $specs_raw = get_post_meta(get_the_ID(), 's3_specs_json', true);
    $specs = ($specs_raw) ? json_decode($specs_raw, true) : null;
    if (!$specs) $specs = function_exists('get_field') ? get_field('s3_specs') : null;
    if (!$specs) {
        $specs = [
            ['parameter'=>'Pulse Width',         'value'=>'50–1000 µs',                          'notes'=>'Adjustable in 10µs increments'],
            ['parameter'=>'Current Amplitude',   'value'=>'0–120 mA',                            'notes'=>'Constant current source'],
            ['parameter'=>'Frequency Range',     'value'=>'1–150 Hz',                            'notes'=>'Supports burst mode patterns'],
            ['parameter'=>'Power Source',        'value'=>'Li-Ion Rechargeable',                 'notes'=>'Up to 12 hours clinical usage'],
            ['parameter'=>'EMG Sensing',         'value'=>'Surface EMG (sEMG)',                  'notes'=>'Single electrode setup for both sensing and stimulation'],
            ['parameter'=>'Operational Modes',   'value'=>'Automatic / Manual / Biofeedback',    'notes'=>'Switchable per session protocol'],
            ['parameter'=>'Regulatory Status',   'value'=>'FDA 510(k) Cleared — K 130424',       'notes'=>'Class II Medical Device · 21 CFR 890.5850'],
            ['parameter'=>'Patent',              'value'=>'US Patent 7,221,980 B2',              'notes'=>'BioRhythmIQ Technology'],
            ['parameter'=>'Intended Settings',   'value'=>'Hospitals · Rehabilitation Centers · Neurology · OT/PT Clinics · Home Use', 'notes'=>'Home use under clinical guidance'],
        ];
    }
    ?>

    <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800">
        <table class="w-full text-left border-collapse" aria-label="<?php echo esc_attr(mi_field('s3_specs_table_aria', false, 'STIMEL-03 Technical Specifications')); ?>">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-900">
                    <th scope="col" class="p-5 text-sm font-bold text-[#3f3e6f] dark:text-white border-b border-gray-200 dark:border-gray-800"><?php echo esc_html(mi_field('s3_specs_col_param', false, 'Parameter')); ?></th>
                    <th scope="col" class="p-5 text-sm font-bold text-[#3f3e6f] dark:text-white border-b border-gray-200 dark:border-gray-800"><?php echo esc_html(mi_field('s3_specs_col_value', false, 'Value')); ?></th>
                    <th scope="col" class="p-5 text-sm font-bold text-[#3f3e6f] dark:text-white border-b border-gray-200 dark:border-gray-800"><?php echo esc_html(mi_field('s3_specs_col_notes', false, 'Notes')); ?></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-[#16161c]">
                <?php foreach ($specs as $i => $spec) : ?>
                <tr class="<?php echo $i < count($specs)-1 ? 'border-b border-gray-100 dark:border-gray-800' : ''; ?>">
                    <td class="p-5 text-sm font-medium text-[#131316] dark:text-white"><?php echo esc_html($spec['parameter'] ?? ''); ?></td>
                    <td class="p-5 text-sm text-gray-600 dark:text-gray-400"><?php echo esc_html($spec['value'] ?? ''); ?></td>
                    <td class="p-5 text-sm text-gray-400"><?php echo esc_html($spec['notes'] ?? ''); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php $datasheet = mi_field('s3_datasheet_url'); ?>
    <?php if ($datasheet) : ?>
    <div class="mt-10 flex justify-center">
        <a href="<?php echo esc_url($datasheet); ?>"
           class="font-bold flex items-center gap-2 hover:underline"
           style="color:#3f3e6f;"
           download target="_blank" rel="noopener noreferrer">
            <span class="material-symbols-outlined" aria-hidden="true">download</span>
            <?php echo esc_html(mi_field('s3_datasheet_link_text', false, 'Download Full Datasheet (PDF)')); ?>
        </a>
    </div>
    <?php endif; ?>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     PRODUCT IN ACTION — VIDEO
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 max-w-[1280px] mx-auto px-6" aria-labelledby="s3-video-heading">
    <div class="text-center mb-12">
        <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#2D9DA8;">
            <?php echo esc_html(mi_field('s3_video_badge', false, 'Product Demonstration')); ?>
        </p>
        <h2 id="s3-video-heading" class="text-3xl font-black text-[#3f3e6f] dark:text-white mb-4">
            <?php echo esc_html(mi_field('s3_video_heading', false, 'See STIMEL-03® in Action')); ?>
        </h2>
        <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            <?php echo esc_html(mi_field('s3_video_desc', false, 'Watch real clinical demonstrations of the STIMEL-03® neuromuscular stimulation system delivering precise, intent-triggered therapy.')); ?>
        </p>
    </div>

    <?php
    $s3_videos_raw = get_post_meta(get_the_ID(), 's3_videos_json', true);
    $s3_videos     = ($s3_videos_raw) ? json_decode($s3_videos_raw, true) : null;
    // Treat as empty if every row has no URL (no point rendering a section with no videos)
    if (is_array($s3_videos)) {
        $has_any_url = false;
        foreach ($s3_videos as $_v) { if (!empty($_v['url'])) { $has_any_url = true; break; } }
        if (!$has_any_url) $s3_videos = null;
    }
    if (!$s3_videos) {
        // Legacy fallback: use the previous fixed fields / hardcoded asset paths so existing site keeps working
        // until the new metabox is populated in the editor.
        $legacy = [
            [
                'url'    => function_exists('get_field') ? get_field('s3_video_main_url') : '',
                'poster' => function_exists('get_field') ? get_field('s3_video_main_poster') : '',
                'aria'   => function_exists('get_field') ? get_field('s3_video_main_aria') : '',
                'fallback_url'    => get_template_directory_uri() . '/assets/videos/stimel-main-demo.mp4',
                'fallback_poster' => get_template_directory_uri() . '/assets/images/stimel3-screen.png',
                'fallback_aria'   => 'STIMEL-03 product demonstration video',
            ],
            [
                'url'    => function_exists('get_field') ? get_field('s3_video_wrist_url') : '',
                'poster' => function_exists('get_field') ? get_field('s3_video_wrist_poster') : '',
                'aria'   => function_exists('get_field') ? get_field('s3_video_wrist_aria') : '',
                'fallback_url'    => get_template_directory_uri() . '/assets/videos/stimel-wrist-demo.mp4',
                'fallback_poster' => get_template_directory_uri() . '/assets/images/stimel3-electrode.png',
                'fallback_aria'   => 'Wrist flexion muscle stimulation demonstration',
            ],
        ];
        $s3_videos = [];
        foreach ($legacy as $l) {
            $s3_videos[] = [
                'url'    => $l['url']    ?: $l['fallback_url'],
                'poster' => $l['poster'] ?: $l['fallback_poster'],
                'aria'   => $l['aria']   ?: $l['fallback_aria'],
            ];
        }
    }
    ?>
    <?php if (!empty($s3_videos)) : ?>
    <div class="grid grid-cols-1 <?php echo (count($s3_videos) > 1) ? 'lg:grid-cols-2' : ''; ?> gap-8">
        <?php foreach ($s3_videos as $v) :
            $url    = is_array($v['url'])    ? ($v['url']['url']    ?? '') : ($v['url']    ?? '');
            $poster = isset($v['poster']) ? (is_array($v['poster']) ? ($v['poster']['url'] ?? '') : ($v['poster'] ?? '')) : '';
            $aria   = $v['aria'] ?? '';
            if (!$url) continue;
            $yt_id  = mi_youtube_id($url);
        ?>
        <div class="rounded-2xl overflow-hidden shadow-xl bg-gray-900 aspect-video">
            <?php if ($yt_id) : ?>
            <iframe class="w-full h-full"
                    src="https://www.youtube.com/embed/<?php echo esc_attr($yt_id); ?>"
                    title="<?php echo esc_attr($aria ?: 'YouTube video player'); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                    loading="lazy"></iframe>
            <?php else : ?>
            <video class="w-full h-full object-cover"
                   controls
                   preload="metadata"
                   <?php if ($poster) : ?>poster="<?php echo esc_url($poster); ?>"<?php endif; ?>
                   <?php if ($aria)   : ?>aria-label="<?php echo esc_attr($aria); ?>"<?php endif; ?>>
                <source src="<?php echo esc_url($url); ?>" type="video/mp4">
                <?php _e('Your browser does not support video playback.', 'motion-informatics'); ?>
            </video>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Product gallery (ACF gallery field, drag-to-reorder in admin) -->
    <?php
    $s3_gallery_acf = function_exists('get_field') ? get_field('s3_gallery') : null;
    $s3_gallery_default = [
        ['url' => get_template_directory_uri() . '/assets/images/stimel3-device-1.png', 'alt' => 'STIMEL-03® device front view'],
        ['url' => get_template_directory_uri() . '/assets/images/stimel3-device-2.png', 'alt' => 'STIMEL-03® device side view'],
        ['url' => get_template_directory_uri() . '/assets/images/stimel3-screen.png',   'alt' => 'STIMEL-03® screen interface'],
        ['url' => get_template_directory_uri() . '/assets/images/stimel3-electrode.png','alt' => 'STIMEL-03® electrode with logo'],
    ];
    $s3_gallery_items = $s3_gallery_acf ?: $s3_gallery_default;
    ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
        <?php foreach ($s3_gallery_items as $img) :
            if (is_numeric($img)) {
                $img_url = wp_get_attachment_image_url((int)$img, 'large') ?: wp_get_attachment_url((int)$img) ?: '';
                $img_alt = get_post_meta((int)$img, '_wp_attachment_image_alt', true) ?: '';
            } else {
                $img_url = $img['url'] ?? '';
                $img_alt = $img['alt'] ?? '';
            }
        ?>
        <div class="rounded-xl overflow-hidden aspect-square bg-gray-100 dark:bg-gray-800 shadow-sm">
            <img src="<?php echo esc_url($img_url); ?>"
                 alt="<?php echo esc_attr($img_alt); ?>"
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                 loading="lazy">
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CTA FOOTER
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 text-white" style="background-color:#3f3e6f;" aria-labelledby="s3-cta-heading">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 id="s3-cta-heading" class="text-4xl font-black mb-6">
            <?php echo esc_html(mi_field('s3_cta_heading', false, 'Ready to transform patient recovery?')); ?>
        </h2>
        <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto">
            <?php echo esc_html(mi_field('s3_cta_desc', false, 'Join hundreds of clinical centers worldwide already utilizing Motion Informatics for advanced neuromuscular rehabilitation.')); ?>
        </p>
        <div class="flex justify-center">
            <?php
            $s3_cta_url = mi_field('s3_cta_btn1_url', false, '');
            if (!$s3_cta_url) {
                $contact_page = get_page_by_path('contact');
                $s3_cta_url   = $contact_page ? get_permalink($contact_page) : '#';
            }
            ?>
            <a href="<?php echo esc_url($s3_cta_url); ?>"
               class="h-14 px-12 text-white font-bold rounded-xl shadow-xl shadow-black/20 hover:scale-[1.05] transition-all inline-flex items-center justify-center"
               style="background-color:#2D9DA8;">
                <?php echo esc_html(mi_field('s3_cta_btn1_text', false, 'Schedule a Demo')); ?>
            </a>
            <?php $s3_cta_btn2_text = mi_field('s3_cta_btn2_text', false, '');
                  $s3_cta_btn2_url  = mi_field('s3_cta_btn2_url',  false, '');
                  if ($s3_cta_btn2_text) : ?>
            <a href="<?php echo esc_url($s3_cta_btn2_url ?: '#'); ?>"
               class="h-14 px-12 font-bold rounded-xl border-2 border-white/30 hover:bg-white/10 transition-all inline-flex items-center justify-center text-white">
                <?php echo esc_html($s3_cta_btn2_text); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

</div>
</main>

<?php get_footer();
