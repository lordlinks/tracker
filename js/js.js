function add_transaction() {
    var ajaxRequest;
    var name = document.getElementById('name').value;
    var shop = document.getElementById('shop').value;
    var price = document.getElementById('Amount').value;
    var date = document.getElementById('Date').value;
    if(name==0){
        document.getElementById('shady').style.display = 'block';
    } else if(shop == 0){
        document.getElementById('shoppy').style.display = 'block';
    } else if(price==0) {
        document.getElementById('dollarydoos').style.display = 'block';
    } else if(date == 0){ // something something regex here
        document.getElementById('timeywhimey').style.display = 'block';
    } else {
        document.getElementById('shady').style.display = 'none';
        document.getElementById('shoppy').style.display = 'none';
        document.getElementById('dollarydoos').style.display = 'none';
        document.getElementById('timeywhimey').style.display = 'none';
        ajaxRequest = new XMLHttpRequest();
        ajaxRequest.onreadystatechange = function () {
            if(ajaxRequest.readyState == 4){
                var ajaxDisplay = document.getElementById('knowing');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
        };
        var data = "?name=" + name + "&shop=" + shop + "&price=" + price + "&date="+ date;
        ajaxRequest.open("POST", "phpcomponents/NewTransaction.php" + data, true);
        ajaxRequest.send(null);
    }
}

function bill_payer() {
    var ajaxRequest;
    var name = document.getElementById('name').value;
    if (name==0){
        document.getElementById('shady').style.display = 'block';
    }
    else{
        document.getElementById('shady').style.display = 'none';
        ajaxRequest = new XMLHttpRequest();
        ajaxRequest.onreadystatechange = function () {
            if(ajaxRequest.readyState == 4){
                var ajaxDisplay = document.getElementById('pay');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
        };
        var data = "?name=" + name;
        ajaxRequest.open("POST", "phpcomponents/payment.php" + data, true);
        ajaxRequest.send(null);
    }
}

function pay_bill() {
    var ajaxRequest;
    var name = document.getElementById('name').value;
    if (name==0){
        document.getElementById('shady').style.display = 'block';
    }
    else{
        document.getElementById('shady').style.display = 'none';
        ajaxRequest = new XMLHttpRequest();
        ajaxRequest.onreadystatechange = function () {
            if(ajaxRequest.readyState == 4){
                var ajaxDisplay = document.getElementById('pay');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
        };
        var data = "?name=" + name;
        ajaxRequest.open("POST", "phpcomponents/pay_and_update.php" + data, true);
        ajaxRequest.send(null);
    }
}