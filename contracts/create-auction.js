if (pluginStatus == 'yes') {
    var pubBtn = $("#publish");

    if (pubBtn.val() == 'Publish') {
        pubBtn.attr("disabled","disabled");
        $("#publishing-action").append("<p class='text-info' style='text-align: center;'>!You can only publish after auction successfully created</p>");
    }else{
        $("#create_auction").attr("disabled", "disabled");
    }

    if (testStatus == 'yes') {
        var requiredNetType = "rinkeby";
        var cEthAddress = cEthAddressTest;
    }else{
        var requiredNetType = "main";
        var cEthAddress = cEthAddressMain;
    }

}else{    
    $("#auction_panel").html('<div class="alert alert-warning ml-3 mt-3" role="alert">Please Enable The Plugin in WooCommerce <a href="admin.php?page=wc-settings&tab=settings_tab_nft">Settings</a></div>');

    throw new Error("plz enable Plugin");
}

//cehck if metamask is installed
if (typeof window.ethereum == 'undefined') {
    $("#auction_panel").html('<div class="alert alert-warning ml-3 mt-3" role="alert">MetaMask is not installed! pelase install it from <a href="https://metamask.io/download.html" target="blank">here</a></div>');

    throw new Error("MetaMask is not installed!");
}

//plugin contract url

// get provider from metamask using web3
if(typeof web3 !== 'undefined'){
    web3 = new Web3(web3.currentProvider);
    // console.log("web3");
}else{
    web3 = new Web3(new Web3.providers.HttpProviders("http://localhost:8545"));
}

web3.eth.net.getNetworkType()
.then(function(netType) {
    console.log(netType);
    if (netType == requiredNetType) {
        console.log("network is okay");
    }else{
        $("#auction_panel").html('<div class="alert alert-warning ml-3 mt-3" role="alert">Please connect your MetaMask to '+requiredNetType+' network then reload this page</div>');
        
        throw new Error("wrong network type selected");
    }
}
);

var cEthAbi = (function () {
    var json = null;
    $.ajax({
        'async': false,
        'global': false,
        'url': contractUrl+'abi/AuctionHouse.json',
        'dataType': "json",
        'success': function (data) {
            json = data;
        }
    });
    return json;
})();

if (cEthAddress == '') {
    $("#auction_panel").html('<div class="alert alert-warning ml-3 mt-3" role="alert">Please set auction house '+requiredNetType+' address first</div>');
    
    throw new Error("no auction house address found");
}

const cEthContract = new web3.eth.Contract(cEthAbi, cEthAddress);

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

const ethereumButton = document.querySelector('.enableEthereumButton');

ethereumButton.addEventListener('click', () => {
    writeAuction();
});

async function getRevertReason(txHash){

  const tx = await web3.eth.getTransaction(txHash)

  var result = await web3.eth.call(tx, tx.blockNumber)

  result = result.startsWith('0x') ? result : `0x${result}`

  if (result && result.substr(138)) {

    const reason = web3.utils.toAscii(result.substr(138))
    console.log('Revert reason:', reason)
    return reason

  } else {
    console.log('Cannot get reason - No return value')
  }

}

async function writeAuction() {
    const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
    const account = accounts[0];

    sleep(1000);

    var tokenId = $("#token_id").val();

    var tokenContract = $("#token_contract").val();

    var start_duration = $("#start_duration").val();
    var duration = $("#duration").val();

    var reservePrice = $("#reserve_price").val();

    var curator = $("#curator").val();

    var curatorFeePercentage = $("#curator_fee").val();

    var auctionCurrency = $("#auction_currency").val();

    if(tokenId == '' || tokenContract == '' || duration ==  '' || reservePrice == '' || curator == '' ||  curatorFeePercentage == '' || auctionCurrency == ''){
        $("#create_auction_err").html("Please fill all fields");
        $("#create_auction_err").show();
    }else{
        $("#create_auction_err").hide();

        if(duration < start_duration){
            console.log("Invalid duration")
            $("#create_auction_err").html("Invalid duration");
            $("#create_auction_err").show();
        }else{
            $("#create_auction_err").hide();

            try{
                web3.eth.handleRevert = true;

                cEthContract.methods.createAuction(tokenId, tokenContract, duration, reservePrice, curator, curatorFeePercentage, auctionCurrency).send({from:account})
                .on('transactionHash', function(hash) { 
                    console.log(hash);
                    getRevertReason(hash);
                 })
                .then((result) => {
                    var AuctionID = result;
                    $("AuctionID").val(AuctionID);
                    console.log(AuctionID);

                    $("#create_auction_success").html("Auction Created Successfully. Your AuctionID is "+ AuctionID);
                    $("#create_auction_success").show();

                    $("#publish").removeAttr("disabled");
                    $("#publishing-action p").hide();
                }).catch((error) => {
                    console.log(error);
                    $("#create_auction_err").html(error.message);
                    $("#create_auction_err").show();
                });
            } catch(error) {
                $("#create_auction_err").html(error.message);
                $("#create_auction_err").show();
            }
        }
    }
}

$("#auction_duration").change(function(){
    // console.log($(this).val());
    var startDate = new Date();
    var endDate = new Date($(this).val());

    $("#duration").val(endDate.getTime());
    $("#start_duration").val(startDate.getTime());
})

// var oldDuration = $("#duration").val();
// var oldDurationMs = new Date(oldDuration * 1000);
// var BDn = oldDurationMs.toISOString();
// console.log(oldDurationMs);
// console.log(BDn);
// $("#auction_duration").val(BDn);