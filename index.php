
<?php
/* This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

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
    <title>shuttlebaby: mather-quad</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="shuttlebaby.css"/>
    <link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>

  </head>
  
  <body>
    
    <div id="container">
      <?php
  foreach ($all_trips as $trip_array) {
      echo "<table class=\"trips\"><tr><th>" . strtolower($trip_array['name']) . "</th></tr>";

      if (empty($trip_array)) {
          echo "<tr><td>";
          echo "No trips found.";
          echo "</tr></td>";
      }

      // Iterate through the forward and backward trips
      for ($i = 0; $i < min($NUM_TRIPS, count($trip_array)); $i++) {
          echo "<tr><td>\n";
          $next_departure = strtotime($trip_array[$i]["departs"]);
          echo date("H:i", $next_departure); 

          // convert to hours if needed
          $time_from_now = round(abs($next_departure - time()) / 60);
          $units = "min";

          if ($time_from_now > 60) {
              $time_from_now = round($time_from_now / 60, 1);
              $units = "hrs";
          }

          echo "<span class=\"minortext\"> ({$time_from_now} {$units})</span>\n";

          echo "</tr></td>\n";
		
      }
      echo "</table>";
  }
?>
    </div>

    <div class="footer">
      <a href="https://github.com/louisrli/shuttlebaby">roll your own shuttlebaby</a> 
      by changing two lines of code.
      </br></br>
      <a href="mailto:louisli@college.harvard.edu">.</a>
    </div>
  </body>
  
</html>
