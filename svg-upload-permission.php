<?php

/**
 * Plugin Name: SVG Upload Permission
 * Description: Allows SVG file uploads in WordPress with security checks of the SVG file.
 * Version: 1.0.0
 * Author: Sabbir Hossain (devsabbir)
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: svg-upload-permission
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SVG_Upload_Permission
{

    private $option_name = 'svg_upload_permission_is_enabled';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'create_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
        load_plugin_textdomain('svg-upload-permission', false, dirname(plugin_basename(__FILE__)) . '/languages');

        if (get_option($this->option_name) === '1') {
            add_filter('upload_mimes', [$this, 'enable_svg_uploads']);
            add_filter('wp_handle_upload_prefilter', [$this, 'sanitize_svg']);
        }
    }

    public function create_settings_page()
    {
        add_options_page(
            __('SVG Upload Permission', 'svg-upload-permission'),
            __('SVG Upload', 'svg-upload-permission'),
            'manage_options',
            'svg-upload-permission',
            [$this, 'settings_page_html']
        );
    }

    public function register_settings()
    {
        register_setting('svg_upload_permission_group', $this->option_name);
    }

    public function settings_page_html()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Nonce verification for CSRF protection
        if (
            isset($_POST['_wpnonce']) &&
            wp_verify_nonce($_POST['_wpnonce'], 'svg_upload_permission_nonce')
        ) {
            // If the checkbox is not set in $_POST, update the option to '0'
            $value = isset($_POST[$this->option_name]) ? '1' : '0';

            // Save the option
            update_option($this->option_name, $value);

            // Display a settings updated message
            add_settings_error('svg_upload_permission_messages', 'svg_upload_permission_message', __('Settings Saved', 'svg-upload-permission'), 'updated');
        }

        settings_errors('svg_upload_permission_messages');
?>
        <div class="wrap">
            <h1><?php _e('SVG Upload Permission Settings', 'svg-upload-permission'); ?></h1>
            <form method="post">
                <?php wp_nonce_field('svg_upload_permission_nonce'); ?> <!-- Nonce field -->
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Enable SVG Uploads', 'svg-upload-permission'); ?></th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->option_name; ?>" value="1" <?php checked(get_option($this->option_name), '1'); ?> />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
<?php
    }



    public function enable_svg_uploads($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public function sanitize_svg($file)
    {
        if ($file['type'] === 'image/svg+xml') {
            $contents = file_get_contents($file['tmp_name']);

            if (stripos($contents, '<script') !== false || stripos($contents, 'onload=') !== false) {
                $file['error'] = __('Insecure SVG file detected.', 'svg-upload-permission');
                return $file;
            }

            if (!$this->is_valid_svg($contents)) {
                $file['error'] = __('Invalid SVG format.', 'svg-upload-permission');
            }
        }
        return $file;
    }

    private function is_valid_svg($svg_content)
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($svg_content);

        if (!$xml) {
            return false;
        }

        $namespaces = $xml->getDocNamespaces();

        if (!isset($namespaces[''])) {
            return false;
        }

        $root_name = $xml->getName();

        if ($root_name !== 'svg') {
            return false;
        }

        return true;
    }
}

new SVG_Upload_Permission();
