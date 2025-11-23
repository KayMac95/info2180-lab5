<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';
$country = $_GET['country'] ?? '';
$flag = $_GET['flag'] ?? '';



function country_lookup($country){
  global $host;
  global $username;
  global $dbname;
  global $password;
  global $country;
  

  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

  $country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
  $like_country = "%{$country}%";
  $stmt->bindParam(':country', $like_country, PDO::PARAM_STR);
  $stmt->execute();

  $countrylist = [];
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $countrylist[$row['name']] = $row;
  };
  return $countrylist;
}

function city_lookup($country){
  global $host;
  global $username;
  global $dbname;
  global $password;
  global $country;


  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

  $country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
  $stmt = $conn->prepare("SELECT countries.name AS country, cities.name, cities.district, cities.population FROM cities JOIN countries ON countries.code = cities.country_code WHERE countries.name = :country");
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);
  $stmt->execute();

  $countrylist = [];
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $countrylist[$row['country']] = $row;
  };
  return $countrylist;
}


function build_Table($countries){
  $tab = "<table class='res_table'>";
  $tr_strt = "<tr>";
  $tr_end = "</tr>";
  $th_strt = "<th>";
  $th_end = "</th>";
  $td_strt = "<td>";
  $td_end = "</td>";
  global $flag;

  if ($flag == "country"){

    // Set up the header row
    $tab .= $tr_strt . $th_strt . "Country Name" . $th_end . $th_strt . "Continent" . $th_end .
    $th_strt . "Independence" . $th_end . $th_strt . "Head of State" . $th_end  . $tr_end; 

    // Set up the rows for each country
    foreach ($countries as $country){
      $tab .= $tr_strt . $td_strt . htmlspecialchars($country["name"]) . $td_end . $td_strt . htmlspecialchars($country["continent"]) . $td_end .
      $td_strt . htmlspecialchars($country["independence_year"]) . $td_end . $td_strt . htmlspecialchars($country["head_of_state"]) . $td_end  . $tr_end;
    }
    $tab .= "</table>";
    return $tab;
  }

  else{
    // Set up the header row
    $tab .= $tr_strt . $th_strt . "Name" . $th_end . $th_strt . "District" . $th_end . $th_strt . "Population" . $th_end .$tr_end;


    // Set up the rows for each country + city
    foreach ($countries as $country_city){
      $tab .= $tr_strt . $td_strt . htmlspecialchars($country_city["name"]) . $td_end . $td_strt . htmlspecialchars($country_city["district"]) . $td_end . $td_strt . htmlspecialchars($country_city["population"]) . $td_end . $tr_end;
    }
    $tab .= "</table>";
    return $tab;
  }
  
  
}
if ($flag == 'country'){
  echo json_encode(build_Table(country_lookup($country)));
}
else{
  echo json_encode(build_Table(city_lookup($country)));
}

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