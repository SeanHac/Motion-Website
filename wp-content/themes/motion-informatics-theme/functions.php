<?php
/**
 * Motion Informatics Theme Functions
 */

defined('ABSPATH') || exit;

// ─── THEME SETUP ────────────────────────────────────────────────────────────

function mi_theme_setup() {
    load_theme_textdomain('motion-informatics', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 260,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('wc-product-gallery-zoom');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'motion-informatics'),
        'footer'  => __('Footer Navigation', 'motion-informatics'),
    ]);
}
add_action('after_setup_theme', 'mi_theme_setup');

// ─── FAVICON ─────────────────────────────────────────────────────────────────

remove_action('wp_head', 'wp_site_icon');

function mi_favicon() {
    $uri = get_template_directory_uri() . '/assets/images';
    $v   = '?v=2';
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($uri . '/favicon-32x32.png' . $v) . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url($uri . '/favicon-16x16.png' . $v) . '">' . "\n";
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($uri . '/apple-touch-icon.png' . $v) . '">' . "\n";
    echo '<link rel="shortcut icon" href="' . esc_url($uri . '/favicon.ico' . $v) . '">' . "\n";
}
add_action('wp_head', 'mi_favicon', 1);

// ─── IMAGE SIZES ─────────────────────────────────────────────────────────────

add_image_size('mi-hero',     1920, 800, true);
add_image_size('mi-product',  800,  800, true);
add_image_size('mi-card',     800,  500, true);
add_image_size('mi-thumb',    400,  250, true);

// ─── SCRIPTS & STYLES ────────────────────────────────────────────────────────

function mi_enqueue_assets() {
    // Google Fonts — Inter
    wp_enqueue_style(
        'mi-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap',
        [],
        null
    );

    // Material Symbols
    wp_enqueue_style(
        'mi-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        [],
        null
    );

    // Theme CSS
    wp_enqueue_style(
        'mi-theme',
        get_template_directory_uri() . '/assets/css/theme.css',
        ['mi-fonts'],
        filemtime(get_template_directory() . '/assets/css/theme.css')
    );

    // Tailwind CDN (must be in head, not footer)
    wp_enqueue_script(
        'tailwindcss',
        'https://cdn.tailwindcss.com?plugins=forms,container-queries',
        [],
        null,
        false
    );

    // Dynamic Tailwind config with Customizer colors
    $primary     = get_theme_mod('mi_color_primary',     '#3f3e6f');
    $accent_teal = get_theme_mod('mi_color_accent_teal', '#2D9DA8');
    $accent_ochre= get_theme_mod('mi_color_accent_ochre','#CC7722');
    $bg_light    = get_theme_mod('mi_color_bg_light',    '#f6f6f7');
    $bg_dark     = get_theme_mod('mi_color_bg_dark',     '#16161c');

    $tailwind_config = sprintf(
        'tailwind.config={darkMode:false,theme:{extend:{colors:{primary:"%s","accent-teal":"%s","accent-ochre":"%s","background-light":"%s","background-dark":"%s"},fontFamily:{display:["Inter","sans-serif"]},borderRadius:{DEFAULT:"0.5rem",lg:"1rem",xl:"1.5rem",full:"9999px"}}}}};',
        esc_js($primary), esc_js($accent_teal), esc_js($accent_ochre), esc_js($bg_light), esc_js($bg_dark)
    );
    wp_add_inline_script('tailwindcss', $tailwind_config, 'after');

    // Theme JS
    wp_enqueue_script(
        'mi-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        [],
        filemtime(get_template_directory() . '/assets/js/theme.js'),
        true
    );

    // Pass AJAX URL and nonce to JS
    wp_localize_script('mi-theme', 'MI', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('mi_form_nonce'),
        'i18n'    => [
            'sending'  => __('Sending...', 'motion-informatics'),
            'success'  => __('Message sent successfully!', 'motion-informatics'),
            'error'    => __('Something went wrong. Please try again.', 'motion-informatics'),
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'mi_enqueue_assets');

// ─── CUSTOMIZER: COLOR SCHEME ────────────────────────────────────────────────

function mi_customizer_settings($wp_customize) {
    $wp_customize->add_section('mi_colors', [
        'title'    => __('Motion Informatics Colors', 'motion-informatics'),
        'priority' => 30,
    ]);

    $colors = [
        'mi_color_primary'      => ['label' => __('Primary Color', 'motion-informatics'),      'default' => '#3f3e6f'],
        'mi_color_accent_teal'  => ['label' => __('Accent Teal', 'motion-informatics'),        'default' => '#2D9DA8'],
        'mi_color_accent_ochre' => ['label' => __('Accent Ochre', 'motion-informatics'),       'default' => '#CC7722'],
        'mi_color_bg_light'     => ['label' => __('Background Light', 'motion-informatics'),   'default' => '#f6f6f7'],
        'mi_color_bg_dark'      => ['label' => __('Background Dark', 'motion-informatics'),    'default' => '#16161c'],
    ];

    foreach ($colors as $key => $args) {
        $wp_customize->add_setting($key, [
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, [
            'label'   => $args['label'],
            'section' => 'mi_colors',
        ]));
    }
}
add_action('customize_register', 'mi_customizer_settings');

// ─── ACF OPTIONS PAGE ─────────────────────────────────────────────────────────

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Theme Global Settings', 'motion-informatics'),
        'menu_title' => __('Theme Settings', 'motion-informatics'),
        'menu_slug'  => 'mi-theme-settings',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-customizer',
        'redirect'   => false,
    ]);

    acf_add_options_sub_page([
        'page_title'  => __('Navigation & Footer', 'motion-informatics'),
        'menu_title'  => __('Nav & Footer', 'motion-informatics'),
        'parent_slug' => 'mi-theme-settings',
    ]);
}

// ─── ACF JSON SAVE/LOAD PATH ──────────────────────────────────────────────────

