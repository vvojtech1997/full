<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/auth_admin.php';
include __DIR__ . '/../includes/header_footer.php';

$log_dir = __DIR__ . '/../logs';
if (!file_exists($log_dir)) mkdir($log_dir, 0777, true);

function read_last_lines($file, $lines = 30) {
    if (!file_exists($file)) return "Log neexistuje.";
    $data = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return implode("\n", array_slice($data, -$lines));
}

$import_log = $log_dir . '/cron_import.log';
$price_log  = $log_dir . '/cron_prices.log';

if (isset($_POST['run_import'])) {
    shell_exec('/usr/bin/php ' . escapeshellarg(__DIR__ . '/../cron/cron_import.php') . ' >> ' . escapeshellarg($import_log) . ' 2>&1 &');
    $msg = "Import receptov spustený na pozadí.";
}
if (isset($_POST['run_prices'])) {
    shell_exec('/usr/bin/php ' . escapeshellarg(__DIR__ . '/../cron/cron_prices.php') . ' >> ' . escapeshellarg($price_log) . ' 2>&1 &');
    $msg = "Aktualizácia cien spustená na pozadí.";
}

$total_recipes = $conn->query("SELECT COUNT(*) AS c FROM recipes")->fetch_assoc()['c'] ?? 0;
$total_ingredients = $conn->query("SELECT COUNT(*) AS c FROM ingredients")->fetch_assoc()['c'] ?? 0;
?>
<div class="admin-container">
  <h2>🧠 Import logy</h2>
  <?php if(!empty($msg)) echo "<p style='color:green;font-weight:600;'>$msg</p>"; ?>
  
  <div class="stats">
    <div class="stat-card">
      <h3><?= $total_recipes ?></h3>
      <p>Recepty v databáze</p>
    </div>
    <div class="stat-card">
      <h3><?= $total_ingredients ?></h3>
      <p>Suroviny s cenou</p>
    </div>
  </div>

  <form method="post" class="import-buttons">
    <button name="run_import" class="btn-primary">🔄 Spusti import receptov</button>
    <button name="run_prices" class="btn-secondary">💰 Spusti aktualizáciu cien</button>
  </form>

  <div class="logs">
    <div class="log-box">
      <h4>📦 Log importu receptov</h4>
      <pre><?= htmlspecialchars(read_last_lines($import_log)) ?></pre>
    </div>

    <div class="log-box">
      <h4>💶 Log aktualizácie cien</h4>
      <pre><?= htmlspecialchars(read_last_lines($price_log)) ?></pre>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer_bottom.php'; ?>
