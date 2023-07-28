<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>İletişim</title>
  <link rel="stylesheet" href="assets/css/iletisim.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">  
  <form id="contact" action="./api/user/gonder.php" method="post">
    <h3>İletişim</h3>
    <h4>Bize Ulaşın</h4>
    <fieldset>
      <input placeholder="Adınız" type="text" tabindex="1" name="isim" required autofocus>
    </fieldset>
    <fieldset>
      <input placeholder="E-posta Adresiniz" type="email" tabindex="2" name="mail" required>
    </fieldset>
    <fieldset>
      <textarea placeholder="Mesajınız...." tabindex="5" name="mesaj" required></textarea>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" name="gonder" id="contact-submit" data-submit="...Sending">Gönder</button>
    </fieldset>
    <p class="copyright">Aeü Kütüphane</p>
  </form>
</div>
<!-- partial -->
  
</body>
</html>
