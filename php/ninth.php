<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("127.0.0.1", "root", "");
mysql_select_db("test") or die(mysql_error());

$chooseValue = strval($_GET["choose"]);

if($chooseValue == "Show me the result!"){
  $result = mysql_query("SELECT  temp.partyName AS Party, COUNT(temp.PID) AS PresidentNum FROM
  (SELECT DISTINCT p.PID, PT.partyName
  FROM test.Presidents p, test.Parties PT
  WHERE p.partyID = PT.partyID AND PT.partyName != 'None') AS temp
  GROUP BY temp.partyName
  ORDER BY COUNT(temp.PID) DESC
  ")
  or die(mysql_error());

  echo "<table border='1'>";
  echo "<tr> <th>Party</th> <th>PresidentNum</th> </tr>";

  while($row = mysql_fetch_array( $result )) {
  // Print out the contents of each row into a table

  echo "<tr><td>";
  echo $row['Party'];
  echo "</td><td>";
  echo $row['PresidentNum'];
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
