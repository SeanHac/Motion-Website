<?php
/**
 * Homepage Template — matches code.html mockup exactly.
 * Uses inline style hex values for buttons/badges so colours always render
 * regardless of Tailwind config load timing.
 */
get_header(); ?>

<main id="main-content" class="pt-20">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════════════════════ -->
<section class="relative w-full h-[640px] overflow-hidden"
         aria-label="<?php _e('Hero', 'motion-informatics'); ?>">

    <?php
    $hero_bg     = mi_field('home_hero_bg');
    $hero_bg_url = $hero_bg ?: get_template_directory_uri() . '/assets/images/home-hero-bg.jpg';
    ?>

    <div class="absolute inset-0 bg-cover bg-center hero-parallax"
         style="background-image: linear-gradient(rgba(19,19,22,0.70) 0%, rgba(19,19,22,0.30) 100%), url(<?php echo esc_url($hero_bg_url); ?>);"
         role="img"
         aria-label="<?php _e('Clinical environment background', 'motion-informatics'); ?>">
    </div>

    <div class="relative h-full max-w-7xl mx-auto px-6 lg:px-20 flex flex-col justify-center items-start gap-8">
        <div class="max-w-3xl space-y-4">

            <span class="hero-anim-1 inline-block px-3 py-1 text-[#2D9DA8] text-xs font-bold uppercase tracking-widest rounded-full border border-[#2D9DA8]/30"
                  style="background-color:rgba(45,157,168,0.2)">
                <?php echo esc_html(mi_field('home_hero_badge', false, 'Leading Neuromuscular Care')); ?>
            </span>

            <h1 class="hero-anim-2 text-white text-5xl md:text-7xl font-black leading-tight tracking-tight">
                <?php echo esc_html(mi_field('home_hero_heading1', false, 'We Are')); ?><br>
                <span class="text-[#2D9DA8]"><?php echo esc_html(mi_field('home_hero_heading2', false, 'Motion Informatics')); ?></span>
            </h1>

            <p class="hero-anim-3 text-gray-200 text-lg md:text-xl font-medium max-w-xl">
                <?php echo esc_html(mi_field('home_hero_desc', false, 'Building intelligent neuromuscular rehabilitation platforms that decode human motor intent and translate it into precise, adaptive stimulation in real time.')); ?>
            </p>
        </div>

        <div class="hero-anim-4 flex flex-wrap gap-4">
            <?php
            $btn1_text = mi_field('home_hero_btn1_text', false, 'View Products');
            $btn1_url  = mi_field('home_hero_btn1_url',  false, '#');
            $btn2_text = mi_field('home_hero_btn2_text', false, 'Learn More');
            $btn2_url  = mi_field('home_hero_btn2_url',  false, '#');
            ?>
            <a href="<?php echo esc_url($btn1_url); ?>"
               class="mi-hero-primary-btn flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-14 px-8 text-white text-base font-bold hover:-translate-y-1 transition-transform"
               style="background-color:#3f3e6f;box-shadow:0 20px 40px -12px rgba(63,62,111,0.5)">
                <?php echo esc_html($btn1_text); ?>
            </a>
            <a href="<?php echo esc_url($btn2_url); ?>"
               class="flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-14 px-8 text-white text-base font-bold hover:-translate-y-1 transition-transform"
               style="background-color:#CC7722;box-shadow:0 20px 40px -12px rgba(204,119,34,0.4)">
                <?php echo esc_html($btn2_text); ?>
            </a>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     CLINICAL ABILITIES
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 lg:px-20 py-20"
         aria-labelledby="capabilities-heading">

    <div class="mb-12" data-animate>
        <h3 class="text-[#2D9DA8] font-bold uppercase tracking-widest text-sm mb-2">
            <?php echo esc_html(mi_field('home_cap_badge', false, 'Our Capabilities')); ?>
        </h3>
        <h2 id="capabilities-heading" class="text-3xl md:text-4xl font-bold text-[#131316] dark:text-white mb-3">
            <?php echo esc_html(mi_field('home_cap_heading', false, 'Clinical Abilities')); ?>
        </h2>
        <p class="text-gray-500 dark:text-gray-400 max-w-2xl text-base">
            <?php echo esc_html(mi_field('home_cap_desc', false, 'Advanced neuromuscular solutions designed for diverse clinical needs and rehabilitation paths.')); ?>
        </p>
    </div>

    <?php
    $capabilities_raw = get_post_meta(get_the_ID(), 'home_capabilities_json', true);
    $capabilities = ($capabilities_raw) ? json_decode($capabilities_raw, true) : null;
    if (!$capabilities) $capabilities = function_exists('get_field') ? get_field('home_capabilities') : null;
    if (!$capabilities) {
        $capabilities = [
            ['icon'=>'bolt',              'title'=>'Muscle Spasm',        'desc'=>'Advanced neuromuscular relief for persistent tension.'],
            ['icon'=>'health_and_safety', 'title'=>'Atrophy',             'desc'=>'Preventing degradation through active stimulation.'],
            ['icon'=>'flex_direction',    'title'=>'Range of Motion',     'desc'=>'Enhancing flexibility with precision movement patterns.'],
            ['icon'=>'psychology',        'title'=>'Muscle Re-education', 'desc'=>'Restoring motor control through targeted feedback.'],
            ['icon'=>'rebase_edit',       'title'=>'Blood Circulation',   'desc'=>'Support for circulatory health and vascular efficiency.'],
        ];
        $use_acf = false;
    } else {
        $use_acf = true;
    }
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <?php foreach ($capabilities as $i => $cap) :
            $icon  = $use_acf ? ($cap['icon']  ?? 'star') : $cap['icon'];
            $title = $use_acf ? ($cap['title'] ?? '')     : $cap['title'];
            $desc  = $use_acf ? ($cap['desc']  ?? '')     : $cap['desc'];
        ?>
        <div class="group bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
             data-animate style="transition-delay:<?php echo $i*80; ?>ms">
            <div class="size-12 rounded-lg flex items-center justify-center mb-6 cap-icon-wrap"
                 style="background-color:rgba(63,62,111,0.1);color:#3f3e6f"
                 aria-hidden="true">
                <span class="material-symbols-outlined text-3xl"><?php echo esc_html($icon); ?></span>
            </div>
            <h4 class="text-lg font-bold mb-2 dark:text-white text-[#131316]"><?php echo esc_html($title); ?></h4>
            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"><?php echo esc_html($desc); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     PRODUCTS OVERVIEW
