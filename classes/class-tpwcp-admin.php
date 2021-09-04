<?php
/**
 * Class to create additional product panel in admin
 * @package TPWCP
 */
 
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'TPWCP_Admin' ) ) {
    class TPWCP_Admin {
 
        public function __construct() {
        }
 
        public function init() {
            // Create the custom tab
            add_filter( 'woocommerce_product_data_tabs', array( $this, 'create_giftwrap_tab' ) );
            // Add the custom fields
            add_action( 'woocommerce_product_data_panels', array( $this, 'display_giftwrap_fields' ) );
            // Save the custom fields
            add_action( 'woocommerce_process_product_meta', array( $this, 'save_fields' ) );
        }
 
        /**
         * Add the new tab to the $tabs array
         * @see     https://github.com/woocommerce/woocommerce/blob/e1a82a412773c932e76b855a97bd5ce9dedf9c44/includes/admin/meta-boxes/class-wc-meta-box-product-data.php
         * @param   $tabs
         * @since   1.0.0
         */
        public function create_giftwrap_tab( $tabs ) {
            $tabs['giftwrap'] = array(
                'label'         => __( 'NFT Auction', 'tpwcp' ), // The name of your panel
                'target'        => 'auction_panel', // Will be used to create an anchor link so needs to be unique
                'class'         => array( 'nft_auction_tab', 'show_if_simple', 'show_if_variable' ), // Class for your panel tab - helps hide/show depending on product type
                'priority'      => 80, // Where your panel will appear. By default, 70 is last item
            );
            return $tabs;
        }
 
        /**
         * Display fields for the new panel
         * @see https://docs.woocommerce.com/wc-apidocs/source-function-woocommerce_wp_checkbox.html
         * @since   1.0.0
         */
        public function display_giftwrap_fields() { 
            $isNftEnabled = get_option( "wc_settings_tab_nft_enable" );
            if (empty($isNftEnabled)) {
                $isNftEnabled = "no";
            }

            $isTestEnabled = get_option( "wc_settings_tab_nft_enable_test" );
            $auctionHouseAddress = get_option( "wc_settings_tab_nft_auction_house" );
            $auctionHouseAddressRinkeby = get_option( "wc_settings_tab_nft_auction_house_rinkeby" );

            $post_id = get_the_ID();
            $token_id = get_post_meta( $post_id, 'token_id', true );
            $AuctionID = get_post_meta( $post_id, 'AuctionID', true );
            $token_contract = get_post_meta( $post_id, 'token_contract', true );
            $duration = get_post_meta( $post_id, 'duration', true );
            $start_duration = get_post_meta( $post_id, 'start_duration', true );
            $reserve_price = get_post_meta( $post_id, 'reserve_price', true );

            $curator = get_post_meta( $post_id, 'curator', true );
            $curator_fee = get_post_meta( $post_id, 'curator_fee', true );

            if ($curator == '') {
                $curator = get_option( "wc_settings_tab_nft_default_curator" );
            }

            if (empty($curator_fee)) {
                $curator_fee = get_option( "wc_settings_tab_nft_default_fee_percentage" );
            }

            include(NFTZORA_PLUGIN_DIR_PATH . '/templates/wc_product_panel.php');

        }
 
        /**
         * Save the custom fields using CRUD method
         * @param $post_id
         * @since 1.0.0
         */
        public function save_fields( $post_id ) {
 
            $product = wc_get_product( $post_id );

            $token_id = isset( $_POST['token_id'] ) ? $_POST['token_id'] : '';
            $product->update_meta_data( 'token_id', sanitize_text_field( $token_id ) );
            
            $token_contract = isset( $_POST['token_contract'] ) ? $_POST['token_contract'] : '';
            $product->update_meta_data( 'token_contract', sanitize_text_field( $token_contract ) );
            
            $duration = isset( $_POST['duration'] ) ? $_POST['duration'] : '';
            $product->update_meta_data( 'duration', sanitize_text_field( $duration ) );
            
            $start_duration = isset( $_POST['start_duration'] ) ? $_POST['start_duration'] : '';
            $product->update_meta_data( 'start_duration', sanitize_text_field( $start_duration ) );
            
            $auction_duration = isset( $_POST['auction_duration'] ) ? $_POST['auction_duration'] : '';
            $product->update_meta_data( 'end_date', sanitize_text_field( $auction_duration ) );
            
            $reserve_price = isset( $_POST['reserve_price'] ) ? $_POST['reserve_price'] : '';
            $product->update_meta_data( 'reserve_price', sanitize_text_field( $reserve_price ) );
            
            $curator = isset( $_POST['curator'] ) ? $_POST['curator'] : '';
            $product->update_meta_data( 'curator', sanitize_text_field( $curator ) );
            
            $curator_fee = isset( $_POST['curator_fee'] ) ? $_POST['curator_fee'] : '';
            $product->update_meta_data( 'curator_fee', sanitize_text_field( $curator_fee ) );
            
            $auction_currency = isset( $_POST['auction_currency'] ) ? $_POST['auction_currency'] : '';
            $product->update_meta_data( 'auction_currency', sanitize_text_field( $auction_currency ) );
            
            $AuctionID = isset( $_POST['AuctionID'] ) ? $_POST['AuctionID'] : '';
            $product->update_meta_data( 'AuctionID', sanitize_text_field( $AuctionID ) );

            $isTestEnabled = isset( $_POST['isTestEnabled'] ) ? $_POST['isTestEnabled'] : '';
            $product->update_meta_data( 'isTestProduct', sanitize_text_field( $isTestEnabled ) );
 
            $product->save();
 
        }
 
    }
}