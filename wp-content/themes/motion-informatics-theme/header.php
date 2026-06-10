<!DOCTYPE html>
<html <?php language_attributes(); ?> class="light">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <!-- Inline dark-mode: always works regardless of CSS caching -->
    <style>
        html.dark body{background-color:#16161c!important;color:#f3f4f6!important}
        html.dark .glass-nav{background-color:rgba(22,22,28,0.92)!important}
        /* Logo switching — dark mode removed; dark logo CSS kept but html.dark never fires */
        .mi-logo-light{display:block}
        .mi-logo-dark{display:none}
        html.dark .mi-logo-light{display:none!important}
        html.dark .mi-logo-dark{display:block!important}
        /* Contact button reliable color */
        .mi-contact-btn{background-color:#3f3e6f!important;color:#ffffff!important}
        .mi-contact-btn:hover{background-color:#2d2c5a!important}
        .mi-contact-mobile{background-color:#3f3e6f!important;color:#ffffff!important}
        /* Outline product button */
        .mi-outline-btn{border:2px solid #3f3e6f;color:#3f3e6f;transition:all .3s}
        .mi-outline-btn:hover{background-color:#3f3e6f!important;color:#ffffff!important}
        html.dark .mi-outline-btn{border-color:#2D9DA8;color:#2D9DA8}
        html.dark .mi-outline-btn:hover{background-color:#2D9DA8!important;color:#ffffff!important}
        /* Ochre CTA button */
        .mi-btn-ochre{background-color:#CC7722!important;color:#fff!important}
        .mi-btn-ochre:hover{filter:brightness(1.1)}
        /* Cap icon group hover */
        .group:hover .cap-icon-wrap{background-color:#3f3e6f!important;color:#ffffff!important}
        /* WordPress admin bar: shift nav down and add extra top padding */
        .admin-bar .glass-nav{top:32px!important}
        .admin-bar main#main-content{padding-top:calc(5rem + 32px)!important}
        @media screen and (max-width:782px){
            .admin-bar .glass-nav{top:46px!important}
            .admin-bar main#main-content{padding-top:calc(5rem + 46px)!important}
        }
        /* Prevent FOUC: dark mode applied before paint */
    </style>
</head>

<body <?php body_class('font-display transition-colors duration-300'); ?>>
<?php wp_body_open(); ?>

<!-- ═══════════════════════════════════════════════════════════════════════════
     COOKIE CONSENT BANNER
═══════════════════════════════════════════════════════════════════════════ -->
<div id="mi-cookie-banner"
     role="alertdialog"
     aria-live="polite"
     aria-label="<?php _e('Cookie consent', 'motion-informatics'); ?>"
     style="display:none;position:fixed;bottom:0;left:0;right:0;z-index:99980;background:#ffffff;border-top:1px solid #e5e7eb;box-shadow:0 -4px 32px rgba(0,0,0,0.10);transition:transform .35s cubic-bezier(.4,0,.2,1),opacity .35s ease">
    <div style="max-width:1280px;margin:0 auto;padding:16px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px">
        <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">
            <span class="material-symbols-outlined" style="color:#3f3e6f;font-size:24px;flex-shrink:0;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24" aria-hidden="true">cookie</span>
            <p style="margin:0;font-size:13px;color:#374151;line-height:1.55">
                <?php _e('We use cookies to improve your experience and analyze site usage.', 'motion-informatics'); ?>
                <a href="<?php echo esc_url(get_page_by_path('contact') ? get_permalink(get_page_by_path('contact')) : '#'); ?>" style="color:#3f3e6f;font-weight:600;text-decoration:underline;margin-left:4px"><?php _e('Learn more', 'motion-informatics'); ?></a>
            </p>
        </div>
        <div style="display:flex;gap:10px;flex-shrink:0;align-items:center">
            <button id="mi-cookie-decline"
                    style="padding:9px 20px;border:1px solid #d1d5db;background:transparent;border-radius:8px;font-size:13px;font-weight:600;color:#6b7280;cursor:pointer;transition:border-color .2s,color .2s"
                    onmouseover="this.style.borderColor='#9ca3af';this.style.color='#374151'"
                    onmouseout="this.style.borderColor='#d1d5db';this.style.color='#6b7280'">
                <?php _e('Decline', 'motion-informatics'); ?>
            </button>
            <button id="mi-cookie-accept"
                    style="padding:9px 22px;background:#3f3e6f;border:none;border-radius:8px;font-size:13px;font-weight:700;color:#fff;cursor:pointer;transition:background .2s,transform .2s,box-shadow .2s;box-shadow:0 4px 14px -4px rgba(63,62,111,0.5)"
                    onmouseover="this.style.background='#2d2c5a';this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 20px -4px rgba(63,62,111,0.5)'"
                    onmouseout="this.style.background='#3f3e6f';this.style.transform='';this.style.boxShadow='0 4px 14px -4px rgba(63,62,111,0.5)'">
                <?php _e('Accept All', 'motion-informatics'); ?>
            </button>
        </div>
    </div>
</div>
<script>
(function(){
    var banner = document.getElementById('mi-cookie-banner');
    if (!localStorage.getItem('mi-cookies')) {
        // Small delay so it doesn't flash immediately on load
        setTimeout(function(){ banner.style.display = 'block'; }, 800);
    }
    function dismiss(val) {
        localStorage.setItem('mi-cookies', val);
        banner.style.transform = 'translateY(100%)';
        banner.style.opacity = '0';
        setTimeout(function(){ banner.style.display = 'none'; }, 380);
    }
    document.getElementById('mi-cookie-accept').addEventListener('click', function(){ dismiss('accepted'); });
    document.getElementById('mi-cookie-decline').addEventListener('click', function(){ dismiss('declined'); });
})();
</script>

<!-- ═══════════════════════════════════════════════════════════════════════════
     ACCESSIBILITY WIDGET (floating button + panel)
═══════════════════════════════════════════════════════════════════════════ -->
<div id="mi-a11y-widget" style="position:fixed;bottom:24px;right:24px;z-index:99999;font-family:inherit">

    <!-- Trigger button -->
    <button id="a11y-trigger"
            aria-label="<?php _e('Open accessibility options', 'motion-informatics'); ?>"
            aria-expanded="false"
            aria-controls="a11y-panel"
            style="width:52px;height:52px;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;background-color:#3f3e6f;color:#fff;box-shadow:0 4px 20px rgba(63,62,111,0.5);transition:transform .2s,box-shadow .2s">
        <span class="material-symbols-outlined" style="font-size:26px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">accessibility_new</span>
    </button>

    <!-- Panel -->
    <div id="a11y-panel"
         role="dialog"
         aria-label="<?php _e('Accessibility Options', 'motion-informatics'); ?>"
         style="display:none;position:absolute;bottom:64px;right:0;width:260px;background:#fff;border-radius:16px;box-shadow:0 8px 40px rgba(0,0,0,0.18);border:1px solid #e5e7eb;overflow:hidden">

        <div style="background:#3f3e6f;padding:14px 18px;display:flex;align-items:center;gap:8px">
            <span class="material-symbols-outlined" style="color:#fff;font-size:20px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">accessibility_new</span>
            <span style="color:#fff;font-size:13px;font-weight:700;letter-spacing:.05em;text-transform:uppercase"><?php _e('Accessibility', 'motion-informatics'); ?></span>
        </div>

        <div style="padding:16px;display:flex;flex-direction:column;gap:10px">

            <!-- Font size row -->
            <div style="display:flex;align-items:center;justify-content:space-between">
                <span style="font-size:12px;font-weight:600;color:#374151"><?php _e('Text Size', 'motion-informatics'); ?></span>
                <div style="display:flex;gap:4px">
                    <button class="a11y-tool-btn" id="a11y-font-decrease" aria-label="<?php _e('Decrease font size', 'motion-informatics'); ?>" title="A-">A-</button>
                    <button class="a11y-tool-btn" id="a11y-font-reset" aria-label="<?php _e('Reset font size', 'motion-informatics'); ?>" title="<?php _e('Reset', 'motion-informatics'); ?>">A</button>
                    <button class="a11y-tool-btn" id="a11y-font-increase" aria-label="<?php _e('Increase font size', 'motion-informatics'); ?>" title="A+">A+</button>
                </div>
            </div>

            <hr style="border:none;border-top:1px solid #f3f4f6;margin:2px 0">

            <!-- Toggle buttons -->
            <button class="a11y-toggle-btn" id="a11y-contrast" aria-pressed="false">
                <span class="material-symbols-outlined" style="font-size:18px">contrast</span>
                <?php _e('High Contrast', 'motion-informatics'); ?>
            </button>
            <button class="a11y-toggle-btn" id="a11y-grayscale" aria-pressed="false">
                <span class="material-symbols-outlined" style="font-size:18px">invert_colors</span>
                <?php _e('Grayscale', 'motion-informatics'); ?>
            </button>
            <button class="a11y-toggle-btn" id="a11y-dyslexia" aria-pressed="false">
                <span class="material-symbols-outlined" style="font-size:18px">font_download</span>
                <?php _e('Dyslexia Font', 'motion-informatics'); ?>
            </button>
            <button class="a11y-toggle-btn" id="a11y-stop-anim" aria-pressed="false">
                <span class="material-symbols-outlined" style="font-size:18px">motion_photos_off</span>
                <?php _e('Pause Animations', 'motion-informatics'); ?>
            </button>

            <hr style="border:none;border-top:1px solid #f3f4f6;margin:2px 0">

            <button class="a11y-tool-btn" id="a11y-reset"
                    style="width:100%;background:#fff5ee;color:#CC7722;border:1px solid #CC7722;border-radius:8px;padding:8px 12px;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px"
                    aria-label="<?php _e('Reset all accessibility settings', 'motion-informatics'); ?>">
                <span class="material-symbols-outlined" style="font-size:16px">restart_alt</span>
                <?php _e('Reset All', 'motion-informatics'); ?>
            </button>
        </div>
    </div>
</div>

<style>
.a11y-tool-btn{
    background:#f3f4f6;border:none;border-radius:8px;
    padding:6px 10px;font-size:12px;font-weight:700;
    cursor:pointer;transition:background .2s,color .2s;color:#374151
}
.a11y-tool-btn:hover{background:#3f3e6f;color:#fff}
.a11y-toggle-btn{
    display:flex;align-items:center;gap:10px;
    width:100%;background:#f9fafb;border:1px solid #e5e7eb;
    border-radius:10px;padding:10px 14px;font-size:13px;font-weight:500;
    cursor:pointer;transition:all .2s;color:#374151;text-align:left
}
.a11y-toggle-btn:hover{border-color:#3f3e6f;color:#3f3e6f}
.a11y-toggle-btn[aria-pressed="true"]{background:#3f3e6f;color:#fff;border-color:#3f3e6f}
.a11y-toggle-btn[aria-pressed="true"] .material-symbols-outlined{color:#2D9DA8}
/* dark panel */
html.dark #a11y-panel{background:#1e1e2a!important;border-color:#2d2d3d!important}
html.dark .a11y-tool-btn{background:#2d2d3d;color:#d1d5db}
html.dark .a11y-toggle-btn{background:#2d2d3d;border-color:#3d3d50;color:#d1d5db}
html.dark .a11y-toggle-btn:hover{border-color:#2D9DA8;color:#2D9DA8}
html.dark .a11y-toggle-btn[aria-pressed="true"]{background:#2D9DA8;border-color:#2D9DA8;color:#fff}
</style>

<!-- ═══════════════════════════════════════════════════════════════════════════
     NAVIGATION BAR
═══════════════════════════════════════════════════════════════════════════ -->
<header class="fixed top-0 left-0 right-0 z-50 h-20 glass-nav border-b border-[#f2f1f3] dark:border-gray-800 px-6 lg:px-20"
        role="banner">
    <div class="max-w-7xl mx-auto h-full flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center">
            <a href="<?php echo home_url('/'); ?>" aria-label="<?php bloginfo('name'); ?> — <?php _e('Home', 'motion-informatics'); ?>">
                <!-- Light mode logo -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mi-logo.png"
                     alt="<?php bloginfo('name'); ?>"
                     class="mi-logo-light h-14 w-auto md:h-[70px] object-contain"
                     loading="eager">
                <!-- Dark mode logo (white version) -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mi-logo-white.png"
                     alt="<?php bloginfo('name'); ?>"
                     class="mi-logo-dark h-14 w-auto md:h-[70px] object-contain"
                     loading="eager">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <?php
        $nav_stimel   = ($p = get_page_by_path('stimel-03'))       ? get_permalink($p) : '#';
        $nav_spatial  = ($p = get_page_by_path('spatial-stimelmd')) ? get_permalink($p) : '#';
        $nav_kinyara  = ($p = get_page_by_path('kinyara'))          ? get_permalink($p) : '#';
        $nav_home    = home_url('/');
        $nav_about   = ($p = get_page_by_path('about-us'))         ? get_permalink($p) : '#';
        $nav_news    = ($p = get_page_by_path('news'))             ? get_permalink($p) : '#';
        $nav_dist    = ($p = get_page_by_path('distributors'))     ? get_permalink($p) : '#';
        $nav_contact = ($p = get_page_by_path('contact'))          ? get_permalink($p) : '#';
        ?>
        <nav class="hidden md:flex items-center gap-8" role="navigation" aria-label="<?php _e('Primary Navigation', 'motion-informatics'); ?>">

            <a href="<?php echo esc_url($nav_home); ?>" class="text-sm font-semibold hover:text-[#2D9DA8] transition-colors"><?php _e('Home', 'motion-informatics'); ?></a>

            <!-- Products dropdown -->
            <div class="group relative" style="padding-top:0.75rem;padding-bottom:0.75rem;">
                <button type="button"
                        class="flex items-center gap-0.5 text-sm font-semibold transition-colors"
                        style="color:inherit;background:none;border:none;padding:0;line-height:inherit;cursor:pointer;"
                        aria-haspopup="true"
                        aria-expanded="false"
                        id="nav-products-btn">
                    <?php _e('Products', 'motion-informatics'); ?>
                    <span class="material-symbols-outlined transition-transform group-hover:rotate-180" style="font-size:16px;line-height:1;" aria-hidden="true">keyboard_arrow_down</span>
                </button>
                <div class="absolute top-full left-0 hidden group-hover:block group-focus-within:block w-56 bg-white dark:bg-gray-900 shadow-xl border border-gray-100 dark:border-gray-800 rounded-xl py-2"
                     role="menu"
                     aria-labelledby="nav-products-btn">
                    <a href="<?php echo esc_url($nav_stimel); ?>"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                       role="menuitem">
                        <span class="material-symbols-outlined text-base" style="color:#2D9DA8" aria-hidden="true">electrical_services</span>
                        STIMEL-03<sup style="font-size:0.6em;vertical-align:super">®</sup>
                    </a>
                    <a href="<?php echo esc_url($nav_spatial); ?>"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                       role="menuitem">
                        <span class="material-symbols-outlined text-base" style="color:#3f3e6f" aria-hidden="true">view_in_ar</span>
                        Spatial StimelMD<sup style="font-size:0.6em;vertical-align:super">®</sup>
                    </a>
                    <a href="<?php echo esc_url($nav_kinyara); ?>"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                       role="menuitem">
                        <span class="material-symbols-outlined text-base" style="color:#CC7722" aria-hidden="true">science</span>
                        Kinyara<sup style="font-size:0.6em;vertical-align:super">®</sup>
                        <span class="ml-auto text-[9px] font-bold px-1.5 py-0.5 rounded-full text-white" style="background-color:#CC7722;">Soon</span>
                    </a>
                </div>
            </div>

            <a href="<?php echo esc_url($nav_about); ?>"   class="text-sm font-semibold hover:text-[#2D9DA8] transition-colors"><?php _e('About Us', 'motion-informatics'); ?></a>
            <a href="<?php echo esc_url($nav_news); ?>"    class="text-sm font-semibold hover:text-[#2D9DA8] transition-colors"><?php _e('Insights', 'motion-informatics'); ?></a>
            <a href="<?php echo esc_url($nav_dist); ?>"    class="text-sm font-semibold hover:text-[#2D9DA8] transition-colors"><?php _e('Distributors', 'motion-informatics'); ?></a>
        </nav>

        <!-- Actions -->
        <div class="flex items-center gap-3">
            <!-- Contact CTA -->
            <a href="<?php echo esc_url($nav_contact); ?>"
               class="hidden md:flex mi-contact-btn min-w-[110px] items-center justify-center rounded-lg h-11 px-6 text-sm font-bold transition-all">
                <?php _e('Contact', 'motion-informatics'); ?>
            </a>

            <!-- Mobile hamburger -->
            <button id="mobile-menu-btn"
                    type="button"
                    class="md:hidden p-2 rounded-lg dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 transition-colors"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    aria-label="<?php _e('Open navigation menu', 'motion-informatics'); ?>">
                <span class="material-symbols-outlined hamburger-icon" aria-hidden="true">menu</span>
                <span class="material-symbols-outlined close-icon hidden" aria-hidden="true">close</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
         class="md:hidden hidden absolute top-full left-0 right-0 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 shadow-xl"
         style="background:rgba(255,255,255,0.97)"
         role="dialog"
         aria-label="<?php _e('Mobile Navigation', 'motion-informatics'); ?>">
        <nav class="max-w-7xl mx-auto px-6 py-6 flex flex-col gap-4" role="navigation">
            <?php
            $stimel_url   = ($sp = get_page_by_path('stimel-03'))       ? get_permalink($sp) : '#';
            $spatial_url  = ($sp = get_page_by_path('spatial-stimelmd')) ? get_permalink($sp) : '#';
            $kinyara_url  = ($sp = get_page_by_path('kinyara'))          ? get_permalink($sp) : '#';
            $about_url   = ($sp = get_page_by_path('about-us'))         ? get_permalink($sp) : '#';
            $news_url    = ($sp = get_page_by_path('news'))             ? get_permalink($sp) : '#';
            $contact_url = ($sp = get_page_by_path('contact'))          ? get_permalink($sp) : '#';
            ?>
            <div class="border-b border-gray-100 pb-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3"><?php _e('Products', 'motion-informatics'); ?></p>
                <a href="<?php echo esc_url($stimel_url); ?>"  class="block py-2 text-sm font-semibold">STIMEL-03<sup style="font-size:0.6em;vertical-align:super">®</sup></a>
                <a href="<?php echo esc_url($spatial_url); ?>" class="block py-2 text-sm font-semibold">Spatial StimelMD<sup style="font-size:0.6em;vertical-align:super">®</sup></a>
                <a href="<?php echo esc_url($kinyara_url); ?>" class="block py-2 text-sm font-semibold flex items-center gap-2">Kinyara<sup style="font-size:0.6em;vertical-align:super">®</sup> <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full text-white" style="background-color:#CC7722;">Soon</span></a>
            </div>
            <a href="<?php echo esc_url($about_url); ?>"   class="block py-2 text-sm font-semibold"><?php _e('About Us', 'motion-informatics'); ?></a>
            <a href="<?php echo esc_url($news_url); ?>"    class="block py-2 text-sm font-semibold"><?php _e('Insights', 'motion-informatics'); ?></a>
            <a href="<?php echo esc_url($contact_url); ?>"
               class="mi-contact-mobile mt-2 flex items-center justify-center rounded-lg h-12 px-6 text-sm font-bold">
                <?php _e('Contact Us', 'motion-informatics'); ?>
            </a>
        </nav>
    </div>
</header>
