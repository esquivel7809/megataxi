<?php
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2008-2013 Schmooze Com Inc.
//
// Change the version numbers and text and publish
$versionupgrade_upgrade_ver     = '12.0';
$versionupgrade_status = 'Final Release';

$versionupgrade_alpha_version   = $versionupgrade_upgrade_ver.'.0alpha0';
$versionupgrade_beta1_version   = $versionupgrade_upgrade_ver.'.0beta1';
$versionupgrade_beta1_0_version = $versionupgrade_beta1_version.'.0';
$versionupgrade_upgrade_final   = $versionupgrade_upgrade_ver.'.0';

$asterisk_min_version = '1.8';

function versionupgrade_setversion($version) {
	global $db;
	sql('DELETE FROM module_xml WHERE id = "xml"');
	$sql = "UPDATE admin SET value = '".$version."' WHERE variable = 'version'";
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		return false;
	}
	return true;
}

function versionupgrade_configpageinit($pagename) {
	global $currentcomponent;
	$currentcomponent->addprocessfunc('versionupgrade_configprocess', 9);
}

function versionupgrade_configprocess() {
	global $db;
	global $versionupgrade_alpha_version;
	global $versionupgrade_beta1_version;
	global $versionupgrade_beta1_0_version;

	$moduleinfo = module_getinfo('core');
	$mainversion = getversion();

	if (version_compare_freepbx($mainversion,$versionupgrade_alpha_version,"ge") && version_compare_freepbx($moduleinfo['core']['version'], $versionupgrade_alpha_version, "lt")) {
		$sql = "UPDATE admin SET value = 'false' WHERE variable = 'need_reload'";
		$result = $db->query($sql);
		if(DB::IsError($result)) {
			//can't do much?
		}
	} else if (version_compare_freepbx($mainversion,$versionupgrade_beta1_version,"ge") && version_compare_freepbx($moduleinfo['core']['version'], $versionupgrade_beta1_0_version, "ge")) {
		$sql = "UPDATE modules SET enabled = 0 WHERE modulename = 'fw_ari'";
		$result = $db->query($sql);
		if(DB::IsError($result)) {
			//can't do much?
		}
		//exec("(/var/lib/asterisk/bin/module_admin download ucp; /var/lib/asterisk/bin/module_admin install ucp) > /dev/null 2>&1 &");
		$results = module_delete('versionupgrade');
	}
}

function versionupgrade_allowed_modules($module) {
	global $versionupgrade_alpha_version;
	static $version;
	static $framework_version;
	static $core_version;
	static $sysadmin_version;

	// These should be cached by the functions but that was added late so in case not we will
	//
	if (!isset($version) || !$version) {
		$version = getversion();
	}
	if (!isset($framework_version) || !$framework_version) {
		$framework_version = get_framework_version();
	}

	if (version_compare_freepbx($version, $versionupgrade_alpha_version,"lt")) {
		return true;
	} elseif (version_compare_freepbx($version, $versionupgrade_alpha_version,"eq")) {
		return ($module['rawname'] == 'framework');
	} else {
		if (!isset($core_version) || !$core_version) {
			$core_version = modules_getversion('core');
		}
		if (!isset($sysadmin_version) || !$sysadmin_version) {
			$sysadmin_version = modules_getversion('sysadmin');
		}
		if(!empty($sysadmin_version)) {
			if (version_compare_freepbx($sysadmin_version, $versionupgrade_alpha_version,"lt")) {
				return ($module['rawname'] == 'sysadmin' || $module['rawname'] == 'framework');
			}
		}
		if (version_compare_freepbx($core_version, $versionupgrade_alpha_version,"lt")) {
			return ($module['rawname'] == 'sysadmin' || $module['rawname'] == 'core' || $module['rawname'] == 'framework');
		} else {
			return true;
		}
	}
}
