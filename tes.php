<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'rental';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil data dari tabel mobil
$sql = 'SELECT id_mobil, warna FROM mobil';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$mobils = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Data Mobil</title>
</head>
<body>
    <h1>Form Data Mobil</h1>
    <form action="proses_form.php" method="POST">
        <label for="id_mobil">ID Mobil:</label>
        <select name="id_mobil" id="id_mobil">
            <?php foreach ($mobils as $mobil) : ?>
                <option value="<?php echo $mobil['id_mobil']; ?>"><?php echo $mobil['id_mobil']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="warna">Warna:</label>
        <select name="warna" id="warna">
            <?php foreach ($mobils as $mobil) : ?>
                <option value="<?php echo $mobil['warna']; ?>"><?php echo $mobil['warna']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>