═══════════════════════════════════════════════════════════════════════════ -->
<section class="bg-gray-50 dark:bg-[#1e1e26] py-24" aria-labelledby="products-heading">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">

        <div class="text-center mb-16" data-animate>
            <h2 id="products-heading" class="text-4xl font-bold text-[#131316] dark:text-white mb-4">
                <?php echo esc_html(mi_field('home_prod_heading', false, 'Precision Technology Overview')); ?>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                <?php echo esc_html(mi_field('home_prod_desc', false, 'Explore our flagship medical solutions designed for clinics and hospitals worldwide.')); ?>
            </p>
        </div>

        <?php
        $products_raw = get_post_meta(get_the_ID(), 'home_products_json', true);
        $products = ($products_raw) ? json_decode($products_raw, true) : null;
        if ($products) {
            // Metabox stores "features" as a textarea (one per line); convert to array for the loop below.
            foreach ($products as &$_p) {
                if (isset($_p['features']) && is_string($_p['features'])) {
                    $_p['features'] = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $_p['features']))));
                }
            }
            unset($_p);
        }
        if (!$products) $products = function_exists('get_field') ? get_field('home_products') : null;
        if (!$products) {
            $stimel_page  = get_page_by_path('stimel-03');
            $spatial_page = get_page_by_path('spatial-stimelmd');
            $products = [
                [
                    'image'       => get_template_directory_uri() . '/assets/images/stimel3-device-1.png',
                    'badge'       => 'FDA Cleared',
                    'badge_color' => 'primary',
                    'name'        => 'STIMEL-03®',
                    'description' => 'A clinically validated neuromuscular stimulation system built on BioRhythmIQ technology and real-time EMG biofeedback. Detects voluntary motor signals, triggers adaptive FES and NMES, and reinforces correct activation patterns through closed-loop feedback.',
                    'features'    => [['feature'=>'Real-time EMG Biofeedback'],['feature'=>'Intent-Triggered FES/NMES'],['feature'=>'BioRhythmIQ Adaptive Technology']],
                    'button_text' => 'Product Details',
                    'button_url'  => $stimel_page ? get_permalink($stimel_page) : '#',
                ],
                [
                    'image'       => get_template_directory_uri() . '/assets/images/ssmd-img-5.jpg',
                    'badge'       => 'Next Generation',
                    'badge_color' => 'accent-teal',
                    'name'        => 'Spatial StimelMD®',
                    'description' => 'Integrates AI, augmented reality (AR), EMG-driven biofeedback, FES, and NMES into a unified rehabilitation platform. Analyzes intent in real time, dynamically personalizes stimulation, and immerses patients in spatial therapy environments designed to accelerate neuroplastic adaptation.',
                    'features'    => [['feature'=>'AR-Integrated Functional Rehabilitation'],['feature'=>'AI-Personalized Adaptive Therapy'],['feature'=>'Closed-Loop Biofeedback Precision']],
                    'button_text' => 'Product Details',
                    'button_url'  => $spatial_page ? get_permalink($spatial_page) : '#',
                ],
            ];
        }
        ?>

        <?php
        $img_fallbacks = [
            get_template_directory_uri() . '/assets/images/stimel3-device-1.png',
            get_template_directory_uri() . '/assets/images/ssmd-img-5.jpg',
        ];
        $img_overrides = [
            function_exists('get_field') ? (get_field('home_prod_img_1') ?: '') : '',
            function_exists('get_field') ? (get_field('home_prod_img_2') ?: '') : '',
        ];
        ?>
        <div class="flex flex-col md:flex-row gap-10">
            <?php foreach ($products as $i => $product) :
                $badge_bg     = ($product['badge_color'] ?? '') === 'accent-teal' ? '#2D9DA8' : '#3f3e6f';
                $img_url      = ($img_overrides[$i] ?? '') ?: ($product['image'] ?? '') ?: ($img_fallbacks[$i] ?? '');
                $features     = $product['features'] ?? [];
                $img_fallback = esc_js($img_fallbacks[$i] ?? $img_fallbacks[0]);
            ?>
            <div class="flex-1 min-w-0 bg-white dark:bg-gray-800 rounded-2xl overflow-hidden flex flex-col shadow-lg border border-gray-100 dark:border-gray-700 group hover:-translate-y-1 hover:shadow-2xl transition-all duration-300"
                 data-animate style="transition-delay:<?php echo $i*120; ?>ms">

                <div class="h-64 overflow-hidden relative">
                    <?php if ($img_url) : ?>
                        <img src="<?php echo esc_url($img_url); ?>"
                             alt="<?php echo esc_attr($product['name'] ?? ''); ?>"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.onerror=null;this.src='<?php echo $img_fallback; ?>'"
                             loading="lazy">
                    <?php else : ?>
                        <div class="absolute inset-0"
                             style="background:linear-gradient(135deg,rgba(63,62,111,0.2),rgba(45,157,168,0.2))"></div>
                    <?php endif; ?>
                    <div class="absolute top-4 left-4">
                        <span class="text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest"
                              style="background-color:<?php echo esc_attr($badge_bg); ?>">
                            <?php echo esc_html($product['badge'] ?? ''); ?>
                        </span>
                    </div>
                </div>

                <div class="p-8 flex flex-col flex-1">
                    <h3 class="text-2xl font-bold mb-3 dark:text-white text-[#131316]"><?php echo esc_html($product['name'] ?? ''); ?></h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 leading-relaxed"><?php echo esc_html($product['description'] ?? ''); ?></p>
                    <?php if ($features) : ?>
                    <ul class="space-y-3 mb-8 flex-1" role="list">
                        <?php foreach ($features as $feat) : ?>
                        <li class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <span class="material-symbols-outlined text-lg" style="color:#2D9DA8" aria-hidden="true">check_circle</span>
                            <?php echo esc_html($feat['feature'] ?? (is_string($feat) ? $feat : '')); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($product['button_url'] ?? '#'); ?>"
                       class="mi-outline-btn w-full py-4 text-center font-bold rounded-lg block">
                        <?php echo esc_html($product['button_text'] ?? 'Product Details'); ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 lg:px-20 py-24">
    <div class="mi-home-cta-box rounded-3xl p-10 md:p-20 text-center text-white relative overflow-hidden"
         style="background-color:#3f3e6f"
         data-animate>
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 pointer-events-none"
             style="transform:skewX(12deg) translateX(50%)"
             aria-hidden="true"></div>
        <div class="relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">
                <?php echo esc_html(mi_field('home_cta_heading', false, 'Ready to transform patient care?')); ?>
            </h2>
            <p class="text-lg mb-10 max-w-xl mx-auto" style="color:rgba(255,255,255,0.8)">
                <?php echo esc_html(mi_field('home_cta_desc', false, 'Contact our clinical specialists for a personalized demonstration of our neuromuscular solutions.')); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url(mi_field('home_cta_btn1_url', false, '#')); ?>"
                   class="font-bold px-10 py-4 rounded-lg transition-colors"
                   style="background-color:#ffffff;color:#3f3e6f">
                    <?php echo esc_html(mi_field('home_cta_btn1_text', false, 'Request a Demo')); ?>
                </a>
                <a href="<?php echo esc_url(mi_field('home_cta_btn2_url', false, '#')); ?>"
                   class="mi-btn-ochre font-bold px-10 py-4 rounded-lg text-white transition-all">
                    <?php echo esc_html(mi_field('home_cta_btn2_text', false, 'Speak to Sales')); ?>
                </a>
            </div>
        </div>
    </div>
</section>

</main>

<?php get_footer(); ?>
