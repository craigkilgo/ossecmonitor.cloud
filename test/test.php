
<?php

$endpoints = $_POST['endpoints'];
$base_url = $_POST['base_url'];

$curl = curl_init();
$url = 'https://ossecmonitor.cloud/oauth/token.php';
$username = 'app';
$p = 'O4o1HWKtSAy0hhYM7VCdkDvQ';

curl_setopt($curl, CURLOPT_URL,$url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content type: application/x-www-form-urlencoded'));
curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $p);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
$response = curl_exec($curl);
$status = curl_getinfo($curl);
curl_close($curl);
$arr = json_decode($response, true);

$token = $arr['access_token'];

$host = '127.0.0.1';
$db   = 'monitor';
$user = 'root';
$pass = 'monitor-cisobox';
$charset = 'utf8mb4';



$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$now = time();

$cookie_query = "INSERT INTO alert (id,server_id,rule_id,timestamp,src_ip,dst_ip, full_log) VALUES ('1','01','007','123456789','10123','80','<script>alert(document.cookie);</script>')";
$cookie = $pdo->query($cookie_query);

//CSRF

//SQL Injection



?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Security Tests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
    <script src="../jquery.min.js"></script>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
      input
      {
        margin-bottom:10px;
      }

      /* Code Styles */


      #codeStyler {
        font-family: Courier, 'New Courier', monospace;
        font-size: 16px;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        margin: 1em 0;
        background-color: #000000;
      color: #6FFF48;
      padding:10px;
      
        
      }

    </style>
</head>
  <body>

<div class="container">
    <section style="margin-top:10px;">
    <h1 class="title"><span style="color:#3273dc";>
        <img src="api.png" style="height:60px; width:auto;">API Endpoints Security Tests</span>
      </h1>
    <hr>
    </section>
      <section style="margin-top:20px;">
        <div class="card">
        <header class="card-header">
          <p class="card-header-title">Open Endpoint Test</p>
          </header>
          <div class="card-content" id="endCard">

        
        </div>
      </div>
  </section>
  <section style="margin-top:30px;">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">XSS Cookie Stealing Test</p>
          </header>
          <div class="card-content" id="endCard">
          <p><strong>The following cookie stealing example script has been inserted in the alerts table:<br></strong> 
          
          <div id="codeStyler">&lt;script>alert(document.cookie);&lt;/script></div>
          </p>
          <a class="button" target="_blank" href="https://ossecmonitor.cloud/">Check for vulnerable cookie</a>
        
        </div>
      </div>
    </section>
  <section style="margin-top:30px;">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">SQL Injection Test</p>
          </header>
          <div class="card-content" id="endCard">
          <form id="sqlForm" method="post" action="../api/send_alert.php">
            <input type="hidden" name="access_token" value="<?php echo $token;?>"><br>
            <strong>Rule ID:</strong>
            <input type="text" class="input" name="rule_id" value="1337"><br>
            <strong>Src IP:</strong>
            <input type="text" class="input" value="10.0.0.1" name="src_ip"><br>
            <strong>Dest IP:</strong>
            <input type="text" class="input" value="192.168.1.1" name="dest_ip"><br>
            <strong>Src Port:</strong>
            <input type="text" class="input" value="10234" name="src_port"><br>
            <strong>Dest Port:</strong>
            <input type="text" class="input" value="80" name="dest_port"><br>
            <strong>Log:</strong>
            <input type="text" class="input" value="good example" name="full_log"><br>
            <strong>Bad Log:</strong>
            <input type="text" class="input" value="bad example');--Comment" name="full_log"><br>
            <!--<button type="submit" class="button">Send SQL Test</button>-->
          </form>
          <button type="button" id="sqlBtn" class="button">Send Good SQL Test</button>
          <button type="button" id="sqlBtnBad" class="button">Send Bad SQL Test</button>
          <script>
            $(document).ready(function() {
                $("#sqlBtn").click(function(){
                  var token = "<?php echo $token?>";

                    var url = "../api/send_alert.php";
                    let data = 'access_token='+token+'&rule_id=1337&src_ip=10.0.0.1&dest_ip=192.168.1.1&src_port=10234&dest_port=80&full_log=good%20example'
                    let data2 = 'access_token='+token+"&rule_id=1337&src_ip=10.0.0.1&dest_ip=192.168.1.1&src_port=10234&dest_port=80&full_log=bad%20example');--Comment"

                    var formData = new FormData($('#sqlForm'));
                    // The parameters we are gonna pass to the fetch function
                    let fetchData = { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }, 
                        body: data
                    }


                    fetch(url, fetchData)
                    .then(function(response) {
                        console.log(response.statusText);



                        })
                  });

                  $("#sqlBtnBad").click(function(){
                  var token = "<?php echo $token?>";

                    var url = "../api/send_alert.php";
                    let data = 'access_token='+token+"&rule_id=1337&src_ip=10.0.0.1&dest_ip=192.168.1.1&src_port=10234&dest_port=80&full_log=bad%20example');--Comment"

                    var formData = new FormData($('#sqlForm'));
                    // The parameters we are gonna pass to the fetch function
                    let fetchData = { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }, 
                        body: data
                    }


                    fetch(url, fetchData)
                    .then(function(response) {
                        console.log(response.statusText);



                        })
                  });
            });
          </script>
        
        </div>
      </div>
    </section>



</div>

<footer class="footer" style="margin-top:30px;">
    <div class="container">
      <div class="content has-text-centered">
        <p>
<strong>Craig Kilgo</strong> | CMSC 618 <br> <a href="https://bulma.io/">Bulma</a> | <a href="https://jquery.com/">jQuery</a> 
        </p>
      </div>
    </div>
  </footer>


<script>
$( document ).ready(function() {

  
    console.log( "ready!" );
    var endpoints = [];
    <?php
      $i = 0;
      foreach($endpoints as $end)
      {
        echo "endpoints[".$i."] = '".$end."';
        ";
        $i++;
      }
    ?>

        var url = "";
        var data = '';
        
        endpoints.forEach(function(end)
        {

            url = '../api/'+end;
            // The parameters we are gonna pass to the fetch function
            
            let fetchData = { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }, 
                body: data
            }

            fetch(url, fetchData)
            .then(function(response){
              if(response.status == "200")
              {
                $("#endCard").append("<strong>"+end+"</strong> returned the response:<br><div class='notification is-success'>"+response.status+" "+response.statusText+"</div>");
                $("#endCard").append("</div>");
              }
              else
              {
                $("#endCard").append("<strong>"+end+"</strong> returned the response:<br><div class='notification is-danger'>"+response.status+" "+response.statusText+"</div>");
                $("#endCard").append("</div>");
              }
             
            })
   
          });

    console.log(endpoints);

    
});

</script>


      </body>
      </html>