add_filter('acf/settings/save_json', function() {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

// ─── ACF FIELD GROUPS ────────────────────────────────────────────────────────
// Registered programmatically — ACF Pro required

add_action('acf/init', 'mi_register_acf_fields');
function mi_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) return;

    // ── GLOBAL OPTIONS ────────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'      => 'group_mi_global',
        'title'    => 'Global Settings',
        'fields'   => [
            ['key'=>'field_mi_site_tagline',   'label'=>'Site Tagline',       'name'=>'mi_site_tagline',   'type'=>'text',  'default_value'=>'Neuromuscular Innovation'],
            ['key'=>'field_mi_footer_desc',    'label'=>'Footer Description', 'name'=>'mi_footer_desc',    'type'=>'textarea','rows'=>3, 'default_value'=>'Advanced neuromuscular solutions for clinical excellence. Proudly serving medical professionals worldwide.'],
            ['key'=>'field_mi_contact_email',  'label'=>'Contact Email',      'name'=>'mi_contact_email',  'type'=>'email', 'default_value'=>'wecare@motioninformatics.ai'],
            ['key'=>'field_mi_address_line1',  'label'=>'Address Line 1',     'name'=>'mi_address_line1',  'type'=>'text',  'default_value'=>'1200 Innovation Way, Suite 400'],
            ['key'=>'field_mi_address_line2',  'label'=>'Address Line 2',     'name'=>'mi_address_line2',  'type'=>'text',  'default_value'=>'Cambridge, MA 02142, USA'],
            ['key'=>'field_mi_support_hours',  'label'=>'Support Hours',      'name'=>'mi_support_hours',  'type'=>'text',  'default_value'=>'Mon — Fri | 08:00 - 20:00 EST'],
            ['key'=>'field_mi_newsletter_title','label'=>'Newsletter Title',  'name'=>'mi_newsletter_title','type'=>'text', 'default_value'=>'Stay updated with our latest innovations.'],
            ['key'=>'field_mi_copyright',      'label'=>'Copyright Text',     'name'=>'mi_copyright',      'type'=>'text',  'default_value'=>'© 2024 Motion Informatics. All rights reserved.'],
            ['key'=>'field_mi_hipaa_notice',   'label'=>'HIPAA Notice Text',  'name'=>'mi_hipaa_notice',   'type'=>'textarea','rows'=>2, 'default_value'=>'Motion Informatics is committed to your privacy. This form is HIPAA compliant. All submitted data is encrypted and handled in accordance with healthcare privacy regulations.'],
        ],
        'location' => [[['param'=>'options_page','operator'=>'==','value'=>'mi-theme-settings']]],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);

    // ── HOMEPAGE ──────────────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_home',
        'title'  => 'Homepage Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_home_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_home_hero_badge',    'label'=>'Hero Badge Text',  'name'=>'home_hero_badge',    'type'=>'text',  'default_value'=>'Leading Neuromuscular Care'],
            ['key'=>'field_home_hero_heading1', 'label'=>'Hero Heading Line 1','name'=>'home_hero_heading1','type'=>'text', 'default_value'=>'We Are'],
            ['key'=>'field_home_hero_heading2', 'label'=>'Hero Heading Accent','name'=>'home_hero_heading2','type'=>'text', 'default_value'=>'Motion Informatics'],
            ['key'=>'field_home_hero_desc',     'label'=>'Hero Description', 'name'=>'home_hero_desc',     'type'=>'textarea','rows'=>3, 'default_value'=>'Proudly Empowering Lives Through Innovation. Developing the next generation of clinical technology for better recovery.'],
            ['key'=>'field_home_hero_btn1_text','label'=>'Hero Button 1 Text','name'=>'home_hero_btn1_text','type'=>'text', 'default_value'=>'View Products'],
            ['key'=>'field_home_hero_btn1_url', 'label'=>'Hero Button 1 URL', 'name'=>'home_hero_btn1_url', 'type'=>'text', 'instructions'=>'Full URL (https://...) or an in-page anchor like #products-heading'],
            ['key'=>'field_home_hero_btn2_text','label'=>'Hero Button 2 Text','name'=>'home_hero_btn2_text','type'=>'text', 'default_value'=>'Learn More'],
            ['key'=>'field_home_hero_btn2_url', 'label'=>'Hero Button 2 URL', 'name'=>'home_hero_btn2_url', 'type'=>'url'],
            ['key'=>'field_home_hero_bg',       'label'=>'Hero Background Image','name'=>'home_hero_bg',   'type'=>'image', 'return_format'=>'url', 'preview_size'=>'medium'],
            // Tab: Capabilities
            ['key'=>'field_home_tab_cap','label'=>'Clinical Abilities','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_home_cap_badge',     'label'=>'Capabilities Badge',   'name'=>'home_cap_badge',  'type'=>'text','default_value'=>'Our Capabilities'],
            ['key'=>'field_home_cap_heading',   'label'=>'Capabilities Heading', 'name'=>'home_cap_heading','type'=>'text','default_value'=>'Clinical Abilities'],
            ['key'=>'field_home_cap_desc',      'label'=>'Capabilities Description','name'=>'home_cap_desc','type'=>'textarea','rows'=>2,'default_value'=>'Advanced neuromuscular solutions designed for diverse clinical needs and rehabilitation paths.'],
            ['key'=>'field_home_capabilities',  'label'=>'Capabilities Items', 'name'=>'home_capabilities', 'type'=>'repeater',
                'button_label'=>'Add Capability', 'min'=>1, 'max'=>10, 'layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_home_cap_icon', 'label'=>'Icon (Material Symbol)', 'name'=>'icon', 'type'=>'text', 'column_width'=>'20%'],
                    ['key'=>'field_home_cap_title','label'=>'Title',                  'name'=>'title','type'=>'text', 'column_width'=>'30%'],
                    ['key'=>'field_home_cap_text', 'label'=>'Description',            'name'=>'desc', 'type'=>'textarea','rows'=>2,'column_width'=>'50%'],
                ],
            ],
            // Tab: Products
            ['key'=>'field_home_tab_products','label'=>'Products Overview','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_home_prod_heading',  'label'=>'Products Heading',     'name'=>'home_prod_heading', 'type'=>'text','default_value'=>'Precision Technology Overview'],
            ['key'=>'field_home_prod_desc',     'label'=>'Products Description', 'name'=>'home_prod_desc',    'type'=>'textarea','rows'=>2,'default_value'=>'Explore our flagship medical solutions designed for clinics and hospitals worldwide.'],
            ['key'=>'field_home_products',      'label'=>'Products',             'name'=>'home_products',     'type'=>'repeater',
                'button_label'=>'Add Product', 'min'=>1, 'max'=>6, 'layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_home_prod_img',    'label'=>'Product Image',    'name'=>'image',       'type'=>'image','return_format'=>'url','preview_size'=>'mi-card'],
                    ['key'=>'field_home_prod_badge',  'label'=>'Badge Text',       'name'=>'badge',       'type'=>'text'],
                    ['key'=>'field_home_prod_badge_c','label'=>'Badge Color',      'name'=>'badge_color', 'type'=>'select','choices'=>['primary'=>'Primary (Purple)','accent-teal'=>'Accent Teal'],'default_value'=>'primary'],
                    ['key'=>'field_home_prod_name',   'label'=>'Product Name',     'name'=>'name',        'type'=>'text'],
                    ['key'=>'field_home_prod_text',   'label'=>'Description',      'name'=>'description', 'type'=>'textarea','rows'=>3],
                    ['key'=>'field_home_prod_feats',  'label'=>'Features',         'name'=>'features',    'type'=>'repeater','button_label'=>'Add Feature','sub_fields'=>[
                        ['key'=>'field_home_prod_feat','label'=>'Feature','name'=>'feature','type'=>'text'],
                    ]],
                    ['key'=>'field_home_prod_btn',    'label'=>'Button Text',      'name'=>'button_text', 'type'=>'text','default_value'=>'Product Details'],
                    ['key'=>'field_home_prod_url',    'label'=>'Button URL',       'name'=>'button_url',  'type'=>'url'],
                ],
            ],
            // Tab: CTA
            ['key'=>'field_home_tab_cta','label'=>'CTA Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_home_cta_heading',   'label'=>'CTA Heading',     'name'=>'home_cta_heading',   'type'=>'text','default_value'=>'Ready to transform patient care?'],
            ['key'=>'field_home_cta_desc',      'label'=>'CTA Description', 'name'=>'home_cta_desc',      'type'=>'textarea','rows'=>2,'default_value'=>'Contact our clinical specialists for a personalized demonstration of our neuromuscular solutions.'],
            ['key'=>'field_home_cta_btn1_text', 'label'=>'CTA Button 1 Text','name'=>'home_cta_btn1_text','type'=>'text','default_value'=>'Request a Demo'],
            ['key'=>'field_home_cta_btn1_url',  'label'=>'CTA Button 1 URL', 'name'=>'home_cta_btn1_url', 'type'=>'url'],
            ['key'=>'field_home_cta_btn2_text', 'label'=>'CTA Button 2 Text','name'=>'home_cta_btn2_text','type'=>'text','default_value'=>'Speak to Sales'],
            ['key'=>'field_home_cta_btn2_url',  'label'=>'CTA Button 2 URL', 'name'=>'home_cta_btn2_url', 'type'=>'url'],
        ],
        'location'=> [[['param'=>'page_type','operator'=>'==','value'=>'front_page']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── ABOUT PAGE ────────────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_about',
        'title'  => 'About Page Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_about_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_about_badge',        'label'=>'Badge Text',        'name'=>'about_badge',        'type'=>'text','default_value'=>'Established 2014'],
            ['key'=>'field_about_heading',      'label'=>'Main Heading',      'name'=>'about_heading',      'type'=>'text','default_value'=>'Who We Are'],
            ['key'=>'field_about_desc',         'label'=>'Description',       'name'=>'about_desc',         'type'=>'wysiwyg','toolbar'=>'basic','media_upload'=>0,'default_value'=>'Motion Informatics is at the forefront of neuromuscular solutions, bridging the gap between motor data and clinical excellence.'],
            ['key'=>'field_about_image',        'label'=>'Hero Image',        'name'=>'about_image',        'type'=>'image','return_format'=>'url','preview_size'=>'mi-hero'],
            ['key'=>'field_about_image_alt',    'label'=>'Hero Image Alt Text','name'=>'about_image_alt',   'type'=>'text','default_value'=>'Motion Informatics team'],
            ['key'=>'field_about_btn1_text',    'label'=>'Button 1 Text',     'name'=>'about_btn1_text',    'type'=>'text','default_value'=>'Our Methodology'],
            ['key'=>'field_about_btn1_url',     'label'=>'Button 1 URL',      'name'=>'about_btn1_url',     'type'=>'url'],
            ['key'=>'field_about_btn2_text',    'label'=>'Button 2 Text',     'name'=>'about_btn2_text',    'type'=>'text','default_value'=>'Clinical Data'],
            ['key'=>'field_about_btn2_url',     'label'=>'Button 2 URL',      'name'=>'about_btn2_url',     'type'=>'url'],
            // Tab: Technology Focus
            ['key'=>'field_about_tab_tech','label'=>'Technology Focus','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_about_tech_badge',   'label'=>'Section Eyebrow',         'name'=>'about_tech_badge',   'type'=>'text','default_value'=>'What We Build'],
            ['key'=>'field_about_tech_heading', 'label'=>'Section Heading',         'name'=>'about_tech_heading', 'type'=>'text','default_value'=>'A Computational Treatment Platform'],
            ['key'=>'field_about_tech_para1',   'label'=>'Description Paragraph 1', 'name'=>'about_tech_para1',   'type'=>'textarea','rows'=>5,'default_value'=>'We focus on one challenge: engineering neuromuscular rehabilitation to be intelligent, precise, and dynamically responsive to each patient\'s neural state. Traditional electrical stimulation delivers fixed output patterns. Conventional therapy depends on repetition without quantified neural intent. We designed a closed-loop system that measures, interprets, and responds.'],
            ['key'=>'field_about_tech_para2',   'label'=>'Description Paragraph 2', 'name'=>'about_tech_para2',   'type'=>'textarea','rows'=>5,'default_value'=>'By integrating real-time Electromyography (EMG) biofeedback, Functional Electrical Stimulation (FES), Neuromuscular Electrical Stimulation (NMES), artificial intelligence (AI), and augmented reality (AR), we created an adaptive neuromodulation framework that detects voluntary motor signals, decodes intent, and modulates stimulation parameters instantly. Therapy becomes computationally driven, physiologically aligned, and continuously optimized around neuroplastic response.'],
            ['key'=>'field_about_technologies', 'label'=>'Technology Cards',        'name'=>'about_technologies', 'type'=>'repeater','button_label'=>'Add Card','layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_about_tech_icon', 'label'=>'Icon (Material Symbol)','name'=>'icon', 'type'=>'text','column_width'=>'40%'],
                    ['key'=>'field_about_tech_label','label'=>'Label',                 'name'=>'label','type'=>'text','column_width'=>'60%'],
                ],
            ],
            // Tab: Journey
            ['key'=>'field_about_tab_journey','label'=>'Our Journey','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_about_journey_heading','label'=>'Journey Heading', 'name'=>'about_journey_heading','type'=>'text','default_value'=>'Our Journey'],
            ['key'=>'field_about_journey_sub',  'label'=>'Journey Subheading','name'=>'about_journey_sub',  'type'=>'text','default_value'=>'From a research startup to a global medical technology team.'],
            ['key'=>'field_about_timeline_aria','label'=>'Timeline Aria Label','name'=>'about_timeline_aria','type'=>'text','default_value'=>'Company Timeline'],
            ['key'=>'field_about_milestones',   'label'=>'Milestones',        'name'=>'about_milestones',   'type'=>'repeater','button_label'=>'Add Milestone','layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_about_mile_year','label'=>'Year',       'name'=>'year',       'type'=>'text','column_width'=>'15%'],
                    ['key'=>'field_about_mile_label','label'=>'Label',     'name'=>'label',      'type'=>'text','column_width'=>'25%'],
                    ['key'=>'field_about_mile_desc','label'=>'Description','name'=>'description','type'=>'textarea','rows'=>2,'column_width'=>'60%'],
                ],
            ],
            // Tab: Vision
            ['key'=>'field_about_tab_vision','label'=>'Our Vision','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_about_vision_heading','label'=>'Vision Heading',   'name'=>'about_vision_heading','type'=>'text','default_value'=>'Our Vision'],
            ['key'=>'field_about_vision_text',  'label'=>'Vision Text',       'name'=>'about_vision_text',  'type'=>'textarea','rows'=>3,'default_value'=>'To be the global leader in neuromuscular innovation, making advanced clinical technology accessible to every patient worldwide.'],
            ['key'=>'field_about_vision_bg',    'label'=>'Vision Background', 'name'=>'about_vision_bg',    'type'=>'image','return_format'=>'url','preview_size'=>'mi-hero'],
            ['key'=>'field_about_vision_btn',   'label'=>'Vision Button Text','name'=>'about_vision_btn',   'type'=>'text','default_value'=>'Explore Our AI Mission'],
            ['key'=>'field_about_vision_url',   'label'=>'Vision Button URL', 'name'=>'about_vision_url',   'type'=>'url'],
            // Tab: Mission Pillars
            ['key'=>'field_about_tab_pillars','label'=>'Mission Pillars','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_about_pillars_heading','label'=>'Pillars Heading', 'name'=>'about_pillars_heading','type'=>'text','default_value'=>'Mission Pillars'],
            ['key'=>'field_about_pillars_desc', 'label'=>'Pillars Subheading','name'=>'about_pillars_desc', 'type'=>'text','default_value'=>'The core values that guide our approach to redefining medical technology and patient outcomes.'],
            ['key'=>'field_about_pillars',      'label'=>'Pillars',           'name'=>'about_pillars',      'type'=>'repeater','button_label'=>'Add Pillar','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_about_pillar_icon', 'label'=>'Icon','name'=>'icon','type'=>'text'],
                    ['key'=>'field_about_pillar_title','label'=>'Title','name'=>'title','type'=>'text'],
                    ['key'=>'field_about_pillar_desc', 'label'=>'Description','name'=>'description','type'=>'textarea','rows'=>2],
                ],
            ],
            ['key'=>'field_about_cta_heading',  'label'=>'CTA Card Heading',  'name'=>'about_cta_heading',  'type'=>'text','default_value'=>'Join Our Mission'],
            ['key'=>'field_about_cta_text',     'label'=>'CTA Card Text',     'name'=>'about_cta_text',     'type'=>'textarea','rows'=>2,'default_value'=>'Be part of the future of neuromuscular health.'],
            ['key'=>'field_about_cta_btn',      'label'=>'CTA Button Text',   'name'=>'about_cta_btn',      'type'=>'text','default_value'=>'Get Started'],
            ['key'=>'field_about_cta_url',      'label'=>'CTA Button URL',    'name'=>'about_cta_url',      'type'=>'url'],
            // Tab: Mission Statement
            ['key'=>'field_about_tab_mission','label'=>'Mission Statement','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_about_mission_eyebrow','label'=>'Section Eyebrow','name'=>'about_mission_eyebrow','type'=>'text','default_value'=>'Our Mission'],
            ['key'=>'field_about_mission_heading','label'=>'Section Heading','name'=>'about_mission_heading','type'=>'text','default_value'=>'Transforming Rehabilitation'],
            ['key'=>'field_about_mission_text',   'label'=>'Mission Text',   'name'=>'about_mission_text',   'type'=>'textarea','rows'=>4,'default_value'=>'Motion Informatics builds intelligent neuromuscular rehabilitation platforms that decode human motor intent and translate it into precise, adaptive stimulation in real time. We exist to transform rehabilitation from repetitive protocol-based intervention into responsive, data-driven neuroplastic recovery.'],
            ['key'=>'field_about_culture_heading','label'=>'Culture Subheading','name'=>'about_culture_heading','type'=>'text','default_value'=>'Our Culture'],
            ['key'=>'field_about_culture',        'label'=>'Culture Cards',  'name'=>'about_culture',  'type'=>'repeater','button_label'=>'Add Card','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_about_culture_icon', 'label'=>'Icon (Material Symbol)','name'=>'icon','type'=>'text'],
                    ['key'=>'field_about_culture_title','label'=>'Title',                 'name'=>'title','type'=>'text'],
                    ['key'=>'field_about_culture_desc', 'label'=>'Description',           'name'=>'description','type'=>'textarea','rows'=>2],
                ],
            ],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-about.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── CONTACT PAGE ──────────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_contact',
        'title'  => 'Contact Page Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_contact_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_contact_heading',  'label'=>'Page Heading',    'name'=>'contact_heading',  'type'=>'text','default_value'=>'Get In Touch'],
            ['key'=>'field_contact_desc',     'label'=>'Page Description','name'=>'contact_desc',     'type'=>'textarea','rows'=>3,'default_value'=>'Dedicated support for our neuromuscular solutions. Connect with our expert team for technical inquiries, clinical support, or global partnership opportunities.'],
            // Tab: Contact Form
            ['key'=>'field_contact_tab_form','label'=>'Contact Form','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_contact_inquiry_label','label'=>'Inquiry Type Label','name'=>'contact_inquiry_label','type'=>'text','default_value'=>'Inquiry Type'],
            ['key'=>'field_contact_type_patient',      'label'=>'Inquiry Type: Patient',      'name'=>'contact_type_patient',      'type'=>'text','default_value'=>'Patient'],
            ['key'=>'field_contact_type_professional', 'label'=>'Inquiry Type: Professional', 'name'=>'contact_type_professional', 'type'=>'text','default_value'=>'Professional'],
            ['key'=>'field_contact_type_distributor',  'label'=>'Inquiry Type: Distributor',  'name'=>'contact_type_distributor',  'type'=>'text','default_value'=>'Distributor'],
            ['key'=>'field_contact_label_first',  'label'=>'Form Label: First Name',         'name'=>'contact_label_first',  'type'=>'text','default_value'=>'First Name'],
            ['key'=>'field_contact_label_last',   'label'=>'Form Label: Last Name',          'name'=>'contact_label_last',   'type'=>'text','default_value'=>'Last Name'],
            ['key'=>'field_contact_label_email',  'label'=>'Form Label: Email Address',      'name'=>'contact_label_email',  'type'=>'text','default_value'=>'Email Address'],
            ['key'=>'field_contact_label_org',    'label'=>'Form Label: Organization',       'name'=>'contact_label_org',    'type'=>'text','default_value'=>'Organization / Facility Name'],
            ['key'=>'field_contact_label_message','label'=>'Form Label: Message',            'name'=>'contact_label_message','type'=>'text','default_value'=>'Message'],
            ['key'=>'field_contact_placeholder_msg','label'=>'Message Placeholder',          'name'=>'contact_placeholder_msg','type'=>'text','default_value'=>'How can our team help you?'],
            ['key'=>'field_contact_btn_send',     'label'=>'Submit Button Text',             'name'=>'contact_btn_send',     'type'=>'text','default_value'=>'Send Inquiry'],
            // Tab: Contact Info Sidebar
            ['key'=>'field_contact_tab_sidebar','label'=>'Contact Info','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_contact_email_label',   'label'=>'Email Section Title',       'name'=>'contact_email_label',   'type'=>'text','default_value'=>'Email Support'],
            ['key'=>'field_contact_email_response','label'=>'Email Response Notice',     'name'=>'contact_email_response','type'=>'text','default_value'=>'Typical response within 24 hours.'],
            ['key'=>'field_contact_hq_label',        'label'=>'HQ Section Title',             'name'=>'contact_hq_label',        'type'=>'text','default_value'=>'Global HQ'],
            ['key'=>'field_contact_address_line1',   'label'=>'Address Line 1',               'name'=>'contact_address_line1',   'type'=>'text','default_value'=>'1200 Innovation Way, Suite 400'],
            ['key'=>'field_contact_address_line2',   'label'=>'Address Line 2',               'name'=>'contact_address_line2',   'type'=>'text','default_value'=>'Cambridge, MA 02142, USA'],
            ['key'=>'field_contact_hipaa_notice',    'label'=>'HIPAA Privacy Notice (bottom)','name'=>'contact_hipaa_notice',    'type'=>'textarea','rows'=>2,'default_value'=>'Motion Informatics is committed to your privacy. This form is HIPAA compliant. All submitted data is encrypted and handled in accordance with healthcare privacy regulations.'],
            ['key'=>'field_contact_consent_patient', 'label'=>'Consent Text — Patient',       'name'=>'contact_consent_patient', 'type'=>'text','default_value'=>'I agree that Motion Informatics may contact me regarding my inquiry.'],
            ['key'=>'field_contact_consent_pro',     'label'=>'Consent Text — Professional/Distributor','name'=>'contact_consent_pro','type'=>'text','default_value'=>'I agree that Motion Informatics may contact me regarding partnership and commercial opportunities.'],
            ['key'=>'field_contact_hours_label',   'label'=>'Support Hours Label',       'name'=>'contact_hours_label',   'type'=>'text','default_value'=>'Available Support Hours'],
            ['key'=>'field_contact_map_placeholder','label'=>'Map Placeholder Notice',   'name'=>'contact_map_placeholder','type'=>'text','default_value'=>'Add a Google Maps Embed URL in Theme Settings'],
            ['key'=>'field_contact_map_url',  'label'=>'Google Maps Embed URL','name'=>'contact_map_url','type'=>'url'],
            ['key'=>'field_contact_map_label','label'=>'Map Label (e.g. Cambridge, MA)','name'=>'contact_map_label','type'=>'text','default_value'=>'Cambridge, MA'],
            // Tab: FAQ
            ['key'=>'field_contact_tab_faq','label'=>'FAQ Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_contact_faq_heading','label'=>'FAQ Heading',   'name'=>'contact_faq_heading','type'=>'text','default_value'=>'Frequently Asked Questions'],
            ['key'=>'field_contact_faq_desc', 'label'=>'FAQ Subheading',  'name'=>'contact_faq_desc', 'type'=>'text','default_value'=>'Quick answers to common questions about our platform and support.'],
            ['key'=>'field_contact_faqs',     'label'=>'FAQ Items',       'name'=>'contact_faqs',     'type'=>'repeater','button_label'=>'Add FAQ','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_contact_faq_q','label'=>'Question','name'=>'question','type'=>'text'],
                    ['key'=>'field_contact_faq_a','label'=>'Answer',  'name'=>'answer',  'type'=>'wysiwyg','toolbar'=>'basic','media_upload'=>0],
                ],
            ],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-contact.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── DISTRIBUTORS PAGE ────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_distributors',
        'title'  => 'Distributors Page Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_dist_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_dist_hero_heading',  'label'=>'Hero Heading',     'name'=>'dist_hero_heading',  'type'=>'text','default_value'=>'Shape the Future of Neuromuscular Solutions'],
            ['key'=>'field_dist_hero_desc',     'label'=>'Hero Description', 'name'=>'dist_hero_desc',     'type'=>'textarea','rows'=>3,'default_value'=>'Partner with Motion Informatics to deliver world-class medical technology to patients and clinics across the globe.'],
            ['key'=>'field_dist_hero_btn1_text','label'=>'Button 1 Text',    'name'=>'dist_hero_btn1_text','type'=>'text','default_value'=>'Explore the Network'],
            ['key'=>'field_dist_hero_btn1_url', 'label'=>'Button 1 URL',     'name'=>'dist_hero_btn1_url', 'type'=>'url'],
            ['key'=>'field_dist_hero_btn2_text','label'=>'Button 2 Text',    'name'=>'dist_hero_btn2_text','type'=>'text','default_value'=>'Download Prospectus'],
            ['key'=>'field_dist_hero_btn2_url', 'label'=>'Button 2 URL',     'name'=>'dist_hero_btn2_url', 'type'=>'url'],
            ['key'=>'field_dist_hero_bg',       'label'=>'Hero Background',  'name'=>'dist_hero_bg',       'type'=>'image','return_format'=>'url','preview_size'=>'mi-hero'],
            // Tab: Global Map
            ['key'=>'field_dist_tab_map','label'=>'Global Map','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_dist_map_heading',      'label'=>'Map Section Heading',     'name'=>'dist_map_heading',      'type'=>'text','default_value'=>'Global Reach, Local Impact'],
            ['key'=>'field_dist_map_desc',         'label'=>'Map Section Description', 'name'=>'dist_map_desc',         'type'=>'textarea','rows'=>2,'default_value'=>'Active in major medical hubs across four continents. Our network of certified distributors ensures clinical excellence at every location.'],
            ['key'=>'field_dist_map_image',        'label'=>'World Map Image',          'name'=>'dist_map_image',        'type'=>'image','return_format'=>'url','preview_size'=>'medium'],
            ['key'=>'field_dist_map_alt',          'label'=>'World Map Image Alt Text', 'name'=>'dist_map_alt',          'type'=>'text','default_value'=>'World map showing distributor locations'],
            // Tab: Find a Distributor Form
            ['key'=>'field_dist_tab_form','label'=>'Find a Distributor Form','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_dist_form_heading',     'label'=>'Form Heading',           'name'=>'dist_form_heading',     'type'=>'text','default_value'=>'Find a Distributor'],
            ['key'=>'field_dist_form_desc',        'label'=>'Form Description',       'name'=>'dist_form_desc',        'type'=>'text','default_value'=>'Connect with a local expert to explore our solutions.'],
            ['key'=>'field_dist_btn_submit',       'label'=>'Submit Button Text',     'name'=>'dist_btn_submit',       'type'=>'text','default_value'=>'Request Local Info'],
            // Tab: Partnership Benefits
            ['key'=>'field_dist_tab_partner','label'=>'Partnership Benefits','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_dist_partner_badge',    'label'=>'Partner Badge Text',      'name'=>'dist_partner_badge',    'type'=>'text','default_value'=>'Partner Program'],
            ['key'=>'field_dist_become_heading','label'=>'Become Distributor Heading','name'=>'dist_become_heading','type'=>'text','default_value'=>'Become a Distributor'],
            ['key'=>'field_dist_become_desc',   'label'=>'Become Distributor Desc','name'=>'dist_become_desc','type'=>'textarea','rows'=>3,'default_value'=>'Join our growing network of elite medical technology providers and lead the transformation of neuromuscular care in your region.'],
            ['key'=>'field_dist_benefits',      'label'=>'Partnership Benefits','name'=>'dist_benefits','type'=>'repeater','button_label'=>'Add Benefit','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_dist_ben_icon', 'label'=>'Icon','name'=>'icon', 'type'=>'text'],
                    ['key'=>'field_dist_ben_title','label'=>'Title','name'=>'title','type'=>'text'],
                    ['key'=>'field_dist_ben_desc', 'label'=>'Desc', 'name'=>'desc', 'type'=>'textarea','rows'=>2],
                ],
            ],
            // Tab: Resource Center
            ['key'=>'field_dist_tab_resources','label'=>'Resource Center','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_dist_resources_heading','label'=>'Resource Center Heading','name'=>'dist_resources_heading','type'=>'text','default_value'=>'Resource Center'],
            ['key'=>'field_dist_resources_desc',   'label'=>'Resource Center Desc',   'name'=>'dist_resources_desc',   'type'=>'text','default_value'=>'Download essential documentation for your region.'],
            ['key'=>'field_dist_download_label',   'label'=>'Download Link Text',      'name'=>'dist_download_label',   'type'=>'text','default_value'=>'Download'],
            ['key'=>'field_dist_resources',     'label'=>'Resources',          'name'=>'dist_resources',    'type'=>'repeater','button_label'=>'Add Resource','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_dist_res_img',  'label'=>'Image',  'name'=>'image',  'type'=>'image','return_format'=>'url','preview_size'=>'mi-card'],
                    ['key'=>'field_dist_res_type', 'label'=>'Type',   'name'=>'type',   'type'=>'text'],
                    ['key'=>'field_dist_res_icon', 'label'=>'Icon',   'name'=>'icon',   'type'=>'text'],
                    ['key'=>'field_dist_res_title','label'=>'Title',  'name'=>'title',  'type'=>'text'],
                    ['key'=>'field_dist_res_file', 'label'=>'File/URL','name'=>'file_url','type'=>'url'],
                ],
            ],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-distributors.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── PRODUCT: STIMEL-03 ────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_product_stimel',
        'title'  => 'STIMEL-03 Product Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_s3_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_badge',         'label'=>'Hero Badge',       'name'=>'s3_badge',        'type'=>'text','default_value'=>'New Release: Stimel Series'],
            ['key'=>'field_s3_heading1',      'label'=>'Heading Line 1',   'name'=>'s3_heading1',     'type'=>'text','default_value'=>'STIMEL-03: Accelerating Recovery with'],
            ['key'=>'field_s3_heading_accent','label'=>'Heading Accent',   'name'=>'s3_heading_accent','type'=>'text','default_value'=>'Tailored Stimulation'],
            ['key'=>'field_s3_desc',          'label'=>'Hero Description', 'name'=>'s3_desc',         'type'=>'textarea','rows'=>3,'default_value'=>'Bridging the gap between informatics and patient outcomes with advanced neuromuscular solutions. Our precision-engineered closed-loop system redefines rehabilitation standards.'],
            ['key'=>'field_s3_image',       'label'=>'Hero Video — Poster Image','name'=>'s3_image',      'type'=>'image','return_format'=>'url','preview_size'=>'mi-product','instructions'=>'Thumbnail shown before the video plays'],
            ['key'=>'field_s3_hero_video',  'label'=>'Hero Video (MP4)',         'name'=>'s3_hero_video', 'type'=>'file', 'return_format'=>'url','library'=>'all','mime_types'=>'mp4,video','instructions'=>'Upload the .mp4 video file for the hero section'],
            ['key'=>'field_s3_show_floating',   'label'=>'Show Floating UI Widget',   'name'=>'s3_show_floating',    'type'=>'true_false','default_value'=>1,'ui'=>1,'ui_on_text'=>'Show','ui_off_text'=>'Hide'],
            ['key'=>'field_s3_floating_label',  'label'=>'Floating UI Label',         'name'=>'s3_floating_label',   'type'=>'text','default_value'=>'Pulse Intensity'],
            ['key'=>'field_s3_floating_value',  'label'=>'Floating UI Value',         'name'=>'s3_floating_value',   'type'=>'text','default_value'=>'84.2 mA'],
            ['key'=>'field_s3_benefits_aria',   'label'=>'Benefits Section Aria Label','name'=>'s3_benefits_aria',   'type'=>'text','default_value'=>'Key Benefits'],
            ['key'=>'field_s3_btn1_text',     'label'=>'Button 1 Text',    'name'=>'s3_btn1_text',    'type'=>'text','default_value'=>'Schedule a Demo'],
            ['key'=>'field_s3_btn1_url',      'label'=>'Button 1 URL',     'name'=>'s3_btn1_url',     'type'=>'url'],
            ['key'=>'field_s3_btn2_text',     'label'=>'Button 2 Text',    'name'=>'s3_btn2_text',    'type'=>'text','default_value'=>'Consult Clinical Papers'],
            ['key'=>'field_s3_btn2_url',      'label'=>'Button 2 URL',     'name'=>'s3_btn2_url',     'type'=>'url'],
            ['key'=>'field_s3_show_hero_badge','label'=>'Show Hero Badge',  'name'=>'s3_show_hero_badge','type'=>'true_false','default_value'=>1,'ui'=>1,'ui_on_text'=>'Show','ui_off_text'=>'Hide'],
            // Tab: Key Benefits
            ['key'=>'field_s3_tab_benefits','label'=>'Key Benefits','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_benefits',      'label'=>'Key Benefits',     'name'=>'s3_benefits',     'type'=>'repeater','button_label'=>'Add Benefit','layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_s3_ben_icon', 'label'=>'Icon', 'name'=>'icon', 'type'=>'text','column_width'=>'20%'],
                    ['key'=>'field_s3_ben_title','label'=>'Title','name'=>'title','type'=>'text','column_width'=>'30%'],
                    ['key'=>'field_s3_ben_desc', 'label'=>'Desc', 'name'=>'desc', 'type'=>'textarea','rows'=>2,'column_width'=>'50%'],
                ],
            ],
            // Tab: Key Differentiators
            ['key'=>'field_s3_tab_diff','label'=>'Key Differentiators','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_diff_badge',  'label'=>'Differentiators Eyebrow','name'=>'s3_diff_badge',  'type'=>'text','default_value'=>'Why Stimel-03'],
            ['key'=>'field_s3_diff_heading','label'=>'Differentiators Heading', 'name'=>'s3_diff_heading','type'=>'text','default_value'=>'Key Differentiators'],
            ['key'=>'field_s3_differentiators','label'=>'Differentiator Cards','name'=>'s3_differentiators','type'=>'repeater','button_label'=>'Add Card','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_s3_diff_icon', 'label'=>'Icon (Material Symbol name)','name'=>'icon', 'type'=>'text'],
                    ['key'=>'field_s3_diff_title','label'=>'Title',                      'name'=>'title','type'=>'text'],
                    ['key'=>'field_s3_diff_desc', 'label'=>'Description',                'name'=>'desc', 'type'=>'textarea','rows'=>2],
                ],
            ],
            // Tab: Adaptive Biofeedback
            ['key'=>'field_s3_tab_biofeedback','label'=>'Adaptive Biofeedback','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_bio_image_alt', 'label'=>'Biofeedback Image Alt','name'=>'s3_bio_image_alt','type'=>'text','default_value'=>'Adaptive biofeedback display showing real-time muscle data'],
            ['key'=>'field_s3_bio_badge',     'label'=>'Biofeedback Badge',    'name'=>'s3_bio_badge',   'type'=>'text','default_value'=>'Precision Technology'],
            ['key'=>'field_s3_bio_heading',   'label'=>'Biofeedback Heading',  'name'=>'s3_bio_heading', 'type'=>'text','default_value'=>'Adaptive Biofeedback'],
            ['key'=>'field_s3_bio_desc',      'label'=>'Biofeedback Desc',     'name'=>'s3_bio_desc',    'type'=>'wysiwyg','toolbar'=>'basic','media_upload'=>0,'default_value'=>'The STIMEL-03 doesn\'t just deliver static pulses. It listens. Our proprietary sensor integration captures micro-adjustments in muscle recruitment, allowing the system to modulate stimulation intensity in real-time to prevent fatigue and maximize neuroplasticity.'],
            ['key'=>'field_s3_bio_image',     'label'=>'Biofeedback Image',    'name'=>'s3_bio_image',   'type'=>'image','return_format'=>'url','preview_size'=>'mi-card'],
            ['key'=>'field_s3_bio_bullets',   'label'=>'Biofeedback Bullets',  'name'=>'s3_bio_bullets', 'type'=>'repeater','button_label'=>'Add Bullet','sub_fields'=>[
                ['key'=>'field_s3_bio_bullet','label'=>'Bullet','name'=>'bullet','type'=>'text'],
            ]],
            // Tab: Closed-Loop Precision
            ['key'=>'field_s3_tab_closedloop','label'=>'Closed-Loop Precision','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_loop_badge',    'label'=>'Closed-Loop Badge',    'name'=>'s3_loop_badge',  'type'=>'text','default_value'=>'Autonomous Recovery'],
            ['key'=>'field_s3_loop_heading',  'label'=>'Closed-Loop Heading',  'name'=>'s3_loop_heading','type'=>'text','default_value'=>'Closed-Loop Precision'],
            ['key'=>'field_s3_loop_desc',     'label'=>'Closed-Loop Desc',     'name'=>'s3_loop_desc',   'type'=>'wysiwyg','toolbar'=>'basic','media_upload'=>0,'default_value'=>'Experience the future of autonomous rehabilitation. The STIMEL-03 operates on a fully closed-loop architecture, continuously monitoring patient output and safety parameters without the need for constant manual therapist intervention.'],
            ['key'=>'field_s3_loop_image',     'label'=>'Closed-Loop Image',       'name'=>'s3_loop_image',     'type'=>'image','return_format'=>'url','preview_size'=>'mi-card'],
            ['key'=>'field_s3_loop_image_alt', 'label'=>'Closed-Loop Image Alt',   'name'=>'s3_loop_image_alt', 'type'=>'text','default_value'=>'Closed-loop feedback system diagram'],
            ['key'=>'field_s3_specs_table_aria','label'=>'Specs Table Aria Label',  'name'=>'s3_specs_table_aria','type'=>'text','default_value'=>'STIMEL-03 Technical Specifications'],
            ['key'=>'field_s3_loop_status_label','label'=>'Feedback Loop Status Label',      'name'=>'s3_loop_status_label','type'=>'text','default_value'=>'Feedback Loop Status'],
            ['key'=>'field_s3_loop_status_badge','label'=>'Feedback Loop Status Badge Text', 'name'=>'s3_loop_status_badge','type'=>'text','default_value'=>'ACTIVE'],
            ['key'=>'field_s3_loop_sr_status',   'label'=>'Feedback Loop Screen Reader Prefix','name'=>'s3_loop_sr_status',  'type'=>'text','default_value'=>'Status:'],
            ['key'=>'field_s3_stats',         'label'=>'Stats (Closed-Loop)',  'name'=>'s3_stats',       'type'=>'repeater','button_label'=>'Add Stat','layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_s3_stat_val',  'label'=>'Value','name'=>'value','type'=>'text','column_width'=>'40%'],
                    ['key'=>'field_s3_stat_label','label'=>'Label','name'=>'label','type'=>'text','column_width'=>'60%'],
                ],
            ],
            // Tab: Technical Specifications
            ['key'=>'field_s3_tab_specs','label'=>'Technical Specifications','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_specs_heading', 'label'=>'Specs Section Heading','name'=>'s3_specs_heading','type'=>'text','default_value'=>'Technical Specifications'],
            ['key'=>'field_s3_specs_desc',    'label'=>'Specs Section Subheading','name'=>'s3_specs_desc','type'=>'text','default_value'=>'Standard performance metrics for clinical evaluation.'],
            ['key'=>'field_s3_specs_col_param','label'=>'Specs Table Header: Parameter','name'=>'s3_specs_col_param','type'=>'text','default_value'=>'Parameter'],
            ['key'=>'field_s3_specs_col_value','label'=>'Specs Table Header: Value',    'name'=>'s3_specs_col_value','type'=>'text','default_value'=>'Value'],
            ['key'=>'field_s3_specs_col_notes','label'=>'Specs Table Header: Notes',    'name'=>'s3_specs_col_notes','type'=>'text','default_value'=>'Notes'],
            ['key'=>'field_s3_specs',         'label'=>'Spec Table Rows',      'name'=>'s3_specs',       'type'=>'repeater','button_label'=>'Add Spec','layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_s3_spec_param','label'=>'Parameter','name'=>'parameter','type'=>'text','column_width'=>'30%'],
                    ['key'=>'field_s3_spec_val',  'label'=>'Value',    'name'=>'value',    'type'=>'text','column_width'=>'30%'],
                    ['key'=>'field_s3_spec_note', 'label'=>'Notes',    'name'=>'notes',    'type'=>'text','column_width'=>'40%'],
                ],
            ],
            ['key'=>'field_s3_datasheet_url',      'label'=>'Datasheet PDF URL',       'name'=>'s3_datasheet_url',       'type'=>'url'],
            ['key'=>'field_s3_datasheet_link_text','label'=>'Datasheet Link Text',     'name'=>'s3_datasheet_link_text', 'type'=>'text','default_value'=>'Download Full Datasheet (PDF)'],
            // Tab: Video Demo
            ['key'=>'field_s3_tab_video','label'=>'Video Demo','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_video_badge',       'label'=>'Video Section Eyebrow',     'name'=>'s3_video_badge',       'type'=>'text','default_value'=>'Product Demonstration'],
            ['key'=>'field_s3_video_heading',     'label'=>'Video Section Heading',     'name'=>'s3_video_heading',     'type'=>'text','default_value'=>'See STIMEL-03® in Action'],
            ['key'=>'field_s3_video_desc',        'label'=>'Video Section Description', 'name'=>'s3_video_desc',        'type'=>'textarea','rows'=>2,'default_value'=>'Watch real clinical demonstrations of the STIMEL-03® neuromuscular stimulation system delivering precise, intent-triggered therapy.'],
            ['key'=>'field_s3_video_main_url',    'label'=>'Demo Video 1 (MP4)',        'name'=>'s3_video_main_url',    'type'=>'file','return_format'=>'url','library'=>'all','mime_types'=>'mp4,video'],
            ['key'=>'field_s3_video_main_poster', 'label'=>'Demo Video 1 — Poster',    'name'=>'s3_video_main_poster', 'type'=>'image','return_format'=>'url','preview_size'=>'mi-thumb'],
            ['key'=>'field_s3_video_main_aria',   'label'=>'Demo Video 1 — Aria Label','name'=>'s3_video_main_aria',   'type'=>'text','default_value'=>'STIMEL-03 product demonstration video'],
            ['key'=>'field_s3_video_wrist_url',   'label'=>'Demo Video 2 (MP4)',        'name'=>'s3_video_wrist_url',   'type'=>'file','return_format'=>'url','library'=>'all','mime_types'=>'mp4,video'],
            ['key'=>'field_s3_video_wrist_poster','label'=>'Demo Video 2 — Poster',    'name'=>'s3_video_wrist_poster','type'=>'image','return_format'=>'url','preview_size'=>'mi-thumb'],
            ['key'=>'field_s3_video_wrist_aria',  'label'=>'Demo Video 2 — Aria Label','name'=>'s3_video_wrist_aria',  'type'=>'text','default_value'=>'Wrist flexion muscle stimulation demonstration'],
            // Tab: Product Gallery
            ['key'=>'field_s3_tab_gallery','label'=>'Product Gallery','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_gallery_heading','label'=>'Gallery Section Heading','name'=>'s3_gallery_heading','type'=>'text','default_value'=>'STIMEL-03® Product Gallery'],
            ['key'=>'field_s3_gallery','label'=>'Gallery Images (drag to reorder)','name'=>'s3_gallery','type'=>'gallery','return_format'=>'array','preview_size'=>'mi-thumb','library'=>'all','instructions'=>'Upload product images. Drag rows to reorder. These appear in the product image grid below the specs.'],
            // Tab: CTA
            ['key'=>'field_s3_tab_cta','label'=>'CTA Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_s3_cta_heading',   'label'=>'CTA Heading',          'name'=>'s3_cta_heading', 'type'=>'text','default_value'=>'Ready to transform patient recovery?'],
            ['key'=>'field_s3_cta_desc',      'label'=>'CTA Description',      'name'=>'s3_cta_desc',    'type'=>'textarea','rows'=>2,'default_value'=>'Join hundreds of clinical centers worldwide already utilizing Motion Informatics for advanced neuromuscular rehabilitation.'],
            ['key'=>'field_s3_cta_btn1_text', 'label'=>'CTA Button 1 Text',   'name'=>'s3_cta_btn1_text','type'=>'text','default_value'=>'Schedule a Demo'],
            ['key'=>'field_s3_cta_btn1_url',  'label'=>'CTA Button 1 URL',    'name'=>'s3_cta_btn1_url', 'type'=>'url'],
            ['key'=>'field_s3_cta_btn2_text', 'label'=>'CTA Button 2 Text',   'name'=>'s3_cta_btn2_text','type'=>'text','default_value'=>'Contact Sales'],
            ['key'=>'field_s3_cta_btn2_url',  'label'=>'CTA Button 2 URL',    'name'=>'s3_cta_btn2_url', 'type'=>'url'],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-product-stimel.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── PRODUCT: SPATIAL STIMELMD ─────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_product_spatial',
        'title'  => 'Spatial StimelMD Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_sp_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_badge',         'label'=>'Hero Badge',        'name'=>'sp_badge',         'type'=>'text','default_value'=>'Next Generation Rehabilitation'],
            ['key'=>'field_sp_heading',       'label'=>'Hero Heading',      'name'=>'sp_heading',       'type'=>'text','default_value'=>'Spatial'],
            ['key'=>'field_sp_heading_accent','label'=>'Heading Accent',    'name'=>'sp_heading_accent','type'=>'text','default_value'=>'StimelMD'],
            ['key'=>'field_sp_desc',          'label'=>'Hero Description',  'name'=>'sp_desc',          'type'=>'textarea','rows'=>3,'default_value'=>'The world\'s first AI-integrated platform combining Immersive Motor Training with AR-enhanced Functional Electrical Stimulation.'],
            ['key'=>'field_sp_image',         'label'=>'Hero Image',            'name'=>'sp_image',         'type'=>'image','return_format'=>'url','preview_size'=>'mi-product'],
            ['key'=>'field_sp_image_alt',      'label'=>'Hero Image Alt Text',   'name'=>'sp_image_alt',      'type'=>'text','default_value'=>'Spatial StimelMD — AR-enhanced neuromuscular rehabilitation system'],
            ['key'=>'field_sp_show_hero_badge',   'label'=>'Show Hero Badge',          'name'=>'sp_show_hero_badge',   'type'=>'true_false','default_value'=>1,'ui'=>1,'ui_on_text'=>'Show','ui_off_text'=>'Hide'],
            ['key'=>'field_sp_show_floating_stat','label'=>'Show Floating Stat Widget','name'=>'sp_show_floating_stat','type'=>'true_false','default_value'=>1,'ui'=>1,'ui_on_text'=>'Show','ui_off_text'=>'Hide'],
            ['key'=>'field_sp_stat_label',        'label'=>'Floating Stat Label',      'name'=>'sp_stat_label',        'type'=>'text','default_value'=>'Neural Sync'],
            ['key'=>'field_sp_stat_value',        'label'=>'Floating Stat Value',      'name'=>'sp_stat_value',        'type'=>'text','default_value'=>'98.4% Active'],
            ['key'=>'field_sp_btn1_text',     'label'=>'Button 1 Text',     'name'=>'sp_btn1_text',     'type'=>'text','default_value'=>'Explore Technology'],
            ['key'=>'field_sp_btn1_url',      'label'=>'Button 1 URL',      'name'=>'sp_btn1_url',      'type'=>'url'],
            ['key'=>'field_sp_btn2_text',     'label'=>'Button 2 Text',     'name'=>'sp_btn2_text',     'type'=>'text','default_value'=>'View Specs'],
            ['key'=>'field_sp_btn2_url',      'label'=>'Button 2 URL',      'name'=>'sp_btn2_url',      'type'=>'url'],
            // Tab: Sub Navigation
            ['key'=>'field_sp_tab_subnav','label'=>'Sub-Navigation','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_nav_immersive', 'label'=>'Nav Label: Immersive Training','name'=>'sp_nav_immersive', 'type'=>'text','default_value'=>'Immersive Training'],
            ['key'=>'field_sp_nav_ai',        'label'=>'Nav Label: AI Adaptability',   'name'=>'sp_nav_ai',        'type'=>'text','default_value'=>'AI Adaptability'],
            ['key'=>'field_sp_nav_vision',    'label'=>'Nav Label: Vision',            'name'=>'sp_nav_vision',    'type'=>'text','default_value'=>'Vision'],
            ['key'=>'field_sp_nav_specs',     'label'=>'Nav Label: Technical Specs',   'name'=>'sp_nav_specs',     'type'=>'text','default_value'=>'Technical Specs'],
            // Tab: Clinical Challenge
            ['key'=>'field_sp_tab_challenge','label'=>'Clinical Challenge','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_challenge_badge',    'label'=>'Challenge Eyebrow',    'name'=>'sp_challenge_badge',    'type'=>'text','default_value'=>'The Problem We Solve'],
            ['key'=>'field_sp_challenge_heading',  'label'=>'Challenge Heading',    'name'=>'sp_challenge_heading',  'type'=>'text','default_value'=>'The Rehabilitation Adherence Gap'],
            ['key'=>'field_sp_challenge_desc',     'label'=>'Challenge Description','name'=>'sp_challenge_desc',     'type'=>'textarea','rows'=>3,'default_value'=>'Stroke and neuromuscular disorders generate long-term disability at a global scale. Rehabilitation systems face increasing pressure due to rising patient volumes, staffing shortages, inconsistent home follow-up, and limited objective progress tracking.'],
            ['key'=>'field_sp_challenge_stats',    'label'=>'Challenge Stat Cards', 'name'=>'sp_challenge_stats',    'type'=>'repeater','button_label'=>'Add Stat','layout'=>'table',
                'sub_fields'=>[
                    ['key'=>'field_sp_ch_value', 'label'=>'Value', 'name'=>'value', 'type'=>'text','column_width'=>'15%'],
                    ['key'=>'field_sp_ch_label', 'label'=>'Label', 'name'=>'label', 'type'=>'textarea','rows'=>2,'column_width'=>'65%'],
                    ['key'=>'field_sp_ch_source','label'=>'Source','name'=>'source','type'=>'text','column_width'=>'20%'],
                ],
            ],
            ['key'=>'field_sp_challenge_solution', 'label'=>'Challenge Solution Text','name'=>'sp_challenge_solution','type'=>'textarea','rows'=>3,'default_value'=>'Spatial StimelMD addresses this adherence challenge by integrating AI-driven real-time EMG decoding, BioRhythmIQ adaptive threshold modulation, FES, NMES, and AR into a closed feedback loop that reinforces patient intent, sustains engagement, and enables clinicians to monitor performance objectively.'],
            // Tab: Immersive Motor Training
            ['key'=>'field_sp_tab_immersive','label'=>'Immersive Motor Training','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_immersive_badge','label'=>'Immersive Badge',  'name'=>'sp_immersive_badge','type'=>'text','default_value'=>'Enhanced Neuroplasticity'],
            ['key'=>'field_sp_immersive_heading','label'=>'Immersive Heading','name'=>'sp_immersive_heading','type'=>'text','default_value'=>'Immersive Motor Training Through AR & FES'],
            ['key'=>'field_sp_immersive_desc','label'=>'Immersive Desc',    'name'=>'sp_immersive_desc','type'=>'wysiwyg','toolbar'=>'basic','media_upload'=>0,'default_value'=>'Our platform synchronizes augmented reality environments with Functional Electrical Stimulation (FES) to accelerate recovery. By providing real-time visual biofeedback, patients can visualize movement before and during muscle activation.'],
            ['key'=>'field_sp_immersive_bullets','label'=>'Immersive Bullets','name'=>'sp_immersive_bullets','type'=>'repeater','button_label'=>'Add Bullet','sub_fields'=>[
                ['key'=>'field_sp_imm_bullet','label'=>'Bullet','name'=>'bullet','type'=>'text'],
            ]],
            ['key'=>'field_sp_immersive_img1',    'label'=>'Immersive Image 1',         'name'=>'sp_immersive_img1',    'type'=>'image','return_format'=>'url','preview_size'=>'mi-card'],
            ['key'=>'field_sp_immersive_img1_alt','label'=>'Immersive Image 1 Alt Text','name'=>'sp_immersive_img1_alt','type'=>'text','default_value'=>'AR-assisted rehabilitation session'],
            ['key'=>'field_sp_immersive_img2',    'label'=>'Immersive Image 2',         'name'=>'sp_immersive_img2',    'type'=>'image','return_format'=>'url','preview_size'=>'mi-card'],
            ['key'=>'field_sp_immersive_img2_alt','label'=>'Immersive Image 2 Alt Text','name'=>'sp_immersive_img2_alt','type'=>'text','default_value'=>'Sensor placement for neuromuscular stimulation'],
            // Immersive overlay chip fields
            ['key'=>'field_sp_imm_chip1_label','label'=>'Card 1 — Chip Label',    'name'=>'sp_imm_chip1_label','type'=>'text','default_value'=>'Spatial StimelMD®'],
            ['key'=>'field_sp_imm_chip1_sub',  'label'=>'Card 1 — Chip Subtitle', 'name'=>'sp_imm_chip1_sub',  'type'=>'text','default_value'=>'Adaptive Electrode System'],
            ['key'=>'field_sp_imm_chip1_badge','label'=>'Card 1 — Badge Text',    'name'=>'sp_imm_chip1_badge','type'=>'text','default_value'=>'AR + FES'],
            ['key'=>'field_sp_imm_chip1_show', 'label'=>'Card 1 — Show Overlays', 'name'=>'sp_imm_chip1_show', 'type'=>'true_false','default_value'=>1,'ui'=>1,'ui_on_text'=>'Show','ui_off_text'=>'Hide'],
            ['key'=>'field_sp_imm_electrode',  'label'=>'Card 1 — Electrode Image','name'=>'sp_imm_electrode',  'type'=>'image','return_format'=>'url','preview_size'=>'mi-thumb'],
            ['key'=>'field_sp_imm_chip2_text', 'label'=>'Card 2 — Screen Label',  'name'=>'sp_imm_chip2_text', 'type'=>'text','default_value'=>'Live EMG'],
            ['key'=>'field_sp_imm_chip2_badge','label'=>'Card 2 — Badge Text',    'name'=>'sp_imm_chip2_badge','type'=>'text','default_value'=>'Real-Time Biofeedback'],
            ['key'=>'field_sp_imm_chip2_show', 'label'=>'Card 2 — Show Overlays', 'name'=>'sp_imm_chip2_show', 'type'=>'true_false','default_value'=>1,'ui'=>1,'ui_on_text'=>'Show','ui_off_text'=>'Hide'],
            ['key'=>'field_sp_imm_screen',     'label'=>'Card 2 — Screen Image',  'name'=>'sp_imm_screen',     'type'=>'image','return_format'=>'url','preview_size'=>'mi-thumb'],
            // Tab: AI Adaptability
            ['key'=>'field_sp_tab_ai','label'=>'AI Adaptability','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_ai_eyebrow',    'label'=>'AI Section Eyebrow','name'=>'sp_ai_eyebrow',    'type'=>'text','default_value'=>'The Intelligent Edge'],
            ['key'=>'field_sp_ai_heading',    'label'=>'AI Section Heading','name'=>'sp_ai_heading',    'type'=>'text','default_value'=>'AI-Driven Adaptability'],
            ['key'=>'field_sp_ai_desc',       'label'=>'AI Section Desc',   'name'=>'sp_ai_desc',       'type'=>'textarea','rows'=>3,'default_value'=>'The StimelMD doesn\'t just deliver therapy—it learns from the patient. Our AI algorithms analyze movement quality 1,000 times per second to optimize stimulation levels.'],
            ['key'=>'field_sp_ai_cards',      'label'=>'AI Feature Cards',  'name'=>'sp_ai_cards',      'type'=>'repeater','button_label'=>'Add Card','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_sp_ai_icon',   'label'=>'Icon',  'name'=>'icon',  'type'=>'text'],
                    ['key'=>'field_sp_ai_color',  'label'=>'Color', 'name'=>'color', 'type'=>'select','choices'=>['accent'=>'Teal Accent','primary'=>'Primary'],'default_value'=>'accent'],
                    ['key'=>'field_sp_ai_title',  'label'=>'Title', 'name'=>'title', 'type'=>'text'],
                    ['key'=>'field_sp_ai_desc',   'label'=>'Desc',  'name'=>'desc',  'type'=>'textarea','rows'=>2],
                ],
            ],
            // Tab: How It Works
            ['key'=>'field_sp_tab_how','label'=>'How It Works','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_how_badge',  'label'=>'Section Eyebrow',   'name'=>'sp_how_badge',  'type'=>'text','default_value'=>'Step by Step'],
            ['key'=>'field_sp_how_heading','label'=>'Section Heading',    'name'=>'sp_how_heading','type'=>'text','default_value'=>'From Intent to Movement'],
            ['key'=>'field_sp_how_desc',   'label'=>'Section Description','name'=>'sp_how_desc',   'type'=>'textarea','rows'=>2,'default_value'=>'Every therapy session follows a precise closed-loop sequence — from the patient\'s voluntary effort to measurable motor output.'],
            ['key'=>'field_sp_how_steps',  'label'=>'Steps (drag to reorder)','name'=>'sp_how_steps','type'=>'repeater','button_label'=>'Add Step','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_sp_step_num',  'label'=>'Step Number (01, 02…)','name'=>'number','type'=>'text'],
                    ['key'=>'field_sp_step_title','label'=>'Title',                'name'=>'title', 'type'=>'text'],
                    ['key'=>'field_sp_step_desc', 'label'=>'Description',          'name'=>'desc',  'type'=>'textarea','rows'=>2],
                ],
            ],
            // Tab: Product Gallery
            ['key'=>'field_sp_tab_gallery','label'=>'Product Gallery','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_gallery_badge',  'label'=>'Gallery Badge',            'name'=>'sp_gallery_badge',   'type'=>'text','default_value'=>'Product Gallery'],
            ['key'=>'field_sp_gallery_heading','label'=>'Gallery Section Heading',  'name'=>'sp_gallery_heading', 'type'=>'text','default_value'=>'Spatial StimelMD® in the Clinic'],
            ['key'=>'field_sp_gallery',        'label'=>'Gallery Images (drag to reorder)','name'=>'sp_gallery','type'=>'gallery','return_format'=>'array','preview_size'=>'mi-thumb','library'=>'all','instructions'=>'Upload clinical photos. Drag to reorder. These appear in the gallery grid section.'],
            // Tab: Vision
            ['key'=>'field_sp_tab_vision','label'=>'Vision Quote','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_quote',         'label'=>'Vision Quote',          'name'=>'sp_quote',         'type'=>'textarea','rows'=>3,'default_value'=>'"Our mission is to restore human potential by bridging the gap between digital intent and physical movement."'],
            ['key'=>'field_sp_quote_attribution','label'=>'Quote Attribution',  'name'=>'sp_quote_attribution','type'=>'text','default_value'=>'Vision Statement · Motion Informatics'],
            ['key'=>'field_sp_quote_bg',      'label'=>'Quote Background',       'name'=>'sp_quote_bg',      'type'=>'image','return_format'=>'url','preview_size'=>'mi-hero'],
            // Tab: Technical Specs
            ['key'=>'field_sp_tab_specs','label'=>'Technical Specifications','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_specs_heading',        'label'=>'Specs Section Heading',       'name'=>'sp_specs_heading',        'type'=>'text','default_value'=>'Technical Specifications'],
            ['key'=>'field_sp_integration_heading',  'label'=>'Integration Card Heading',    'name'=>'sp_integration_heading',  'type'=>'text','default_value'=>'Integration Ready'],
            ['key'=>'field_sp_integration_desc',     'label'=>'Integration Card Description','name'=>'sp_integration_desc',     'type'=>'textarea','rows'=>3,'default_value'=>'StimelMD offers a robust REST API and SDK for research institutions and clinical health systems looking to integrate custom data pipelines.'],
            ['key'=>'field_sp_integration_btn',      'label'=>'Integration Card Button Text','name'=>'sp_integration_btn',      'type'=>'text','default_value'=>'Download Datasheet'],
            ['key'=>'field_sp_integration_btn_url','label'=>'Integration Card Button URL', 'name'=>'sp_integration_btn_url','type'=>'url'],
            ['key'=>'field_sp_specs',         'label'=>'Spec Accordion',    'name'=>'sp_specs',         'type'=>'repeater','button_label'=>'Add Spec Section','layout'=>'block',
                'sub_fields'=>[
                    ['key'=>'field_sp_spec_title',  'label'=>'Title',  'name'=>'title',  'type'=>'text'],
                    ['key'=>'field_sp_spec_content','label'=>'Content','name'=>'content','type'=>'textarea','rows'=>2],
                ],
            ],
            // Tab: CTA
            ['key'=>'field_sp_tab_cta','label'=>'CTA Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_sp_cta_heading',   'label'=>'CTA Heading',       'name'=>'sp_cta_heading',   'type'=>'text','default_value'=>'Ready to transform patient recovery?'],
            ['key'=>'field_sp_cta_desc',      'label'=>'CTA Description',   'name'=>'sp_cta_desc',      'type'=>'textarea','rows'=>2,'default_value'=>'Join hundreds of clinical centers worldwide already utilizing Motion Informatics for advanced neuromuscular rehabilitation.'],
            ['key'=>'field_sp_cta_btn1_text', 'label'=>'CTA Button 1',      'name'=>'sp_cta_btn1_text', 'type'=>'text','default_value'=>'Schedule Virtual Demo'],
            ['key'=>'field_sp_cta_btn1_url',  'label'=>'CTA Button 1 URL',  'name'=>'sp_cta_btn1_url',  'type'=>'url'],
            ['key'=>'field_sp_cta_btn2_text', 'label'=>'CTA Button 2 Text', 'name'=>'sp_cta_btn2_text', 'type'=>'text','default_value'=>'Contact Sales'],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-product-spatial.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── PRODUCT: KINYARA ───────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_product_kinyara',
        'title'  => 'Kinyara Product Content',
        'fields' => [
            // Tab: Hero
            ['key'=>'field_ky_tab_hero','label'=>'Hero Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_ky_badge',         'label'=>'Hero Badge',         'name'=>'ky_badge',         'type'=>'text','default_value'=>'In Development'],
            ['key'=>'field_ky_heading',       'label'=>'Hero Heading',       'name'=>'ky_heading',       'type'=>'text','default_value'=>'Axionis–Kynara'],
            ['key'=>'field_ky_subheading',    'label'=>'Hero Subheading',    'name'=>'ky_subheading',    'type'=>'text','default_value'=>'The Future of Predictive Neurorehabilitation'],
            ['key'=>'field_ky_desc',          'label'=>'Hero Description',   'name'=>'ky_desc',          'type'=>'textarea','rows'=>4,'default_value'=>'Axionis–Kynara is a next-generation neurorehabilitation platform designed to transform the way patients recover from stroke, spinal cord injury, traumatic brain injury, and other neurological disorders. By combining AI, AR, FES, NMES, real-time biofeedback, and BioRhythmIQ® technology, Axionis-Kynara delivers a new level of personalized rehabilitation that adapts continuously to each patient\'s neurological condition and recovery progress.'],
            ['key'=>'field_ky_image',         'label'=>'Hero Image',         'name'=>'ky_image',         'type'=>'image','return_format'=>'url','preview_size'=>'mi-product'],
            ['key'=>'field_ky_image_alt',     'label'=>'Hero Image Alt Text','name'=>'ky_image_alt',     'type'=>'text','default_value'=>'Axionis–Kynara — predictive neurorehabilitation platform'],
            ['key'=>'field_ky_video_btn_text','label'=>'"Watch the Video" Button Text','name'=>'ky_video_btn_text','type'=>'text','default_value'=>'Watch the video'],
            ['key'=>'field_ky_btn1_text',     'label'=>'Button 1 Text',      'name'=>'ky_btn1_text',     'type'=>'text','default_value'=>'Request our Deck'],
            ['key'=>'field_ky_btn1_url',      'label'=>'Button 1 URL',       'name'=>'ky_btn1_url',      'type'=>'url'],
            // Tab: Video
            ['key'=>'field_ky_tab_video','label'=>'Video Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_ky_video_label',   'label'=>'Section Eyebrow',    'name'=>'ky_video_label',   'type'=>'text','default_value'=>'Video'],
            ['key'=>'field_ky_hero_video',    'label'=>'Video (MP4 or YouTube URL)','name'=>'ky_hero_video','type'=>'url'],
            // Tab: Differentiator
            ['key'=>'field_ky_tab_diff','label'=>'Differentiator','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_ky_diff_label',    'label'=>'Section Eyebrow',    'name'=>'ky_diff_label',    'type'=>'text','default_value'=>'Differentiator'],
            ['key'=>'field_ky_diff_heading',  'label'=>'Heading',            'name'=>'ky_diff_heading',  'type'=>'text','default_value'=>'Predictive, not reactive'],
            ['key'=>'field_ky_diff_quote',    'label'=>'Highlighted Quote',  'name'=>'ky_diff_quote',    'type'=>'textarea','rows'=>3,'default_value'=>'Unlike conventional rehabilitation systems that respond only after movement occurs, Axionis-Kynara is being developed to decode patient intent in real time and deliver predictive stimulation before movement is fully expressed.'],
            ['key'=>'field_ky_diff_bg',       'label'=>'Background Image (optional)','name'=>'ky_diff_bg','type'=>'image','return_format'=>'url','preview_size'=>'mi-hero','instructions'=>'Leave empty to use the default navy gradient background.'],
            // Tab: Core Features
            ['key'=>'field_ky_tab_features','label'=>'Core Features','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_ky_features_label','label'=>'Section Eyebrow',   'name'=>'ky_features_label','type'=>'text','default_value'=>'Core Features — Feature / Benefit'],
            ['key'=>'field_ky_features_heading','label'=>'Section Heading', 'name'=>'ky_features_heading','type'=>'text','default_value'=>'What Makes Axionis–Kynara Different'],
            // Tab: CTA
            ['key'=>'field_ky_tab_cta','label'=>'CTA Section','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_ky_cta_heading', 'label'=>'CTA Heading',     'name'=>'ky_cta_heading', 'type'=>'text','default_value'=>'Be part of the future'],
            ['key'=>'field_ky_cta_desc',    'label'=>'CTA Description', 'name'=>'ky_cta_desc',    'type'=>'textarea','rows'=>2,'default_value'=>'Kynara is currently in development. Join us early.'],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-product-kinyara.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);

    // ── NEWS / INSIGHTS HUB PAGE ───────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mi_news',
        'title'  => 'News / Insights Hub Content',
        'fields' => [
            // Tab: Hero Banner
            ['key'=>'field_news_tab_hero','label'=>'Hero Banner','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_news_hero_badge',        'label'=>'Hero Badge Text',          'name'=>'news_hero_badge',        'type'=>'text','default_value'=>'Resource Center'],
            ['key'=>'field_news_hero_fallback_desc','label'=>'Hero Fallback Description','name'=>'news_hero_fallback_desc','type'=>'textarea','rows'=>2,'default_value'=>'Advancing neuromuscular rehabilitation through data-driven informatics and cutting-edge medical research.'],
            // Tab: Filters
            ['key'=>'field_news_tab_filters','label'=>'Search & Filters','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_news_search_placeholder','label'=>'Search Placeholder Text','name'=>'news_search_placeholder','type'=>'text','default_value'=>'Search resources, whitepapers, and clinical data...'],
            ['key'=>'field_news_filter_label',      'label'=>'Filter Label',            'name'=>'news_filter_label',      'type'=>'text','default_value'=>'Filter:'],
            ['key'=>'field_news_filter_all',        'label'=>'Filter All Label',        'name'=>'news_filter_all',        'type'=>'text','default_value'=>'All'],
            // Tab: Featured Resource
            ['key'=>'field_news_tab_featured','label'=>'Featured Resource','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_news_featured_heading',  'label'=>'Featured Section Heading','name'=>'news_featured_heading',  'type'=>'text','default_value'=>'Featured Resource'],
            ['key'=>'field_news_read_analysis',     'label'=>'Read Analysis Link Text', 'name'=>'news_read_analysis',     'type'=>'text','default_value'=>'Read the full analysis'],
            // Tab: Article Grid
            ['key'=>'field_news_tab_grid','label'=>'Article Grid','name'=>'','type'=>'tab','placement'=>'top','endpoint'=>0],
            ['key'=>'field_news_read_more',         'label'=>'Read More Link Text',     'name'=>'news_read_more',         'type'=>'text','default_value'=>'Read More'],
            ['key'=>'field_news_no_results',        'label'=>'No Results Message',      'name'=>'news_no_results',        'type'=>'text','default_value'=>'No articles found. Try a different search or filter.'],
        ],
        'location'=> [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/template-news.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top','instruction_placement'=>'label',
    ]);
}

