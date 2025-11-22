<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';
$country = $_GET['country'] ?? '';



function country_lookup($country){
  global $host;
  global $username;
  global $dbname;
  global $password;
  global $country;

  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
  $countrylist = [];
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $countrylist[$row['name']] = $row;
  };
  return $countrylist;
}


function build_Table($countries){
  $tab = "<Table>";
  $tr_strt = "<tr>";
  $tr_end = "</tr>";
  $th_strt = "<th>";
  $th_end = "</th>";
  $td_strt = "<td>";
  $td_end = "</td>";

  $tab .= $tr_strt . $th_strt . "Country Name" . $th_end . $th_strt . "Continent" . $th_end .
  $th_strt . "Independence" . $th_end . $th_strt . "Head of State" . $th_end  . $tr_end; 

  foreach ($countries as $country){
    $tab .= $tr_strt . $td_strt . $country["name"] . $td_end . $td_strt . $country["continent"] . $td_end .
    $td_strt . $country["independence_year"] . $td_end . $td_strt . $country["head_of_state"] . $td_end  . $tr_end;
  }
  $tab .= "</Table>";

  return $tab;
  
}

echo json_encode(build_Table(country_lookup($country)));
?>

<?php
/*
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
*
?>

/*
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
*/