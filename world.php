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

echo json_encode(country_lookup($country));
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