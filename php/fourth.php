<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("test") or die(mysql_error());

$chooseValue = strval($_GET["choose"]);

if($chooseValue == "Show me the result!"){

	$result = mysql_query(
		"SELECT c.year as Year, p.name as Name, partyName as Party, Result
FROM Candidates c, People p, Parties p2, Results r,
(SELECT distinct c1.PID 
FROM Candidates c1, Candidates c2
WHERE c1.PID = c2.PID
and c1.partyID != c2.partyID) as temp
WHERE c.PID = temp.PID
and c.PID = p.PID
AND c.partyID = p2.partyID
AND c.CID = r.CID
ORDER BY p.name") or die(mysql_error());  

	echo "<table border='1'>";
	echo "<tr> <th>Year</th> <th>Name</th> <th>Party</th> <th>Result</th> </tr>";

	while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table

	echo "<tr><td>"; 
	echo $row['Year'];
	echo "</td><td>"; 
	echo $row['Name'];
	echo "</td><td>"; 
	echo $row['Party'];
	echo "</td><td>"; 
	echo $row['Result'];
	echo "</td></tr>"; 
	} 
	echo "</table>";
}
else {
	echo "There is no input!";
}

?>

</body>
</html>


