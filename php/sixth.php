<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("127.0.0.1", "root", "");
mysql_select_db("test") or die(mysql_error());

$stateValue = strval($_GET["state"]);

// Get all the data from the "tablefirst" table
$result = mysql_query(" SELECT distinct pp.name AS PresidentName, p.year AS Year, py.partyName AS Party
FROM test.Candidates c, test.Presidents p, test.People pp, test.Parties py
WHERE p.year NOT IN (
SELECT  distinct c1.year
FROM test.Candidates c1
) AND p.PID = pp.PID AND p.partyID = py.partyID;
")
or die(mysql_error());

if(mysql_num_rows($result) == 0){
	echo "Invalid input!";
} else {
	echo "<table border='1'>";
	echo "<tr> <th>PresidentName</th> <th>Year</th> <th>Party</th> </tr>";

	while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table

	echo "<tr><td>";
	echo $row['PresidentName'];
	echo "</td><td>";
	echo $row['Year'];
	echo "</td><td>";
	echo $row['Party'];
	echo "</td></tr>";
	}
	echo "</table>";
}
?>

</body>
</html>
