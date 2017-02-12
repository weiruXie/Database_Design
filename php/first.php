<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("test") or die(mysql_error());

$yearValue = intval($_GET["year"]);

$result = mysql_query(
	"SELECT c.year as Year, p1.name as Name, p2.partyName as Party, r.vote as Vote, votePercent, poll, Result 
	FROM Candidates c , People p1, Parties p2, Results r
	WHERE c.year = $yearValue AND c.PID = p1.PID
	AND c.CID = r.CID
	AND c.partyID = p2.partyID
	order by vote desc ") 
	or die(mysql_error());  

if(mysql_num_rows($result) == 0){
	echo "Invalid input!";
} else {
	echo "<table border='1'>";
	echo "<tr> <th>Year</th> <th>Name</th> <th>Party</th> <th>Vote</th> <th>votePercent</th> <th>poll</th>  <th>Result</th> </tr>";

	while($row = mysql_fetch_array( $result )) {

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
	echo $row['poll'];
	echo "</td><td>";
	echo $row['Result'];
	echo "</td></tr>"; 
	} 
	echo "</table>";
}
?>

</body>
</html>


<!-- SELECT c.year, p.name, state, party, vote, votePercent, poll FROM Candidates c , Person p
WHERE c.year = $yearValue and c.PID = p.PID -->
