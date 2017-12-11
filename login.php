<?php
$sess_name = session_name();
if (session_start()) {
    setcookie($sess_name, session_id(), null, '/', null, null, true);
}

$invalid = FALSE;

if(isset($_POST['u']))
{
  $phash = hash("sha256",$_POST['p']);
  $un = $_POST['u'];
  $p = $_POST['p'];
  
  
  $host = '127.0.0.1';
  $db   = 'oauth';
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
  
  $all_pass = $pdo->query('SELECT * FROM oauth_clients');
  $array = [];
  
  while ($row = $all_pass->fetch())
  {
      if($un == $row['client_id'])
      {
          array_push($array,$row);
  
          if($phash == $row['client_secret'])
          {
              $curl = curl_init();
              $url = 'https://ossecmonitor.cloud/oauth/token.php';
              
              curl_setopt($curl, CURLOPT_URL,$url);
              curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content type: application/x-www-form-urlencoded'));
              curl_setopt($curl, CURLOPT_USERPWD, $un . ":" . $phash);
              curl_setopt($curl, CURLOPT_POST, 1);
              curl_setopt($curl, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
              curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
              $response = curl_exec($curl);
              $status = curl_getinfo($curl);
              curl_close($curl);
              $arr = json_decode($response, true);
              
              $token = $arr['access_token'];
              
              $_SESSION['token'] = $token;
              
  
              header('Location: '.'index.php');
              //var_dump($arr);
          }
  
      }
  }


$invalid = TRUE;

}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <!-- Bulma Version 0.6.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
  <section class="hero is-success is-fullheight">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <h3 class="title has-text-grey">Login</h3>
          <p class="subtitle has-text-grey">Please login to proceed.</p>
          <div class="box">
            <figure class="avatar">
              <img style="width:196px;height:auto;" src="ossec.png">
            </figure>
            <?php
            if($invalid)
            {
              echo '<div class="notification is-danger">
                Incorrect username/password.
              </div>';
            }

              ?>
            <form action="login.php" method="post">
              <div class="field">
                <div class="control">
                  <input class="input is-large" type="text" name="u" placeholder="Your Username" autofocus="">
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <input class="input is-large" type="password" name="p" placeholder="Your Password">
                </div>
              </div>
              <button class="button is-block is-info is-large" type="submit">Login</a>
            </form>
          </div>
 
        </div>
      </div>
    </div>
  </section>
</body>
</html>
