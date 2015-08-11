<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	// Extend the FileList to submit the current FileOrFolderObject
	$className = \TYPO3\CMS\Backend\Backend\Avatar\Avatar::class;
	while (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$className])) {
		$className = $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$className]['className'];
	}
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$className] = array(
		'className' => \IchHabRecht\T3gravatar\Xclass\Avatar::class
	);
}

?>