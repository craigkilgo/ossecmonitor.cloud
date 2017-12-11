<?php
session_start();

if(!isset($_SESSION['token']))
{
    header('Location:login.php');
}

$token = $_SESSION['token'];
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OSSEC Log Monitor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <!--<script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script> -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
  <body>
  <section class="section">
    <div class="container">
      <h1 class="title"><span style="color:#3273dc";>
        <img src="ossec.png" style="height:40px; width:auto;">OSSEC MonitorUI</span>
      </h1>
      <hr>

        <div class="field has-addons is-pulled-right">
            <p class="control">
              <a class="button is-link is-outlined" id="alertBtn">
                <span>Alerts</span>
              </a>
            </p>
            <p class="control">
              <a class="button is-link is-outlined" id="eventBtn">
                <span>Events</span>
              </a>
            </p>
            <p class="control">
              <a class="button is-link is-outlined" id="sessionBtn">
                <span>Sessions</span>
              </a>
            </p>
          </div>
            <p>
                <h4 class="title is-4" id="tableTitle">Alerts</h4>
            </p>

        <div class="tableDiv" style="margin-top:30px;">
        <table id="mainTable" class="mdl-data-table" cellspacing="0" width="100%">
            <thead id="tableHead">
                <tr>
                    <th>id</th>
                    <th>Rule id</th>
                    <th>Timestamp</th>
                    <th>Src IP</th>
                    <th>Dest IP</th>
                    <th>Src Port</th>
                    <th>Dest Port</th>
                    <th>Full Log</th>
                </tr>
            </thead>
            <tfoot id="tableFoot">
                <tr>
                    <th>id</th>
                    <th>Rule id</th>
                    <th>Timestamp</th>
                    <th>Src IP</th>
                    <th>Dest IP</th>
                    <th>Src Port</th>
                    <th>Dest Port</th>
                    <th>Full Log</th>
                </tr>
            </tfoot>
            <tbody id="tableBody">

            </tbody>
        </table>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    

    var token = '<?php echo $token;?>';
    
    function reloadDT()
    {
        table = $('#mainTable').DataTable( {
            columnDefs: [
                {
                    targets: [ 0, 1, 2 ],
                    className: 'mdl-data-table__cell--non-numeric'
                }
            ]
            } );
    }
    function loadAlert()
    {
        var url = "api/alerts.php";
        let data = 'access_token='+token
        // The parameters we are gonna pass to the fetch function
        let fetchData = { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }, 
            body: data
        }


        fetch(url, fetchData)
        .then((resp) => resp.json()) // Transform the data into json
        .then(function(data) {
            
            var tr = '';
            for (var i = 0, len = data.length; i < len; i++) {
                tr = '<tr><td>'+data[i]['id']+'</td><td>'+data[i]['rule_id']+'</td><td>'+data[i]['timestamp']+'</td><td>'+data[i]['src_ip']+'</td><td>'+data[i]['dst_ip']+'</td><td>'+data[i]['src_port']+'</td><td>'+data[i]['dst_port']+'</td><td>'+data[i]['full_log']+'</td></tr>';
                $("#tableBody").append(tr);
            }
            reloadDT();

            })
    }
    loadAlert();

    function reloadAlert()
    {
        table.destroy();
        var th = "<tr><th>id</th><th>Rule id</th><th>Timestamp</th><th>Src IP</th><th>Dest IP</th><th>Src Port</th><th>Dest Port</th><th>Full Log</th></tr>";
        $("#tableHead").html(th);
        $("#tableFoot").html(th);
        $("#tableBody").html("");

        loadAlert();
        $("#tableTitle").html("Alerts");
    }

    function loadEvent()
    {
        table.destroy();
        
        var th = "<tr><th>id</th><th>Session id</th><th>IP</th><th>Content</th></tr>";
        $("#tableHead").html(th);
        $("#tableFoot").html(th);
        $("#tableBody").html("");

        var url = "api/events.php";
        
        

        let data = 'access_token='+token
        // The parameters we are gonna pass to the fetch function
        let fetchData = { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }, 
            body: data
        }


        fetch(url, fetchData)
        .then((resp) => resp.json()) // Transform the data into json
        .then(function(data) {
            
            var tr = '';
            for (var i = 0, len = data.length; i < len; i++) {
                tr = '<tr><td>'+data[i]['id']+'</td><td>'+data[i]['session_id']+'</td><td>'+data[i]['ip_address']+'</td><td>'+data[i]['content']+'</td></tr>';
                $("#tableBody").append(tr);
            }
            reloadDT();
            
            })
            
        $("#tableTitle").html("Events");
    }

    function loadSession()
    {
        table.destroy();
        var th = "<tr><th>id</th><th>IP</th><th>Content</th></tr>";
        
        $("#tableHead").html(th);
        $("#tableFoot").html(th);

        $("#tableBody").html("");

        var url = "api/sessions.php";
        let data = 'access_token='+token
        // The parameters we are gonna pass to the fetch function
        let fetchData = { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }, 
            body: data
        }


        fetch(url, fetchData)
        .then((resp) => resp.json()) // Transform the data into json
        .then(function(data) {
            
            var tr = '';
            for (var i = 0, len = data.length; i < len; i++) {
                tr = '<tr><td>'+data[i]['id']+'</td><td>'+data[i]['ip_address']+'</td><td>'+data[i]['content']+'</td></tr>';
                $("#tableBody").append(tr);
            }

            reloadDT();

            })

            
        $("#tableTitle").html("Sessions");
    }

    $("#alertBtn").click(reloadAlert);
    $("#eventBtn").click(loadEvent);
    $("#sessionBtn").click(loadSession);

} );

</script>
  <footer class="footer">
    <div class="container">
      <div class="content has-text-centered">
        <p>
<strong>Craig Kilgo</strong> | CMSC 618 <br> <a href="https://bulma.io/">Bulma</a> | <a href="https://datatables.net/">DataTables</a> | <a href="https://jquery.com/">jQuery</a> | <a href="https://ossec.github.io/">OSSEC</a>
        </p>
      </div>
    </div>
  </footer>
  </body>
</html>