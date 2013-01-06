
<?php
  // See Shuttleboy API for valid stop names
  $raw_src = "Mather House";
  $raw_dest = "Quad";
  
  $src = urlencode($raw_src);
  $dest = urlencode($raw_dest);
  
  function get_trips($src_name, $dest_name) {
      $base_api = "http://shuttleboy.cs50.net/api/1.2/trips?output=php";
      $url_trips = "{$base_api}&a=" . urlencode($src_name) . "&b=" . urlencode($dest_name);
      return unserialize(file_get_contents($url_trips));
  }
  
  $forward_trips = get_trips($raw_src, $raw_dest);
  $forward_trips['name'] = "$raw_src to $raw_dest";

  $backward_trips = get_trips($raw_dest, $raw_src);
  $backward_trips['name'] = "$raw_dest to $raw_src";

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
      <?php
        foreach ($all_trips as $trip_array) {
    echo "<table><tr><th>" . strtolower($trip_array['name']) . "</th></tr>";

    if (empty($trip_array)) {
      echo "<tr><td>";
      echo "No trips found.";
      echo "</tr></td>";
    }

    for ($i = 0; $i < min($NUM_TRIPS, count($trip_array)); $i++) {
                echo "<tr><td>";
		$next_departure = strtotime($trip_array[$i]["departs"]);
		echo date("H:i", $next_departure); 

		$min_from_now = round(abs($next_departure - time()) / 60);
		echo " <span class=\"minortext\">{$min_from_now} min</span>";

                echo "</tr></td>";
		
	}
                 echo "</table>";
        }
      ?>
    </div>
  </body>
  
</html>
