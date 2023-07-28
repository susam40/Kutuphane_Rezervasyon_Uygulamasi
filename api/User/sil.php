<?php
// PostgreSQL veritabanı bağlantısı
$host = 'localhost';
$dbname = 'vtys';
$user = 'postgres';
$password = 'admin';

// Silinecek mesajın ID'sini alma
$id = $_GET['id'];

try {
    // PostgreSQL veritabanına bağlanma
    $dbh = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Mesajı silme sorgusu
$sql = "DELETE FROM iletisim WHERE id_il = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Silme işlemi başarılı mesajı

echo "<script>
            alert('Mesaj Silindi');
    </script>";
header("Refresh: 0.1; admin.php");
} catch (PDOException $e) {
echo "Hata: " . $e->getMessage();
}

// Veritabanı bağlantısını kapatma
$dbh = null;
?>