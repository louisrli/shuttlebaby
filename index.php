
<?php
$stops = unserialize(file_get_contents("http://shuttleboy.cs50.net/api/1.2/stops?output=php"));

$raw_src = "Mather House";
$raw_dest = "Quad";

$src = urlencode($raw_src);
$dest = urlencode($raw_dest);

function get_trips($src_name, $dest_name) {
  $base_api = "http://shuttleboy.cs50.net/api/1.2/trips?output=php";
  $url_trips = $base_api . "&a=" . $src_name . "&" . "b=" . $dest_name;
  return unserialize(file_get_contents($url_trips));
}

$forward_trips = get_trips($raw_src, $raw_dest);
$backward_trips = get_trips($raw_dest, $raw_src);

$all_trips = array($forward_trips, $backward_trips);

// Maximum number of trips to display
$NUM_TRIPS = 3;
?>

<!doctype html>
<html>
  <head>
  <title>mather quad</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

  </head>
  
  <body>

  <div>

  <table>
     <tr>
        <th>mather to quad</th>
        <th>quad to mather</th>
     </tr>

  <?php
  foreach ($all_trips as $trip_array) {
  for ($i = 0; i < max(NUM_TRIPS)
}
?>
     <tr>
        <td>foobar</td>
     </tr>
     <tr>
        <td>hello</td>
     </tr>
  </table>

  <? print_r($trips) ?>
  </div>
  </body>
  
</html>
