<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("test") or die(mysql_error());

$partyValue = strval($_GET["party"]);

$result = mysql_query(
	"SELECT c.year as Year, p.Name as Name, y.partyName as Party, Vote, votePercent, Result 
	FROM Parties y, Candidates c, People p, Results r
	WHERE y.partyName LIKE '$partyValue'
	AND c.partyID = y.partyID
	AND c.CID = r.CID
	AND c.PID = p.PID
	ORDER BY c.year ") or die(mysql_error()); 

if(mysql_num_rows($result) == 0){
	echo "Invalid input!";
} else {
	echo "<table border='1'>";
	echo "<tr> <th>Year</th> <th>Name</th> <th>Party</th> <th>Vote</th> <th>votePercent</th> <th>Result</th> </tr>";

	while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table

	echo "<tr><td>"; 
	echo $row['Year'];
	echo "</td><td>"; 
	echo $row['Name'];
	echo "</td><td>"; 
	echo $row['Party'];
	echo "</td><td>"; 
	echo $row['Vote'];
	echo "</td><td>"; 
	echo $row['votePercent'];
	echo "</td><td>"; 
	echo $row['Result'];
	echo "</td></tr>"; 
	} 
	echo "</table>";
}
?>

</body>
</html>

<!-- SELECT c.year as Year, p.Name as Name, y.partyName as Party, Vote, votePercent, Result 
FROM Parties y, Candidates c, People p, Results r
WHERE y.partyName = $partyValue
AND c.partyID = y.partyID
AND c.CID = r.CID
AND c.PID = p.PID
ORDER BY c.year
 -->