<?php

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
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OSSEC Log Monitor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
    <script src="../jquery.min.js"></script>

    <!--<script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script> -->
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>
  <body>
  <section class="section">
    <div class="container">
      <h1 class="title"><span style="color:#3273dc";>
        <img src="../ossec.png" style="height:40px; width:auto;">OSSEC MonitorUI</span>
      </h1>
      <hr>
        <div class="columns">
            <div class="column is-one-third">
                <form action="../api/send_alert.php" method="post">
                <div class="field">
                    <label class="label">Rule id</label>
                        <div class="control">
                            <input class="input" name="rule_id" type="text" value="1337">
                        </div>
                </div>

                <div class="field">
                    <label class="label">Src IP</label>
                        <div class="control">
                            <input class="input" name="src_ip" type="text" value="192.168.1.1">
                        </div>
                </div>

                <div class="field">
                    <label class="label">Dest IP</label>
                        <div class="control">
                            <input class="input" type="text"  name="dest_ip" value="172.31.56.250">
                        </div>
                </div>

                <div class="field">
                    <label class="label">Src Port</label>
                        <div class="control">
                            <input class="input" type="text"  name="src_port" value="10123">
                        </div>
                </div>
                <div class="field">
                    <label class="label">Dest Port</label>
                        <div class="control">
                            <input class="input" type="text"  name="dest_port" value="443">
                        </div>
                </div>

                <div class="field">
                    <label class="label">Full Log</label>
                    <div class="control">
                        <textarea class="textarea" name="full_log" placeholder="Textarea">This is an example of a full log that could be entered.</textarea>
                    </div>
                </div>
                <input type="hidden" name="access_token" value="<?php echo $token;?>">
                    <div class="control">
                        <button class="button is-link" type="submit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
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