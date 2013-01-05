<?php
if (!isset($gCms)) exit;

include(dirname(__FILE__).'/function.database.php');

// Load data from database
$locations = loadTable('locations');
$questions = loadTable('questions');
$conditions = loadTable('conditions', array('order_by', 'conditionname'));
$practitioners = loadTable('practitioners');
$settings = loadSettings();

foreach($locations as $key => $location) {
    $idquestions = array();
    foreach($questions as $question) {
        $idlocations = json_decode($question['idlocations']);
        if(in_array($location['idlocations'], $idlocations)) {
            array_push($idquestions, $question['idquestions']);
        }
    }
    $locations[$key]['idquestions'] = json_encode($idquestions);
}

foreach($questions as $key => $question) {
    $thisconditions = array();
    foreach(json_decode($question['idconditions']) as $order => $idconditions) {
        $condition['idconditions'] = $idconditions;
        $condition['conditionname'] = $conditions[$idconditions]['conditionname'];
        array_push($thisconditions, $condition);
    }
    $questions[$key]['conditions'] = $thisconditions;
}

foreach($conditions as $key => $condition) {
    $thispractitioners = array();
    foreach(json_decode($condition['idpractitioners']) as $order => $idpractitioners) {
        $thispractitioners[$order] = $practitioners[$idpractitioners];
    }
    $doc = new DOMDocument();
    $doc->loadHTML($condition['content']);
    $imgs = $doc->getElementsByTagName('img');
    
    foreach($imgs as $img) {
        $src = $img->getAttribute('src');
        $img->removeAttribute('src');
        $img->setAttribute('data-src', $src);
    }
    
    $conditions[$key]['content'] = $doc->saveHTML();
    $conditions[$key]['practitioners'] = $thispractitioners;
}

// Assign smarty variables
$smarty->assign('locations', $locations);
$smarty->assign('questions', $questions);
$smarty->assign('conditions', $conditions);
$smarty->assign('practitioners', $practitioners);
$smarty->assign('settings', $settings);

$smarty->assign('treatmentman', $this->GetModuleURLPath().'/images/treatment-man.svg');
$smarty->assign('portaldir', $this->GetModuleURLPath());

echo $this->ProcessTemplate('stylesheet.tpl');
echo $this->ProcessTemplate('PatientPortal.tpl');
?>