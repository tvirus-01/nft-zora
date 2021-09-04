<?php
    $settings = array(
        'section_title' => array(
            'name'     => __( 'NFT Zora', 'woocommerce-settings-tab-nft' ),
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'wc_settings_tab_nft_section_title'
        ),
        'enable_nft' => array(
            'name' => __( 'Enable NFT Zora ', 'woocommerce-settings-tab-nft' ),
            'type' => 'checkbox',
            'desc' => __( 'Enable/Disable', 'woocommerce-settings-tab-nft' ),
            'id'   => 'wc_settings_tab_nft_enable'
        ),
        'enable_nft_test' => array(
            'name' => __( 'Enable Test Mode', 'woocommerce-settings-tab-nft' ),
            'type' => 'checkbox',
            'desc' => __( 'Enable/Disable', 'woocommerce-settings-tab-nft' ),
            'id'   => 'wc_settings_tab_nft_enable_test'
        ),
        'network' => array(
            'name' => __( 'Network', 'woocommerce-settings-tab-nft' ),
            'type' => 'multiselect',
            'desc' => __( 'hold Ctrl/Control to select multiple', 'woocommerce-settings-tab-nft' ),
            'id'   => 'wc_settings_tab_nft_network',
            'options' => array(
                ''              => __( 'Select a network', 'woocommerce-settings-tab-nft' ),
                'ethEtherium'   => __( 'Etherium', 'woocommerce-settings-tab-nft' ),
            ),
        ),
        'set_auction_house' => array(
            'name' => __( 'Set Auction House Address(eth Mainnet)', 'woocommerce-settings-tab-nft' ),
            'type' => 'text',
            'id'   => 'wc_settings_tab_nft_auction_house'
        ),
        'set_auction_house_test' => array(
            'name' => __( 'Set Auction House Address(rinkeby test net)', 'woocommerce-settings-tab-nft' ),
            'type' => 'text',
            'id'   => 'wc_settings_tab_nft_auction_house_rinkeby'
        ),
        'infura_api' => array(
            'name' => __( 'Infura API', 'woocommerce-settings-tab-nft' ),
            'type' => 'text',
            'id'   => 'wc_settings_tab_nft_infura_api'
        ),
        'etherscan_api' => array(
            'name' => __( 'Etherscan API', 'woocommerce-settings-tab-nft' ),
            'type' => 'text',
            'placeholder' => '',
            'id'   => 'wc_settings_tab_nft_etherscan_api'
        ),
        'default_curator' => array(
            'name' => __( 'Default Curator', 'woocommerce-settings-tab-nft' ),
            'type' => 'text',
            'id'   => 'wc_settings_tab_nft_default_curator'
        ),
        'default_fee_percentage' => array(
            'name' => __( 'Default Fee Percentage %', 'woocommerce-settings-tab-nft' ),
            'type' => 'number',
            'id'   => 'wc_settings_tab_nft_default_fee_percentage'
        ),
        'nft_shop_url' => array(
            'name' => __( 'Auction Shop URL', 'woocommerce-settings-tab-nft' ),
            'type' => 'text',
            'value' => site_url() . "/nft-shop",
            'custom_attributes' => array(
                'readonly' => 'readonly'
            ),
            'id'   => 'wc_settings_tab_nft_auction_shop_url'
        ),
        'section_end' => array(
             'type' => 'sectionend',
             'id' => 'wc_settings_tab_nft_section_end'
        )
    );