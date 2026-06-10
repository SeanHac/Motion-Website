<?php
/**
 * Plugin Name: MI Gallery Picker
 * Description: Admin page to assign Media Library images to gallery fields via WP media modal.
 */

add_action('admin_menu', function () {
    add_management_page('Gallery Manager', 'MI Gallery Manager', 'manage_options', 'mi-gallery', 'mi_gallery_page');
});

// Save handler
add_action('admin_post_mi_gallery_save', function () {
    check_admin_referer('mi_gallery_save');
    if (!current_user_can('manage_options')) wp_die('No permission');

    $s3_ids = array_filter(array_map('intval', explode(',', $_POST['s3_gallery'] ?? '')));
    $sp_ids = array_filter(array_map('intval', explode(',', $_POST['sp_gallery'] ?? '')));

    $by_tpl = function ($tpl) {
        $p = get_posts(['post_type'=>'page','meta_key'=>'_wp_page_template','meta_value'=>$tpl,'posts_per_page'=>1,'post_status'=>'any']);
        return $p ? $p[0]->ID : 0;
    };

    $stimel_id  = $by_tpl('page-templates/template-product-stimel.php');
    $spatial_id = $by_tpl('page-templates/template-product-spatial.php');

    if ($stimel_id && $s3_ids) {
        delete_post_meta($stimel_id, 's3_gallery');
        add_post_meta($stimel_id, 's3_gallery', $s3_ids);
        update_post_meta($stimel_id, '_s3_gallery', 'field_s3_gallery');
    }
    if ($spatial_id && $sp_ids) {
        delete_post_meta($spatial_id, 'sp_gallery');
        add_post_meta($spatial_id, 'sp_gallery', $sp_ids);
        update_post_meta($spatial_id, '_sp_gallery', 'field_sp_gallery');
    }

    wp_redirect(admin_url('tools.php?page=mi-gallery&saved=1'));
    exit;
});

function mi_gallery_page() {
    $by_tpl = function ($tpl) {
        $p = get_posts(['post_type'=>'page','meta_key'=>'_wp_page_template','meta_value'=>$tpl,'posts_per_page'=>1,'post_status'=>'any']);
        return $p ? $p[0]->ID : 0;
    };
    $stimel_id  = $by_tpl('page-templates/template-product-stimel.php');
    $spatial_id = $by_tpl('page-templates/template-product-spatial.php');

    $s3_current = is_array(get_post_meta($stimel_id,  's3_gallery', true)) ? get_post_meta($stimel_id,  's3_gallery', true) : [];
    $sp_current = is_array(get_post_meta($spatial_id, 'sp_gallery', true)) ? get_post_meta($spatial_id, 'sp_gallery', true) : [];

    wp_enqueue_media();
    ?>
    <div class="wrap">
        <h1>MI Gallery Manager</h1>
        <?php if (isset($_GET['saved'])): ?>
            <div class="notice notice-success"><p><strong>Saved!</strong> Reload the frontend to see changes.</p></div>
        <?php endif; ?>

        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <?php wp_nonce_field('mi_gallery_save'); ?>
            <input type="hidden" name="action" value="mi_gallery_save">

            <!-- STIMEL-03 Gallery -->
            <h2>STIMEL-03 Product Gallery (post ID: <?php echo $stimel_id; ?>)</h2>
            <div id="s3-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
                <?php foreach ($s3_current as $id):
                    $url = wp_get_attachment_image_url($id, 'thumbnail'); ?>
                    <div style="position:relative">
                        <img src="<?php echo esc_url($url); ?>" style="width:80px;height:80px;object-fit:cover;border:2px solid #ccc;border-radius:4px;">
                        <span style="position:absolute;top:-6px;right:-6px;background:#cc0000;color:#fff;border-radius:50%;width:18px;height:18px;text-align:center;cursor:pointer;font-size:12px;line-height:18px" onclick="removeImg('s3','<?php echo $id; ?>')">×</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="s3_gallery" id="s3_ids" value="<?php echo esc_attr(implode(',', $s3_current)); ?>">
            <button type="button" class="button button-primary" onclick="openPicker('s3')">+ Select Images (STIMEL-03)</button>
            <hr>

            <!-- Spatial Gallery -->
            <h2>Spatial StimelMD Gallery (post ID: <?php echo $spatial_id; ?>)</h2>
            <div id="sp-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
                <?php foreach ($sp_current as $id):
                    $url = wp_get_attachment_image_url($id, 'thumbnail'); ?>
                    <div style="position:relative">
                        <img src="<?php echo esc_url($url); ?>" style="width:80px;height:80px;object-fit:cover;border:2px solid #ccc;border-radius:4px;">
                        <span style="position:absolute;top:-6px;right:-6px;background:#cc0000;color:#fff;border-radius:50%;width:18px;height:18px;text-align:center;cursor:pointer;font-size:12px;line-height:18px" onclick="removeImg('sp','<?php echo $id; ?>')">×</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="sp_gallery" id="sp_ids" value="<?php echo esc_attr(implode(',', $sp_current)); ?>">
            <button type="button" class="button button-primary" onclick="openPicker('sp')">+ Select Images (Spatial)</button>
            <hr>

            <p><input type="submit" class="button button-primary button-large" value="Save Both Galleries"></p>
        </form>
    </div>

    <script>
    function openPicker(prefix) {
        const frame = wp.media({
            title: 'Select Gallery Images',
            button: { text: 'Add to Gallery' },
            multiple: true,
            library: { type: 'image' }
        });
        frame.on('select', function () {
            const attachments = frame.state().get('selection').toJSON();
            const preview = document.getElementById(prefix + '-preview');
            const input   = document.getElementById(prefix + '_ids');
            const current = input.value ? input.value.split(',').filter(Boolean) : [];

            attachments.forEach(function (att) {
                if (current.includes(String(att.id))) return; // skip duplicates
                current.push(att.id);

                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:relative';
                wrapper.dataset.id = att.id;

                const img = document.createElement('img');
                img.src = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                img.style.cssText = 'width:80px;height:80px;object-fit:cover;border:2px solid #2271b1;border-radius:4px';

                const del = document.createElement('span');
                del.innerHTML = '×';
                del.style.cssText = 'position:absolute;top:-6px;right:-6px;background:#cc0000;color:#fff;border-radius:50%;width:18px;height:18px;text-align:center;cursor:pointer;font-size:12px;line-height:18px';
                del.onclick = function() { removeImg(prefix, att.id); };

                wrapper.appendChild(img);
                wrapper.appendChild(del);
                preview.appendChild(wrapper);
            });

            input.value = current.join(',');
        });
        frame.open();
    }

    function removeImg(prefix, id) {
        const input   = document.getElementById(prefix + '_ids');
        const preview = document.getElementById(prefix + '-preview');
        const current = input.value.split(',').filter(v => v && v != id);
        input.value   = current.join(',');
        const wrapper = preview.querySelector('[data-id="' + id + '"]');
        if (wrapper) wrapper.remove();
    }
    </script>
    <?php
}
