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
    } else if(typeof (price) == "string") { //more advanced method may be good
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

function add_pie() {
    var jsonData = $.ajax({
        url: "phpcomponents/pie_chart.php",
        dataType:"json",
        async: false
    }).responseText;

// Create our data table out of JSON data loaded from server.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable(jsonData);

        // Set chart options
        var options = {
            'title': 'Amount spent by location (current month)',
            'width': 400,
            'height': 300
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('pie_div'));
        chart.draw(data, options);
    }
}

function add_column() {
    var jsonData = $.ajax({
        url: "phpcomponents/column_chart.php",
        dataType: "json",
        async: false
    }).responseText;

// Create our data table out of JSON data loaded from server.
    google.charts.load('current', {'packages': ['bar']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable(jsonData);

        // Set chart options
        var options = {
            'title': 'Amount spent by people (current month)',
            'width': 400,
            'height': 300,
            'colors': ['#AA5139', '#AA8B39', '#323875', '#29794C'],
            'is3d': true
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('column_div'));
        chart.draw(data, options);
    }
}