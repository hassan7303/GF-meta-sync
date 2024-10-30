<?php

/**
 * Plugin Name: GF Meta Sync
 *
 * Description: A WordPress plugin that allows admins to input data through the admin panel, save it into the wp_options table as JSON, and provide it to JavaScript for frontend usage. It also syncs Gravity Forms submission data with user metadata.
 *
 * Version: 1.0.0
 *
 * Author: hassan Ali Askari
 * Author URI: https://t.me/hassan7303
 * Plugin URI: https://github.com/hassan7303
 *
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * Email: hassanali7303@gmail.com
 * Domain Path: https://www.instagram.com/hasan_ali_askari
 */


if (!defined(constant_name: 'ABSPATH')) {
    exit; // Prevent direct access
}


/**
 * Adds menu items to the WordPress admin dashboard.
 *
 * @return void
 */
function gf_meta_sync_menu(): void
{
    add_menu_page(
        'GF Meta Sync',           // Page title
        'GF Meta Sync',           // Menu title
        'manage_options',         // Capability required to access
        'GF-meta-sync',           // Menu slug
        'gf_meta_sync_page'       // Function to display the settings page content
    );
}
add_action('admin_menu', 'gf_meta_sync_menu');


/**
 * Displays the admin settings page for entering form ID.
 *
 * @return void
 */
function gf_meta_sync_page():void
{
    ?>
    <div class="wrap">
        <h1>GF Meta Sync Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('GF_meta_sync_options_group');
            do_settings_sections('GF_meta_sync');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


/**
 * Registers settings fields and sections for entering the Gravity Form ID.
 *
 * @return void
 */
function gf_meta_sync_settings_init():void
{
    register_setting('GF_meta_sync_options_group', 'GF_meta_sync_options');

    add_settings_section(
        'GF_meta_sync_section',
        '',
        '',
        'GF_meta_sync'
    );

    // Form Id field
    add_settings_field(
        'GF_meta_sync_form_id',
        'Form ID',
        'gf_meta_sync_form_id_callback',
        'GF_meta_sync',
        'GF_meta_sync_section'
    );
}
add_action('admin_init', 'gf_meta_sync_settings_init');


/**
 * Callback for form ID field.
 * 
 * @return void
 */
function gf_meta_sync_form_id_callback(): void
{
    $options = get_option('GF_meta_sync_options');
    $form_id = isset($options['form-id']) ? $options['form-id'] : '';
    echo '<input type="text" name="GF_meta_sync_options[form-id]" value="' . esc_attr($form_id) . '" />';
}


/**
 * Saves Gravity Forms submission phone data to user meta dynamically.
 *
 * This function searches for fields that are related to phone numbers in the submitted form
 * and saves them to the user's meta data based on key names that include 'phone'.
 *
 * @param array $entry The Gravity Forms entry data.
 * @param array $form  The Gravity Forms form data.
 *
 * @return void
 */
function save_seller_phone_info(array $entry, array $form): void
{

    // Get form ID from settings
    $options = get_option('GF_meta_sync_options');
    $form_id = $options['form-id'] ?? '';


    if ($form['id'] != $form_id) {
        return;
    }


    $phone = '';

    foreach ($form['fields'] as $field) {
        if (
            strpos(strtolower($field->label), 'شماره تلفن') !== false || 
            strpos(strtolower($field->label), 'شماره موبایل') !== false 
        ) {
            $key = $field->id;
           
            $value = $entry[$key] ?? '';

            if (!empty($value)) {
                $phone = $value; 
            }
            break; 
        }
    }


    if (!empty($phone)) {
        
        $phone_en = convert($phone);
        $user_id = get_current_user_id();

        $data = [
            'billing_phone',
            'shipping_phone',
            'digits_phone'
        ];

        // Save each phone field in user meta
        foreach ($data as $meta_key) {
            update_user_meta($user_id, $meta_key, $phone_en);
        }
    }
}

// Hook the function into Gravity Forms submission (use form ID dynamically)
add_action('gform_after_submission', 'save_seller_phone_info', 10, 2);


/**
 * convert persian phone to en phone
 * 
 * @param string $string
 * 
 * @return string
 */
function convert(string $string):string
{
$persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
$arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
$num = range(0, 9);
$convertedPersianNums = str_replace($persian, $num, $string);
$englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
return $englishNumbersOnly;
}
