<?php
/**
 * Plugin Name: MI Native Gallery Metaboxes
 * Description: Native WP metaboxes for galleries and repeater fields (replaces ACF Pro features).
 */

// ── Register metaboxes ────────────────────────────────────────────────────────
add_action('add_meta_boxes', function () {
    global $post;
    if (!$post) return;
    $tpl = get_post_meta($post->ID, '_wp_page_template', true);

    if ($tpl === 'page-templates/template-product-stimel.php') {
        add_meta_box('mi_s3_gallery', '📷 Product Gallery — STIMEL-03', function ($post) {
            mi_gallery_metabox($post->ID, 's3_gallery', 'field_s3_gallery');
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_differentiators', '🔷 Key Differentiator Cards — STIMEL-03', function ($post) {
            mi_repeater_metabox($post->ID, 's3_differentiators_json', [
                ['name'=>'icon',  'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'bolt', 'wide'=>false],
                ['name'=>'title', 'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',     'wide'=>false],
                ['name'=>'desc',  'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',     'wide'=>true],
            ], [
                ['icon'=>'memory',      'title'=>'Intent-Triggered Stimulation',    'desc'=>'Stimulation fires only when the patient\'s own muscle signal is detected — reinforcing voluntary effort rather than replacing it.'],
                ['icon'=>'sync',        'title'=>'Real-Time Timing Alignment',      'desc'=>'Stimulation is synchronized with neuromotor intent, not delivered on a fixed schedule.'],
                ['icon'=>'insights',    'title'=>'Adaptive Threshold Modulation',   'desc'=>'The system continuously adjusts EMG detection thresholds to account for muscle fatigue and changing baseline activity.'],
                ['icon'=>'device_hub',  'title'=>'Multi-Channel Precision',         'desc'=>'Up to 8 independent stimulation channels allow targeted activation of specific muscle groups simultaneously.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_stats', '📊 Closed-Loop Stats — STIMEL-03', function ($post) {
            mi_repeater_metabox($post->ID, 's3_stats_json', [
                ['name'=>'value', 'label'=>'Value (e.g. 94%)', 'type'=>'text', 'placeholder'=>'', 'wide'=>false],
                ['name'=>'label', 'label'=>'Label',             'type'=>'text', 'placeholder'=>'', 'wide'=>false],
            ], [
                ['value'=>'94%',   'label'=>'Stimulation Accuracy'],
                ['value'=>'<8ms',  'label'=>'Trigger Latency'],
                ['value'=>'12hrs', 'label'=>'Battery Life'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_specs', '📋 Technical Specifications — STIMEL-03', function ($post) {
            mi_repeater_metabox($post->ID, 's3_specs_json', [
                ['name'=>'parameter', 'label'=>'Parameter', 'type'=>'text',     'placeholder'=>'', 'wide'=>false],
                ['name'=>'value',     'label'=>'Value',     'type'=>'text',     'placeholder'=>'', 'wide'=>false],
                ['name'=>'notes',     'label'=>'Notes',     'type'=>'textarea', 'placeholder'=>'', 'wide'=>true],
            ], [
                ['parameter'=>'Stimulation Channels', 'value'=>'Up to 8',         'notes'=>'Independent multi-channel output'],
                ['parameter'=>'EMG Sample Rate',      'value'=>'2,000 Hz',        'notes'=>'Real-time intent detection'],
                ['parameter'=>'Pulse Width',          'value'=>'20–500 μs',       'notes'=>'Programmable per channel'],
                ['parameter'=>'Max Output Current',   'value'=>'120 mA',          'notes'=>'Per channel, adjustable'],
                ['parameter'=>'Battery Life',         'value'=>'Up to 12 hours',  'notes'=>'Full clinical session'],
                ['parameter'=>'Connectivity',         'value'=>'BLE 5.2 / USB-C', 'notes'=>'Wireless and wired sync'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_bio_bullets', '💡 Biofeedback Bullet Points — STIMEL-03', function ($post) {
            mi_repeater_metabox($post->ID, 's3_bio_bullets_json', [
                ['name'=>'bullet', 'label'=>'Bullet Point', 'type'=>'text', 'placeholder'=>'', 'wide'=>true],
            ], [
                ['bullet'=>'EMG-triggered stimulation with <8ms latency'],
                ['bullet'=>'Adaptive threshold modulation prevents over-stimulation'],
                ['bullet'=>'Real-time visual and auditory biofeedback'],
                ['bullet'=>'Session data logged for clinician review'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_benefits', '✅ Key Benefits — STIMEL-03', function ($post) {
            mi_repeater_metabox($post->ID, 's3_benefits_json', [
                ['name'=>'icon',  'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'bolt', 'wide'=>false],
                ['name'=>'title', 'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',     'wide'=>false],
                ['name'=>'desc',  'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',     'wide'=>true],
            ], [
                ['icon'=>'bolt',          'title'=>'Accelerated Motor Recovery',         'desc'=>'EMG-triggered stimulation reinforces voluntary intent in real time, driving faster functional gains and measurable improvement in activities of daily living.'],
                ['icon'=>'neurology',     'title'=>'Active Neuroplasticity Engagement',  'desc'=>'Synchronization of brain intent, visual biofeedback, and electrical stimulation strengthens motor pathways and supports durable neural rewiring.'],
                ['icon'=>'tune',          'title'=>'Personalized Patient-Specific Therapy','desc'=>'Individual EMG thresholds and adaptive stimulation parameters reduce fatigue, prevent over-stimulation, and align therapy with each patient\'s neuromuscular status.'],
                ['icon'=>'accessibility','title'=>'Early & Chronic Stage Applicability', 'desc'=>'High-sensitivity EMG detection enables intervention even when visible movement is minimal, supporting early post-stroke care and long-term rehabilitation.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_videos', '🎬 Demo Videos — STIMEL-03', function ($post) {
            $base = get_template_directory_uri();
            mi_videos_metabox($post->ID, 's3_videos_json', [
                ['url' => $base . '/assets/videos/stimel-main-demo.mp4'],
                ['url' => $base . '/assets/videos/stimel-wrist-demo.mp4'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_s3_videos_diff', '🎬 Videos — After Key Differentiators', function ($post) {
            mi_videos_metabox($post->ID, 's3_videos_diff_json', []);
        }, 'page', 'normal', 'high');
    }

    if ($tpl === 'page-templates/template-product-spatial.php') {
        add_meta_box('mi_sp_gallery', '📷 Product Gallery — Spatial StimelMD', function ($post) {
            mi_gallery_metabox($post->ID, 'sp_gallery', 'field_sp_gallery');
        }, 'page', 'normal', 'high');

        add_meta_box('mi_sp_immersive_bullets', '💡 AR & FES Bullet Points — SSMD', function ($post) {
            mi_repeater_metabox($post->ID, 'sp_immersive_bullets_json', [
                ['name'=>'bullet', 'label'=>'Bullet Point', 'type'=>'text', 'placeholder'=>'', 'wide'=>true],
            ], [
                ['bullet'=>'Real-time AR overlay guides voluntary movement attempts'],
                ['bullet'=>'FES activates target muscles synchronized with patient intent'],
                ['bullet'=>'Visual biofeedback reinforces correct movement patterns'],
                ['bullet'=>'Session data logged for clinical outcome tracking'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_sp_challenge_stats', '📊 Rehabilitation Gap Stats — SSMD', function ($post) {
            mi_repeater_metabox($post->ID, 'sp_challenge_stats_json', [
                ['name'=>'value',  'label'=>'Value (e.g. 68%)',  'type'=>'text',     'placeholder'=>'', 'wide'=>false],
                ['name'=>'label',  'label'=>'Label',             'type'=>'textarea', 'placeholder'=>'', 'wide'=>false],
                ['name'=>'source', 'label'=>'Source',            'type'=>'text',     'placeholder'=>'', 'wide'=>true],
            ], [
                ['value'=>'68%',  'label'=>'of stroke patients fail to complete prescribed rehabilitation', 'source'=>'WHO 2023'],
                ['value'=>'3.4x', 'label'=>'higher recovery rate with consistent biofeedback therapy',     'source'=>'Lancet Neurology'],
                ['value'=>'$47B', 'label'=>'annual cost of incomplete neurological rehabilitation globally','source'=>'Global Health Econ.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_sp_how_steps', '🔢 From Intent to Movement — Steps — SSMD', function ($post) {
            mi_repeater_metabox($post->ID, 'sp_how_steps_json', [
                ['name'=>'number', 'label'=>'Step Number (01, 02…)', 'type'=>'text',     'placeholder'=>'01', 'wide'=>false],
                ['name'=>'title',  'label'=>'Title',                 'type'=>'text',     'placeholder'=>'',   'wide'=>false],
                ['name'=>'desc',   'label'=>'Description',           'type'=>'textarea', 'placeholder'=>'',   'wide'=>true],
            ], [
                ['number'=>'01', 'title'=>'EMG Signal Capture',      'desc'=>'Surface electrodes detect micro-signals from voluntary muscle activation attempts, even at sub-threshold levels.'],
                ['number'=>'02', 'title'=>'AI Intent Decoding',       'desc'=>'BioRhythmIQ algorithms classify the signal in real time to determine patient intent and optimal stimulation parameters.'],
                ['number'=>'03', 'title'=>'Synchronized Stimulation', 'desc'=>'FES/NMES fires within milliseconds of intent detection, amplifying voluntary effort into functional movement.'],
                ['number'=>'04', 'title'=>'AR Visual Feedback',       'desc'=>'The patient receives immediate visual confirmation of the movement through the AR interface, reinforcing the neural pathway.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_sp_ai_cards', '🤖 AI Adaptability Cards — SSMD', function ($post) {
            mi_repeater_metabox($post->ID, 'sp_ai_cards_json', [
                ['name'=>'icon',  'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'smart_toy', 'wide'=>false],
                ['name'=>'color', 'label'=>'Color (accent / primary)','type'=>'text',    'placeholder'=>'accent',    'wide'=>false],
                ['name'=>'title', 'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',          'wide'=>false],
                ['name'=>'desc',  'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',          'wide'=>true],
            ], [
                ['icon'=>'psychology',  'color'=>'accent',  'title'=>'Neuromuscular Profiling',    'desc'=>'The system builds a unique neuromuscular profile for each patient session.'],
                ['icon'=>'tune',        'color'=>'primary', 'title'=>'Adaptive Threshold Control', 'desc'=>'Stimulation thresholds adjust dynamically to prevent muscle fatigue.'],
                ['icon'=>'timeline',    'color'=>'accent',  'title'=>'Progress Analytics',         'desc'=>'Session-by-session performance data is logged and visualized for clinicians.'],
                ['icon'=>'shield',      'color'=>'primary', 'title'=>'Safety Protocols',           'desc'=>'Built-in safety limits prevent over-stimulation and are configurable per patient.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_sp_specs', '📋 Technical Specifications — SSMD', function ($post) {
            mi_repeater_metabox($post->ID, 'sp_specs_json', [
                ['name'=>'title',   'label'=>'Section Title', 'type'=>'text',     'placeholder'=>'', 'wide'=>false],
                ['name'=>'content', 'label'=>'Content',       'type'=>'textarea', 'placeholder'=>'', 'wide'=>true],
            ], [
                ['title'=>'EMG Processing',    'content'=>'2,000 Hz sampling, real-time AI decoding, <8ms latency'],
                ['title'=>'Stimulation',       'content'=>'FES + NMES, up to 8 channels, 20–500μs pulse width, 0–120mA'],
                ['title'=>'AR Integration',    'content'=>'Compatible with major AR headsets, real-time overlay rendering'],
                ['title'=>'Connectivity',      'content'=>'BLE 5.2, USB-C, Wi-Fi for cloud sync'],
                ['title'=>'Battery',           'content'=>'Up to 10 hours clinical use, fast-charge capable'],
            ]);
        }, 'page', 'normal', 'high');
    }

    if ($tpl === 'page-templates/template-contact.php') {
        add_meta_box('mi_contact_locations', '📍 Office Locations', function ($post) {
            mi_repeater_metabox($post->ID, 'contact_locations_json', [
                ['name'=>'label',    'label'=>'Location Name', 'type'=>'text',     'placeholder'=>'Global HQ', 'wide'=>false],
                ['name'=>'line1',    'label'=>'Address Line 1','type'=>'text',     'placeholder'=>'',          'wide'=>false],
                ['name'=>'line2',    'label'=>'Address Line 2','type'=>'text',     'placeholder'=>'',          'wide'=>true],
            ], [
                ['label'=>'Global HQ', 'line1'=>'1200 Innovation Way, Suite 400', 'line2'=>'Cambridge, MA 02142, USA'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_contact_faqs', '❓ FAQ — Questions & Answers', function ($post) {
            mi_repeater_metabox($post->ID, 'contact_faqs_json', [
                ['name'=>'question', 'label'=>'Question', 'type'=>'text',     'placeholder'=>'', 'wide'=>true],
                ['name'=>'answer',   'label'=>'Answer',   'type'=>'textarea', 'placeholder'=>'', 'wide'=>true],
            ], [
                ['question'=>'How do I access clinical data for my patients?',    'answer'=>'Clinicians can access the Motion Informatics Portal using their institutional credentials. Once logged in, you can view real-time neuromuscular analytics and longitudinal data for all authorized patients.'],
                ['question'=>'Is the hardware compatible with legacy systems?',   'answer'=>'Yes, our sensor arrays are designed with universal API bridges, allowing seamless integration with most modern Electronic Health Record (EHR) systems and legacy monitoring equipment via our secure gateway.'],
                ['question'=>'How is data security handled during clinical trials?','answer'=>'We utilize AES-256 end-to-end encryption and strictly follow GDPR and HIPAA guidelines. All trial data is anonymized at the source before being transmitted to our secure cloud servers.'],
                ['question'=>'Who should I contact for technical support?',       'answer'=>'For immediate technical assistance, please use the form above and select your inquiry type, or email our specialist team directly.'],
            ]);
        }, 'page', 'normal', 'high');
    }

    if ($tpl === '' || $tpl === 'default') { // Homepage (front page)
        add_meta_box('mi_home_capabilities', '⚡ Clinical Capabilities — Homepage', function ($post) {
            mi_repeater_metabox($post->ID, 'home_capabilities_json', [
                ['name'=>'icon',  'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'star',   'wide'=>false],
                ['name'=>'title', 'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',       'wide'=>false],
                ['name'=>'desc',  'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',       'wide'=>true],
            ], [
                ['icon'=>'neurology',       'title'=>'EMG-Triggered Stimulation',   'desc'=>'Real-time muscle signal detection drives intent-triggered FES/NMES therapy.'],
                ['icon'=>'insights',        'title'=>'AI Motor Analytics',           'desc'=>'Proprietary algorithms decode neuromuscular intent at 2,000 Hz sampling rate.'],
                ['icon'=>'view_in_ar',      'title'=>'AR Biofeedback',              'desc'=>'Augmented reality overlays guide patients through precise movement rehabilitation.'],
                ['icon'=>'monitor_heart',   'title'=>'Closed-Loop Precision',       'desc'=>'Autonomous feedback loops modulate stimulation without constant manual adjustment.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_home_products', '📦 Product Cards — Homepage', function ($post) {
            mi_repeater_metabox($post->ID, 'home_products_json', [
                ['name'=>'image',        'label'=>'Product Image',                  'type'=>'image',    'placeholder'=>'',            'wide'=>true],
                ['name'=>'badge',        'label'=>'Badge Text',                     'type'=>'text',     'placeholder'=>'New Release', 'wide'=>false],
                ['name'=>'name',         'label'=>'Product Name',                   'type'=>'text',     'placeholder'=>'',            'wide'=>false],
                ['name'=>'description',  'label'=>'Description',                    'type'=>'textarea', 'placeholder'=>'',            'wide'=>true],
                ['name'=>'features',     'label'=>'Features (one per line)',        'type'=>'textarea', 'placeholder'=>'Feature 1\nFeature 2', 'wide'=>true],
                ['name'=>'button_text',  'label'=>'Button Text',                    'type'=>'text',     'placeholder'=>'Product Details', 'wide'=>false],
                ['name'=>'button_url',   'label'=>'Button URL',                     'type'=>'text',     'placeholder'=>'https://',     'wide'=>false],
            ], [
                ['image'=>get_template_directory_uri() . '/assets/images/stimel3-device-1.png', 'badge'=>'Flagship Device',    'name'=>'STIMEL-03®',           'description'=>'Intelligent closed-loop neuromuscular stimulation system for post-stroke and neurological rehabilitation.','features'=>"EMG-triggered stimulation\nAdaptive threshold modulation\nMulti-channel precision\nClinical data analytics",'button_text'=>'Product Details','button_url'=>'/stimel-03'],
                ['image'=>get_template_directory_uri() . '/assets/images/ssmd-img-5.jpg',       'badge'=>'Next Generation',    'name'=>'Spatial StimelMD®',    'description'=>'AR-integrated rehabilitation platform combining FES, NMES and real-time biofeedback for immersive therapy.','features'=>"AR immersive biofeedback\nAI-driven adaptability\nMulti-modal stimulation\nRemote monitoring",'button_text'=>'Product Details','button_url'=>'/spatial-stimelmd'],
            ]);
        }, 'page', 'normal', 'high');
    }

    if ($tpl === 'page-templates/template-distributors.php') {
        add_meta_box('mi_dist_benefits', '🤝 Partnership Benefits — Distributors', function ($post) {
            mi_repeater_metabox($post->ID, 'dist_benefits_json', [
                ['name'=>'icon',  'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'star', 'wide'=>false],
                ['name'=>'title', 'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',     'wide'=>false],
                ['name'=>'desc',  'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',     'wide'=>true],
            ], [
                ['icon'=>'workspace_premium', 'title'=>'Exclusive Territory Rights',    'desc'=>'Secure exclusive distribution rights in your region with guaranteed market protection and defined territory boundaries.'],
                ['icon'=>'school',            'title'=>'Comprehensive Clinical Training','desc'=>'Access to our world-class training programs, clinical certification courses, and ongoing education for your sales and clinical teams.'],
                ['icon'=>'support_agent',     'title'=>'Dedicated Partner Support',     'desc'=>'A dedicated partner success manager, technical support line, and marketing co-investment program to accelerate your growth.'],
                ['icon'=>'trending_up',       'title'=>'Industry-Leading Margins',      'desc'=>'Competitive distributor pricing with volume incentives, milestone bonuses, and a performance-based rebate structure.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_dist_resources', '📄 Resource Center — Distributors', function ($post) {
            mi_repeater_metabox($post->ID, 'dist_resources_json', [
                ['name'=>'type',     'label'=>'Type (e.g. PDF, Video)',  'type'=>'text', 'placeholder'=>'PDF',      'wide'=>false],
                ['name'=>'icon',     'label'=>'Icon (Material Symbol)',   'type'=>'text', 'placeholder'=>'description','wide'=>false],
                ['name'=>'title',    'label'=>'Title',                    'type'=>'text', 'placeholder'=>'',         'wide'=>false],
                ['name'=>'file_url', 'label'=>'File URL (upload & paste)','type'=>'text', 'placeholder'=>'https://', 'wide'=>true],
            ], [
                ['type'=>'PDF', 'icon'=>'picture_as_pdf', 'title'=>'Distributor Prospectus 2025', 'file_url'=>''],
                ['type'=>'PDF', 'icon'=>'picture_as_pdf', 'title'=>'Clinical Evidence Summary',   'file_url'=>''],
                ['type'=>'PPT', 'icon'=>'slideshow',      'title'=>'Product Presentation Deck',   'file_url'=>''],
            ]);
        }, 'page', 'normal', 'high');
    }

    if ($tpl === 'page-templates/template-about.php') {
        add_meta_box('mi_about_milestones', '🗓 Our Journey — Milestones', function ($post) {
            mi_repeater_metabox($post->ID, 'about_milestones_json', [
                ['name'=>'year',        'label'=>'Year',        'type'=>'text',     'placeholder'=>'2024', 'wide'=>false],
                ['name'=>'label',       'label'=>'Label',       'type'=>'text',     'placeholder'=>'',     'wide'=>false],
                ['name'=>'description', 'label'=>'Description', 'type'=>'textarea', 'placeholder'=>'',     'wide'=>true],
            ], [
                ['year'=>'2018','label'=>'Planning',         'description'=>'Initial research phase focused on neuromuscular motion data.'],
                ['year'=>'2021','label'=>'AI Breakthrough',  'description'=>'Integration of proprietary machine learning algorithms.'],
                ['year'=>'2023','label'=>'Global Expansion', 'description'=>'Growing clinical investment across three continents.'],
                ['year'=>'2025','label'=>'The Future',       'description'=>'Next-gen wearable diagnostic platforms worldwide.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_about_technologies', '🧬 Technology Cards — About', function ($post) {
            mi_repeater_metabox($post->ID, 'about_technologies_json', [
                ['name'=>'icon',  'label'=>'Icon (Material Symbol)', 'type'=>'text', 'placeholder'=>'biotech',       'wide'=>false],
                ['name'=>'label', 'label'=>'Label',                  'type'=>'text', 'placeholder'=>'Real-time EMG', 'wide'=>false],
            ], [
                ['icon'=>'biotech',       'label'=>'Real-time EMG'],
                ['icon'=>'electric_bolt', 'label'=>'FES / NMES'],
                ['icon'=>'psychology',    'label'=>'Artificial Intelligence'],
                ['icon'=>'view_in_ar',    'label'=>'Augmented Reality'],
                ['icon'=>'favorite',      'label'=>'BioRhythmIQ'],
                ['icon'=>'loop',          'label'=>'Closed-Loop Control'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_about_pillars', '🏛 Mission Pillars', function ($post) {
            mi_repeater_metabox($post->ID, 'about_pillars_json', [
                ['name'=>'icon',        'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'star', 'wide'=>false],
                ['name'=>'title',       'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',     'wide'=>false],
                ['name'=>'description', 'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',     'wide'=>true],
            ], [
                ['icon'=>'diversity_3', 'title'=>'Health Equity',            'description'=>'We expand access to advanced neuromuscular rehabilitation by enabling scalable deployment across hospitals, clinics, and underserved regions.'],
                ['icon'=>'groups',      'title'=>'Empowering Communities',   'description'=>'We help patients regain independence and functional confidence while reducing caregiver burden.'],
                ['icon'=>'science',     'title'=>'Innovating with Technology','description'=>'We integrate AI, AR, real-time EMG analytics, and adaptive neuromodulation into a coherent therapeutic platform.'],
                ['icon'=>'eco',         'title'=>'Sustainability',            'description'=>'We develop rehabilitation technologies that reduce waste, optimize resource use, and support long-term healthcare delivery.'],
                ['icon'=>'handshake',   'title'=>'Collaborative Progress',   'description'=>'We work closely with clinicians, therapists, distributors, and healthcare partners to ensure our systems deliver clinical value.'],
            ]);
        }, 'page', 'normal', 'high');

        add_meta_box('mi_about_culture', '🌱 Our Culture Cards', function ($post) {
            mi_repeater_metabox($post->ID, 'about_culture_json', [
                ['name'=>'icon',        'label'=>'Icon (Material Symbol)', 'type'=>'text',     'placeholder'=>'star', 'wide'=>false],
                ['name'=>'title',       'label'=>'Title',                  'type'=>'text',     'placeholder'=>'',     'wide'=>false],
                ['name'=>'description', 'label'=>'Description',            'type'=>'textarea', 'placeholder'=>'',     'wide'=>true],
            ], [
                ['icon'=>'diversity_2', 'title'=>'Gender Equality',  'description'=>'We are committed to equal opportunity, inclusive leadership, and professional growth across our organization.'],
                ['icon'=>'balance',     'title'=>'Work-Life Balance','description'=>'We foster a work environment that supports high performance, intellectual rigor, and respect for personal wellbeing.'],
            ]);
        }, 'page', 'normal', 'high');
    }
});

// ── Generic repeater metabox ──────────────────────────────────────────────────
function mi_repeater_metabox($post_id, $meta_key, $fields, $defaults) {
    wp_nonce_field('mi_rep_save_' . $meta_key, 'mi_rep_nonce_' . $meta_key);
    $raw   = get_post_meta($post_id, $meta_key, true);
    $items = ($raw && is_string($raw)) ? json_decode($raw, true) : null;
    if (!is_array($items) || empty($items)) $items = $defaults;
    $uid   = esc_attr($meta_key);

    // Build a template row (for JS "Add" button)
    $tpl_row = '';
    foreach ($fields as $f) {
        $fname = esc_attr($f['name']);
        $flabel = esc_html($f['label']);
        $fph   = esc_attr($f['placeholder'] ?? '');
        $wide  = !empty($f['wide']) ? ' mi-rep-wide' : '';
        if ($f['type'] === 'textarea') {
            $tpl_row .= '<div class="mi-rep-cell' . $wide . '"><label>' . $flabel . '</label><textarea name="' . $uid . '[__i__][' . $fname . ']" placeholder="' . $fph . '"></textarea></div>';
        } elseif ($f['type'] === 'image') {
            $tpl_row .= '<div class="mi-rep-cell' . $wide . ' mi-rep-image-cell"><label>' . $flabel . '</label><div class="mi-rep-image-preview"></div><input type="hidden" class="mi-rep-image-input" name="' . $uid . '[__i__][' . $fname . ']" value=""><button type="button" class="button mi-rep-image-pick">Choose Image</button> <button type="button" class="button mi-rep-image-clear" style="display:none">Remove</button></div>';
        } else {
            $tpl_row .= '<div class="mi-rep-cell' . $wide . '"><label>' . $flabel . '</label><input type="text" name="' . $uid . '[__i__][' . $fname . ']" placeholder="' . $fph . '"></div>';
        }
    }
    ?>
    <style>
    .mi-rep-list .mi-rep-row{display:flex;gap:8px;align-items:flex-start;padding:8px;border:1px solid #ddd;border-radius:6px;margin-bottom:8px;background:#fafafa;}
    .mi-rep-handle{color:#aaa;font-size:20px;padding-top:4px;cursor:grab;flex-shrink:0;}
    .mi-rep-cells{flex:1;display:flex;flex-wrap:wrap;gap:6px;}
    .mi-rep-cell{flex:1;min-width:120px;}
    .mi-rep-cell.mi-rep-wide{flex-basis:100%;}
    .mi-rep-cell label{font-size:11px;color:#666;display:block;margin-bottom:2px;}
    .mi-rep-cell input,.mi-rep-cell textarea{width:100%;font-size:13px;box-sizing:border-box;}
    .mi-rep-cell textarea{height:55px;resize:vertical;}
    .mi-rep-del{background:#cc0000;color:#fff;border:none;border-radius:4px;padding:4px 8px;cursor:pointer;font-size:12px;flex-shrink:0;}
    .mi-rep-image-cell{flex-basis:100%;}
    .mi-rep-image-preview{margin-bottom:6px;}
    .mi-rep-image-preview img{max-width:160px;max-height:100px;border:1px solid #ccc;border-radius:4px;display:block;}
    </style>

    <div>
        <div class="mi-rep-list" id="<?php echo $uid; ?>-list">
        <?php foreach ($items as $i => $item): ?>
            <div class="mi-rep-row">
                <span class="mi-rep-handle dashicons dashicons-menu"></span>
                <div class="mi-rep-cells">
                <?php foreach ($fields as $f):
                    $fname = esc_attr($f['name']);
                    $wide  = !empty($f['wide']) ? ' mi-rep-wide' : '';
                    $val   = $item[$f['name']] ?? '';
                    $fph   = esc_attr($f['placeholder'] ?? '');
                ?>
                    <div class="mi-rep-cell<?php echo $wide; ?><?php echo $f['type'] === 'image' ? ' mi-rep-image-cell' : ''; ?>">
                        <label><?php echo esc_html($f['label']); ?></label>
                        <?php if ($f['type'] === 'textarea'): ?>
                        <textarea name="<?php echo $uid; ?>[<?php echo $i; ?>][<?php echo $fname; ?>]" placeholder="<?php echo $fph; ?>"><?php echo esc_textarea($val); ?></textarea>
                        <?php elseif ($f['type'] === 'image'): ?>
                        <div class="mi-rep-image-preview"><?php if ($val) : ?><img src="<?php echo esc_url($val); ?>" alt=""><?php endif; ?></div>
                        <input type="hidden" class="mi-rep-image-input" name="<?php echo $uid; ?>[<?php echo $i; ?>][<?php echo $fname; ?>]" value="<?php echo esc_attr($val); ?>">
                        <button type="button" class="button mi-rep-image-pick">Choose Image</button>
                        <button type="button" class="button mi-rep-image-clear" style="<?php echo $val ? '' : 'display:none'; ?>">Remove</button>
                        <?php else: ?>
                        <input type="text" name="<?php echo $uid; ?>[<?php echo $i; ?>][<?php echo $fname; ?>]" value="<?php echo esc_attr($val); ?>" placeholder="<?php echo $fph; ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
                <button type="button" class="mi-rep-del">✕</button>
            </div>
        <?php endforeach; ?>
        </div>
        <button type="button" class="button" id="<?php echo $uid; ?>-add" style="margin-top:8px">+ Add Row</button>
        <p class="description" style="margin-top:6px">Drag ☰ to reorder · Click ✕ to remove</p>
    </div>

    <script>
    (function($){
        var uid = '<?php echo $uid; ?>';
        var idx = <?php echo count($items); ?>;
        var tpl = <?php echo wp_json_encode($tpl_row); ?>;

        $('#' + uid + '-list').sortable({items:'.mi-rep-row', handle:'.mi-rep-handle'});

        $('#' + uid + '-list').on('click', '.mi-rep-del', function(){
            $(this).closest('.mi-rep-row').remove();
            reindex();
        });

        $('#' + uid + '-add').on('click', function(){
            var cells = tpl.replace(/__i__/g, idx);
            var row = $('<div class="mi-rep-row"><span class="mi-rep-handle dashicons dashicons-menu"></span><div class="mi-rep-cells">' + cells + '</div><button type="button" class="mi-rep-del">✕</button></div>');
            $('#' + uid + '-list').append(row);
            idx++;
        });

        function reindex() {
            $('#' + uid + '-list .mi-rep-row').each(function(i){
                $(this).find('input,textarea').each(function(){
                    var n = $(this).attr('name');
                    if (n) $(this).attr('name', n.replace(/\[\d+\]/, '[' + i + ']'));
                });
            });
        }

        $('#' + uid + '-list').on('click', '.mi-rep-image-pick', function(){
            var $cell = $(this).closest('.mi-rep-image-cell');
            var frame = wp.media({title:'Select Image', button:{text:'Use this image'}, multiple:false, library:{type:'image'}});
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
                $cell.find('.mi-rep-image-input').val(att.url);
                $cell.find('.mi-rep-image-preview').html('<img src="' + url + '" alt="">');
                $cell.find('.mi-rep-image-clear').show();
            });
            frame.open();
        });

        $('#' + uid + '-list').on('click', '.mi-rep-image-clear', function(){
            var $cell = $(this).closest('.mi-rep-image-cell');
            $cell.find('.mi-rep-image-input').val('');
            $cell.find('.mi-rep-image-preview').empty();
            $(this).hide();
        });
    })(jQuery);
    </script>
    <?php
}

// ── Videos metabox (file URL + poster image + aria) ─────────────────────────
function mi_videos_metabox($post_id, $meta_key, $defaults = []) {
    wp_nonce_field('mi_vid_save_' . $meta_key, 'mi_vid_nonce_' . $meta_key);
    $raw   = get_post_meta($post_id, $meta_key, true);
    $items = ($raw && is_string($raw)) ? json_decode($raw, true) : null;
    if (!is_array($items) || empty($items)) $items = $defaults;
    $uid = esc_attr($meta_key);
    ?>
    <style>
    .mi-vid-list .mi-vid-row{display:flex;gap:8px;align-items:flex-start;padding:10px;border:1px solid #ddd;border-radius:6px;margin-bottom:10px;background:#fafafa;}
    .mi-vid-handle{color:#aaa;font-size:20px;padding-top:4px;cursor:grab;flex-shrink:0;}
    .mi-vid-cells{flex:1;display:flex;flex-direction:column;gap:8px;}
    .mi-vid-cell label{font-size:11px;color:#666;display:block;margin-bottom:2px;font-weight:600;}
    .mi-vid-row-flex{display:flex;gap:6px;align-items:center;}
    .mi-vid-row-flex input{flex:1;font-size:13px;}
    .mi-vid-cell input{width:100%;font-size:13px;box-sizing:border-box;}
    .mi-vid-del{background:#cc0000;color:#fff;border:none;border-radius:4px;padding:6px 10px;cursor:pointer;flex-shrink:0;align-self:flex-start;}
    .mi-vid-pick{background:#2271b1;color:#fff;border:none;border-radius:4px;padding:6px 10px;cursor:pointer;font-size:12px;flex-shrink:0;}
    .mi-vid-clear{background:#999;color:#fff;border:none;border-radius:4px;padding:6px 8px;cursor:pointer;font-size:12px;flex-shrink:0;}
    .mi-vid-thumb{margin-top:4px;max-width:120px;max-height:70px;border:1px solid #ccc;border-radius:3px;display:block;}
    </style>
    <div>
        <div class="mi-vid-list" id="<?php echo $uid; ?>-list">
            <?php foreach ($items as $i => $item):
                $url = $item['url'] ?? '';
            ?>
            <div class="mi-vid-row">
                <span class="mi-vid-handle dashicons dashicons-menu" title="Drag to reorder"></span>
                <div class="mi-vid-cells">
                    <div class="mi-vid-cell">
                        <label>Video URL (MP4 file or YouTube link)</label>
                        <div class="mi-vid-row-flex">
                            <input type="text" class="mi-vid-url-input" name="<?php echo $uid; ?>[<?php echo $i; ?>][url]" value="<?php echo esc_attr($url); ?>" placeholder="https://…/video.mp4 — or paste a YouTube link">
                            <button type="button" class="mi-vid-pick" data-target="url">+ Pick</button>
                            <button type="button" class="mi-vid-clear" data-target="url" title="Clear">×</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="mi-vid-del" title="Remove">✕</button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary" id="<?php echo $uid; ?>-add" style="margin-top:8px">+ Add Video</button>
        <p class="description" style="margin-top:6px">Drag ☰ to reorder · ✕ to remove · "+ Pick" opens media library · Paste a YouTube URL to embed</p>
    </div>

    <script>
    (function($){
        var uid = '<?php echo $uid; ?>';
        var idx = <?php echo count($items); ?>;
        var $list = $('#' + uid + '-list');
        $list.sortable({items:'.mi-vid-row', handle:'.mi-vid-handle', update: reindex});

        function reindex() {
            $list.find('.mi-vid-row').each(function(i){
                $(this).find('input').each(function(){
                    var n = $(this).attr('name');
                    if (n) $(this).attr('name', n.replace(/\[\d+\]/, '[' + i + ']'));
                });
            });
        }

        $list.on('click', '.mi-vid-del', function(){
            $(this).closest('.mi-vid-row').remove();
            reindex();
        });

        $list.on('click', '.mi-vid-clear', function(){
            var target = $(this).data('target');
            var $row = $(this).closest('.mi-vid-row');
            $row.find('input.mi-vid-' + target + '-input').val('');
            if (target === 'poster') $row.find('.mi-vid-thumb').remove();
        });

        $list.on('click', '.mi-vid-pick', function(){
            var $btn = $(this);
            var target = $btn.data('target');
            var libType = (target === 'url') ? 'video' : 'image';
            var frame = wp.media({
                title: (target === 'url') ? 'Select Video' : 'Select Poster Image',
                button: { text: 'Use this' },
                multiple: false,
                library: { type: libType }
            });
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                var $row = $btn.closest('.mi-vid-row');
                $row.find('input.mi-vid-' + target + '-input').val(att.url);
                if (target === 'poster') {
                    $row.find('.mi-vid-thumb').remove();
                    $btn.closest('.mi-vid-cell').append('<img class="mi-vid-thumb" src="' + att.url + '" alt="">');
                }
            });
            frame.open();
        });

        $('#' + uid + '-add').on('click', function(){
            var i = idx++;
            var html = '<div class="mi-vid-row">' +
              '<span class="mi-vid-handle dashicons dashicons-menu" title="Drag to reorder"></span>' +
              '<div class="mi-vid-cells">' +
                '<div class="mi-vid-cell"><label>Video URL (MP4 file or YouTube link)</label><div class="mi-vid-row-flex">' +
                  '<input type="text" class="mi-vid-url-input" name="'+uid+'['+i+'][url]" placeholder="https://…/video.mp4 — or paste a YouTube link">' +
                  '<button type="button" class="mi-vid-pick" data-target="url">+ Pick</button>' +
                  '<button type="button" class="mi-vid-clear" data-target="url" title="Clear">×</button>' +
                '</div></div>' +
              '</div>' +
              '<button type="button" class="mi-vid-del" title="Remove">✕</button>' +
              '</div>';
            $list.append(html);
        });
    })(jQuery);
    </script>
    <?php
}

// ── Gallery metabox ───────────────────────────────────────────────────────────
function mi_gallery_metabox($post_id, $field, $field_key) {
    wp_nonce_field('mi_gallery_save_' . $field, 'mi_nonce_' . $field);
    $ids = get_post_meta($post_id, $field, true);
    if (!is_array($ids)) $ids = [];
    $uid = esc_attr($field);
    ?>
    <style>
    .mi-gal-list{display:flex;flex-wrap:wrap;gap:8px;min-height:60px;padding:8px;border:2px dashed #ccd;border-radius:6px;margin-bottom:10px;}
    .mi-gal-list .mi-item{position:relative;cursor:grab;}
    .mi-gal-list .mi-item img{width:90px;height:90px;object-fit:cover;border-radius:4px;border:2px solid #ccc;display:block;}
    .mi-gal-list .mi-item:hover img{border-color:#2271b1;}
    .mi-gal-list .mi-item .mi-del{position:absolute;top:-7px;right:-7px;background:#cc0000;color:#fff;border-radius:50%;width:20px;height:20px;text-align:center;line-height:20px;font-size:14px;cursor:pointer;font-weight:bold;}
    .mi-gal-empty{color:#999;font-style:italic;padding:10px;}
    </style>
    <div>
        <ul class="mi-gal-list" id="<?php echo $uid; ?>-list">
            <?php if (empty($ids)): ?>
                <li class="mi-gal-empty" id="<?php echo $uid; ?>-empty">No images yet — click "Add Images" below</li>
            <?php endif; ?>
            <?php foreach ($ids as $id):
                $thumb = wp_get_attachment_image_url($id, 'thumbnail') ?: wp_get_attachment_url($id);
                if (!$thumb) continue;
            ?>
            <li class="mi-item" data-id="<?php echo (int)$id; ?>">
                <img src="<?php echo esc_url($thumb); ?>" alt="">
                <span class="mi-del" title="Remove">×</span>
            </li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" name="<?php echo $uid; ?>_ids" id="<?php echo $uid; ?>-ids" value="<?php echo esc_attr(implode(',', $ids)); ?>">
        <button type="button" class="button button-primary" id="<?php echo $uid; ?>-btn">+ Add / Change Images</button>
        <p class="description" style="margin-top:6px">Click thumbnail to remove · Drag to reorder</p>
    </div>
    <script>
    (function($){
        var f = '<?php echo $uid; ?>';
        function updateIds(){
            var ids=[];$('#'+f+'-list .mi-item').each(function(){ids.push($(this).data('id'));});
            $('#'+f+'-ids').val(ids.join(','));
            if(!ids.length){if(!$('#'+f+'-empty').length)$('#'+f+'-list').append('<li class="mi-gal-empty" id="'+f+'-empty">No images yet — click "Add Images" below</li>');}
            else{$('#'+f+'-empty').remove();}
        }
        $('#'+f+'-list').sortable({items:'.mi-item',update:updateIds});
        $('#'+f+'-list').on('click','.mi-del',function(){$(this).closest('.mi-item').remove();updateIds();});
        $('#'+f+'-btn').on('click',function(){
            var frame=wp.media({title:'Select Gallery Images',button:{text:'Add to Gallery'},multiple:true,library:{type:'image'}});
            frame.on('open',function(){
                var sel=frame.state().get('selection');
                $('#'+f+'-ids').val().split(',').filter(Boolean).forEach(function(id){var a=wp.media.attachment(id);a.fetch();sel.add(a);});
            });
            frame.on('select',function(){
                var atts=frame.state().get('selection').toJSON();
                var list=$('#'+f+'-list');$('#'+f+'-empty').remove();list.find('.mi-item').remove();
                atts.forEach(function(a){
                    var thumb=(a.sizes&&a.sizes.thumbnail)?a.sizes.thumbnail.url:a.url;
                    list.append($('<li class="mi-item" data-id="'+a.id+'"><img src="'+thumb+'" alt=""><span class="mi-del" title="Remove">×</span></li>'));
                });
                updateIds();
            });
            frame.open();
        });
    })(jQuery);
    </script>
    <?php
}

// ── Save galleries ────────────────────────────────────────────────────────────
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    foreach (['s3_gallery' => 'field_s3_gallery', 'sp_gallery' => 'field_sp_gallery'] as $field => $key) {
        $nonce_key = 'mi_nonce_' . $field;
        if (!isset($_POST[$nonce_key]) || !wp_verify_nonce($_POST[$nonce_key], 'mi_gallery_save_' . $field)) continue;
        $ids = array_values(array_filter(array_map('intval', explode(',', $_POST[$field . '_ids'] ?? ''))));
        delete_post_meta($post_id, $field);
        if ($ids) { add_post_meta($post_id, $field, $ids); update_post_meta($post_id, '_' . $field, $key); }
    }
});

// ── Save repeaters ────────────────────────────────────────────────────────────
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $repeaters = [
        's3_benefits_json', 's3_differentiators_json', 's3_stats_json', 's3_specs_json', 's3_bio_bullets_json',
        'sp_immersive_bullets_json', 'sp_challenge_stats_json', 'sp_how_steps_json', 'sp_ai_cards_json', 'sp_specs_json',
        'home_capabilities_json', 'home_products_json',
        'dist_benefits_json', 'dist_resources_json',
        'about_milestones_json', 'about_pillars_json', 'about_technologies_json', 'about_culture_json',
        'contact_faqs_json', 'contact_locations_json',
    ];
    foreach ($repeaters as $meta_key) {
        $nonce_key = 'mi_rep_nonce_' . $meta_key;
        if (!isset($_POST[$nonce_key]) || !wp_verify_nonce($_POST[$nonce_key], 'mi_rep_save_' . $meta_key)) continue;

        $raw   = $_POST[$meta_key] ?? [];
        $items = [];
        if (is_array($raw)) {
            foreach ($raw as $row) {
                $clean = [];
                foreach ($row as $k => $v) {
                    $clean[sanitize_key($k)] = sanitize_textarea_field($v);
                }
                if (array_filter($clean)) $items[] = $clean;
            }
        }
        // wp_slash prevents update_post_meta's internal wp_unslash from stripping JSON escapes (e.g. \n in textarea values).
        update_post_meta($post_id, $meta_key, wp_slash(wp_json_encode($items, JSON_UNESCAPED_UNICODE)));
    }
});

// ── Save videos metabox ──────────────────────────────────────────────────────
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    foreach (['s3_videos_json', 's3_videos_diff_json'] as $meta_key) {
        $nonce_key = 'mi_vid_nonce_' . $meta_key;
        if (!isset($_POST[$nonce_key]) || !wp_verify_nonce($_POST[$nonce_key], 'mi_vid_save_' . $meta_key)) continue;

        $raw   = $_POST[$meta_key] ?? [];
        $items = [];
        if (is_array($raw)) {
            foreach ($raw as $row) {
                $url = esc_url_raw(wp_unslash($row['url'] ?? ''));
                if ($url) $items[] = ['url' => $url];
            }
        }
        update_post_meta($post_id, $meta_key, wp_slash(wp_json_encode($items, JSON_UNESCAPED_UNICODE)));
    }
});

// ── Hide ACF repeater fields replaced by metaboxes ───────────────────────────
$mi_hidden_fields = [
    's3_gallery', 'sp_gallery',
    's3_benefits', 's3_differentiators', 's3_stats', 's3_specs', 's3_bio_bullets',
    'sp_immersive_bullets', 'sp_challenge_stats', 'sp_how_steps', 'sp_ai_cards', 'sp_specs',
    'home_capabilities', 'home_products',
    'dist_resources', 'dist_benefits',
    'about_milestones', 'about_pillars', 'about_technologies', 'about_culture',
    'contact_faqs',
    's3_video_main_url', 's3_video_main_poster', 's3_video_main_aria',
    's3_video_wrist_url', 's3_video_wrist_poster', 's3_video_wrist_aria',
];
foreach ($mi_hidden_fields as $f) {
    add_filter('acf/prepare_field/name=' . $f, '__return_false');
}

// ── Hide sub-navigation tab (removed from SSMD frontend) ─────────────────────
add_filter('acf/prepare_field/key=field_sp_tab_subnav',  '__return_false');
add_filter('acf/prepare_field/key=field_sp_subnav_items','__return_false');
