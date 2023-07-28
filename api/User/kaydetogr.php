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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $created = date('Y-m-d H:i:s');
    $query = "SELECT * FROM students WHERE username = :username";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':username', $username);
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
    $sql = "INSERT INTO students (username, password, first_name, last_name, email, phone, created)
            VALUES (:username, :password, :first_name, :last_name, :email, :phone, :created)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':created', $created);
// Sorguyu çalıştırma
$stmt->execute();
echo "<script>
            alert('Öğrenci Kaydedildi!');
    </script>";
header("Refresh: 0.1; admin.php");
    }



} catch (PDOException $e) {
echo "Hata: " . $e->getMessage();
}

// Veritabanı bağlantısını kapatma
$dbh = null;
?>