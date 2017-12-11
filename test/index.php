<?php

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Security Tests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="../jquery.min.js"></script>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
      input
      {
        margin-bottom:10px;
      }
    </style>
</head>
  <body>
  <section class="section">
    <div class="container">
      <h1 class="title"><span style="color:#3273dc";>
        <img src="api.png" style="height:60px; width:auto;">API Security Tests</span>
      </h1>
      <hr>
        <div class="columns">
          <div class="column is-one-third">
            <form action="https://ossecmonitor.cloud/test/test.php" method="post">
              <div class="field">
                <label class="label">Base URL</label>
                  <div class="control">
                      <input class="input" name="base_url" type="text" value="https://ossecmonitor.cloud">
                    </div>
                  </div>

                  <div class="field" id="inputsCol">
                    <label class="label">API Endpoints</label>
                    <div class="control">
                        <input class="input" name="endpoints[]" type="text" value="alerts.php">
                      </div>
                      <div class="control">
                        <input class="input" name="endpoints[]" type="text" value="events.php">
                      </div>            
                      <div class="control">
                        <input class="input" name="endpoints[]" type="text" value="sessions.php">
                      </div>            
                      <div class="control">
                        <input class="input" name="endpoints[]" type="text" value="send_alert.php">
                      </div>
                  </div>
            
         
          <div class="field is-grouped">
            <div class="control">
                <button id="go" type="submit" class="button is-link is-outlined">Go</button>
            </div>
          
            <div class="control">
              <button id="add" type="button" class="button is-link is-outlined"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
          </div>
        </div>

  </form>
  </div>
<hr>

        </div>
    </section>
<script>
 $( document ).ready(function() {
  console.log( "ready!" );
  
  $('#add').click(function()
  {
    var newInp = '<div class="field has-addons"><div class="control"><input class="input" name="endpoints[]" type="text" placeholder="Additional endpoint"></div><div class="control"><a class="button is-link is-outlined minusBtn"><i class="fa fa-minus-square" aria-hidden="true"></i></a></div></div>';
    $('#inputsCol').append(newInp);
  });

  $(document).on("click", ".minusBtn",function(e) {
    e.preventDefault();
    console.log("clicked");
    $(this).parents().eq(1).remove();
  });
});
</script>
    <footer class="footer">
    <div class="container">
      <div class="content has-text-centered">
        <p>
<strong>Craig Kilgo</strong> | CMSC 618 <br> <a href="https://bulma.io/">Bulma</a> | <a href="https://jquery.com/">jQuery</a> 
        </p>
      </div>
    </div>
  </footer>
    </body>
</html>
