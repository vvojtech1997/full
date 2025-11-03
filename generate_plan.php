<?php session_start(); require_once 'includes/db_connect.php'; if(empty($_SESSION['user_id'])) header('Location:/login.php'); include 'includes/header_footer.php'; ?>
<h2>Generovať týždenný plán</h2>
<form id="planForm" method="post" action="/api/api_generate_plan.php">
  <label>Počet osôb</label><input type="number" name="people" value="2" min="1">
  <label>Rozpočet (€ / týždeň)</label><input type="number" step="0.01" name="budget">
  <label>Typ stravy</label><select name="goal"><option value="classic">Klasická</option><option value="healthy">Zdravá</option><option value="vegetarian">Vegetariánska</option></select>
  <label>Alergény (čiarkou)</label><input type="text" name="allergies" placeholder="orechy, mlieko">
  <button class="btn-primary">Generovať plán</button>
</form>
<div id="result"></div>
<?php include 'includes/footer_bottom.php'; ?>
<script>
document.getElementById('planForm').addEventListener('submit', function(e){
  e.preventDefault();
  var f = e.target; var data = new FormData(f);
  fetch(f.action,{method:'POST',body:data}).then(r=>r.json()).then(j=>{
    var out=''; if(j.error) out='<p class="error">'+j.error+'</p>'; else{ out='<h3>Celkové náklady: '+(j.total||0)+' €</h3>'; j.plan.forEach(function(day,i){ out+='<h4>Deň '+(i+1)+'</h4><ul>'; day.forEach(m=> out+='<li>'+m.slot+' — '+m.name+' ('+m.perMealCost+'€)</li>'); out+='</ul>'; }); } document.getElementById('result').innerHTML=out;
  });
});
</script>