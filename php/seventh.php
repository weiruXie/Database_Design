<!DOCTYPE html>
<html>
<body>

<?php

mysql_connect("127.0.0.1", "root", "");
mysql_select_db("test") or die(mysql_error());

$chooseValue = strval($_GET["choose"]);

if($chooseValue == "Show me the result!"){
  $result = mysql_query("SELECT distinct c.year as Year, pp1.name AS Failed_Candidate, py.partyName AS Candidate_Party,r.poll AS
Candidate_Poll,r.vote AS Candidate_Vote, pp2.name AS President, py2.partyName AS President_Party,
r1.poll AS President_Poll,r1.vote AS President_Vote
  FROM test.candidates c,test.People pp1,test.People pp2, test.Results r,test.Results r1, test.Presidents p,
  test.Parties py,test.Parties py2,test.candidates c1,
  (SELECT MAX(r.poll) AS maxpoll,c.year
  FROM test.candidates c, test.Results r
  WHERE c.CID = r.CID and c.year > 1932
  GROUP BY c.year) AS temp
  WHERE (c.CID = r.CID AND temp.year = c.year AND temp.maxpoll = r.poll AND r.result = 'fail'
  AND c.partyID = py.partyID AND c.PID = pp1.PID) AND c.year = p.year AND p.PID = pp2.PID
  and p.partyID = py2.partyID AND c1.year = c.year and c1.PID = p.PID AND r1.CID = c1.CID ;
  ")
  or die(mysql_error());

  echo "<table border='1'>";
  echo "<tr> <th>Year</th> <th>Failed_candidate</th> <th>Candidate_Party</th> 
  <th>Candidate_Poll</th> <th>Candidate_Vote</th> <th>President</th> <th>President_Party</th> <th>President_Poll</th> <th>President_Vote</th> </tr>";

  while($row = mysql_fetch_array( $result )) {
  // Print out the contents of each row into a table

  echo "<tr><td>";
  echo $row['Year'];
  echo "</td><td>";
  echo $row['Failed_Candidate'];
  echo "</td><td>";
  echo $row['Candidate_Party'];
  echo "</td><td>";
  echo $row['Candidate_Poll'];
  echo "</td><td>";
  echo $row['Candidate_Vote'];
  echo "</td><td>";
  echo $row['President'];
  echo "</td><td>";
  echo $row['President_Party'];
  echo "</td><td>";
  echo $row['President_Poll'];
  echo "</td><td>";
  echo $row['President_Vote'];
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
