<?php
class Error{
  function fileNotFound(){
    echo '<script>alert("That ticker Doesnt exist");</script>';
    return false;
  }
  public function PleaseLogIn()
  {
    ?>
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8">
        <title>Ooops!</title>
      </head>
      <body>
        You need to be logged in to view this content
      </body>
    </html>
    <?php
  }

  public function comboNotFound($value='')
  {
    echo '<script type="text/javascript">
        confirm("Username/password combination not found");
        window.location.href = "../login.php";
    </script>';;
  }
}

 ?>