<?php

/**
 * This file is part of the "Approved Users" plugin for Wolf CMS.
 * Licensed under an MIT style license. For full details see license.txt.
 *
 * @author Giles Metcalf <giles@lughnasadh.com>
 * @copyright Giles Metcalf, 2015
 * 
 * Original authors:
 * 
 * @author Andrew Waters <andrew@band-x.org>
 * @copyright Andrew Waters, 2009
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2009-2013
 */
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'New users'],
<?php
$users_count = User::countFrom('User');

// month on month
$months = array(
    'Jan' => '01',
    'Feb' => '02',
    'Mar' => '03',
    'Apr' => '04',
    'May' => '05',
    'June' => '06',
    'July' => '07',
    'Aug' => '08',
    'Sep' => '09',
    'Oct' => '10',
    'Nov' => '11',
    'Dec' => '12'
);

while (list($monthname, $month) = each($months)) {
    $where = "created_on LIKE '%-$month-%'";
    $users_count = User::countFrom('User', $where);
    echo "['".$monthname."', ".$users_count."],";
} ?>
        ]);

        var options = {
          title: 'New users per month',
          hAxis: {title: 'Month'},
          vAxis: {title: 'Users'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>


<h1><?php echo __('Approved users statistics'); ?></h1>

<div id="chart_div" style="width: 800px; height: 300px; margin: 0px auto;"></div>