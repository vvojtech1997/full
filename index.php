<?php require_once 'includes/db_connect.php'; include 'includes/header_footer.php'; ?>


<!-- Hero sekcia -->
<section class="hero container">
  <div class="hero-text">
    <h1>Váš inteligentný jedálniček</h1>
    <p>Ušetrite čas a peniaze – vygenerujte si týždenný plán podľa rozpočtu, alergénov a preferencií.</p>
    <a class="btn-primary" href="/register.php">Začni zadarmo</a>
  </div>
  <div class="hero-image">
    <img src="/assets/images/illustration.png" alt="Ilustrácia">
  </div>
</section>

<!-- Sekcia s funkciami -->
<section class="features container">
  <div class="feature">
    <img src="/assets/images/icon_calendar.png" alt="">
    <h4>Automatický plán</h4>
    <p>Generuj plán podľa rozpočtu a preferencií.</p>
  </div>
  <div class="feature">
    <img src="/assets/images/icon_check.png" alt="">
    <h4>Bez alergénov</h4>
    <p>Vyhni sa surovinám, ktoré nemôžeš jesť.</p>
  </div>
  <div class="feature">
    <img src="/assets/images/icon_user.png" alt="">
    <h4>Prispôsobené</h4>
    <p>Počet osôb a gramáž receptov sa automaticky upraví.</p>
  </div>
</section>

<?php include 'includes/footer_bottom.php'; ?>
