<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style type="text/css">
    .create_auction_button{
        margin: 12px !important; 
        padding: 5px; 
        cursor: pointer;
    }
</style>

<div id='auction_panel' class='panel woocommerce_options_panel'>
    <div class="options_group nz_create_ac_fieldset">

        <input type="hidden" value="<?php echo $AuctionID; ?>" id="AuctionID" name="AuctionID">
        <input type="hidden" value="<?php echo $isTestEnabled; ?>" id="isTestEnabled" name="isTestEnabled">
        
        <p class='form-field token_id_field'>
            <label for='token_id'>Token ID</label>
            <input type='number' class='short' style='' name='token_id' id='token_id' value="<?php echo $token_id; ?>" data-toggle="tooltip" data-placement="top" title="The tokenID to use in the auction" />
        </p>


        <p class='form-field token_contract_field'>
            <label for='token_contract'>Token Contract</label>
            <input type='text' class='short' style='' name='token_contract' id='token_contract' value='<?php echo $token_contract; ?>' placeholder='' data-toggle="tooltip" data-placement="top" title="The address of the nft contract the token is from"  />
        </p>


        <p class='form-field auction_duration_field'>
            <label for='auction_duration'>Auction Duration</label>
            <input type='datetime-local' class='short' style='' name='auction_duration' id='auction_duration' value='<?php echo $token_id; ?>' placeholder='' data-toggle="tooltip" data-placement="top" title="The length of time, in seconds, that the auction should run for once the reserve price is hit."  />
            <input type="hidden" name="duration" id="duration" value="<?php echo $duration; ?>">
            <input type="hidden" name="start_duration" id="start_duration" value="<?php echo $start_duration; ?>">
        </p>


        <p class='form-field reserve_price_field'>
            <label for='reserve_price'>Reserve Price</label>
            <input type='number' class='short' style='' name='reserve_price' id='reserve_price' value='<?php echo $reserve_price; ?>' placeholder='' data-toggle="tooltip" data-placement="top" title="The minimum price for the first bid, starting the auction."  /> 
        </p>


        <p class='form-field curator_field'>
            <label for='curator'>Curator</label>
            <input type='text' class='short' style='' name='curator' id='curator' value='<?php echo $curator; ?>' placeholder='' data-toggle="tooltip" data-placement="top" title="The address of the curator for this auction"  />
        </p>


        <p class='form-field curator_fee_field'>
            <label for='curator_fee'>Curator Fee %</label>
            <input type='number' class='short' style='' name='curator_fee' id='curator_fee' value='<?php echo $curator_fee; ?>' placeholder='' data-toggle="tooltip" data-placement="top" title="The percentage of the winning bid to share with the curator"  />
        </p>


        <p class='form-field auction_currency_field'>
            <label for='auction_currency'>Auction Currency</label>
            <input type='text' class='short' style='' name='auction_currency' id='auction_currency' value='0x0000000000000000000000000000000000000000' placeholder='' data-toggle="tooltip" data-placement="top" title="The currency to perform this auction in, or 0x0 for ETH"  /> 
        </p>


        <input type='button' class='create_auction_button enableEthereumButton' style='' id='create_auction' value='Create Auction Contract' placeholder=''  />

        <div class="alert alert-danger col-11 ml-3" id="create_auction_err" style="display: none;" role="alert"></div>
        <div class="alert alert-success col-11 ml-3" id="create_auction_success" style="display: none;" role="alert"></div>
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

<script type="text/javascript" src="<?php echo NFTZORA_PLUGIN_URL_CONTRACTS . 'create-auction.js' ?>"></script>
