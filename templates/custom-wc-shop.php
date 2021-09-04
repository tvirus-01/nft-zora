<?php
/**
* Template Name: Wc Custom Page
*
*/
get_header();


global $wpdb;

$no = md5('no');
$yes = md5('yes');

if (isset($_GET['test'])) {
    if ($_GET['test'] == $no) {
        $isTestMod = 'no';
    }elseif ($_GET['test'] == $yes) {
        $isTestMod = 'yes';
    }
}

$isNftEnabled = get_option( "wc_settings_tab_nft_enable" );
if (empty($isNftEnabled)) {
    $isNftEnabled = "no";
}
$isTestEnabled = get_option( "wc_settings_tab_nft_enable_test" );

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<div class="container">
    <h1 class="text-center text-light bg-dark">Auction Shop</h1>
    <div class="row">
        <?php
        $get_products = $wpdb->get_results("SELECT * from {$wpdb->prefix}posts WHERE post_type = 'product' AND post_status = 'publish' ");

        foreach($get_products as $row){
            $product_id =  $row->ID;

            // $image_id = get_post_thumbnail_id($product_id);
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

            $get_auction_id = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = {$product_id} AND meta_key = 'AuctionID' ");
            $get_is_test_prod = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = {$product_id} AND meta_key = 'isTestProduct' ");

            if (null !== $get_auction_id && $get_is_test_prod->meta_value == $isTestMod) {

                $auction_id = $get_auction_id->meta_value;

                if ('' !== $auction_id ) {            
                    ?>
                        <div class="col-md-4 mt-3">
                            <div class="card" style="width: 18rem;">
                              <img class="card-img-top" src="<?php echo $image[0]; ?>" alt="Card image cap">
                              <div class="card-body">
                                <h5 class="card-title"><?php echo $row->post_title; ?></h5>
                                <p class="card-text"><?php echo $row->post_content; ?></p>
                                <a href="<?php echo site_url() . "/nft-details?nft_id=" . $row->ID; ?>" class="btn btn-primary">Check Details</a>
                              </div>
                            </div>
                        </div>
                    <?php
                }
            }
        }

        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>
<script type="text/javascript">
    const pluginStatus = "<?php echo $isNftEnabled; ?>";
    const testStatus = "<?php echo $isTestEnabled; ?>";

    if (pluginStatus == 'yes') {

        if (testStatus == 'yes') {
            nt = md5('yes');
        }else{
            nt = md5('no');
        }

        url = window.location.href;

        if (url.split("=")[1] == undefined) {
            window.location.href= url+"?test="+nt;

        }


    }else{    
        $("#auction_panel").html('<div class="alert alert-warning ml-3 mt-3" role="alert">Please Enable The Plugin in WooCommerce <a href="admin.php?page=wc-settings&tab=settings_tab_nft">Settings</a></div>');

        throw new Error("plz enable Plugin");
    }

</script>

<?php
get_footer();