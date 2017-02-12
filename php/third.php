<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("test") or die(mysql_error());

$chooseValue = strval($_GET["choose"]);

if($chooseValue == "Show me the result!"){

	$result = mysql_query(
		"SELECT a.year as Year, b.name as Name, d.partyName as Party, r1.result as Result
    	FROM Candidates a, People b, Parties d, Results r1,
    	(SELECT p.name
		FROM Candidates c, People p, Results r,
		(SELECT p2.year as year1, p1.year as year2, p1.PID
		FROM Presidents p1, Presidents p2
		WHERE p1.PID = p2.PID
		AND p1.year-p2.year > 4) as temp 
		WHERE c.PID = temp.PID
        AND c.CID = r.CID
		AND c. year > year1
		AND c.year < year2
		AND result = 'fail'
		AND c.PID = p.PID) as target
		WHERE b.name = target .name
		AND a.PID = b.PID
        AND a.partyID = d.partyID
        AND a.CID = r1.CID") or die(mysql_error());  

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


