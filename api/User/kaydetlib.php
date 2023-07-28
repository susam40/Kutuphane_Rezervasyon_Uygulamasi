<?php
// PostgreSQL veritabanı bağlantısı
$host = 'localhost';
$dbname = 'vtys';
$user = 'postgres';
$password = 'admin';

try {
    // PostgreSQL veritabanına bağlanma
    $dbh = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    // Veritabanı hatayı doğrudan göstersin
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Formdan gelen verileri alma
    $lib_username = $_POST['lib_username'];
    $lib_password = $_POST['lib_password'];
    $lib_first_name = $_POST['lib_first_name'];
    $lib_last_name = $_POST['lib_last_name'];
    $lib_created = date('Y-m-d H:i:s');
    $query = "SELECT * FROM librarians WHERE lib_username = :lib_username";
    $stmt = $dbh->prepare($query);
    
    $stmt->bindParam(':lib_username', $lib_username);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    // Aynı kullanıcı adıyla kayıtlı öğrenci varsa hata mesajı verilir
    echo "<script>
            alert('Bu Kullanıcı adı zaten kullanılıyor');
    </script>";
    header("Refresh: 0.1; admin.php");
}
    else{
        // Verileri ekleme sorgusu
    $sql = "INSERT INTO librarians (lib_username, lib_password, lib_first_name, lib_last_name, lib_created)
            VALUES (:lib_username, :lib_password, :lib_first_name, :lib_last_name, :lib_created)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':lib_username', $lib_username);
    $stmt->bindParam(':lib_password', $lib_password);
    $stmt->bindParam(':lib_first_name', $lib_first_name);
    $stmt->bindParam(':lib_last_name', $lib_last_name);
    $stmt->bindParam(':lib_created', $lib_created);

    // Sorguyu çalıştırma
    $stmt->execute();

echo "<script>
            alert('Admin Kaydedildi!');
    </script>";
header("Refresh: 0.1; admin.php");
    }

    
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

// Veritabanı