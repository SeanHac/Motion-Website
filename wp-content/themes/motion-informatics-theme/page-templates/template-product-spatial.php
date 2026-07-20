<?php
/**
 * Template Name: Product — Spatial StimelMD
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-20">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="relative overflow-hidden pt-16 pb-24 md:pt-24 md:pb-32" aria-labelledby="spatial-heading">
    <div class="absolute inset-0 -z-10" style="background:radial-gradient(circle at top right, rgba(45,157,168,0.1), transparent, transparent);" aria-hidden="true"></div>
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <!-- Text Column -->
        <div class="flex flex-col gap-8">
            <?php if (mi_field('sp_show_hero_badge', false, true)) : ?>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider w-fit" style="background-color:rgba(45,157,168,0.1);border:1px solid rgba(45,157,168,0.2);color:#2D9DA8;">
                <span class="relative flex h-2 w-2" aria-hidden="true">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color:#2D9DA8;"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2" style="background-color:#2D9DA8;"></span>
                </span>
                <?php echo esc_html(mi_field('sp_badge', false, 'Next Generation Rehabilitation')); ?>
            </div>
            <?php endif; ?>
            <h1 id="spatial-heading" class="text-5xl md:text-7xl font-black leading-[1.1] tracking-tight text-slate-900 dark:text-white">
                <?php echo esc_html(mi_field('sp_heading', false, 'Spatial')); ?>
                <span style="color:#2D9DA8;"> <?php echo esc_html(mi_field('sp_heading_accent', false, 'StimelMD')); ?><sup style="font-size:0.4em;vertical-align:super">®</sup></span>
            </h1>
            <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-lg">
                <?php echo esc_html(mi_field('sp_desc', false, 'A next-generation neuromuscular rehabilitation platform integrating Artificial Intelligence (AI), Augmented Reality (AR), Functional Electrical Stimulation (FES), Neuromuscular Electrical Stimulation (NMES), real-time biofeedback, and BioRhythmIQ technology into a unified, adaptive clinical ecosystem designed to restore motor function and promote neuroplasticity.')); ?>
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="#immersive-video"
                   class="mi-product-primary-btn h-14 px-8 text-white font-bold rounded-xl flex items-center gap-2 hover:scale-[1.02] transition-transform"
                   style="background-color:#3f3e6f;">
                    <?php echo esc_html(mi_field('sp_btn1_text', false, 'Explore Technology')); ?>
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                </a>
                <a href="<?php echo esc_url(mi_field('sp_btn2_url', false, '#')); ?>"
                   class="h-14 px-8 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-bold rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                    <?php echo esc_html(mi_field('sp_btn2_text', false, 'View Specs')); ?>
                </a>
            </div>
        </div>

        <!-- Product Image with Floating Element -->
        <div class="relative">
            <?php $sp_image = mi_field('sp_image'); ?>
            <div class="relative z-10 w-full aspect-square rounded-3xl overflow-hidden shadow-2xl bg-slate-200 dark:bg-slate-800">
                <?php if ($sp_image) : ?>
                    <img src="<?php echo esc_url($sp_image); ?>"
                         alt="<?php echo esc_attr(mi_field('sp_image_alt', false, 'Spatial StimelMD — AR-enhanced neuromuscular rehabilitation system')); ?>"
                         class="w-full h-full object-cover"
                         loading="eager">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/ssmd-img-5.jpg'; ?>"
                         alt="<?php echo esc_attr(mi_field('sp_image_alt', false, 'Spatial StimelMD® — clinical rehabilitation session')); ?>"
                         class="w-full h-full object-cover"
                         loading="eager"
                         onerror="this.onerror=null;this.src='<?php echo esc_js(get_template_directory_uri() . '/assets/images/spatial-hero-device.jpg'); ?>'">
                <?php endif; ?>

                <!-- Floating AR Stats Card -->
                <?php if (mi_field('sp_show_floating_stat', false, true)) : ?>
                <div class="absolute top-10 right-10 glass-panel p-4 rounded-xl shadow-xl"
                     aria-label="<?php printf('%s: %s', esc_attr(mi_field('sp_stat_label', false, 'Neural Sync')), esc_attr(mi_field('sp_stat_value', false, '98.4% Active'))); ?>">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined font-bold" style="color:#2D9DA8;" aria-hidden="true">heart_check</span>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-500"><?php echo esc_html(mi_field('sp_stat_label', false, 'Neural Sync')); ?></p>
                            <p class="text-sm font-bold text-[#3f3e6f] dark:text-white"><?php echo esc_html(mi_field('sp_stat_value', false, '98.4% Active')); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="absolute -top-10 -left-10 w-40 h-40 rounded-full blur-3xl -z-10" style="background-color:rgba(45,157,168,0.2);" aria-hidden="true"></div>
            <div class="absolute -bottom-10 -right-10 w-60 h-60 rounded-full blur-3xl -z-10" style="background-color:rgba(63,62,111,0.2);" aria-hidden="true"></div>
        </div>

        <!-- Immersive Motor Training demo video(s) — full width, spans both columns -->
        <?php
        $tdir_hero     = get_template_directory_uri();
        $imm_video_raw = get_post_meta(get_the_ID(), 'sp_immersive_video_json', true);
        $imm_videos    = ($imm_video_raw) ? json_decode($imm_video_raw, true) : null;
        if (is_array($imm_videos)) {
            $imm_has_url = false;
            foreach ($imm_videos as $_v) { if (!empty($_v['url'])) { $imm_has_url = true; break; } }
            if (!$imm_has_url) $imm_videos = null;
        }
        if (!$imm_videos) {
            $imm_videos = [
                ['url' => $tdir_hero . '/assets/videos/ssmd-immersive-demo.mp4'],
            ];
        }
        ?>
        <div id="immersive-video" class="lg:col-span-2 mt-8 grid grid-cols-1 <?php echo count($imm_videos) > 1 ? 'lg:grid-cols-2' : ''; ?> gap-8">
            <?php foreach ($imm_videos as $imm_v) :
                $imm_v_url = $imm_v['url'] ?? '';
                if (!$imm_v_url) continue;
                $imm_yt_id = mi_youtube_id($imm_v_url);
            ?>
            <div class="relative rounded-2xl overflow-hidden shadow-xl bg-slate-900 aspect-video">
                <?php if ($imm_yt_id) : ?>
                <iframe class="w-full h-full"
                        src="https://www.youtube.com/embed/<?php echo esc_attr($imm_yt_id); ?>"
                        title="Immersive Motor Training demonstration video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        loading="lazy"></iframe>
                <?php else : ?>
                <video class="w-full h-full object-cover"
                       controls
                       preload="metadata"
                       aria-label="Immersive Motor Training demonstration video">
                    <source src="<?php echo esc_url($imm_v_url); ?>" type="video/mp4">
                    <?php _e('Your browser does not support video playback.', 'motion-informatics'); ?>
                </video>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CLINICAL CHALLENGE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-[#16161c]" id="challenge" aria-labelledby="challenge-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16" data-animate>
            <p class="font-bold uppercase tracking-widest text-xs mb-4" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('sp_challenge_badge', false, 'The Problem We Solve')); ?>
            </p>
            <h2 id="challenge-heading" class="text-4xl font-black text-slate-900 dark:text-white mb-6 leading-tight">
                <?php echo esc_html(mi_field('sp_challenge_heading', false, 'The Rehabilitation Adherence Gap')); ?>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
                <?php echo esc_html(mi_field('sp_challenge_desc', false, 'Stroke and neuromuscular disorders generate long-term disability at a global scale. Rehabilitation systems face increasing pressure due to rising patient volumes, staffing shortages, inconsistent home follow-up, and limited objective progress tracking.')); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <?php
            $stats_raw = get_post_meta(get_the_ID(), 'sp_challenge_stats_json', true);
        $stats = ($stats_raw) ? json_decode($stats_raw, true) : null;
        if (!$stats) $stats = function_exists('get_field') ? get_field('sp_challenge_stats') : null;
            if (!$stats) {
                $stats = [
                    ['value'=>'76%', 'label'=>'of patients did not complete all assigned at-home physical therapy exercises after discharge', 'source'=>'National Survey'],
                    ['value'=>'73%', 'label'=>'missed at least one scheduled visit during their course of care — in a cohort of 444,995 patients', 'source'=>'U.S. Cohort Study'],
                ];
            }
            foreach ($stats as $i => $stat): ?>
            <div class="rounded-2xl p-10 text-center text-white relative overflow-hidden"
                 style="background-color:#3f3e6f;"
                 data-animate style="transition-delay:<?php echo $i*120; ?>ms">
                <div class="text-7xl font-black mb-4" style="color:#2D9DA8;"><?php echo esc_html($stat['value'] ?? ''); ?></div>
                <p class="text-white/90 text-lg leading-relaxed mb-3"><?php echo esc_html($stat['label'] ?? ''); ?></p>
                <span class="text-xs uppercase tracking-widest text-white/50"><?php echo esc_html($stat['source'] ?? ''); ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="max-w-3xl mx-auto text-center bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700" data-animate>
            <p class="text-slate-700 dark:text-slate-300 text-lg leading-relaxed">
                <?php echo esc_html(mi_field('sp_challenge_solution', false, 'Spatial StimelMD addresses this adherence challenge by integrating AI-driven real-time EMG decoding, BioRhythmIQ adaptive threshold modulation, FES, NMES, and AR into a closed feedback loop that reinforces patient intent, sustains engagement, and enables clinicians to monitor performance objectively.')); ?>
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     IMMERSIVE MOTOR TRAINING (AR & FES)
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-[#16161c]" id="immersive" aria-labelledby="immersive-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <!-- Text -->
            <div class="lg:w-1/2 flex flex-col gap-6">
                <p class="font-bold tracking-wider uppercase text-sm" style="color:#2D9DA8;">
                    <?php echo esc_html(mi_field('sp_immersive_badge', false, 'Enhanced Neuroplasticity')); ?>
                </p>
                <h2 id="immersive-heading" class="text-4xl font-black text-slate-900 dark:text-white leading-tight">
                    <?php echo esc_html(mi_field('sp_immersive_heading', false, 'Immersive Motor Training Through AR & FES')); ?>
                </h2>
                <div class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    <?php echo wp_kses_post(mi_field('sp_immersive_desc', false, 'Augmented Reality is embedded at the core of SSMD, anchoring therapy in real-world context. Patients maintain visual contact with their limbs during therapy, strengthening sensorimotor integration and improving functional carryover into daily life. The system combines AR engagement with intent-driven EMG-triggered FES and NMES to reinforce true motor relearning and strengthen neuroplastic pathways.')); ?>
                </div>
                <?php
                $bullets_raw = get_post_meta(get_the_ID(), 'sp_immersive_bullets_json', true);
                $bullets = ($bullets_raw) ? json_decode($bullets_raw, true) : null;
                if (!$bullets) $bullets = function_exists('get_field') ? get_field('sp_immersive_bullets') : null;
                if (!$bullets) {
                    $bullets = [
                        ['bullet'=>'AR overlays therapeutic elements onto the patient\'s real-world environment'],
                        ['bullet'=>'Enhances mirror neuron activation and improves functional carryover into daily life'],
                        ['bullet'=>'Links voluntary EMG activity to precisely timed FES/NMES for true motor relearning'],
                    ];
                }
                ?>
                <ul class="flex flex-col gap-4 py-4 list-none" role="list">
                    <?php foreach ($bullets as $b) : ?>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined font-bold flex-shrink-0" style="color:#2D9DA8;" aria-hidden="true">check_circle</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300"><?php echo esc_html($b['bullet'] ?? ''); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Product Composite Visual -->
            <?php $tdir = get_template_directory_uri(); ?>
            <div class="lg:w-1/2 flex flex-col gap-4">

                <!-- Card 1: Clinical photo -->
                <div class="relative rounded-2xl overflow-hidden shadow-xl group" style="height:260px;">
                    <img src="<?php echo esc_url(mi_field('sp_immersive_img1') ?: $tdir . '/assets/images/ssmd-clinical-ai-1.jpg'); ?>"
                         alt="Spatial StimelMD® in clinical use"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='<?php echo esc_js($tdir . '/assets/images/ssmd-clinical-ai-1.jpg'); ?>'">
                </div>

                <!-- Card 2: Second SSMD photo -->
                <div class="relative rounded-2xl overflow-hidden shadow-xl group" style="height:220px;">
                    <img src="<?php echo esc_url(mi_field('sp_immersive_img2') ?: $tdir . '/assets/images/ssmd-clinical-ai-2.jpg'); ?>"
                         alt="Spatial StimelMD® device in session"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='<?php echo esc_js($tdir . '/assets/images/ssmd-clinical-ai-2.jpg'); ?>'">
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     AI ADAPTABILITY CARDS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-slate-50 dark:bg-slate-900/50" id="adaptability" aria-labelledby="adaptability-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <p class="font-bold uppercase tracking-widest text-xs mb-4" style="color:#2D9DA8;"><?php echo esc_html(mi_field('sp_ai_eyebrow', false, 'The Intelligent Edge')); ?></p>
            <h2 id="adaptability-heading" class="text-4xl font-black text-slate-900 dark:text-white mb-6">
                <?php echo esc_html(mi_field('sp_ai_heading', false, 'AI-Driven Adaptability')); ?>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg">
                <?php echo esc_html(mi_field('sp_ai_desc', false, 'Multi-layer AI analyzes muscle activation, fatigue, and performance trends in real time, dynamically optimizing therapy within and across sessions. AI operates at three levels: real-time signal interpretation, longitudinal trend analysis, and structured report generation for clinical decision-making.')); ?>
            </p>
        </div>

        <?php
        $ai_raw = get_post_meta(get_the_ID(), 'sp_ai_cards_json', true);
        $ai_cards = ($ai_raw) ? json_decode($ai_raw, true) : null;
        if (!$ai_cards) $ai_cards = function_exists('get_field') ? get_field('sp_ai_cards') : null;
        if (!$ai_cards) {
            $ai_cards = [
                ['icon'=>'neurology',      'color'=>'accent', 'title'=>'AI-Personalized Adaptive Therapy',    'desc'=>'Multi-layer AI analyzes muscle activation, fatigue, and performance trends in real time, dynamically optimizing stimulation parameters within and across sessions.'],
                ['icon'=>'monitor_heart',  'color'=>'primary','title'=>'Closed-Loop Biofeedback Precision',   'desc'=>'Real-time EMG visualization combined with dynamic threshold recalibration maintains optimal therapeutic challenge, improves adherence, and supports measurable progress.'],
                ['icon'=>'home_health',    'color'=>'accent', 'title'=>'Seamless Clinic-to-Home Continuity',  'desc'=>'A unified therapist, home, and remote ecosystem enables hybrid rehabilitation models while preserving clinical oversight and treatment consistency.'],
            ];
        }
        ?>
        <ul class="grid grid-cols-1 md:grid-cols-3 gap-8 list-none" role="list">
            <?php foreach ($ai_cards as $card) :
                $color = $card['color'] ?? 'accent';
                if ($color === 'accent') {
                    $icon_bg    = 'rgba(45,157,168,0.1)';
                    $icon_color = '#2D9DA8';
                } else {
                    $icon_bg    = 'rgba(63,62,111,0.1)';
                    $icon_color = '#3f3e6f';
                }
            ?>
            <li class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="size-14 rounded-xl flex items-center justify-center mb-6" style="background-color:<?php echo $icon_bg; ?>;color:<?php echo $icon_color; ?>;">
                    <span class="material-symbols-outlined text-3xl font-light" aria-hidden="true"><?php echo esc_html($card['icon'] ?? 'star'); ?></span>
                </div>
                <h3 class="text-xl font-bold mb-3 dark:text-white"><?php echo esc_html($card['title'] ?? ''); ?></h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed"><?php echo esc_html($card['desc'] ?? ''); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     HOW SSMD WORKS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-[#16161c]" id="how-it-works" aria-labelledby="how-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-animate>
            <p class="font-bold uppercase tracking-widest text-xs mb-4" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('sp_how_badge', false, 'Step by Step')); ?>
            </p>
            <h2 id="how-heading" class="text-4xl font-black text-slate-900 dark:text-white mb-4">
                <?php echo esc_html(mi_field('sp_how_heading', false, 'From Intent to Movement')); ?>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                <?php echo esc_html(mi_field('sp_how_desc', false, 'Every therapy session follows a precise closed-loop sequence — from the patient\'s voluntary effort to measurable motor output.')); ?>
            </p>
        </div>

        <?php
        $steps_raw = get_post_meta(get_the_ID(), 'sp_how_steps_json', true);
        $steps = ($steps_raw) ? json_decode($steps_raw, true) : null;
        if (!$steps) $steps = function_exists('get_field') ? get_field('sp_how_steps') : null;
        if (!$steps) {
            $steps = [
                ['number'=>'01', 'title'=>'Patient Attempts Movement',     'desc'=>'The patient initiates a voluntary movement attempt, activating residual neuromuscular signals.'],
                ['number'=>'02', 'title'=>'EMG Signals Detected',          'desc'=>'Surface EMG electrodes capture and analyze voluntary motor signals in real time — even ultra-low amplitude signals.'],
                ['number'=>'03', 'title'=>'AI Evaluates Signal Quality',   'desc'=>'Multi-layer AI assesses signal strength, activation quality, and pattern against the dynamically calibrated threshold.'],
                ['number'=>'04', 'title'=>'Targeted FES or NMES Delivered','desc'=>'When threshold criteria are achieved, precisely timed Functional Electrical Stimulation (FES) or NMES is delivered to reinforce the movement.'],
                ['number'=>'05', 'title'=>'AR Visual Reinforcement',       'desc'=>'Augmented Reality provides immediate visual feedback within the real-world setting, strengthening sensorimotor integration.'],
                ['number'=>'06', 'title'=>'Session Data Stored',           'desc'=>'All session data is analyzed and stored for longitudinal tracking, reporting, and AI-driven therapy optimization.'],
            ];
        }
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($steps as $i => $step): ?>
            <div class="relative bg-slate-50 dark:bg-slate-800/50 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 hover:shadow-xl transition-all duration-300"
                 data-animate style="transition-delay:<?php echo $i*80; ?>ms">
                <div class="text-5xl font-black mb-4 leading-none" style="color:rgba(45,157,168,0.2);"><?php echo esc_html($step['number'] ?? ''); ?></div>
                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-3"><?php echo esc_html($step['title'] ?? ''); ?></h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo esc_html($step['desc'] ?? ''); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     SSMD CLINICAL PHOTO GALLERY
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-16 bg-white dark:bg-[#16161c]" aria-labelledby="ssmd-gallery-heading">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-10">
            <p class="font-bold uppercase tracking-widest text-xs mb-3" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('sp_gallery_badge', false, 'Product Gallery')); ?>
            </p>
            <h2 id="ssmd-gallery-heading" class="text-3xl font-black text-slate-900 dark:text-white">
                <?php echo esc_html(mi_field('sp_gallery_heading', false, 'Spatial StimelMD® in the Clinic')); ?>
            </h2>
        </div>
        <?php
        $sp_gallery_acf = function_exists('get_field') ? get_field('sp_gallery') : null;
        $tdir_gallery = get_template_directory_uri();
        $sp_gallery_default = [
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-3.jpg', 'alt' => 'Spatial StimelMD® clinical session'],
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-4.jpg', 'alt' => 'Spatial StimelMD® therapy application'],
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-5.jpg', 'alt' => 'Spatial StimelMD® patient rehabilitation'],
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-6.jpg', 'alt' => 'Spatial StimelMD® neuromuscular stimulation'],
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-7.jpg', 'alt' => 'Spatial StimelMD® biofeedback session'],
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-8.jpg', 'alt' => 'Spatial StimelMD® clinical environment'],
            ['url' => $tdir_gallery . '/assets/images/ssmd-img-9.jpg', 'alt' => 'Spatial StimelMD® device in use'],
        ];
        $sp_gallery_items = $sp_gallery_acf ?: $sp_gallery_default;
        ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($sp_gallery_items as $photo) :
                if (is_numeric($photo)) {
                    $photo_url = wp_get_attachment_image_url((int)$photo, 'large') ?: wp_get_attachment_url((int)$photo) ?: '';
                    $photo_alt = get_post_meta((int)$photo, '_wp_attachment_image_alt', true) ?: '';
                } else {
                    $photo_url = $photo['url'] ?? '';
                    $photo_alt = $photo['alt'] ?? '';
                }
            ?>
            <div class="rounded-xl overflow-hidden aspect-square bg-slate-100 dark:bg-slate-800 shadow-sm group">
                <img src="<?php echo esc_url($photo_url); ?>"
                     alt="<?php echo esc_attr($photo_alt); ?>"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     loading="lazy">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     VISION QUOTE — PARALLAX STYLE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="relative py-32 overflow-hidden flex items-center justify-center text-center px-6" id="vision">
    <?php $quote_bg = mi_field('sp_quote_bg'); ?>
    <div class="absolute inset-0"
         style="<?php echo $quote_bg ? 'background-image: linear-gradient(rgba(19,19,22,0.8), rgba(19,19,22,0.8)), url(' . esc_url($quote_bg) . '); background-size: cover; background-position: center;' : 'background-image: url(' . get_template_directory_uri() . '/assets/images/spatial-vision-bg.jpg); background-size: cover; background-position: center;'; ?>"
         aria-hidden="true">
        <div class="absolute inset-0" style="background:linear-gradient(rgba(19,19,22,0.8),rgba(19,19,22,0.8));"></div>
    </div>
    <blockquote class="relative max-w-4xl">
        <p class="text-3xl md:text-5xl font-black text-white leading-tight mb-8">
            <?php echo esc_html(mi_field('sp_quote', false, '"We are building a computational treatment platform that fuses real-time electrophysiology, adaptive stimulation, and spatial computing into a unified architecture for movement recovery."')); ?>
        </p>
        <div class="h-1 w-24 mx-auto mb-8" style="background-color:#2D9DA8;" aria-hidden="true"></div>
        <footer class="font-bold uppercase tracking-[0.2em] text-sm" style="color:#2D9DA8;">
            <?php echo esc_html(mi_field('sp_quote_attribution', false, 'Vision Statement · Motion Informatics')); ?>
        </footer>
    </blockquote>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     TECHNICAL SPECS — ACCORDION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-[#16161c]" id="specs" aria-labelledby="sp-specs-heading">
    <div class="max-w-7xl mx-auto px-6">
        <h2 id="sp-specs-heading" class="text-3xl font-black text-center mb-16 dark:text-white"><?php echo esc_html(mi_field('sp_specs_heading', false, 'Technical Specifications')); ?></h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-4">
                <?php
                $specs_raw = get_post_meta(get_the_ID(), 'sp_specs_json', true);
                $specs = ($specs_raw) ? json_decode($specs_raw, true) : null;
                if (!$specs) $specs = function_exists('get_field') ? get_field('sp_specs') : null;
                if (!$specs) {
                    $specs = [
                        ['title'=>'Multi-Setting Deployment', 'content'=>'SSMD-T (Therapist Unit): Clinical-grade, protocol customization, EMG calibration, detailed reporting. SSMD-H (Home Unit): Patient-friendly, AI-guided auto-adaptation, AR engagement. SSMD-R (Remote Module): Cloud-synced tele-rehabilitation interface.'],
                        ['title'=>'Clinical Capabilities',    'content'=>'Upper Limb: Wrist/finger flexion & extension, supination/pronation, elbow/shoulder activation. Lower Limb: Foot drop correction, gait phase stimulation, balance training. Neurological: Post-stroke motor recovery, hemiparesis/hemiplegia, spinal cord injury, TBI, neuromuscular re-education. Orthopedic: Muscle re-activation, disuse atrophy prevention, strength restoration.'],
                        ['title'=>'Regulatory & Safety',      'content'=>'Submitted to the FDA under the 510(k) pathway and to CE-MDR in Europe. Designed to meet Class II medical device standards. Built on US Patent No. 7,221,980 B2 (BioRhythmIQ technology).'],
                    ];
                }
                foreach ($specs as $i => $spec) :
                    $spec_id   = 'spec-' . $i;
                    $panel_id  = 'spec-panel-' . $i;
                ?>
                <div class="border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
                    <button type="button"
                            class="spec-trigger w-full p-6 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center text-left cursor-pointer"
                            aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                            aria-controls="<?php echo esc_attr($panel_id); ?>"
                            id="<?php echo esc_attr($spec_id); ?>">
                        <span class="font-bold text-[#131316] dark:text-white"><?php echo esc_html($spec['title'] ?? ''); ?></span>
                        <span class="material-symbols-outlined transition-transform duration-300 <?php echo $i === 0 ? 'rotate-180' : ''; ?>" aria-hidden="true">expand_more</span>
                    </button>
                    <div id="<?php echo esc_attr($panel_id); ?>"
                         role="region"
                         aria-labelledby="<?php echo esc_attr($spec_id); ?>"
                         class="spec-panel p-6 text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-200 dark:border-slate-800 <?php echo $i === 0 ? '' : 'hidden'; ?>">
                        <?php echo esc_html($spec['content'] ?? ''); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Integration Ready Card -->
            <div class="bg-slate-900 rounded-2xl p-10 text-white relative overflow-hidden flex flex-col justify-center">
                <div class="absolute top-0 right-0 p-8 opacity-20" aria-hidden="true">
                    <span class="material-symbols-outlined text-[120px]">architecture</span>
                </div>
                <h3 class="text-2xl font-bold mb-4 relative z-10"><?php echo esc_html(mi_field('sp_integration_heading', false, 'Integration Ready')); ?></h3>
                <p class="text-slate-400 mb-8 relative z-10">
                    <?php echo esc_html(mi_field('sp_integration_desc', false, 'SSMD is built as a scalable rehabilitation platform integrating AI, AR, FES, NMES, real-time biofeedback, and BioRhythmIQ technology across multi-setting deployment and tele-rehabilitation environments. Automated session analytics and structured reports support data-driven clinical decision-making.')); ?>
                </p>
                <a href="<?php echo esc_url(mi_field('sp_integration_btn_url', false, '#')); ?>" class="w-fit px-6 py-3 text-white font-bold rounded-lg transition-all relative z-10" style="background-color:#2D9DA8;">
                    <?php echo esc_html(mi_field('sp_integration_btn', false, 'Download Datasheet')); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 text-white" style="background-color:#3f3e6f;" aria-labelledby="sp-cta-heading">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 id="sp-cta-heading" class="text-4xl font-black mb-6">
            <?php echo esc_html(mi_field('sp_cta_heading', false, 'Ready to transform patient recovery?')); ?>
        </h2>
        <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto">
            <?php echo esc_html(mi_field('sp_cta_desc', false, 'Join hundreds of clinical centers worldwide already utilizing Motion Informatics for advanced neuromuscular rehabilitation.')); ?>
        </p>
        <div class="flex justify-center">
            <?php
            $sp_cta_url = mi_field('sp_cta_btn1_url', false, '');
            if (!$sp_cta_url) {
                $contact_page = get_page_by_path('contact');
                $sp_cta_url   = $contact_page ? get_permalink($contact_page) : '#';
            }
            ?>
            <a href="<?php echo esc_url($sp_cta_url); ?>"
               class="h-14 px-12 text-white font-bold rounded-xl shadow-xl shadow-black/20 hover:scale-[1.05] transition-all inline-flex items-center justify-center"
               style="background-color:#2D9DA8;">
                <?php echo esc_html(mi_field('sp_cta_btn1_text', false, 'Schedule Virtual Demo')); ?>
            </a>
        </div>
    </div>
</section>

</main>

<?php get_footer();
