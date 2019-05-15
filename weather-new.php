<?php 

error_reporting(0);

$weather = "";
$error = "";

if (array_key_exists('city', $_GET)) {

  
  $urlContents = file_get_contents("http://api.openweathermap.org//data/2.5/weather?q=".urlencode($_GET['city'])."&appid=6791ee49784e2d0f0099dfaac977bbe8");
  
  $weatherArray = json_decode($urlContents, true);
  
  if ($weatherArray['cod'] == 200) {
    $error = "";
    $weather = "The weather in ".ucfirst($_GET['city'])." is currently '".$weatherArray['weather'][0]['description']."'. <br>";
  
    $tempInCelcius = intval($weatherArray['main']['temp'] - 273.15);
  
    $weather .= "The temperature is ".$tempInCelcius."°C. <br>";
  
    $weather .= "The wind speed is ".$weatherArray['wind']['speed']." m/s. ";  
  } else {
    $weather = "";
    $error = "This city could not be found. Sorry!";
  }
  
//  print_r($weatherArray);
  
  
}

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="shortcut icon" href="images/weather.ico" type="image/x-icon">

    <title>Weather Scraper</title>
    
    <style>
      body { 
        background: url("images/background.jpeg") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
      
      #container-1 {
        position: relative;
        top: 150px;
      }
      
      .alert {
        width: 450px;
      }
      
      form {
        margin: 0 auto;
        text-align: center;
      }
      #submit-btn {
        
        font-size: 140%;
        margin-top: 20px;
      }
      
      #city-input {
        width: 500px;
      }
      
      
      body {
        height: 800px;
      }
      
    </style>
  </head>
  <body>
  <div id="container-1" class="container">
      <div class="mb-1">
        <h1 class="display-4 text-center">What's the weather?</h1>
        <p class="lead text-center">Enter the name of a city</p>
      </div>


    <div id="input-div" class="row justify-content-center align-items-center h-100">
      <form method="get">
        <input id="city-input" name="city" type="text" class="form-control" placeholder="E.g. London, Moscow" aria-label="Username" aria-describedby="basic-addon1" value="<?php if (array_key_exists("city", $_GET)) { echo $_GET['city']; }?>">

        <input type="submit" id="submit-btn" class="btn btn-primary form-group mb-2" value="Find out!">
      </form>
    
    </div>
    <div id="input-div" class="row justify-content-center align-items-center h-100">
      <?php 
        if ($_GET) {
          if ($error == "") {
            echo '<div class="alert alert-success text-center" role="alert">'.$weather.'</div>';  
          } else {
            echo '<div class="alert alert-danger text-center" role="alert">'.$error.'</div>';
          }
        }
      ?>
    </div>
    
  </div>
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script>
      
      $("#city-input").keyup(function(event) {
          if (event.keyCode === 13) {
              $("#submit-btn").trigger('click');
          }
      });
      
    </script>
  </body>
</html>