// ─── NEWS CUSTOM POST TYPE / TAXONOMY ────────────────────────────────────────

add_action('init', 'mi_register_post_types');
function mi_register_post_types() {
    // News taxonomy (post category replacement with named types)
    register_taxonomy('news_type', 'post', [
        'labels' => [
            'name'          => __('Content Types', 'motion-informatics'),
            'singular_name' => __('Content Type', 'motion-informatics'),
            'all_items'     => __('All Types', 'motion-informatics'),
            'add_new_item'  => __('Add New Type', 'motion-informatics'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_in_nav_menus' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'news-type'],
        'query_var'         => true,
    ]);
}

// ─── LEADS — STORAGE + ADMIN UI ──────────────────────────────────────────────

add_action('init', 'mi_register_leads_cpt');
function mi_register_leads_cpt() {
    register_post_type('mi_lead', [
        'label'             => __('Leads', 'motion-informatics'),
        'labels'            => [
            'name'               => __('Leads', 'motion-informatics'),
            'singular_name'      => __('Lead', 'motion-informatics'),
            'menu_name'          => __('Leads', 'motion-informatics'),
            'all_items'          => __('All Leads', 'motion-informatics'),
            'view_item'          => __('View Lead', 'motion-informatics'),
            'edit_item'          => __('Lead Details', 'motion-informatics'),
            'search_items'       => __('Search Leads', 'motion-informatics'),
            'not_found'          => __('No leads yet — they will appear here when forms are submitted.', 'motion-informatics'),
            'not_found_in_trash' => __('No leads found in Trash.', 'motion-informatics'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'show_in_rest'        => false,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-email-alt',
        'capability_type'     => 'post',
        'capabilities'        => ['create_posts' => 'do_not_allow'], // disable manual "Add New"
        'map_meta_cap'        => true,
        'supports'            => ['title'],
        'has_archive'         => false,
        'rewrite'             => false,
        'exclude_from_search' => true,
    ]);
}

/**
 * Persist a form submission as a lead record. Stores all scalar values from
 * $data as post_meta with the prefix _mi_, so they are searchable + filterable.
 */
function mi_save_lead(array $data) {
    $first = trim((string)($data['first_name'] ?? ''));
    $last  = trim((string)($data['last_name']  ?? ''));
    $name  = trim($first . ' ' . $last);
    $email = (string)($data['email'] ?? '');
    $title = $name ?: ($email ?: __('(no name)', 'motion-informatics'));
    if ($email && $name) $title = $name . ' — ' . $email;

    $post_id = wp_insert_post([
        'post_type'    => 'mi_lead',
        'post_title'   => $title,
        'post_status'  => 'publish',
        'post_content' => (string)($data['message'] ?? ''),
    ], true);
    if (!$post_id || is_wp_error($post_id)) return 0;

    foreach ($data as $k => $v) {
        if (!is_scalar($v) || $v === '' || $v === null) continue;
        update_post_meta($post_id, '_mi_' . $k, (string)$v);
    }
    return $post_id;
}

// Custom admin columns
add_filter('manage_mi_lead_posts_columns', function ($cols) {
    $new = [];
    $new['cb']        = $cols['cb'] ?? '<input type="checkbox" />';
    $new['title']     = __('Lead', 'motion-informatics');
    $new['mi_form']   = __('Form', 'motion-informatics');
    $new['mi_type']   = __('Lead Type', 'motion-informatics');
    $new['mi_email']  = __('Email', 'motion-informatics');
    $new['mi_phone']  = __('Phone', 'motion-informatics');
    $new['mi_company']= __('Company', 'motion-informatics');
    $new['date']      = __('Submitted', 'motion-informatics');
    return $new;
});

add_action('manage_mi_lead_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'mi_form':
            echo esc_html(get_post_meta($post_id, '_mi_form', true) ?: '—');
            break;
        case 'mi_type':
            $t = get_post_meta($post_id, '_mi_user_type', true);
            echo $t ? esc_html(ucfirst($t)) : '—';
            break;
        case 'mi_email':
            $e = get_post_meta($post_id, '_mi_email', true);
            echo $e ? '<a href="mailto:' . esc_attr($e) . '">' . esc_html($e) . '</a>' : '—';
            break;
        case 'mi_phone':
            echo esc_html(get_post_meta($post_id, '_mi_phone', true) ?: '—');
            break;
        case 'mi_company':
            echo esc_html(get_post_meta($post_id, '_mi_company', true) ?: '—');
            break;
    }
}, 10, 2);

// Filter dropdowns above the leads list
add_action('restrict_manage_posts', function ($post_type) {
    if ($post_type !== 'mi_lead') return;

    global $wpdb;
    $forms = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_mi_form' AND meta_value != '' ORDER BY meta_value");
    $types = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_mi_user_type' AND meta_value != '' ORDER BY meta_value");

    $cur_form = $_GET['mi_form_filter'] ?? '';
    $cur_type = $_GET['mi_type_filter'] ?? '';
    ?>
    <select name="mi_form_filter">
        <option value=""><?php _e('All Forms', 'motion-informatics'); ?></option>
        <?php foreach ($forms as $f): ?>
        <option value="<?php echo esc_attr($f); ?>" <?php selected($cur_form, $f); ?>><?php echo esc_html($f); ?></option>
        <?php endforeach; ?>
    </select>
    <select name="mi_type_filter">
        <option value=""><?php _e('All Lead Types', 'motion-informatics'); ?></option>
        <?php foreach ($types as $t): ?>
        <option value="<?php echo esc_attr($t); ?>" <?php selected($cur_type, $t); ?>><?php echo esc_html(ucfirst($t)); ?></option>
        <?php endforeach; ?>
    </select>
    <?php
});

// Apply the filter values to the query
add_action('pre_get_posts', function ($query) {
    if (!is_admin() || !$query->is_main_query()) return;
    if ($query->get('post_type') !== 'mi_lead') return;
    $mq = [];
    if (!empty($_GET['mi_form_filter'])) {
        $mq[] = ['key' => '_mi_form', 'value' => sanitize_text_field(wp_unslash($_GET['mi_form_filter']))];
    }
    if (!empty($_GET['mi_type_filter'])) {
        $mq[] = ['key' => '_mi_user_type', 'value' => sanitize_text_field(wp_unslash($_GET['mi_type_filter']))];
    }
    if ($mq) $query->set('meta_query', $mq);
});

// Detail metabox shown when opening a single lead
add_action('add_meta_boxes', function () {
    add_meta_box('mi_lead_details', __('Lead Details', 'motion-informatics'), 'mi_lead_details_metabox', 'mi_lead', 'normal', 'high');
});
function mi_lead_details_metabox($post) {
    $rows = get_post_meta($post->ID);
    $order = ['form','source_page','timestamp','first_name','last_name','email','phone','user_type','region','interest','company','company_url','role','message'];
    ksort($rows);
    echo '<table class="widefat striped" style="margin-top:8px;"><tbody>';
    $printed = [];
    foreach ($order as $field) {
        $key = '_mi_' . $field;
        if (empty($rows[$key])) continue;
        $printed[] = $key;
        $val = $rows[$key][0];
        $label = ucwords(str_replace('_', ' ', $field));
        if ($field === 'email') {
            $val = '<a href="mailto:' . esc_attr($val) . '">' . esc_html($val) . '</a>';
        } elseif (in_array($field, ['source_page','company_url'])) {
            $val = $val ? '<a href="' . esc_url($val) . '" target="_blank" rel="noopener">' . esc_html($val) . '</a>' : '—';
        } else {
            $val = nl2br(esc_html($val));
        }
        printf('<tr><th style="width:180px;text-align:left;padding:8px 12px;">%s</th><td style="padding:8px 12px;">%s</td></tr>', esc_html($label), $val);
    }
    // Render any extra fields not in $order, for forwards-compat
    foreach ($rows as $key => $values) {
        if (strpos($key, '_mi_') !== 0 || in_array($key, $printed, true)) continue;
        $label = ucwords(str_replace('_', ' ', substr($key, 4)));
        printf('<tr><th style="width:180px;text-align:left;padding:8px 12px;">%s</th><td style="padding:8px 12px;">%s</td></tr>', esc_html($label), nl2br(esc_html($values[0])));
    }
    echo '</tbody></table>';
}

// ─── CONTACT FORM AJAX ────────────────────────────────────────────────────────

add_action('wp_ajax_mi_contact_form',        'mi_handle_contact_form');
add_action('wp_ajax_nopriv_mi_contact_form', 'mi_handle_contact_form');
function mi_handle_contact_form() {
    check_ajax_referer('mi_form_nonce', 'nonce');

    $first_name   = sanitize_text_field($_POST['first_name']   ?? '');
    $last_name    = sanitize_text_field($_POST['last_name']    ?? '');
    $email        = sanitize_email($_POST['email']             ?? '');
    $phone_prefix = sanitize_text_field($_POST['phone_prefix'] ?? '');
    $phone        = sanitize_text_field($_POST['phone']        ?? '');
    $phone_full   = $phone_prefix . $phone;
    $message      = sanitize_textarea_field($_POST['message']  ?? '');
    $user_type    = sanitize_text_field($_POST['user_type']    ?? 'patient');
    $consent      = sanitize_text_field($_POST['consent']      ?? '');
    $source_page  = esc_url_raw($_POST['source_page']         ?? home_url('/contact'));

    // Pro/Distributor-specific fields
    $company      = sanitize_text_field($_POST['company']      ?? '');
    $company_url  = esc_url_raw($_POST['company_url']          ?? '');
    $role         = sanitize_text_field($_POST['role']         ?? '');

    $is_pro = in_array($user_type, ['professional', 'distributor']);

    // Validate required fields
    $required_ok = $first_name && $last_name && $email && is_email($email) && $phone && $consent === '1' && $message;
    if ($is_pro) $required_ok = $required_ok && $company && $company_url && $role;
    if (!$required_ok) {
        wp_send_json_error(['message' => __('Please fill in all required fields.', 'motion-informatics')]);
    }

    // reCAPTCHA v3 — TEMPORARILY NON-BLOCKING for debugging.
    // We log the result but no longer reject the submission on it. Re-enable
    // blocking once reCAPTCHA token generation is confirmed reliable (see TODO).
    $secret = get_option('mi_recaptcha_secret', '');
    $token  = sanitize_text_field($_POST['g-recaptcha-response'] ?? '');
    if ($secret) {
        if (!$token) {
            error_log('[MI reCAPTCHA] No token received from browser (script may not have loaded).');
        } else {
            $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
                'body' => ['secret' => $secret, 'response' => $token],
            ]);
            $result = json_decode(wp_remote_retrieve_body($verify), true);
            $score  = isset($result['score']) ? (float) $result['score'] : 0;
            error_log('[MI reCAPTCHA] success=' . (empty($result['success']) ? 'false' : 'true') . ' score=' . $score);
            // TODO: once reCAPTCHA is confirmed stable, restore blocking:
            // if (empty($result['success']) || $score < 0.3) {
            //     wp_send_json_error(['message' => __('Security check failed. Please try again.', 'motion-informatics')]);
            // }
        }
    }

    $to      = mi_get_form_recipients();
    $subject = sprintf('[Contact Form] %s from %s %s', ucfirst($user_type), $first_name, $last_name);

    if ($is_pro) {
        $body = "Form: Contact Form\nPage: {$source_page}\n\nName: {$first_name} {$last_name}\nEmail: {$email}\nPhone: {$phone_full}\nType: {$user_type}\nCompany: {$company}\nCompany URL: {$company_url}\nRole: {$role}\n\nMessage:\n{$message}";
    } else {
        $body = "Form: Contact Form\nPage: {$source_page}\n\nName: {$first_name} {$last_name}\nEmail: {$email}\nPhone: {$phone_full}\nType: patient\n\nMessage:\n{$message}";
    }

    $sent = wp_mail($to, $subject, $body, ['Reply-To: ' . $email]);

    $payload = array_filter([
        'form'        => 'Contact Form',
        'source_page' => $source_page,
        'timestamp'   => date('c'),
        'first_name'  => $first_name,
        'last_name'   => $last_name,
        'email'       => $email,
        'phone'       => $phone_full,
        'user_type'   => $user_type,
        'message'     => $message,
        'company'     => $company ?: null,
        'company_url' => $company_url ?: null,
        'role'        => $role ?: null,
    ]);
    mi_save_lead($payload);
    mi_send_webhook($payload);
    mi_send_monday($payload);

    if ($sent) {
        wp_send_json_success(['message' => __('Your message has been sent successfully!', 'motion-informatics')]);
    } else {
        wp_send_json_error(['message' => __('Failed to send message. Please try again.', 'motion-informatics')]);
    }
}

