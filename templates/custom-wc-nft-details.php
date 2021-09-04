<?php
/**
* Template Name: Wc Custom Details Page
*
*/
get_header();


global $wpdb;

if (!isset($_GET['nft_id'])) {
    die("no nft item");
}

$product_id = $_GET['nft_id'];
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

$product = $wpdb->get_row("SELECT * from {$wpdb->prefix}posts WHERE ID = {$product_id}");

$categories = get_the_terms( $product_id, 'product_cat' );

$token_contract = get_post_meta( $product_id, 'token_contract', true );

$token_contract = get_post_meta( $product_id, 'token_contract', true );
$duration = get_post_meta( $product_id, 'duration', true );
$start_duration = get_post_meta( $product_id, 'start_duration', true );
$end_date = $duration;
$reserve_price = get_post_meta( $product_id, 'reserve_price', true );

$AuctionID = get_post_meta( $post_id, 'AuctionID', true );

$isNftEnabled = get_option( "wc_settings_tab_nft_enable" );
if (empty($isNftEnabled)) {
    $isNftEnabled = "no";
}
$isTestEnabled = get_option( "wc_settings_tab_nft_enable_test" );
$auctionHouseAddress = get_option( "wc_settings_tab_nft_auction_house" );
$auctionHouseAddressRinkeby = get_option( "wc_settings_tab_nft_auction_house_rinkeby" );

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo NFTZORA_PLUGIN_URL_ASSETS . 'product-details.css' ?>">

<div class="container">
    <div class="card">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">
                    
                    <div class="preview-pic tab-content">
                      <div class="tab-pane active" id="pic-1"><img src="<?php echo $image[0]; ?>" /></div>
                    </div>
                    
                </div>
                <div class="details col-md-6">
                    <h3 class="product-title"><?php echo $product->post_title; ?></h3>
                    <div class="rating">
                        <div class="stars">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <span class="review-no"><?php echo $categories[0]->name; ?></span>
                        <p class="review-no">Owned By <?php echo substr($token_contract, 0, 6) . '......' .substr($token_contract, -5, -1) ; ?></p>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <h5>No Bids</h5>
                            <h5>
                                Reserve Ð
                                <span reserve_price="<?php echo $reserve_price; ?>" id="reserve_price">
                                    <?php echo $reserve_price; ?>
                                </span>
                            </h5>
                        </div>
                        <div class="col">
                            <input type="hidden" name="AuctionID" value="<?php echo $AuctionID; ?>" id="AuctionID">
                            
                            <label>Enter Bid Amount</label>
                            <input type="number" name="bidAmount" id="bidAmount" class="form-control" >
                            
                            <button class="btn btn-lg btn-dark mt-3" id="placeBidButton">
                                Place Bid
                            </button>
                            
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <h4>Auction Ends In</h4>
                            <?php require NFTZORA_PLUGIN_DIR_PATH . 'templates/count-down.php'; ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <div id="err_div" contract_url="<?php echo NFTZORA_PLUGIN_URL_CONTRACTS; ?>" auction_house="<?php echo $auctionHouseAddress; ?>"></div>
                            <div class="alert alert-danger" id="create_auction_err" style="display: none;" role="alert"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    const pluginStatus = "<?php echo $isNftEnabled; ?>";
    const testStatus = "<?php echo $isTestEnabled; ?>";
    const contractUrl = "<?php echo NFTZORA_PLUGIN_URL_CONTRACTS; ?>";
    const cEthAddressMain = "<?php echo $auctionHouseAddress; ?>";    
    const cEthAddressTest = "<?php echo $auctionHouseAddressRinkeby; ?>";    
    // const cEthAddress = "0xE7dd1252f50B3d845590Da0c5eADd985049a03ce"; //rinkeby address
</script>
<script type="text/javascript" src="<?php echo NFTZORA_PLUGIN_URL_CONTRACTS . 'create-bid.js' ?>"></script>
<?php
get_footer();