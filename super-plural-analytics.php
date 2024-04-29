<?php
/*
Plugin Name: Super Plural Analytics
Plugin URI: https://superplural.com/analytics/
Description: Inserts the Super Plural Analytics Pixel Code script into the website's head, allowing the user to configure the unique pixel ID.
Version: 1.0
Author: Super Plural
Author URI: https://suplerplural.com
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define the base URL for the plugin
define('SPA_PLUGIN_URL', plugin_dir_url(__FILE__));

// Function to add the settings field in the admin panel
function spa_register_settings() {
    add_option('spa_pixel_id', '');
    register_setting('spa_options_group', 'spa_pixel_id', 'spa_callback');
}
add_action('admin_init', 'spa_register_settings');

// Function to add the options menu in the admin panel
function spa_register_options_page() {
    add_options_page('Super Plural Analytics', 'Super Plural Analytics', 'manage_options', 'spa', 'spa_options_page');
}
add_action('admin_menu', 'spa_register_options_page');

// Options page HTML
function spa_options_page() {
?>
  <div class="wrap">
  <h1>
    <a href="https://superplural.com/omni/" target="_blank">
      <img src="<?php echo SPA_PLUGIN_URL . 'images/super-plural-analytics-fav-512px.png'; ?>" alt="Super Plural Analytics" style="max-width: 50px;"/>
    </a>
  </h1>
  <h2>Super Plural Analytics Pixel Code Configuration</h2>
  <p>Follow the steps below to find your unique pixel ID:</p>
  <ol>
    <li>Log in to your Super Plural Analytics account at <a href="https://analytics.superplural.com/login" target="_blank">https://analytics.superplural.com/login</a>.</li>
    <li>Navigate through Websites > click on <i class="fa-regular fa-code"></i> Tracking code.</li>
    <li>
      Find your Pixel ID as shown in the image below:
      <br/>
      <img src="<?php echo SPA_PLUGIN_URL . 'images/super-plural-analytics-pixel-id.png'; ?>" alt="pixel ID Example" style="max-width: 500px;"/>
    </li>
    <li>For more information visit <a href="https://analytics.superplural.com/help/" target="_blank">https://analytics.superplural.com/help/</a>.</li>
  </ol>
  <form method="post" action="options.php">
    <?php settings_fields('spa_options_group'); ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row"><label for="spa_pixel_id">Pixel ID:</label></th>
        <td><input type="text" id="spa_pixel_id" name="spa_pixel_id" value="<?php echo esc_attr(get_option('spa_pixel_id')); ?>" class="regular-text"/></td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </form>
  </div>
<?php
}

// Function to insert the script in the website's head
function spa_insert_script() {
    $pixel_id = get_option('spa_pixel_id');
    if (!empty($pixel_id)) {
        echo '<!-- Pixel Code for Super Plural Analytics https://analytics.superplural.com/ -->' . "\n";
        echo '<script defer src="https://analytics.superplural.com/pixel/' . esc_attr($pixel_id) . '"></script>' . "\n";
        echo '<!-- END Pixel Code -->' . "\n";
    }
}
add_action('wp_head', 'spa_insert_script');