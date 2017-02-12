<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("test") or die(mysql_error());

$nameValue = strval($_GET["person"]);

$result = mysql_query("SELECT Year, p.name as Name, p2.partyName as Party, r.result as Result
FROM People p, Candidates c, Results r, Parties p2
WHERE c.PID = p.PID
AND c.CID = r.CID
AND c.partyID = p2.partyID
AND p.name like '%".$nameValue."%'") or die(mysql_error());  

if(mysql_num_rows($result) == 0){
	echo "Invalid input!";
} else {
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
?>

</body>
</html>

