<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("127.0.0.1", "root", "");
mysql_select_db("test") or die(mysql_error());

$chooseValue = strval($_GET["choose"]);

if($chooseValue == "Show me the result!"){
  $result = mysql_query("SELECT name AS President, count AS Reappointment_Times 
    FROM People p, 
    (select p1.PID, count(p1.PID)*2-(count(p1.PID)-1) as count
    FROM Presidents p1, Presidents p2
    WHERE p1.PID = p2.PID
    AND p2.year-p1.year <= 4
    AND p2.year > p1.year
    GROUP BY p1.PID) as temp
    WHERE p.PID = temp.PID;
  ")
  or die(mysql_error());

  echo "<table border='1'>";
  echo "<tr> <th>President</th> <th>Reappointment_Times</th> </tr>";

  while($row = mysql_fetch_array( $result )) {
  // Print out the contents of each row into a table

  echo "<tr><td>";
  echo $row['President'];
  echo "</td><td>";
  echo $row['Reappointment_Times'];
  echo "</td></tr>";
  }
  echo "</table>";
}
else{
  echo "There is on input!";
}
?>

</body>
</html>