// ─── KYNARA CTA BUTTON CLICK NOTIFICATION ────────────────────────────────────

add_action('wp_ajax_mi_kynara_cta_click',        'mi_handle_kynara_cta_click');
add_action('wp_ajax_nopriv_mi_kynara_cta_click', 'mi_handle_kynara_cta_click');
function mi_handle_kynara_cta_click() {
    check_ajax_referer('mi_form_nonce', 'nonce');

    $button_text = sanitize_text_field($_POST['button_text'] ?? 'Kynara CTA button');
    $source_page = esc_url_raw($_POST['source_page'] ?? '');
    $ip          = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $user_agent  = sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? '');

    $to      = 'gary@motioninformatics.ai';
    $subject = '[Kynara] Someone clicked "' . $button_text . '"';
    $body    = "A visitor clicked the \"{$button_text}\" button on the Kynara page.\n\n"
             . "Page: {$source_page}\n"
             . "Time: " . date('Y-m-d H:i:s') . "\n"
             . "IP Address: {$ip}\n"
             . "Browser: {$user_agent}\n\n"
             . "Note: this confirms a click happened, not who clicked it — that information\n"
             . "only becomes available if they go on to submit the Contact form.";

    wp_mail($to, $subject, $body);

    wp_send_json_success();
}

// ─── DISTRIBUTOR FORM AJAX ───────────────────────────────────────────────────

