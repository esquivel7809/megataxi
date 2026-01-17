<?php
global $amp_conf, $db;
global $asterisk_conf;
global $version;

// HELPER FUNCTIONS:

if (! function_exists('out')) {
	function out($text) {
		echo $text."<br>";
	}
}

if (! function_exists('outn')) {
	function outn($text) {
		echo $text;
	}
}

/* If Blacklist module version less than 2.7.0.2 is not present then
 * upgrading to 2.9 will result in a crash. The module MUST be updated
 * even if it is currenlty disabled.
 * We don't check this in the module.xml dependencies because if they
 * don't have blacklist installed then it is ok for them to upgrade and
 * there is no dependency mode that can express that.
 */
$ver = modules_getversion('blacklist');
if ($ver !== null && version_compare($ver,'2.7.0.2','lt')) {
  out(_("Blacklist Module MUST be updated before installing."));
  out(sprintf(_("You have %s installed, 2.7.0.2 or higher is required."),$ver));
  return false;
}

if (!isset($version) || !$version || !is_string($version)) {
	$engine_info = engine_getinfo();
	$version = $engine_info['version'];
}

if (version_compare($version, '1.8', '<')) {
	out(sprintf(_("FreePBX 12 Requires Asterisk 1.8 or higher! You have %s"),$version));
	return false;
}
if (version_compare(PHP_VERSION, '5.3.3', '<')) {
	out(sprintf(_("FreePBX 12 Requires PHP 5.3.3 or higher! You have %s"),PHP_VERSION));
	return false;
}

//weird php errors if this is enabled.
$ver = modules_getversion('cxpanel');
if ($ver !== null) {
	out(_("Disabling cxpanel for now..."));
	module_disable('cxpanel', true);
}
//Errors with cos
//FREEPBX-7929
$ver = modules_getversion('cos');
if ($ver !== null) {
	out(_("Disabling cos for now..."));
	module_disable('cos', true);
}
//Errors with userman
//FREEPBX-7929
$ver = modules_getversion('userman');
if ($ver !== null) {
	out(_("Disabling cos for now..."));
	module_disable('userman', true);
}
return true;
