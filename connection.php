<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gis_penduduk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

if (isset($_GET['villageName'])) {
    $villageName = $conn->real_escape_string($_GET['villageName']);

    // Query to get data for the entire village (grouped by desa)
    $sql1 = "SELECT 
                desa, 
                SUM(sd) as total_sd, 
                SUM(smp) as total_smp,
                SUM(sma) as total_sma, 
                SUM(smk) as total_smk,
                SUM(s1) as total_s1,
                SUM(s2) as total_s2,
                SUM(s3) as total_s3   
            FROM penduduk 
            WHERE desa = '$villageName'
            GROUP BY desa";
    $result1 = $conn->query($sql1);

    // Query to get data per RW in the specified village (grouped by desa and rw)
    $sql2 = "SELECT 
                desa, 
                rw,
                SUM(sd) as total_sd, 
                SUM(smp) as total_smp,
                SUM(sma) as total_sma, 
                SUM(smk) as total_smk,
                SUM(s1) as total_s1,
                SUM(s2) as total_s2,
                SUM(s3) as total_s3   
            FROM penduduk 
            WHERE desa = '$villageName'
            GROUP BY desa, rw";
    $result2 = $conn->query($sql2);

    // Fetch the total data for the village
    if ($result1->num_rows > 0) {
        $data = $result1->fetch_assoc();
    } else {
        $data = null;
    }

    // Fetch the data per RW
    if ($result2->num_rows > 0) {
        $rwData = [];
        while ($row = $result2->fetch_assoc()) {
            $rwData[] = $row;
        }
    } else {
        $rwData = [];
    }

    // Return both sets of data as JSON
    echo json_encode([
        "status" => "success",
        "data" => [
            "villageTotal" => $data,
            "rwData" => $rwData
        ]
    ]);

} else {
    echo json_encode(["status" => "error", "message" => "Village name not provided"]);
}

$conn->close();
?>