add_action('wp_ajax_mi_distributor_form',        'mi_handle_distributor_form');
add_action('wp_ajax_nopriv_mi_distributor_form', 'mi_handle_distributor_form');
function mi_handle_distributor_form() {
    check_ajax_referer('mi_form_nonce', 'nonce');

    $name        = sanitize_text_field($_POST['full_name']  ?? '');
    $email       = sanitize_email($_POST['email']           ?? '');
    $phone       = sanitize_text_field($_POST['phone']      ?? '');
    $region      = sanitize_text_field($_POST['region']     ?? '');
    $interest    = sanitize_text_field($_POST['interest']   ?? '');
    $message     = sanitize_textarea_field($_POST['message']?? '');
    $source_page = esc_url_raw($_POST['source_page']        ?? home_url('/distributors'));

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => __('Please provide a valid email.', 'motion-informatics')]);
    }

    $to      = mi_get_form_recipients();
    $subject = sprintf(__('[Distributor Form] %s — %s', 'motion-informatics'), $name, $region);
    $body    = sprintf(
        "Form: Distributor Form\nPage: %s\n\nName: %s\nEmail: %s\nPhone: %s\nRegion: %s\nInterest: %s\n\nMessage:\n%s",
        $source_page, $name, $email, $phone ?: '—', $region, $interest, $message
    );

    $sent = wp_mail($to, $subject, $body, ['Reply-To: ' . $email]);

    $payload = [
        'form'        => 'Distributor Form',
        'source_page' => $source_page,
        'timestamp'   => date('c'),
        'first_name'  => $name,
        'last_name'   => '',
        'email'       => $email,
        'phone'       => $phone,
        'region'      => $region,
        'interest'    => $interest,
        'message'     => $message,
    ];
    mi_save_lead($payload);
    mi_send_webhook($payload);
    mi_send_monday($payload);

    if ($sent) {
        wp_send_json_success(['message' => __('Thank you! We will connect you with a local representative.', 'motion-informatics')]);
    } else {
        wp_send_json_error(['message' => __('Failed to send. Please try again.', 'motion-informatics')]);
    }
}

