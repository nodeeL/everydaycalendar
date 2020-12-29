<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Everyday calendar</title>
<link rel="stylesheet" href="daily.css" />
</head>
<?php
$year = "2021";
$startDate = new DateTime($year.'-01-01');
$endDate = new DateTime($year.'-12-31');
$days = array();
$data = array();
for ($month = 1; $month <13; $month++) {
   for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++ ) {
      $ds = date ( 'M', mktime(0,0,0,$month,1,$year));
      $data[$ds][$day] = "unchecked";
   }
}
if (isset($_POST["update"])) {
   unset ($_POST["update"]);
   foreach ($_POST as $item => $state) {
      list ($month, $day) = explode("-", $item);
      $data[$month][$day] = "checked";
   }
   file_put_contents("array.json",json_encode($data));
} elseif (isset($_POST["clear"])) {
   file_put_contents("array.json",json_encode($data));
} else {
   $data = json_decode(file_get_contents('array.json'), true);
}
?>
<body>
<form action='daily.php' method='post'>
<div class="grid">
   <div class="head">My "Do this every day" calendar for <?php echo $year ?></div>
   <input class="head" type="submit" name="update" value="Update">
   <input class="head" type="submit" name="clear" value="Clear">
</div>
<div class="grid">
<?php
foreach ($data as $m => $da) {
   echo '<div class="grid-month"><div class="month">',$m,'</div>';
   foreach ($da as $d => $v) {
//      echo '<div class="grid-day"><input class="tick" type="checkbox" name="',$m,'-',$d,'" value="',$data[$m][$d],'" ',$data[$m][$d],' /><span class="custom"></span></div>';
      echo '<div class="day-frame"><input id="',$m,'-',$d,'" class="tick" type="checkbox" name="',$m,'-',$d,'" value="',$data[$m][$d],'" ',$data[$m][$d],' /><label for="',$m,'-',$d,'" class="grid-day">',$d,'<span class="custom"></span></label></div>';
   }
   echo '</div>';
}
?>
</div>
</form>
</body>
</html>
