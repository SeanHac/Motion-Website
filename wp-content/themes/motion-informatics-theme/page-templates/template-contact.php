<?php
/**
 * Template Name: Contact & Support
 * Template Post Type: page
 */
get_header(); ?>

<main id="main-content" class="pt-20">

<!-- ═══════════════════════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-20 px-6" aria-labelledby="contact-heading">
    <div class="max-w-4xl mx-auto text-center">
        <h1 id="contact-heading" class="text-5xl md:text-6xl font-black text-slate-900 dark:text-white mb-6 tracking-tight">
            <?php echo esc_html(mi_field('contact_heading', false, 'Get In Touch')); ?>
        </h1>
        <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
            <?php echo esc_html(mi_field('contact_desc', false, 'Dedicated support for our neuromuscular solutions. Connect with our expert team for technical inquiries, clinical support, or global partnership opportunities.')); ?>
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     MAIN: FORM + SIDEBAR
═══════════════════════════════════════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 lg:px-12 pb-24">
    <div class="grid lg:grid-cols-2 gap-16 items-start">

        <!-- Contact Form -->
        <div class="bg-white dark:bg-slate-900 p-8 md:p-10 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <?php
            $inp  = 'w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:border-transparent outline-none transition-all dark:text-white';
            $lbl  = 'text-sm font-semibold text-slate-700 dark:text-slate-300';
            $star = ' <span aria-hidden="true" class="text-red-500">*</span>';
            $consent_patient = mi_field('contact_consent_patient', false, 'I agree that Motion Informatics may contact me regarding my inquiry.');
            $consent_pro     = mi_field('contact_consent_pro',     false, 'I agree that Motion Informatics may contact me regarding partnership and commercial opportunities.');
            $recaptcha_key   = get_option('mi_recaptcha_site', '');
            $phone_prefixes  = [
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

            <form id="mi-contact-form" class="space-y-6" novalidate aria-label="<?php _e('Contact form', 'motion-informatics'); ?>">
                <?php wp_nonce_field('mi_form_nonce', '_wpnonce_contact'); ?>
                <input type="hidden" name="source_page" value="<?php echo esc_url(get_permalink()); ?>">
                <input type="hidden" name="user_type" id="mi_hidden_user_type" value="patient">

                <!-- Inquiry Type Selector (inside form) -->
                <div role="group" aria-labelledby="inquiry-type-label">
                    <p id="inquiry-type-label" class="text-sm font-bold uppercase tracking-widest mb-3" style="color:#3f3e6f;">
                        <?php echo esc_html(mi_field('contact_inquiry_label', false, 'Inquiry Type')); ?>
                    </p>
                    <div class="flex p-1 bg-slate-100 dark:bg-slate-800 rounded-xl" id="mi-type-switcher">
                        <?php
                        $types = [
                            'patient'      => mi_field('contact_type_patient',      false, 'Patient'),
                            'professional' => mi_field('contact_type_professional', false, 'Professional'),
                            'distributor'  => mi_field('contact_type_distributor',  false, 'Distributor'),
                        ];
                        foreach ($types as $value => $label) : ?>
                        <button type="button" data-type="<?php echo esc_attr($value); ?>"
                                class="mi-type-btn flex-1 text-center py-2.5 rounded-lg text-sm font-semibold transition-all text-slate-500 <?php echo $value === 'patient' ? 'bg-white dark:bg-slate-700 shadow-sm !text-[#3f3e6f]' : ''; ?>">
                            <?php echo esc_html($label); ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ── Shared fields ────────────────────────────────────────── -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="first_name" class="<?php echo $lbl; ?>"><?php echo esc_html(mi_field('contact_label_first', false, 'First Name')); ?><?php echo $star; ?></label>
                        <input id="first_name" name="first_name" type="text" class="<?php echo $inp; ?>"
                               placeholder="John" required autocomplete="given-name" aria-required="true">
                    </div>
                    <div class="space-y-2">
                        <label for="last_name" class="<?php echo $lbl; ?>"><?php echo esc_html(mi_field('contact_label_last', false, 'Last Name')); ?><?php echo $star; ?></label>
                        <input id="last_name" name="last_name" type="text" class="<?php echo $inp; ?>"
                               placeholder="Doe" required autocomplete="family-name" aria-required="true">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="contact_email" class="<?php echo $lbl; ?>"><?php echo esc_html(mi_field('contact_label_email', false, 'Email Address')); ?><?php echo $star; ?></label>
                    <input id="contact_email" name="email" type="email" class="<?php echo $inp; ?>"
                           placeholder="john.doe@example.com" required autocomplete="email" aria-required="true">
                </div>

                <!-- Phone with country prefix -->
                <div class="space-y-2">
                    <label for="contact_phone" class="<?php echo $lbl; ?>"><?php _e('Phone Number', 'motion-informatics'); ?><?php echo $star; ?></label>
                    <div class="flex border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden bg-slate-50 dark:bg-slate-800 focus-within:ring-2" style="--tw-ring-color:#3f3e6f;">
                        <select name="phone_prefix" autocomplete="tel-country-code"
                                class="bg-slate-100 dark:bg-slate-700 border-r border-slate-200 dark:border-slate-600 px-3 py-3 text-sm outline-none dark:text-white flex-shrink-0">
                            <?php foreach ($phone_prefixes as $code => $display):
                                $selected = ($code === '+972') ? 'selected' : ''; ?>
                            <option value="<?php echo esc_attr($code); ?>" <?php echo $selected; ?>><?php echo esc_html($display); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input id="contact_phone" name="phone" type="tel"
                               class="flex-1 bg-transparent px-4 py-3 text-sm outline-none dark:text-white min-w-0"
                               placeholder="50 000 0000" required autocomplete="tel-national" aria-required="true">
                    </div>
                </div>

                <!-- ── PATIENT section ───────────────────────────────────────── -->
                <div id="mi-section-patient" class="space-y-6">
                    <div class="space-y-2">
                        <label for="patient_message" class="<?php echo $lbl; ?>"><?php _e('Why are you contacting us?', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <textarea id="patient_message" name="message" rows="4"
                                  class="<?php echo $inp; ?> resize-none"
                                  placeholder="<?php echo esc_attr(mi_field('contact_placeholder_msg', false, 'How can our team help you?')); ?>"
                                  required aria-required="true"></textarea>
                    </div>
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="consent_patient" name="consent" value="1" required
                               class="mt-1 rounded border-slate-300 flex-shrink-0" style="accent-color:#3f3e6f;">
                        <label for="consent_patient" class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed cursor-pointer">
                            <?php echo esc_html($consent_patient); ?> <span class="text-red-500">*</span>
                        </label>
                    </div>
                </div>

                <!-- ── PROFESSIONAL / DISTRIBUTOR section ────────────────────── -->
                <div id="mi-section-pro" class="space-y-6 hidden">
                    <div class="space-y-2">
                        <label for="company" class="<?php echo $lbl; ?>"><?php _e('Company / Organization', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <input id="company" name="company" type="text" class="<?php echo $inp; ?>"
                               placeholder="Medical Solutions Ltd." autocomplete="organization" disabled>
                    </div>
                    <div class="space-y-2">
                        <label for="company_url" class="<?php echo $lbl; ?>"><?php _e('Company Website or LinkedIn URL', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <input id="company_url" name="company_url" type="url" class="<?php echo $inp; ?>"
                               placeholder="https://company.com or https://linkedin.com/company/..." disabled>
                    </div>
                    <div class="space-y-2">
                        <label for="role" class="<?php echo $lbl; ?>"><?php _e('Your Role / Position', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <input id="role" name="role" type="text" class="<?php echo $inp; ?>"
                               placeholder="Clinical Director" disabled>
                    </div>
                    <div class="space-y-2">
                        <label for="pro_message" class="<?php echo $lbl; ?>"><?php _e('Why are you contacting us?', 'motion-informatics'); ?><?php echo $star; ?></label>
                        <textarea id="pro_message" name="message" rows="4"
                                  class="<?php echo $inp; ?> resize-none"
                                  placeholder="<?php _e('Please describe your inquiry or partnership interest...', 'motion-informatics'); ?>"
                                  disabled></textarea>
                    </div>
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="consent_pro" name="consent" value="1"
                               class="mt-1 rounded border-slate-300 flex-shrink-0" style="accent-color:#3f3e6f;" disabled>
                        <label for="consent_pro" class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed cursor-pointer">
                            <?php echo esc_html($consent_pro); ?> <span class="text-red-500">*</span>
                        </label>
                    </div>
                </div>

                <!-- reCAPTCHA -->
                <!-- reCAPTCHA v3 — invisible, token injected by JS before submit -->
                <?php if ($recaptcha_key): ?>
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <?php endif; ?>

                <!-- Status message -->
                <div id="contact-form-status" class="hidden rounded-lg px-4 py-3 text-sm font-medium" role="alert" aria-live="polite"></div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full text-white py-4 rounded-lg font-bold text-lg transition-all flex items-center justify-center gap-2"
                            style="background-color:#3f3e6f;">
                        <?php echo esc_html(mi_field('contact_btn_send', false, 'Send Inquiry')); ?>
                        <span class="material-symbols-outlined" aria-hidden="true">send</span>
                    </button>
                </div>

                <!-- HIPAA Notice -->
                <div class="flex items-start gap-3 p-4 rounded-lg border" style="background-color:rgba(63,62,111,0.05);border-color:rgba(63,62,111,0.1);" role="note">
                    <span class="material-symbols-outlined text-xl flex-shrink-0" style="color:#3f3e6f;" aria-hidden="true">verified_user</span>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-normal">
                        <?php echo esc_html(mi_field('contact_hipaa_notice', false, 'Motion Informatics is committed to your privacy. This form is HIPAA compliant. All submitted data is encrypted and handled in accordance with healthcare privacy regulations.')); ?>
                    </p>
                </div>
            </form>

            <?php if ($recaptcha_key): ?>
            <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr($recaptcha_key); ?>" async defer></script>
            <?php endif; ?>
        </div>

        <!-- Contact Info Sidebar -->
        <aside class="space-y-10" aria-label="<?php _e('Contact Information', 'motion-informatics'); ?>">

            <!-- Email -->
            <div class="flex items-start gap-4 group">
                <div class="size-12 rounded-xl flex items-center justify-center transition-all flex-shrink-0" style="background-color:rgba(63,62,111,0.1);color:#3f3e6f;" aria-hidden="true">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 dark:text-white mb-1"><?php echo esc_html(mi_field('contact_email_label', false, 'Email Support')); ?></h2>
                    <?php $email = function_exists('get_field') ? (get_field('mi_contact_email', 'option') ?: 'wecare@motioninformatics.ai') : 'wecare@motioninformatics.ai'; ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="text-slate-600 dark:text-slate-400 transition-colors hover:text-[#3f3e6f]"><?php echo esc_html($email); ?></a>
                    <p class="text-xs text-slate-400 mt-1"><?php echo esc_html(mi_field('contact_email_response', false, 'Typical response within 24 hours.')); ?></p>
                </div>
            </div>

            <!-- Locations -->
            <?php
            $locs_raw = get_post_meta(get_the_ID(), 'contact_locations_json', true);
            $locations = ($locs_raw) ? json_decode($locs_raw, true) : null;
            if (!$locations) $locations = [['label'=>mi_field('contact_hq_label', false, 'Global HQ'), 'line1'=>'1200 Innovation Way, Suite 400', 'line2'=>'Cambridge, MA 02142, USA']];
            foreach ($locations as $loc) : ?>
            <div class="flex items-start gap-4 group">
                <div class="size-12 rounded-xl flex items-center justify-center transition-all flex-shrink-0" style="background-color:rgba(63,62,111,0.1);color:#3f3e6f;" aria-hidden="true">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 dark:text-white mb-1"><?php echo esc_html($loc['label'] ?? ''); ?></h2>
                    <address class="text-slate-600 dark:text-slate-400 not-italic">
                        <?php echo esc_html($loc['line1'] ?? ''); ?><br>
                        <?php echo esc_html($loc['line2'] ?? ''); ?>
                    </address>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Map -->
            <?php
            $map_url   = mi_field('contact_map_url');
            $map_label = mi_field('contact_map_label', false, 'Cambridge, MA');
            ?>
            <?php if ($map_url) : ?>
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
                <iframe src="<?php echo esc_url($map_url); ?>"
                        width="100%" height="100%"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?php printf(__('Map showing %s', 'motion-informatics'), esc_attr($map_label)); ?>"
                        class="absolute inset-0 w-full h-full"></iframe>
            </div>
            <?php else : ?>
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/contact-map.jpg'; ?>"
                     alt="<?php printf(__('Map showing %s', 'motion-informatics'), esc_attr($map_label)); ?>"
                     class="w-full h-full object-cover"
                     loading="lazy">
                <div class="absolute inset-0 flex items-center justify-center bg-slate-100/70 dark:bg-slate-800/70">
                    <div class="text-center p-6">
                        <span class="material-symbols-outlined text-4xl mb-2 block" style="color:rgba(63,62,111,0.5);" aria-hidden="true">map</span>
                        <p class="text-sm text-slate-500"><?php echo esc_html($map_label); ?></p>
                        <p class="text-xs text-slate-400 mt-1"><?php echo esc_html(mi_field('contact_map_placeholder', false, 'Add a Google Maps Embed URL in Theme Settings')); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Support Hours -->
            <div class="p-6 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900">
                <p class="text-sm font-medium mb-4 opacity-80"><?php echo esc_html(mi_field('contact_hours_label', false, 'Available Support Hours')); ?></p>
                <p class="text-lg font-bold">
                    <?php echo esc_html(function_exists('get_field') ? (get_field('mi_support_hours', 'option') ?: 'Mon — Fri | 08:00 - 20:00 EST') : 'Mon — Fri | 08:00 - 20:00 EST'); ?>
                </p>
            </div>
        </aside>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     FAQ SECTION
═══════════════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white dark:bg-slate-950/50 border-t border-slate-200 dark:border-slate-800" aria-labelledby="faq-heading">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 id="faq-heading" class="text-3xl font-black mb-4 text-[#131316] dark:text-white">
                <?php echo esc_html(mi_field('contact_faq_heading', false, 'Frequently Asked Questions')); ?>
            </h2>
            <p class="text-slate-600 dark:text-slate-400">
                <?php echo esc_html(mi_field('contact_faq_desc', false, 'Quick answers to common questions about our platform and support.')); ?>
            </p>
        </div>

        <?php
        $faqs_raw = get_post_meta(get_the_ID(), 'contact_faqs_json', true);
        $faqs = ($faqs_raw) ? json_decode($faqs_raw, true) : null;
        if (!$faqs) $faqs = function_exists('get_field') ? get_field('contact_faqs') : null;
        if (!$faqs) {
            $faqs = [
                ['question'=>'How do I access clinical data for my patients?',
                 'answer'  =>'Clinicians can access the Motion Informatics Portal using their institutional credentials. Once logged in, you can view real-time neuromuscular analytics and longitudinal data for all authorized patients.'],
                ['question'=>'Is the hardware compatible with legacy systems?',
                 'answer'  =>'Yes, our sensor arrays are designed with universal API bridges, allowing seamless integration with most modern Electronic Health Record (EHR) systems and legacy monitoring equipment via our secure gateway.'],
                ['question'=>'How is data security handled during clinical trials?',
                 'answer'  =>'We utilize AES-256 end-to-end encryption and strictly follow GDPR and HIPAA guidelines. All trial data is anonymized at the source before being transmitted to our secure cloud servers.'],
                ['question'=>'Who should I contact for technical support?',
                 'answer'  =>'For immediate technical assistance, please use the form above and select your inquiry type, or email our specialist team directly.'],
            ];
        }
        ?>

        <div class="space-y-4" role="list" aria-label="<?php _e('Frequently Asked Questions', 'motion-informatics'); ?>">
            <?php foreach ($faqs as $i => $faq) :
                $faq_id = 'faq-' . $i;
                $panel_id = 'faq-panel-' . $i;
            ?>
            <div class="faq-item border border-slate-200 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-900 overflow-hidden"
                 role="listitem">
                <button type="button"
                        class="faq-trigger w-full flex items-center justify-between p-6 text-left cursor-pointer"
                        aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                        aria-controls="<?php echo esc_attr($panel_id); ?>"
                        id="<?php echo esc_attr($faq_id); ?>">
                    <span class="text-lg font-bold text-slate-800 dark:text-slate-100 pr-4">
                        <?php echo esc_html($faq['question'] ?? ''); ?>
                    </span>
                    <span class="material-symbols-outlined transition-transform duration-300 flex-shrink-0 <?php echo $i === 0 ? 'rotate-180' : ''; ?>" style="color:#3f3e6f;" aria-hidden="true">expand_more</span>
                </button>
                <div id="<?php echo esc_attr($panel_id); ?>"
                     role="region"
                     aria-labelledby="<?php echo esc_attr($faq_id); ?>"
                     class="faq-panel px-6 pb-6 text-slate-600 dark:text-slate-400 leading-relaxed <?php echo $i === 0 ? '' : 'hidden'; ?>">
                    <?php echo wp_kses_post($faq['answer'] ?? ''); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</main>

<?php get_footer();