// ─── FORM NOTIFICATION RECIPIENTS ────────────────────────────────────────────

/**
 * Hard-coded default recipient list used when the option has never been saved.
 */
function mi_default_form_recipients(): string {
    return "ori@motioninformatics.ai\ngkobzafrani@gmail.com";
}

/**
 * Take user input from the textarea (newlines and/or commas) and return a clean
 * newline-separated list of valid email addresses.
 */
function mi_normalize_recipient_list(string $raw): string {
    $parts = preg_split('/[\s,;]+/', $raw);
    $clean = [];
    foreach ($parts as $p) {
        $email = sanitize_email(trim($p));
        if ($email && is_email($email) && !in_array($email, $clean, true)) {
            $clean[] = $email;
        }
    }
    return implode("\n", $clean);
}

/**
 * Resolve the recipients option to an array suitable for wp_mail().
 * Falls back to admin_email if nothing is configured.
 */
function mi_get_form_recipients(): array {
    $raw = get_option('mi_form_recipients', mi_default_form_recipients());
    $raw = mi_normalize_recipient_list($raw);
    if (!$raw) return [get_option('admin_email')];
    return array_filter(array_map('trim', explode("\n", $raw)));
}

// ─── WEBHOOK / CRM INTEGRATION ───────────────────────────────────────────────

