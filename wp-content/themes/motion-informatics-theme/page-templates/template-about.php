<?php
/**
 * Template Name: About Us
 * Template Post Type: page
 *
 * About Us & Company Vision page.
 */
get_header(); ?>

<main id="main-content" class="pt-20">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO: WHO WE ARE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 lg:px-20 py-20 md:py-28" aria-labelledby="about-heading">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="flex flex-col gap-8">
            <span class="text-xs font-bold uppercase tracking-widest text-[#3f3e6f] dark:text-[#2D9DA8]">
                <?php echo esc_html(mi_field('about_badge', false, 'Established 2014')); ?>
            </span>
            <h1 id="about-heading" class="text-5xl md:text-6xl font-black text-[#131316] dark:text-white leading-tight tracking-tight">
                <?php echo esc_html(mi_field('about_heading', false, 'Who We Are')); ?>
            </h1>
            <div class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed max-w-xl">
                <?php
                $about_desc = mi_field('about_desc', false, 'Motion Informatics is a deep-tech bioelectronic systems company architecting next-generation, AI-driven adaptive stimulation platforms for advanced rehabilitation. We operate beyond the traditional medical device model — building a computational treatment platform that fuses real-time electrophysiology, adaptive stimulation, and spatial computing into a unified rehabilitation architecture.');
                echo wp_kses_post($about_desc);
                ?>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="<?php echo esc_url(mi_field('about_btn1_url', false, '#')); ?>"
                   class="mi-product-primary-btn flex items-center gap-2 px-8 py-4 text-white font-bold rounded-xl hover:brightness-110 transition-all shadow-lg"
                   style="background-color:#3f3e6f;">
                    <?php echo esc_html(mi_field('about_btn1_text', false, 'Our Methodology')); ?>
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                </a>
                <a href="<?php echo esc_url(mi_field('about_btn2_url', false, '#')); ?>"
                   class="flex items-center gap-2 px-8 py-4 border-2 border-gray-200 dark:border-gray-700 text-[#3f3e6f] dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <?php echo esc_html(mi_field('about_btn2_text', false, 'Clinical Data')); ?>
                </a>
            </div>
        </div>
        <div class="relative">
            <?php $about_image = mi_field('about_image'); ?>
            <?php if ($about_image) : ?>
                <img src="<?php echo esc_url($about_image); ?>"
                     alt="<?php echo esc_attr(mi_field('about_image_alt', false, 'Motion Informatics team')); ?>"
                     class="w-full aspect-[4/3] object-cover rounded-3xl shadow-2xl"
                     loading="lazy">
            <?php else : ?>
                <div class="w-full aspect-[4/3] rounded-3xl shadow-2xl flex items-center justify-center" style="background:linear-gradient(to bottom right, rgba(63,62,111,0.1), rgba(45,157,168,0.2));">
                    <span class="material-symbols-outlined text-8xl" style="color:rgba(63,62,111,0.3);" aria-hidden="true">neurology</span>
                </div>
            <?php endif; ?>
            <!-- Decorative blob -->
            <div class="absolute -top-6 -right-6 w-48 h-48 rounded-full blur-3xl -z-10" style="background-color:rgba(45,157,168,0.1);" aria-hidden="true"></div>
            <div class="absolute -bottom-6 -left-6 w-36 h-36 rounded-full blur-3xl -z-10" style="background-color:rgba(63,62,111,0.1);" aria-hidden="true"></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     WHAT WE BUILD — TECHNOLOGY FOCUS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 bg-gray-50 dark:bg-[#1e1e26]" aria-labelledby="tech-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-12" data-animate>
            <p class="text-sm font-bold uppercase tracking-widest mb-3" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('about_tech_badge', false, 'What We Build')); ?>
            </p>
            <h2 id="tech-heading" class="text-3xl md:text-4xl font-bold text-[#131316] dark:text-white mb-4">
                <?php echo esc_html(mi_field('about_tech_heading', false, 'A Computational Treatment Platform')); ?>
            </h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="space-y-5 text-gray-600 dark:text-gray-400 leading-relaxed" data-animate>
                <p><?php echo esc_html(mi_field('about_tech_para1', false, 'We focus on one challenge: engineering neuromuscular rehabilitation to be intelligent, precise, and dynamically responsive to each patient\'s neural state. Traditional electrical stimulation delivers fixed output patterns. Conventional therapy depends on repetition without quantified neural intent. We designed a closed-loop system that measures, interprets, and responds.')); ?></p>
                <p><?php echo esc_html(mi_field('about_tech_para2', false, 'By integrating real-time Electromyography (EMG) biofeedback, Functional Electrical Stimulation (FES), Neuromuscular Electrical Stimulation (NMES), artificial intelligence (AI), and augmented reality (AR), we created an adaptive neuromodulation framework that detects voluntary motor signals, decodes intent, and modulates stimulation parameters instantly. Therapy becomes computationally driven, physiologically aligned, and continuously optimized around neuroplastic response.')); ?></p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" data-animate>
                <?php
                $tech_raw = get_post_meta(get_the_ID(), 'about_technologies_json', true);
                $technologies = ($tech_raw) ? json_decode($tech_raw, true) : null;
                if (!$technologies) $technologies = function_exists('get_field') ? get_field('about_technologies') : null;
                if (!$technologies) {
                    $technologies = [
                        ['icon' => 'biotech',        'label' => 'Real-time EMG'],
                        ['icon' => 'electric_bolt',  'label' => 'FES / NMES'],
                        ['icon' => 'psychology',     'label' => 'Artificial Intelligence'],
                        ['icon' => 'view_in_ar',     'label' => 'Augmented Reality'],
                        ['icon' => 'favorite',       'label' => 'BioRhythmIQ'],
                        ['icon' => 'loop',           'label' => 'Closed-Loop Control'],
                    ];
                }
                foreach ($technologies as $i => $tech): ?>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col items-center text-center gap-3 hover:shadow-lg transition-shadow"
                     data-animate style="transition-delay:<?php echo $i*60; ?>ms">
                    <span class="material-symbols-outlined text-3xl" style="color:#2D9DA8;" aria-hidden="true"><?php echo esc_html($tech['icon']); ?></span>
                    <span class="text-sm font-bold text-[#3f3e6f] dark:text-white"><?php echo esc_html($tech['label']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     OUR JOURNEY — TIMELINE
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 bg-white dark:bg-[#16161c]" aria-labelledby="journey-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-16">
            <h2 id="journey-heading" class="text-3xl md:text-4xl font-bold text-[#131316] dark:text-white mb-4">
                <?php echo esc_html(mi_field('about_journey_heading', false, 'Our Journey')); ?>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                <?php echo esc_html(mi_field('about_journey_sub', false, 'From a research startup to a global medical technology team.')); ?>
            </p>
        </div>

        <?php
        $milestones_raw = get_post_meta(get_the_ID(), 'about_milestones_json', true);
        $milestones = ($milestones_raw) ? json_decode($milestones_raw, true) : null;
        if (!$milestones) $milestones = function_exists('get_field') ? get_field('about_milestones') : null;
        if (!$milestones) {
            $milestones = [
                ['year'=>'2018','label'=>'Planning',         'description'=>'Initial research phase focused on neuromuscular motion data.'],
                ['year'=>'2021','label'=>'AI Breakthrough',  'description'=>'Integration of proprietary machine learning algorithms.'],
                ['year'=>'2023','label'=>'Global Expansion', 'description'=>'Growing clinical investment across three continents.'],
                ['year'=>'2025','label'=>'The Future',       'description'=>'Next-gen wearable diagnostic platforms worldwide.'],
            ];
        }
        ?>

        <!-- Timeline: desktop horizontal, mobile vertical -->
        <div class="relative" role="list" aria-label="<?php echo esc_attr(mi_field('about_timeline_aria', false, 'Company Timeline')); ?>">
            <!-- Horizontal connector line (desktop) -->
            <div class="hidden lg:block absolute top-10 left-[10%] right-[10%] h-0.5 z-0" style="background-color:rgba(63,62,111,0.2);" aria-hidden="true"></div>

            <ol class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-4 relative z-10 list-none">
                <?php foreach ($milestones as $i => $milestone) : ?>
                <li class="flex flex-col items-center text-center" role="listitem">
                    <div class="size-20 rounded-full flex items-center justify-center text-white font-black text-sm mb-4 shadow-lg ring-4 ring-white dark:ring-[#16161c]" style="background-color:#3f3e6f;">
                        <?php echo esc_html($milestone['year'] ?? ''); ?>
                    </div>
                    <h3 class="font-bold text-lg text-[#131316] dark:text-white mb-2"><?php echo esc_html($milestone['label'] ?? ''); ?></h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-xs"><?php echo esc_html($milestone['description'] ?? ''); ?></p>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     OUR VISION — FULL WIDTH
═══════════════════════════════════════════════════════════════════════════ -->
<section class="relative py-40 overflow-hidden flex items-center justify-center text-center px-6"
         aria-labelledby="vision-heading">
    <?php $vision_bg = mi_field('about_vision_bg'); ?>
    <div class="absolute inset-0"
         style="<?php echo $vision_bg ? 'background-image: linear-gradient(rgba(63,62,111,0.85),rgba(19,19,22,0.9)), url(' . esc_url($vision_bg) . '); background-size: cover; background-position: center;' : 'background: linear-gradient(135deg, #3f3e6f 0%, #16161c 100%);'; ?>"
         aria-hidden="true">
    </div>
    <div class="relative z-10 max-w-4xl">
        <h2 id="vision-heading" class="text-4xl md:text-6xl font-black text-white mb-8 leading-tight">
            <?php echo esc_html(mi_field('about_vision_heading', false, 'Our Vision')); ?>
        </h2>
        <p class="text-white/80 text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
            <?php echo esc_html(mi_field('about_vision_text', false, 'We are building a computational treatment platform that fuses real-time electrophysiology, adaptive stimulation, and spatial computing into a unified architecture for movement recovery.')); ?>
        </p>
        <a href="<?php echo esc_url(mi_field('about_vision_url', false, '#')); ?>"
           class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/30 text-white font-bold rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all">
            <?php echo esc_html(mi_field('about_vision_btn', false, 'Explore Our AI Mission')); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
        </a>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     MISSION PILLARS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-[#16161c]" aria-labelledby="pillars-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-16">
            <h2 id="pillars-heading" class="text-3xl md:text-4xl font-bold text-[#131316] dark:text-white mb-4">
                <?php echo esc_html(mi_field('about_pillars_heading', false, 'Mission Pillars')); ?>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                <?php echo esc_html(mi_field('about_pillars_desc', false, 'The core values that guide our approach to redefining medical technology and patient outcomes.')); ?>
            </p>
        </div>

        <?php
        $pillars_raw = get_post_meta(get_the_ID(), 'about_pillars_json', true);
        $pillars = ($pillars_raw) ? json_decode($pillars_raw, true) : null;
        if (!$pillars) $pillars = function_exists('get_field') ? get_field('about_pillars') : null;
        if (!$pillars) {
            $pillars = [
                ['icon'=>'diversity_3',   'title'=>'Health Equity',           'description'=>'We expand access to advanced neuromuscular rehabilitation by enabling scalable deployment across hospitals, clinics, and underserved regions. Intelligent systems should not be limited by geography.'],
                ['icon'=>'groups',        'title'=>'Empowering Communities',  'description'=>'We help patients regain independence and functional confidence while reducing caregiver burden. Technology should restore movement, dignity, and participation in daily life.'],
                ['icon'=>'science',       'title'=>'Innovating with Technology','description'=>'We integrate AI, AR, real-time EMG analytics, and adaptive neuromodulation into a coherent therapeutic platform. Innovation means measurable improvement in motor recovery, not novelty.'],
                ['icon'=>'eco',           'title'=>'Sustainability',           'description'=>'We develop rehabilitation technologies that reduce waste, optimize resource use, and support long-term, responsible healthcare delivery. Efficiency and durability are built into every system.'],
                ['icon'=>'handshake',     'title'=>'Collaborative Progress',  'description'=>'We work closely with clinicians, therapists, distributors, and healthcare partners to ensure our systems deliver clinical value, operational practicality, and measurable outcomes.'],
            ];
        }
        ?>

        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 list-none" role="list">
            <?php foreach ($pillars as $pillar) : ?>
            <li class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 group">
                <div class="size-12 rounded-xl flex items-center justify-center mb-6 transition-colors" style="background-color:rgba(63,62,111,0.1);color:#3f3e6f;" aria-hidden="true">
                    <span class="material-symbols-outlined text-2xl"><?php echo esc_html($pillar['icon'] ?? 'star'); ?></span>
                </div>
                <h3 class="font-bold text-xl text-[#131316] dark:text-white mb-3"><?php echo esc_html($pillar['title'] ?? ''); ?></h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"><?php echo esc_html($pillar['description'] ?? ''); ?></p>
            </li>
            <?php endforeach; ?>

            <!-- CTA Pillar Card -->
            <li class="p-8 rounded-2xl text-white flex flex-col justify-between" style="background-color:#3f3e6f;">
                <div>
                    <div class="size-12 rounded-xl bg-white/20 flex items-center justify-center mb-6" aria-hidden="true">
                        <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                    </div>
                    <h3 class="font-bold text-xl mb-3"><?php echo esc_html(mi_field('about_cta_heading', false, 'Join Our Mission')); ?></h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6"><?php echo esc_html(mi_field('about_cta_text', false, 'Be part of the future of neuromuscular health.')); ?></p>
                </div>
                <a href="<?php echo esc_url(mi_field('about_cta_url', false, '#')); ?>"
                   class="flex items-center gap-2 font-bold text-white hover:gap-4 transition-all">
                    <?php echo esc_html(mi_field('about_cta_btn', false, 'Get Started')); ?>
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                </a>
            </li>
        </ul>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     OUR MISSION STATEMENT
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gray-50 dark:bg-[#1e1e26]" aria-labelledby="mission-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="max-w-4xl mx-auto text-center" data-animate>
            <p class="text-sm font-bold uppercase tracking-widest mb-4" style="color:#2D9DA8;">
                <?php echo esc_html(mi_field('about_mission_eyebrow', false, 'Our Mission')); ?>
            </p>
            <h2 id="mission-heading" class="text-3xl md:text-4xl font-bold text-[#131316] dark:text-white mb-8 leading-tight">
                <?php echo esc_html(mi_field('about_mission_heading', false, 'Transforming Rehabilitation')); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed mb-16">
                <?php echo esc_html(mi_field('about_mission_text', false, 'Motion Informatics builds intelligent neuromuscular rehabilitation platforms that decode human motor intent and translate it into precise, adaptive stimulation in real time. We exist to transform rehabilitation from repetitive protocol-based intervention into responsive, data-driven neuroplastic recovery.')); ?>
            </p>
        </div>

        <!-- Culture -->
        <div class="max-w-4xl mx-auto">
            <h3 class="text-2xl font-bold text-[#131316] dark:text-white mb-8 text-center">
                <?php echo esc_html(mi_field('about_culture_heading', false, 'Our Culture')); ?>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <?php
                $culture_raw = get_post_meta(get_the_ID(), 'about_culture_json', true);
                $culture = ($culture_raw) ? json_decode($culture_raw, true) : null;
                if (!$culture) $culture = function_exists('get_field') ? get_field('about_culture') : null;
                if (!$culture) {
                    $culture = [
                        ['icon'=>'diversity_2', 'title'=>'Gender Equality',   'description'=>'We are committed to equal opportunity, inclusive leadership, and professional growth across our organization.'],
                        ['icon'=>'balance',     'title'=>'Work-Life Balance',  'description'=>'We foster a work environment that supports high performance, intellectual rigor, and respect for personal wellbeing.'],
                    ];
                }
                foreach ($culture as $item): ?>
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 flex gap-5 items-start" data-animate>
                    <div class="size-12 rounded-xl flex-shrink-0 flex items-center justify-center" style="background-color:rgba(45,157,168,0.1);color:#2D9DA8;" aria-hidden="true">
                        <span class="material-symbols-outlined text-2xl"><?php echo esc_html($item['icon'] ?? 'star'); ?></span>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg text-[#131316] dark:text-white mb-2"><?php echo esc_html($item['title'] ?? ''); ?></h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"><?php echo esc_html($item['description'] ?? ''); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

</main>

<?php get_footer();
