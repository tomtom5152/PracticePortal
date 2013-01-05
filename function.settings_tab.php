<?php
if (! $this->CheckAccess("PracticePortalSettings"))
	{
	return $this->Lang('accessdenied');
	}

$sql = "SELECT * FROM ".cms_db_prefix().'module_practiceportal_settings';
$dbresult = $db->Execute($sql);
$settings = array();
while($dbresult && $row = $dbresult->FetchRow()) {
    $setting['label'] = $this->CreateLabelForInput($id,"PracticePortalSettings['".$row['key']."']",$row['key']);
    $setting['input'] = $this->CreateTextArea(true,$id,$row['value'],"PracticePortalSettings['".$row['key']."']");
    $settings[] = $setting;
}

$smarty->assign('settings',$settings);

$smarty->assign('startform', $this->CreateFormStart($id,'editsettings',$returnid));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('endform', $this->CreateFormEnd());;

return $this->ProcessTemplate('settings_tab.tpl');
?>
