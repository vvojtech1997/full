<?php
require_once __DIR__ . '/../includes/db_connect.php';
session_start();
header('Content-Type: application/json; charset=utf-8');
if(empty($_SESSION['user_id'])){ echo json_encode(['error'=>'not_logged']); exit; }
$people = max(1,intval($_POST['people'] ?? 2));
$budget = isset($_POST['budget']) && $_POST['budget'] !== '' ? floatval($_POST['budget']) : null;
$allergies = array_filter(array_map('trim', explode(',', strtolower($_POST['allergies'] ?? ''))));
$goal = $_POST['goal'] ?? 'classic';
$res = $mysqli->query("SELECT * FROM recipes");
$recipes = [];
while($r = $res->fetch_assoc()){ $r['ingredients'] = json_decode($r['ingredients'], true) ?: []; $recipes[] = $r; }
$filtered = array_filter($recipes, function($r) use ($allergies){
    $txt = strtolower($r['name'].' '.implode(' ', array_column($r['ingredients'],'name')));
    foreach($allergies as $a) if($a && strpos($txt,$a)!==false) return false;
    return true;
});
if(empty($filtered)){ echo json_encode(['error'=>'no_recipes']); exit; }
usort($filtered, function($a,$b){ return ($a['estimatedCost'] ?? 0) <=> ($b['estimatedCost'] ?? 0); });
$slots = ['breakfast','lunch','dinner']; $days=7; $plan=[]; $used=[]; $total=0.0;
foreach(range(1,$days) as $d){
  $day=[];
  foreach($slots as $slot){
    $pick=null;
    foreach($filtered as $r){ if(in_array($r['id'],$used)) continue; if($r['mealType']===$slot || $r['mealType']==='lunch'){ $pick=$r; break; } }
    if(!$pick){ foreach($filtered as $r){ if(!in_array($r['id'],$used)){ $pick=$r; break; } } }
    if($pick){
      $base = max(1,intval($pick['servings']??2));
      $price = round(($pick['estimatedCost'] ?? 0) * $people / $base, 2);
      $used[] = $pick['id'];
      $day[] = ['slot'=>$slot,'id'=>$pick['id'],'name'=>$pick['name'],'perMealCost'=>$price,'ingredients'=>$pick['ingredients']];
      $total += $price;
    } else {
      $day[] = ['slot'=>$slot,'id'=>null,'name'=>'(Žiadna)','perMealCost'=>0,'ingredients'=>[]];
    }
  }
  $plan[] = $day;
}
$warning = null;
if($budget !== null && $total > $budget) $warning = 'Plán presahuje rozpočet.';
$stmt = $mysqli->prepare("INSERT INTO meal_plans (user_id,plan_data,total_cost,created_at) VALUES (?,?,?,NOW())");
$uid = intval($_SESSION['user_id']); $json = json_encode($plan, JSON_UNESCAPED_UNICODE);
$stmt->bind_param('isd',$uid,$json,$total); $stmt->execute();
echo json_encode(['success'=>true,'plan'=>$plan,'total'=>$total,'warning'=>$warning]);
?>