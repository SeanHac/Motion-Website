<?php
/**
 * Template Name: Global Distributors Network
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-20">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="relative h-[450px] w-full flex items-center justify-center overflow-hidden"
         style="background-color:#3f3e6f;"
         aria-labelledby="dist-heading">
    <?php $hero_bg = mi_field('dist_hero_bg'); ?>
    <?php if ($hero_bg) : ?>
    <div class="absolute inset-0 opacity-20 bg-cover bg-center mix-blend-overlay"
         style="background-image: url(<?php echo esc_url($hero_bg); ?>);"
         aria-hidden="true"></div>
    <?php else : ?>
    <div class="absolute inset-0 opacity-20 bg-cover bg-center mix-blend-overlay"
         style="background-image: url(<?php echo get_template_directory_uri() . '/assets/images/dist-hero-bg.jpg'; ?>);"
         aria-hidden="true"></div>
    <?php endif; ?>
    <div class="relative z-10 max-w-4xl px-6 text-center">
        <h1 id="dist-heading" class="text-white text-5xl md:text-6xl font-black tracking-tight mb-6">
            <?php echo esc_html(mi_field('dist_hero_heading', false, 'Shape the Future of Neuromuscular Solutions')); ?>
        </h1>
        <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto mb-8 font-light leading-relaxed">
            <?php echo esc_html(mi_field('dist_hero_desc', false, 'Partner with Motion Informatics to deliver world-class medical technology to patients and clinics across the globe.')); ?>
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="<?php echo esc_url(mi_field('dist_hero_btn1_url', false, '#')); ?>"
               class="bg-white px-8 py-4 rounded-xl font-bold transition-all"
               style="color:#3f3e6f;">
                <?php echo esc_html(mi_field('dist_hero_btn1_text', false, 'Explore the Network')); ?>
            </a>
            <a href="<?php echo esc_url(mi_field('dist_hero_btn2_url', false, '#')); ?>"
               class="border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold backdrop-blur-sm hover:bg-white/10 transition-all">
                <?php echo esc_html(mi_field('dist_hero_btn2_text', false, 'Download Prospectus')); ?>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     INTERACTIVE MAP SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 py-20" aria-labelledby="map-heading">
    <div class="flex flex-col items-center mb-12 text-center">
        <h2 id="map-heading" class="text-3xl font-bold mb-4 text-[#131316] dark:text-white">
            <?php echo esc_html(mi_field('dist_map_heading', false, 'Global Reach, Local Impact')); ?>
        </h2>
        <p class="text-gray-500 dark:text-gray-400 max-w-2xl">
            <?php echo esc_html(mi_field('dist_map_desc', false, 'We are currently active in major medical hubs across four continents. Hover a region to view local distribution hubs.')); ?>
        </p>
    </div>

    <div class="relative bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-gray-800">
        <?php $dist_map_img = mi_field('dist_map_image'); ?>
        <?php if ($dist_map_img) : ?>
        <img src="<?php echo esc_url($dist_map_img); ?>"
             alt="<?php echo esc_attr(mi_field('dist_map_alt', false, 'World map showing distributor locations')); ?>"
             class="w-full h-auto rounded-2xl"
             loading="lazy">
        <?php else : ?>
        <img src="<?php echo get_template_directory_uri() . '/assets/images/dist-world-map.jpg'; ?>"
             alt="<?php echo esc_attr(mi_field('dist_map_alt', false, 'World map showing distributor locations')); ?>"
             class="w-full h-auto rounded-2xl"
             loading="lazy">
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     FORM + BENEFITS
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

        <!-- Find a Distributor Form (matches Contact form structure) -->
        <div class="bg-white dark:bg-slate-900 p-8 md:p-10 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="text-2xl font-bold mb-2 text-[#131316] dark:text-white"><?php echo esc_html(mi_field('dist_form_heading', false, 'Find a Distributor')); ?></h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8"><?php echo esc_html(mi_field('dist_form_desc', false, 'Connect with a local expert to explore our solutions.')); ?></p>

            <?php
            $inp  = 'w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:border-transparent outline-none transition-all dark:text-white';
            $lbl  = 'text-sm font-semibold text-slate-700 dark:text-slate-300';
            $star = ' <span aria-hidden="true" class="text-red-500">*</span>';
            $consent_dist = mi_field('contact_consent_pro', false, 'I agree that Motion Informatics may contact me regarding partnership and commercial opportunities.');
            $phone_prefixes = [
                '+972'=>'🇮🇱 +972','+ 1'=>'🇺🇸 +1','+44'=>'🇬🇧 +44','+49'=>'🇩🇪 +49',
                '+33'=>'🇫🇷 +33','+39'=>'🇮🇹 +39','+34'=>'🇪🇸 +34','+31'=>'🇳🇱 +31',
                '+41'=>'🇨🇭 +41','+43'=>'🇦🇹 +43','+32'=>'🇧🇪 +32','+46'=>'🇸🇪 +46',
                '+47'=>'🇳🇴 +47','+45'=>'🇩🇰 +45','+358'=>'🇫🇮 +358','+48'=>'🇵🇱 +48',
                '+351'=>'🇵🇹 +351','+420'=>'🇨🇿 +420','+36'=>'🇭🇺 +36','+40'=>'🇷🇴 +40',
                '+90'=>'🇹🇷 +90','+7'=>'🇷🇺 +7','+971'=>'🇦🇪 +971','+966'=>'🇸🇦 +966',
                '+61'=>'🇦🇺 +61','+64'=>'🇳🇿 +64','+81'=>'🇯🇵 +81','+82'=>'🇰🇷 +82',
                '+86'=>'🇨🇳 +86','+91'=>'🇮🇳 +91','+55'=>'🇧🇷 +55','+52'=>'🇲🇽 +52',
                '+27'=>'🇿🇦 +27',
            ];
            ?>

            <form id="mi-distributor-form" class="space-y-6" novalidate aria-label="<?php _e('Find a distributor form', 'motion-informatics'); ?>">
                <?php wp_nonce_field('mi_form_nonce', '_wpnonce_dist'); ?>
                <input type="hidden" name="source_page" value="<?php echo esc_url(get_permalink()); ?>">
                <input type="hidden" name="user_type" value="distributor">

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="dist_first" class="<?php echo $lbl; ?>"><?php _e('First Name', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <input id="dist_first" name="first_name" type="text" class="<?php echo $inp; ?>"
                               placeholder="John" required autocomplete="given-name" aria-required="true">
                    </div>
                    <div class="space-y-2">
                        <label for="dist_last" class="<?php echo $lbl; ?>"><?php _e('Last Name', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <input id="dist_last" name="last_name" type="text" class="<?php echo $inp; ?>"
                               placeholder="Doe" required autocomplete="family-name" aria-required="true">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="dist_email" class="<?php echo $lbl; ?>"><?php _e('Email Address', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <input id="dist_email" name="email" type="email" class="<?php echo $inp; ?>"
                           placeholder="john.doe@example.com" required autocomplete="email" aria-required="true">
                </div>

                <div class="space-y-2">
                    <label for="dist_phone" class="<?php echo $lbl; ?>"><?php _e('Phone Number', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <div class="flex border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden bg-slate-50 dark:bg-slate-800 focus-within:ring-2" style="--tw-ring-color:#3f3e6f;">
                        <select name="phone_prefix" autocomplete="tel-country-code"
                                class="bg-slate-100 dark:bg-slate-700 border-r border-slate-200 dark:border-slate-600 px-3 py-3 text-sm outline-none dark:text-white flex-shrink-0">
                            <?php foreach ($phone_prefixes as $code => $display):
                                $selected = ($code === '+972') ? 'selected' : ''; ?>
                            <option value="<?php echo esc_attr($code); ?>" <?php echo $selected; ?>><?php echo esc_html($display); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input id="dist_phone" name="phone" type="tel"
                               class="flex-1 bg-transparent px-4 py-3 text-sm outline-none dark:text-white min-w-0"
                               placeholder="50 000 0000" required autocomplete="tel-national" aria-required="true">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="dist_company" class="<?php echo $lbl; ?>"><?php _e('Company / Organization', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <input id="dist_company" name="company" type="text" class="<?php echo $inp; ?>"
                           placeholder="Medical Solutions Ltd." autocomplete="organization" required aria-required="true">
                </div>

                <div class="space-y-2">
                    <label for="dist_company_url" class="<?php echo $lbl; ?>"><?php _e('Company Website or LinkedIn URL', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <input id="dist_company_url" name="company_url" type="url" class="<?php echo $inp; ?>"
                           placeholder="https://company.com or https://linkedin.com/company/..." required aria-required="true">
                </div>

                <div class="space-y-2">
                    <label for="dist_role" class="<?php echo $lbl; ?>"><?php _e('Your Role / Position', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <input id="dist_role" name="role" type="text" class="<?php echo $inp; ?>"
                           placeholder="Clinical Director" required aria-required="true">
                </div>

                <div class="space-y-2">
                    <label for="dist_message" class="<?php echo $lbl; ?>"><?php _e('Why are you contacting us?', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <textarea id="dist_message" name="message" rows="4"
                              class="<?php echo $inp; ?> resize-none"
                              placeholder="<?php _e('Please describe your inquiry or partnership interest...', 'motion-informatics'); ?>"
                              required aria-required="true"></textarea>
                </div>

                <div class="flex items-start gap-3">
                    <input type="checkbox" id="dist_consent" name="consent" value="1" required
                           class="mt-1 rounded border-slate-300 flex-shrink-0" style="accent-color:#3f3e6f;">
                    <label for="dist_consent" class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed cursor-pointer">
                        <?php echo esc_html($consent_dist); ?> <span class="text-red-500">*</span>
                    </label>
                </div>

                <div id="dist-form-status" class="hidden rounded-lg px-4 py-3 text-sm font-medium" role="alert" aria-live="polite"></div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full text-white py-4 rounded-lg font-bold text-lg transition-all flex items-center justify-center gap-2"
                            style="background-color:#3f3e6f;">
                        <?php echo esc_html(mi_field('dist_btn_submit', false, 'Request Local Info')); ?>
                        <span class="material-symbols-outlined" aria-hidden="true">send</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Partnership Benefits -->
        <div class="flex flex-col justify-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-bold mb-6 w-fit" style="background-color:rgba(63,62,111,0.1);color:#3f3e6f;">
                <span class="material-symbols-outlined text-sm" aria-hidden="true">handshake</span>
                <?php echo esc_html(mi_field('dist_partner_badge', false, 'Partner Program')); ?>
            </div>
            <h2 class="text-3xl font-bold mb-6 text-[#131316] dark:text-white">
                <?php echo esc_html(mi_field('dist_become_heading', false, 'Become a Distributor')); ?>
            </h2>
            <p class="text-lg text-gray-500 dark:text-gray-400 mb-10">
                <?php echo esc_html(mi_field('dist_become_desc', false, 'Join our growing network of elite medical technology providers and lead the transformation of neuromuscular care in your region.')); ?>
            </p>

            <?php
            $benefits_raw = get_post_meta(get_the_ID(), 'dist_benefits_json', true);
            $benefits     = ($benefits_raw) ? json_decode($benefits_raw, true) : null;
            if (!$benefits) $benefits = function_exists('get_field') ? get_field('dist_benefits') : null;
            if (!$benefits) {
                $benefits = [
                    ['icon'=>'workspace_premium', 'title'=>'Exclusive Territory Rights',    'desc'=>'Secure exclusive distribution rights in your region with guaranteed market protection and defined territory boundaries.'],
                    ['icon'=>'school',            'title'=>'Comprehensive Clinical Training','desc'=>'Access to our world-class training programs, clinical certification courses, and ongoing education for your sales and clinical teams.'],
                    ['icon'=>'support_agent',     'title'=>'Dedicated Partner Support',     'desc'=>'A dedicated partner success manager, technical support line, and marketing co-investment program to accelerate your growth.'],
                    ['icon'=>'trending_up',       'title'=>'Industry-Leading Margins',      'desc'=>'Competitive distributor pricing with volume incentives, milestone bonuses, and a performance-based rebate structure.'],
                ];
            }
            ?>

            <ul class="space-y-8 list-none" role="list">
                <?php foreach ($benefits as $benefit) : ?>
                <li class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 flex items-center justify-center" style="color:#3f3e6f;" aria-hidden="true">
                        <span class="material-symbols-outlined"><?php echo esc_html($benefit['icon'] ?? 'star'); ?></span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1 text-[#131316] dark:text-white"><?php echo esc_html($benefit['title'] ?? ''); ?></h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"><?php echo esc_html($benefit['desc'] ?? ''); ?></p>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

</main>

<?php get_footer();
