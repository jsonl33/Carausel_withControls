<?php
//index.php
$connect = mysqli_connect("localhost", "root", "", "testing");
//mysqli_connect(hostname or IP address, MySQL username, password, dbname);
function make_query($connect)
{
  $query = "SELECT * FROM banner ORDER BY banner_id ASC";
  $result = mysqli_query($connect, $query);
  return $result;
}

function make_slide_indicators($connect)
{
  $output = '';
  $count = 0;
  $result = make_query($connect);
  while ($row = mysqli_fetch_array($result)) {
    if ($count == 0) {
      $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="' . $count . '" class="active"></li>
   ';
    } else {
      $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="' . $count . '"></li>
   ';
    }
    $count = $count + 1;
  }
  return $output;
}

function make_slides($connect)
{
  $output = '';
  $count = 0;
  $result = make_query($connect);
  while ($row = mysqli_fetch_array($result)) {
    if ($count == 0) {
      $output .= '<div class="item active">';
    } else {
      $output .= '<div class="item">';
    }
    $output .= '
   <img src="banner/' . $row["banner_image"] . '" alt="' . $row["banner_title"] . '" />
  </div>
  ';
    $count = $count + 1;
  }
  return $output;
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>신데렐라 성형외과</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
    // 3초마다 다음 이미지로 넘어가게 하는 스크립트
    $(document).ready(function () {
      $('.carousel').carousel({
        interval: 3000 // Change slide interval here (in milliseconds)
      });
    });
  </script>
</head>

<body>
  <br />
  <div class="container">
    <div id="dynamic_slide_show" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <?php echo make_slide_indicators($connect); ?>
      </ol>

      <div class="carousel-inner">
        <?php echo make_slides($connect); ?>
      </div>
      <a class="left carousel-control" href="#dynamic_slide_show" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="right carousel-control" href="#dynamic_slide_show" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </div>
</body>

</html>