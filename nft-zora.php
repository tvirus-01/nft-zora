<?php
/**
 * Plugin Name: NFT Zora Plugin
 * Plugin URI: https://wordpress.org/
 * Description: An NFT Acution Plugin.
 * Version: 1.0.19
 * Author: Syed
 * Author URI: https://wordpress.org/
 * Text Domain: nftzora
 * Licence: GPLv2 or later
 *
 * @package NFTZoraPlugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'NFTZORA_PLUGIN_DIR_PATH' ) ) {
    define( 'NFTZORA_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'NFTZORA_PLUGIN_URL_CONTRACTS' ) ) {
    define( 'NFTZORA_PLUGIN_URL_CONTRACTS', plugins_url('/contracts/', __FILE__ ) );
}

if ( ! defined( 'NFTZORA_PLUGIN_URL_ASSETS' ) ) {
    define( 'NFTZORA_PLUGIN_URL_ASSETS', plugins_url('/assets/', __FILE__ ) );
}

require( NFTZORA_PLUGIN_DIR_PATH . '/classes/class-tpwcp-admin.php' );
require( NFTZORA_PLUGIN_DIR_PATH . '/classes/createCustomPages.php' );

class NftZora{
    public $templates;

    //Constructor
    function __construct() {  
        add_action('init', array($this, 'zoraCpt'));
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_nft', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_nft', __CLASS__ . '::update_settings' );
        add_action( 'plugins_loaded', array($this, 'tpwcp_init') );
        add_action( 'woocommerce_single_product_summary', __CLASS__ . '::add_to_cart_button_woocommerce', 20 );
        add_action( 'admin_init', array($this, 'checkForWooCommerce') );
    }

    public static function add_to_cart_button_woocommerce() {
        $post_id = get_the_ID();
        $end_date = get_post_meta( $post_id, 'end_date', true );
        // echo 'WooCommerce customize add to cart button '. $end_date;
        require NFTZORA_PLUGIN_DIR_PATH . 'templates/count-down.php';

        return __('Place Bid', 'woocommerce');
    }

    function register(){
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));

        //add custom templates
        $this->templates = array(
            "templates/custom-wc-shop.php" => "Wc Custom Page",
            "templates/custom-wc-nft-details.php" => "Wc Custom Details Page",
        );

        add_filter('theme_page_templates', array($this, 'custom_wc_template'));

        add_filter( 'template_include', array($this, 'wpa3396_page_template') );
    }

    function wpa3396_page_template( $template ){
        global $post;

        if(!$post){
            return $template;
        }
        $template_name = get_post_meta($post->ID, '_wp_page_template', true);

        if (!isset($this->templates[$template_name])) {
            return $template;
        }

        $file = NFTZORA_PLUGIN_DIR_PATH . $template_name;

        if (file_exists($file)) {
            return $file;
        }

        return $template;
    }

    public function custom_wc_template($templates){
        $templates = array_merge($templates, $this->templates);
        return $templates;
    }

    function checkForWooCommerce() {
        if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            $this->child_plugin_notice();

            deactivate_plugins( plugin_basename( __FILE__ ) ); 

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    }

    function child_plugin_notice(){
        echo '<script>alert("Sorry, but this Plugin requires the Woocommerce plugin to be installed and active.")</script>';
    }

    //methods
    function deactivate() {
        global $wpdb;

        $getPagePost = $wpdb->get_row(
            $wpdb->prepare( 
                "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_title = %s",
                'page',
                'Nft Shop'
            )
        );

        $PagePostID = $getPagePost->ID;

        wp_delete_post($PagePostID, true);
        delete_post_meta( $PagePostID, '_wp_page_template' );

        flush_rewrite_rules();
    }

    function zoraCpt() {
        register_post_type('nft', ['public' => true, 'label' => 'NFT']);
    }

    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_nft'] = __( 'NFT', 'woocommerce-settings-tab-nft' );
        return $settings_tabs;
    }

    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }

    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }

    public static function get_settings() {

        require(NFTZORA_PLUGIN_DIR_PATH . 'classes/class-nzwcp-settings-tab.php');

        return apply_filters( 'wc_settings_tab_nft_settings', $settings );
    }

    function tpwcp_init() {
        if ( is_admin() ) {
            $TPWCP = new TPWCP_Admin();
            $TPWCP->init();
        }
    }

    function enqueue() {
        wp_enqueue_script( 'nftzora_jquery',  NFTZORA_PLUGIN_URL_ASSETS . 'js/jquery-3.6.0.min.js');
        wp_enqueue_script( 'nftzora_web3',  NFTZORA_PLUGIN_URL_ASSETS . 'js/dist/web3.min.js');
        wp_enqueue_script( 'nftzora_web3_utils',  NFTZORA_PLUGIN_URL_ASSETS . 'js/dist/web3-utils.min.js');
        wp_enqueue_script( 'nftzora_main_js',  NFTZORA_PLUGIN_URL_ASSETS . 'js/nft-zora.js');
    }
}

if (class_exists('NftZora')) {
    $nftZora = new NftZora();
    $nftZora->register();
}

//activation
register_activation_hook( __FILE__, 'activate' );

//deactivation
register_deactivation_hook( __FILE__, array($nftZora, 'deactivate') );


function activate() {
    if ( ! current_user_can( 'activate_plugins' ) ) return;

    global $wpdb;
}