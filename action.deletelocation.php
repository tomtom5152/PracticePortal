<?php
if (!isset($gCms)) exit;

if (!$this->CheckPermission('Edit Locations'))
  {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
  }

$idlocations = isset($params['idlocations']) ? $params['idlocations'] : '';

// Do a usage search on the location to remove it and prevent errors
$sql = 'SELECT idquestions, idlocations FROM '.cms_db_prefix().'module_practiceportal_questions';
$dbr = $db->Execute($sql);
while($dbr && $row = $dbr->FetchRow()) {
    $locs = json_decode($row['idlocations'], true);
    if(($key = array_search($idlocations, $locs)) !== false) {
        unset($locs[$key]);
    }
    $locs = json_encode($locs);
    $sql = 'UPDATE '.cms_db_prefix().'module_practiceportal_questions SET idlocations=? WHERE idquestions=?';
    $db->Execute($sql, array($locs, $row['idquestions']));
}

$sql = 'DELETE FROM '.cms_db_prefix().'module_practiceportal_locations '
    .'WHERE idlocations=?;';
$dbr = $db->Execute($sql, array($idlocations));

if( !$dbr )
  {
    // Check and echo errors with SQL
    echo "DEBUG: SQL = ".$db->sql."<br/>";
    die($db->ErrorMsg());
  }

$params = array('tab_message'=> 'deletesuccess', 'active_tab' => 'locations');
$this->Redirect($id, 'defaultadmin', $returnid, $params);
?>
