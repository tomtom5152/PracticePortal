<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

   Code for PracticePortal "defaultadmin" admin action
   
   -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
   
   Typically, this will display something from a template
   or do some other task.
   
*/
        
if(!isset($smarty)) $smarty = $this->smarty;

$tab = (!empty($params['active_tab'])) ? $params['active_tab'] : FALSE;

$smarty->assign('tab_headers',$this->StartTabHeaders().
	$this->SetTabHeader('practitioners',$this->Lang('title_practitioners'),($tab == 'practitioners')?true:false).
	$this->SetTabHeader('conditions',$this->Lang('title_conditions'),($tab == 'conditions')?true:false).
        $this->SetTabHeader('locations',$this->Lang('title_locations'),($tab == 'locations')?true:false).
        $this->SetTabHeader('questions',$this->Lang('title_questions'),($tab == 'questions')?true:false).
        $this->SetTabHeader('settings',$this->Lang('title_settings'),($tab == 'settings')?true:false).
	//$this->SetTabHeader('insurance',$this->Lang('title_insurance'),($tab == 'insurance')?true:false).     To be implemented with V2 of the module
	$this->EndTabHeaders().$this->StartTabContent());
$smarty->assign('end_tab',$this->EndTab());
$smarty->assign('tab_footers',$this->EndTabContent());
$smarty->assign('start_practitioners_tab',$this->StartTab('practitioners'));
$smarty->assign('start_conditions_tab',$this->StartTab('conditions'));
$smarty->assign('start_locations_tab',$this->StartTab('locations'));
$smarty->assign('start_questions_tab',$this->StartTab('questions'));
$smarty->assign('start_settings_tab',$this->StartTab('settings'));
$smarty->assign('start_finance_tab',$this->StartTab('finance'));
$smarty->assign('title',$this->Lang('admin_title'));
$smarty->assign('description', $this->Lang('admindescription'));
$smarty->assign('copyright', $this->Lang('copyright'));
$smarty->assign('addnew', $this->Lang('addnew'));

$smarty->assign('practitioners_tab', include(dirname(__FILE__).'/function.practitioners_tab.php'));
$smarty->assign('conditions_tab', include(dirname(__FILE__).'/function.conditions_tab.php'));
$smarty->assign('locations_tab', include(dirname(__FILE__).'/function.locations_tab.php'));
$smarty->assign('questions_tab', include(dirname(__FILE__).'/function.questions_tab.php'));
$smarty->assign('settings_tab', include(dirname(__FILE__).'/function.settings_tab.php'));

echo $this->ProcessTemplate('adminpanel.tpl');


?>