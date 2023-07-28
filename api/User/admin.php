<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION["admlog"])=='ok') {
    header('Location: ../../index2.html');
    exit;
}

?>
<html lang="en" class="dashboard">
<head>
  <meta charset="UTF-8">
  <title>Admin Sayfası</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css'><link rel="stylesheet" href="admin_page.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>
<body>
<!-- partial:index.partial.html -->
<header role="banner">
  <h1>Yönetim Paneli</h1>
  <ul class="utilities">
    <li class="logout warn"><a href="logout.php">Çıkış Yap</a></li>
  </ul>
</header>

<nav role="navigation">
  <ul class="main">
    <li class="dashboard"><a href="#">Gösterge Paneli</a></li>
    <li class="users"><a href="#">Öğrenci Ekle</a></li>
    <li class="search"><a href="dashboard.php">Rezervasyonları Görüntüle</a></li>
    <li class="user"><a href="#">Kütüphaneci Ekle</a></li>
  </ul>
</nav>

<main role="main">
  <section class="panel important">
    <h2>Kontrol Paneline Hoş Geldiniz </h2>
    <ul>
      <!-- <li>Important panel that will always be really wide Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
      <li>Aliquam tincidunt mauris eu risus.</li>
      <li>Vestibulum auctor dapibus neque.</li> -->
    </ul>
  </section>
  <!-- <section class="panel">
    <h2>Posts</h2>
    <ul>
      <li><b>2458 </b>Published Posts</li>
      <li><b>18</b> Drafts.</li>
      <li>Most popular post: <b>This is a post title</b>.</li>
    </ul>
  </section> -->
  <!-- <section class="panel">
    <h2>Chart</h2>
    <ul>
      <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
      <li>Aliquam tincidunt mauris eu risus.</li>
      <li>Vestibulum auctor dapibus neque.</li>
    </ul>
  </section> -->
  <section class="panel important">
    <h2>Öğrenci Ekle</h2>
    <form action="kaydetogr.php" method="POST">
      <div class="twothirds">
        <label for="name">Öğrenci Numarası</label>
        <input type="text" name="username" id="name" placeholder="Öğrenci numarası" />

        <label for="password">Öğrenci Şifresi</label>
        <input type="password" name="password" id="name" placeholder="Öğrenci şifresi" />
         
        <label for="name">Öğrenci Adı</label>
        <input type="text" name="first_name" id="name" placeholder="Öğrenci adı" />

        <label for="soyad">Öğrenci Soyadı</label>
        <input type="text" name="last_name" id="name" placeholder="Öğrenci soyadı" />

        <label for="email">Öğrenci Email</label>
        <input type="Email" name="email" id="name" placeholder="Öğrenci e-posta adresi" />

        <label for="email">Öğrenci Telefon Numarası</label>
        <input type="tel" name="phone" id="name" placeholder="Öğrenci telefon numarası" />

        <div><br>
          <input type="submit" value="Öğrenci Ekle" />
        </div>
      </div>
        <h2>Kütüphaneci Ekle</h2>
       
    </form>
    <form action="kaydetlib.php" method="POST">
      <div class="onethird">
          <label for="name">Kütüphaneci Numarası</label>
          <input type="text" name="lib_username" id="name" placeholder="Kütüphaneci numarası" />

          <label for="password">Kütüphaneci Şifresi</label>
          <input type="password" name="lib_password" id="name" placeholder="Kütüphaneci şifresi" />
           
          <label for="name">Kütüphaneci Adı</label>
          <input type="text" name="lib_first_name" id="name" placeholder="Kütüphaneci adı" />

          <label for="soyad">Kütüphaneci Soyadı</label>
          <input type="text" name="lib_last_name" id="name" placeholder="Kütüphaneci soyadı" />

          <div><br><br><br><br><br><br><br><br>
          <input type="submit" value="Kütüphaneci Ekle" />
          </div>
      </div>
    </form>
  </section>
  <!-- <section class="panel">
    <h2>feedback</h2>
    <div class="feedback">This is neutral feedback Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, praesentium. Libero perspiciatis quis aliquid iste quam dignissimos, accusamus temporibus ullam voluptatum, tempora pariatur, similique molestias blanditiis at sunt earum neque.</div>
    <div class="feedback error">This is warning feedback
<ul>
  <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
  <li>Aliquam tincidunt mauris eu risus.</li>
  <li>Vestibulum auctor dapibus neque.</li>
</ul>  </div>
    <div class="feedback success">This is positive feedback</div>

  </section> -->
 <section class="panel ">
    <h2>İletişim Mesajları</h2>
    <table>
      <tr>
        <th>İsim</th>
        <th>Mail</th>
        <th>Mesaj</th>
      </tr>

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

    // İletişim mesajlarını veritabanından çekme sorgusu
    $sql = "SELECT id_il,isim, mail, mesaj FROM iletisim";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // İletişim mesajlarını tabloya yerleştirme
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['isim'] . "</td>";
        echo "<td>" . $row['mail'] . "</td>";
        echo "<td>" . $row['mesaj'] . "</td>";
        echo "<td><a href='sil.php?id=" . $row['id_il'] . "'>Sil</a></td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

// Veritabanı bağlantısını kapatma
$dbh = null;
?>
    </table>
  </section>


</main><br>
<footer role="contentinfo">AEÜ Kütüphane Kontrol Paneli</footer>
<!-- partial -->
  <script  src="assets/js/admin_page.js"></script>

</body>
</html>
