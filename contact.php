<?php 
require_once 'includes/db_connect.php'; 
include 'includes/header_footer.php'; 
?>
<section class="page-section">
  <div class="container">
    <h1>Kontaktujte nás</h1>
    <p>Máte otázky, návrhy alebo nápady na vylepšenie MealMind? Neváhajte nám napísať – odpovieme čo najskôr!</p>

    <div class="contact-grid">
      <div class="contact-info">
        <h3>Naše údaje</h3>
        <p><strong>Email:</strong> podpora@mealmind.sk</p>
        <p><strong>Telefón:</strong> +421 900 123 456</p>
        <p><strong>Adresa:</strong><br>MealMind s.r.o.<br>Trnavská cesta 12<br>821 02 Bratislava</p>
      </div>

      <div class="contact-form">
        <h3>Napíšte nám</h3>
        <form action="#" method="post" onsubmit="alert('Ďakujeme! Vaša správa bola odoslaná.'); return false;">
          <label>Meno</label>
          <input type="text" name="name" required>

          <label>Email</label>
          <input type="email" name="email" required>

          <label>Správa</label>
          <textarea name="message" rows="5" required></textarea>

          <button type="submit" class="btn-primary">Odoslať správu</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer_bottom.php'; ?>
