<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// PostgreSQL veritabanına bağlanma bilgileri
$host = 'localhost';
$dbname = 'vtys';
$user = 'postgres';
$password = 'admin';

// Formdan gelen verileri alma
$isim = $_POST['isim'];
$mail = $_POST['mail'];
$mesaj = $_POST['mesaj'];

try {
    // PostgreSQL veritabanına bağlanma
    $dbh = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    // Veritabanı hatayı doğrudan göstersin
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verileri ekleme sorgusu
    $sql = "INSERT INTO iletisim (isim, mail, mesaj) VALUES (:isim, :mail, :mesaj)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':isim', $isim);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':mesaj', $mesaj);

    // Sorguyu çalıştırma
    $stmt->execute();
     echo "<script>
            alert('Mesajınız gönderildi!');
    </script>";

    header("Refresh: 0.1; URL=../../index.html");
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();

}
?>