/**
 * Admin settings page for webhook configuration.
 */
function mi_webhook_menu() {
    add_submenu_page(
        'options-general.php',
        __('CRM Webhook', 'motion-informatics'),
        __('CRM Webhook', 'motion-informatics'),
        'manage_options',
        'mi-webhook-settings',
        'mi_webhook_settings_page'
    );
}
add_action('admin_menu', 'mi_webhook_menu');

function mi_webhook_settings_page() {
    if (isset($_POST['mi_webhook_save']) && check_admin_referer('mi_webhook_nonce')) {
        $url = esc_url_raw(trim($_POST['mi_webhook_url'] ?? ''));
        update_option('mi_webhook_url', $url);
        $enabled = isset($_POST['mi_webhook_enabled']) ? '1' : '0';
        update_option('mi_webhook_enabled', $enabled);
        $recaptcha_secret = sanitize_text_field($_POST['mi_recaptcha_secret'] ?? '');
        update_option('mi_recaptcha_secret', $recaptcha_secret);
        $recaptcha_site = sanitize_text_field($_POST['mi_recaptcha_site'] ?? '');
        update_option('mi_recaptcha_site', $recaptcha_site);
        $recipients_raw = wp_unslash($_POST['mi_form_recipients'] ?? '');
        update_option('mi_form_recipients', mi_normalize_recipient_list($recipients_raw));
        $monday_token    = sanitize_text_field($_POST['mi_monday_token']    ?? '');
        update_option('mi_monday_token', $monday_token);
        $monday_board_id = sanitize_text_field($_POST['mi_monday_board_id'] ?? '');
        update_option('mi_monday_board_id', $monday_board_id);
        echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved.', 'motion-informatics') . '</p></div>';
    }

    $url              = get_option('mi_webhook_url', '');
    $enabled          = get_option('mi_webhook_enabled', '0');
    $recaptcha_secret = get_option('mi_recaptcha_secret', '');
    $recaptcha_site   = get_option('mi_recaptcha_site', '');
    $form_recipients  = get_option('mi_form_recipients', mi_default_form_recipients());
    $monday_token     = get_option('mi_monday_token', '');
    $monday_board_id  = get_option('mi_monday_board_id', '');
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            <span class="dashicons dashicons-share" style="font-size:28px;color:#3f3e6f;"></span>
            <?php _e('CRM Webhook Settings', 'motion-informatics'); ?>
        </h1>
        <p class="description"><?php _e('All form submissions (Contact, Distributor) will be sent to this webhook URL. Use this to connect to Monday.com, HubSpot, Zapier, or any CRM.', 'motion-informatics'); ?></p>
        <hr>
        <form method="post" action="">
            <?php wp_nonce_field('mi_webhook_nonce'); ?>

            <h2><?php _e('Email Notifications', 'motion-informatics'); ?></h2>
            <p class="description"><?php _e('Form submissions across the site (Contact, Distributor) will be sent as email notifications to every address listed below.', 'motion-informatics'); ?></p>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mi_form_recipients"><?php _e('Notification Recipients', 'motion-informatics'); ?></label></th>
                    <td>
                        <textarea id="mi_form_recipients" name="mi_form_recipients" rows="4" class="large-text code"
                                  placeholder="name@example.com&#10;another@example.com"><?php echo esc_textarea($form_recipients); ?></textarea>
                        <p class="description"><?php _e('One email address per line (or comma-separated). All forms across the site will notify each address listed here.', 'motion-informatics'); ?></p>
                    </td>
                </tr>
            </table>

            <h2><?php _e('Monday CRM (Direct)', 'motion-informatics'); ?></h2>
            <p class="description"><?php _e('When both fields below are filled in, every form submission creates a lead directly in Monday CRM — including the page the user came from. No Zapier needed.', 'motion-informatics'); ?></p>
            <?php if ($monday_token && $monday_board_id) : ?>
            <div style="background:#edf7ed;border:1px solid #4caf50;border-radius:6px;padding:12px 16px;margin:12px 0;display:flex;align-items:center;gap:8px;">
                <span class="dashicons dashicons-yes-alt" style="color:#4caf50;"></span>
                <strong><?php _e('Monday CRM is active.', 'motion-informatics'); ?></strong>
                <?php _e('Leads will be sent directly to your Monday board.', 'motion-informatics'); ?>
            </div>
            <?php endif; ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mi_monday_token"><?php _e('Monday API Token', 'motion-informatics'); ?></label></th>
                    <td>
                        <input type="text" id="mi_monday_token" name="mi_monday_token"
                               value="<?php echo esc_attr($monday_token); ?>"
                               class="large-text" placeholder="eyJhbGci...">
                        <p class="description"><?php _e('Monday.com → click your avatar (bottom-left) → Developers → My Access Tokens.', 'motion-informatics'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="mi_monday_board_id"><?php _e('Monday Board ID', 'motion-informatics'); ?></label></th>
                    <td>
                        <input type="text" id="mi_monday_board_id" name="mi_monday_board_id"
                               value="<?php echo esc_attr($monday_board_id); ?>"
                               class="large-text" placeholder="1234567890">
                        <p class="description"><?php _e('Open your Monday board → copy the number from the URL: monday.com/boards/XXXXXXXXXX', 'motion-informatics'); ?></p>
                    </td>
                </tr>
            </table>

            <h2><?php _e('CRM Webhook', 'motion-informatics'); ?></h2>            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mi_webhook_enabled"><?php _e('Enable Webhook', 'motion-informatics'); ?></label></th>
                    <td>
                        <input type="checkbox" id="mi_webhook_enabled" name="mi_webhook_enabled" value="1" <?php checked($enabled, '1'); ?>>
                        <label for="mi_webhook_enabled"><?php _e('Send form submissions to webhook', 'motion-informatics'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="mi_webhook_url"><?php _e('Webhook URL', 'motion-informatics'); ?></label></th>
                    <td>
                        <input type="url" id="mi_webhook_url" name="mi_webhook_url" value="<?php echo esc_attr($url); ?>"
                               class="large-text" placeholder="https://hooks.monday.com/... or https://hooks.zapier.com/...">
                        <p class="description"><?php _e('Paste the webhook URL from your CRM or automation tool.', 'motion-informatics'); ?></p>
                    </td>
                </tr>
            </table>

                <tr>
                    <th scope="row"><label for="mi_recaptcha_site"><?php _e('reCAPTCHA Site Key', 'motion-informatics'); ?></label></th>
                    <td>
                        <input type="text" id="mi_recaptcha_site" name="mi_recaptcha_site"
                               value="<?php echo esc_attr($recaptcha_site); ?>" class="large-text" placeholder="6Lc...">
                        <p class="description"><?php _e('Public site key from Google reCAPTCHA v3. Get one at google.com/recaptcha (choose reCAPTCHA v3, not v2).', 'motion-informatics'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="mi_recaptcha_secret"><?php _e('reCAPTCHA Secret Key', 'motion-informatics'); ?></label></th>
                    <td>
                        <input type="text" id="mi_recaptcha_secret" name="mi_recaptcha_secret"
                               value="<?php echo esc_attr($recaptcha_secret); ?>" class="large-text" placeholder="6Lc...">
                        <p class="description"><?php _e('Secret key (kept server-side only). reCAPTCHA activates on all forms only when both keys are filled in.', 'motion-informatics'); ?></p>
                    </td>
                </tr>
            </table>

            <?php if ($url && $enabled === '1') : ?>
            <div style="background:#edf7ed;border:1px solid #4caf50;border-radius:6px;padding:12px 16px;margin:12px 0;display:flex;align-items:center;gap:8px;">
                <span class="dashicons dashicons-yes-alt" style="color:#4caf50;"></span>
                <strong><?php _e('Webhook is active.', 'motion-informatics'); ?></strong>
                <?php _e('Form submissions will be forwarded to your CRM.', 'motion-informatics'); ?>
            </div>
            <?php elseif (!$url) : ?>
            <div style="background:#fff8e1;border:1px solid #ffc107;border-radius:6px;padding:12px 16px;margin:12px 0;display:flex;align-items:center;gap:8px;">
                <span class="dashicons dashicons-warning" style="color:#ff9800;"></span>
                <?php _e('No webhook URL set. Forms will only send email notifications.', 'motion-informatics'); ?>
            </div>
            <?php endif; ?>

            <h2><?php _e('Payload Preview', 'motion-informatics'); ?></h2>
            <p class="description"><?php _e('This is the JSON structure sent to your webhook on each form submission:', 'motion-informatics'); ?></p>
            <pre style="background:#1e1e2a;color:#9cdcfe;padding:16px;border-radius:8px;overflow-x:auto;font-size:13px;"><?php echo esc_html(json_encode([
                'form'         => 'contact | distributor',
                'timestamp'    => date('c'),
                'source_url'   => site_url(),
                'first_name'   => 'John',
                'last_name'    => 'Doe',
                'email'        => 'john@example.com',
                'organization' => 'Hospital Name',
                'user_type'    => 'clinician | patient | researcher',
                'region'       => '(distributor form only)',
                'interest'     => '(distributor form only)',
                'message'      => 'Message content...',
            ], JSON_PRETTY_PRINT)); ?></pre>

            <?php submit_button(__('Save Settings', 'motion-informatics'), 'primary', 'mi_webhook_save'); ?>
        </form>

        <?php if ($url) : ?>
        <h2><?php _e('Test Webhook', 'motion-informatics'); ?></h2>
        <p><?php _e('Send a test payload to verify your webhook is working:', 'motion-informatics'); ?></p>
        <?php
        if (isset($_POST['mi_webhook_test']) && check_admin_referer('mi_webhook_nonce')) {
            $result = mi_send_webhook([
                'form'         => 'test',
                'timestamp'    => date('c'),
                'source_url'   => site_url(),
                'first_name'   => 'Test',
                'last_name'    => 'Submission',
                'email'        => get_option('admin_email'),
                'organization' => 'Motion Informatics Test',
                'message'      => 'This is a test webhook payload from your WordPress site.',
            ]);
            if ($result) {
                echo '<div class="notice notice-success"><p>' . __('Test sent successfully! Check your CRM.', 'motion-informatics') . '</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>' . __('Test failed. Please check the webhook URL.', 'motion-informatics') . '</p></div>';
            }
        }
        ?>
        <form method="post" action="">
            <?php wp_nonce_field('mi_webhook_nonce'); ?>
            <?php submit_button(__('Send Test Payload', 'motion-informatics'), 'secondary', 'mi_webhook_test'); ?>
        </form>
        <?php endif; ?>
    </div>
    <?php
}

// ─── MONDAY CRM — DIRECT API ─────────────────────────────────────────────────

/**
 * Send a lead directly to Monday CRM via its GraphQL API.
 * Requires mi_monday_token and mi_monday_board_id set in Settings → CRM Webhook.
 *
 * Column IDs used (adjust to match your board):
 *   email_mm4kfk78     → Email column
 *   phone_mm4kr8xf     → Phone column
 *   text_mm4kxz6x      → Text column  (mapped to "Came from page" / source_page)
 *   long_text_mm4ktjh9 → Long Text column (message)
 *   date4              → Date column (submission date)
 *
 * Routes the item into the correct group based on user_type:
 *   patient       → topics
 *   professional  → group_mm4tby6e
 *   distributor   → group_mm4tn36w
 */
function mi_send_monday(array $data): bool {
    $token    = get_option('mi_monday_token', '');
    $board_id = (int) get_option('mi_monday_board_id', 0);

    if (!$token || !$board_id) return false;

    $first = trim((string)($data['first_name'] ?? ''));
    $last  = trim((string)($data['last_name']  ?? ''));
    $name  = trim($first . ' ' . $last) ?: ($data['email'] ?? 'New Lead');

    // Region/Interest (distributor-only fields with no dedicated column) still
    // get folded into the message; Company/URL/Role now have their own columns.
    $message = (string)($data['message'] ?? '');
    $extra_bits = array_filter([
        !empty($data['region'])   ? 'Region: '   . $data['region']   : null,
        !empty($data['interest']) ? 'Interest: ' . $data['interest'] : null,
    ]);
    if ($extra_bits) {
        $message = implode("\n", $extra_bits) . "\n\n" . $message;
    }

    $columns_raw = [
        'email_mm4kfk78'     => ['email' => $data['email'] ?? '', 'text' => $data['email'] ?? ''],
        'phone_mm4kr8xf'     => ['phone' => $data['phone'] ?? '', 'countryShortName' => 'IL'],
        'text_mm4kxz6x'      => $data['source_page'] ?? '',
        'long_text_mm4ktjh9' => ['text' => $message],
        'date4'              => ['date' => date('Y-m-d')],
        'text_mm4tx9tw'      => $data['company'] ?? '',
        'text_mm4t2hw8'      => $data['role'] ?? '',
    ];
    if (!empty($data['company_url'])) {
        $columns_raw['link_mm4t6ct8'] = ['url' => $data['company_url'], 'text' => $data['company_url']];
    }
    $column_values = wp_json_encode($columns_raw);

    // Route to the matching group based on lead type
    $group_map = [
        'patient'      => 'topics',
        'professional' => 'group_mm4tby6e',
        'distributor'  => 'group_mm4tn36w',
    ];
    $user_type = $data['user_type'] ?? 'patient';
    $group_id  = $group_map[$user_type] ?? 'topics';

    $mutation = sprintf(
        'mutation { create_item (board_id: %d, group_id: %s, item_name: %s, column_values: %s) { id } }',
        $board_id,
        json_encode($group_id),
        json_encode($name),
        json_encode($column_values)
    );

    $response = wp_remote_post('https://api.monday.com/v2', [
        'headers' => [
            'Authorization' => $token,
            'Content-Type'  => 'application/json',
            'API-Version'   => '2024-01',
        ],
        'body'    => wp_json_encode(['query' => $mutation]),
        'timeout' => 15,
    ]);

    if (is_wp_error($response)) return false;
    $body = json_decode(wp_remote_retrieve_body($response), true);
    return !empty($body['data']['create_item']['id']);
}

/**
 * Send data to the configured webhook URL.
 * Returns true on HTTP 2xx, false otherwise.
 */
function mi_send_webhook(array $data): bool {
    $url     = get_option('mi_webhook_url', '');
    $enabled = get_option('mi_webhook_enabled', '0');

    if (!$enabled || !$url || !filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    $response = wp_remote_post($url, [
        'headers'     => ['Content-Type' => 'application/json'],
        'body'        => wp_json_encode($data),
        'timeout'     => 10,
        'data_format' => 'body',
    ]);

    if (is_wp_error($response)) {
        return false;
    }

    return wp_remote_retrieve_response_code($response) < 300;
}

// ─── HELPER FUNCTIONS ────────────────────────────────────────────────────────

/**
 * Get an ACF field value with fallback.
 */
function mi_field(string $field_name, $post_id = false, string $fallback = ''): string {
    if (!function_exists('get_field')) return $fallback;
    // If no explicit post_id, use get_the_ID() which is more reliable than ACF's false default
    $resolved_id = ($post_id !== false) ? $post_id : get_the_ID();
    $value = get_field($field_name, $resolved_id);
    // Handle image/file fields that return arrays (e.g. return_format='array')
    if (is_array($value)) {
        $value = $value['url'] ?? ($value['src'] ?? '');
    }
    return (string)($value ?: $fallback);
}

/**
 * Output an ACF image as an <img> tag with lazy loading and alt text.
 */
function mi_image(string $field_name, string $class = '', string $size = 'large', $post_id = false): void {
    if (!function_exists('get_field')) return;
    $image = get_field($field_name, $post_id);
    if (!$image) return;

    if (is_array($image)) {
        $url = $image['sizes'][$size] ?? $image['url'];
        $alt = $image['alt'] ?: $image['title'];
    } else {
        $url = $image;
        $alt = '';
    }
    echo '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($class) . '" loading="lazy">';
}

/**
 * Get background image style string from ACF image field.
 */
function mi_bg_image(string $field_name, $post_id = false): string {
    if (!function_exists('get_field')) return '';
    $image = get_field($field_name, $post_id);
    if (!$image) return '';
    $url = is_array($image) ? ($image['url'] ?? '') : $image;
    return $url ? 'background-image: url(' . esc_url($url) . ');' : '';
}

/**
 * Extract YouTube video ID from any common URL form. Returns '' if not a YouTube URL.
 * Supports: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID, youtube.com/shorts/ID, youtube-nocookie.com/embed/ID
 */
function mi_youtube_id(string $url): string {
    if (!$url) return '';
    if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?v=|embed/|shorts/|v/)|youtu\.be/)([A-Za-z0-9_\-]{6,20})~i', $url, $m)) {
        return $m[1];
    }
    return '';
}

/**
 * Render news type badge with appropriate color.
 */
function mi_news_badge(string $type): string {
    // Inline colors so the badge always renders, even before Tailwind CDN finishes loading.
    $colors = [
        'Case Study'    => '#2563eb', // blue-600
        'Brochure'      => '#16a34a', // green-600
        'News'          => '#ea580c', // orange-600
        'Article'       => '#3f3e6f', // primary
        'Press Release' => '#9333ea', // purple-600
        'Whitepaper'    => '#4b5563', // gray-600
    ];
    $hex = $colors[$type] ?? '#3f3e6f';
    return '<span class="inline-block px-2 py-1 text-white text-[10px] font-bold rounded shadow-sm uppercase" style="background-color:' . esc_attr($hex) . ';color:#ffffff;">' . esc_html($type) . '</span>';
}

// ─── YOAST SEO COMPATIBILITY ─────────────────────────────────────────────────

// Remove duplicate title if Yoast is active
add_filter('wpseo_metabox_prio', function() { return 'low'; });

// ─── ACCESSIBILITY: SKIP LINK ────────────────────────────────────────────────

add_action('wp_body_open', function() {
    echo '<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[9999] focus:px-4 focus:py-2 focus:bg-primary focus:text-white focus:rounded-lg focus:font-bold">' . __('Skip to main content', 'motion-informatics') . '</a>';
});
