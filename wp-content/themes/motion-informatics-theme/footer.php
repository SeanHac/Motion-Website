<!-- ═══════════════════════════════════════════════════════════════════════════
     SITE FOOTER
═══════════════════════════════════════════════════════════════════════════ -->
<footer class="bg-white dark:bg-background-dark border-t border-gray-100 dark:border-gray-800 py-16 px-6 lg:px-20"
        role="contentinfo">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">

        <!-- Brand Column -->
        <div class="col-span-1 md:col-span-1">
            <a href="<?php echo home_url('/'); ?>" class="flex items-center mb-6" aria-label="<?php bloginfo('name'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mi-logo.png"
                     alt="<?php bloginfo('name'); ?>"
                     class="mi-logo-light h-10 w-auto object-contain">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mi-logo-white.png"
                     alt="<?php bloginfo('name'); ?>"
                     class="mi-logo-dark h-10 w-auto object-contain">
            </a>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                <?php echo esc_html(function_exists('get_field') ? (get_field('mi_footer_desc', 'option') ?: 'Advanced neuromuscular solutions for clinical excellence. Proudly serving medical professionals worldwide.') : 'Advanced neuromuscular solutions for clinical excellence. Proudly serving medical professionals worldwide.'); ?>
            </p>
            <div class="flex gap-4" aria-label="<?php _e('Social Links', 'motion-informatics'); ?>">
                <a href="mailto:<?php echo esc_attr(function_exists('get_field') ? (get_field('mi_contact_email', 'option') ?: 'wecare@motioninformatics.ai') : 'wecare@motioninformatics.ai'); ?>"
                   class="text-gray-400 hover:text-primary dark:hover:text-accent-teal transition-colors"
                   aria-label="<?php _e('Email Us', 'motion-informatics'); ?>">
                    <span class="material-symbols-outlined" aria-hidden="true">alternate_email</span>
                </a>
                <?php
                $li_url = function_exists('get_field') ? (get_field('mi_linkedin_url', 'option') ?: 'https://www.linkedin.com/company/motion-informatics') : 'https://www.linkedin.com/company/motion-informatics';
                $fb_url = function_exists('get_field') ? (get_field('mi_facebook_url', 'option') ?: 'https://www.facebook.com/motioninformatics') : 'https://www.facebook.com/motioninformatics';
                ?>
                <a href="<?php echo esc_url($li_url); ?>" target="_blank" rel="noopener noreferrer"
                   class="text-gray-400 hover:text-primary dark:hover:text-accent-teal transition-colors"
                   aria-label="<?php _e('LinkedIn (opens in new tab)', 'motion-informatics'); ?>">
                    <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
                <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener noreferrer"
                   class="text-gray-400 hover:text-primary dark:hover:text-accent-teal transition-colors"
                   aria-label="<?php _e('Facebook (opens in new tab)', 'motion-informatics'); ?>">
                    <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Products Column -->
        <nav aria-label="<?php _e('Products Footer Links', 'motion-informatics'); ?>">
            <h3 class="font-bold mb-6 dark:text-white text-[#131316]"><?php _e('Products', 'motion-informatics'); ?></h3>
            <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                <?php
                $stimel_page  = get_page_by_path('stimel-03');
                $spatial_page = get_page_by_path('spatial-stimelmd');
                $contact_page = get_page_by_path('contact');
                ?>
                <li><a href="<?php echo $stimel_page  ? get_permalink($stimel_page)  : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors">STIMEL-03<sup style="font-size:0.6em;vertical-align:super">®</sup></a></li>
                <li><a href="<?php echo $spatial_page ? get_permalink($spatial_page) : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors">Spatial StimelMD<sup style="font-size:0.6em;vertical-align:super">®</sup></a></li>
                <li><a href="#" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Accessories', 'motion-informatics'); ?></a></li>
                <li><a href="<?php echo $contact_page ? get_permalink($contact_page) : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Support', 'motion-informatics'); ?></a></li>
            </ul>
        </nav>

        <!-- Company Column -->
        <nav aria-label="<?php _e('Company Footer Links', 'motion-informatics'); ?>">
            <h3 class="font-bold mb-6 dark:text-white text-[#131316]"><?php _e('Company', 'motion-informatics'); ?></h3>
            <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                <?php
                $about_page = get_page_by_path('about-us');
                $dist_page  = get_page_by_path('distributors');
                $news_page  = get_page_by_path('news');
                ?>
                <li><a href="<?php echo $about_page ? get_permalink($about_page) : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('About Us', 'motion-informatics'); ?></a></li>
                <li><a href="<?php echo $dist_page  ? get_permalink($dist_page)  : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Distributors', 'motion-informatics'); ?></a></li>
                <li><a href="<?php echo $news_page  ? get_permalink($news_page)  : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('News & Press', 'motion-informatics'); ?></a></li>
                <li><a href="<?php echo $contact_page ? get_permalink($contact_page) : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Contact', 'motion-informatics'); ?></a></li>
            </ul>
        </nav>

        <!-- Contact Column -->
        <div>
            <h3 class="font-bold mb-6 dark:text-white text-[#131316]"><?php _e('Get In Touch', 'motion-informatics'); ?></h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                <?php _e('Interested in our neuromuscular solutions? Contact our clinical specialists for a personalized demonstration.', 'motion-informatics'); ?>
            </p>
            <?php $contact_url = ($cp = get_page_by_path('contact')) ? get_permalink($cp) : '#'; ?>
            <a href="<?php echo esc_url($contact_url); ?>"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-lg text-white text-sm font-bold transition-all hover:brightness-110"
               style="background-color:#3f3e6f;">
                <span class="material-symbols-outlined text-base" aria-hidden="true">mail</span>
                <?php _e('Contact Us', 'motion-informatics'); ?>
            </a>
            <div class="mt-6 flex gap-4">
                <?php
                $li_url2 = function_exists('get_field') ? (get_field('mi_linkedin_url', 'option') ?: 'https://www.linkedin.com/company/motion-informatics') : 'https://www.linkedin.com/company/motion-informatics';
                $fb_url2 = function_exists('get_field') ? (get_field('mi_facebook_url', 'option') ?: 'https://www.facebook.com/motioninformatics') : 'https://www.facebook.com/motioninformatics';
                ?>
                <a href="<?php echo esc_url($li_url2); ?>" target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-2 text-sm text-gray-500 hover:text-primary dark:hover:text-accent-teal transition-colors"
                   aria-label="<?php _e('Follow us on LinkedIn', 'motion-informatics'); ?>">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    LinkedIn
                </a>
                <a href="<?php echo esc_url($fb_url2); ?>" target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-2 text-sm text-gray-500 hover:text-primary dark:hover:text-accent-teal transition-colors"
                   aria-label="<?php _e('Follow us on Facebook', 'motion-informatics'); ?>">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Bottom Bar -->
    <div class="max-w-7xl mx-auto border-t border-gray-100 dark:border-gray-800 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-400">
        <p>
            <?php echo esc_html(function_exists('get_field') ? (get_field('mi_copyright', 'option') ?: '© ' . date('Y') . ' Motion Informatics. All rights reserved.') : '© ' . date('Y') . ' Motion Informatics. All rights reserved.'); ?>
        </p>
        <nav class="flex gap-8" aria-label="<?php _e('Legal Links', 'motion-informatics'); ?>">
            <?php
            $privacy_page = get_page_by_path('privacy-policy');
            $terms_page   = get_page_by_path('terms-of-service');
            ?>
            <a href="<?php echo $privacy_page ? get_permalink($privacy_page) : get_privacy_policy_url(); ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Privacy Policy', 'motion-informatics'); ?></a>
            <a href="<?php echo $terms_page ? get_permalink($terms_page) : '#'; ?>" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Terms of Service', 'motion-informatics'); ?></a>
            <a href="#" class="hover:text-primary dark:hover:text-accent-teal transition-colors"><?php _e('Compliance', 'motion-informatics'); ?></a>
        </nav>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
