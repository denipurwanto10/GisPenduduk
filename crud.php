<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gis_penduduk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

switch ($data->action) {
    case 'read':
        // Check if a village (desa) is specified
        $desa = isset($data->desa) && $data->desa !== 'all' ? $data->desa : null;
    
        // If a specific desa is selected, filter by desa, else fetch all records
        if ($desa) {
            $stmt = $conn->prepare("SELECT * FROM penduduk WHERE desa = ?");
            $stmt->bind_param("s", $desa);
        } else {
            $stmt = $conn->prepare("SELECT * FROM penduduk");
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pendudukData = [];
        while ($row = $result->fetch_assoc()) {
            $pendudukData[] = $row;
        }
        
        echo json_encode($pendudukData);
        break;
    
    case 'create':
        $stmt = $conn->prepare("INSERT INTO penduduk (kode, desa, rw, sd, smp, sma, smk, s1, s2, s3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiiiiii", $data->kode, $data->desa, $data->rw, $data->sd, $data->smp, $data->sma, $data->smk, $data->s1, $data->s2, $data->s3);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add record"]);
        }
        break;
        case 'edit':
            $stmt = $conn->prepare("UPDATE penduduk SET desa=?, rw=?, sd=?, smp=?, sma=?, smk=?, s1=?, s2=?, s3=? WHERE kode=?");
            $stmt->bind_param("ssiiiiiiis", $data->desa, $data->rw, $data->sd, $data->smp, $data->sma, $data->smk, $data->s1, $data->s2, $data->s3, $data->kode);
        
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Data berhasil diubah"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update record"]);
            }
            break;
        
        
    case 'delete':
        $stmt = $conn->prepare("DELETE FROM penduduk WHERE kode=?");
        $stmt->bind_param("s", $data->kode);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data telah terhapus"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete record"]);
        }
        break;
    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}

$conn->close();
?>
