<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	// Xclass Avatar since AvatarProvider API is not present
	if (!interface_exists('TYPO3\\CMS\\Backend\\Backend\\Avatar\\AvatarProviderInterface')) {
		$className = \TYPO3\CMS\Backend\Backend\Avatar\Avatar::class;
		while (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$className])) {
			$className = $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$className]['className'];
		}
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$className] = array(
			'className' => \IchHabRecht\T3gravatar\Xclass\Avatar::class
		);
	} else {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['avatarProviders']['gravatarProvider'] = array(
			'provider' => \IchHabRecht\T3gravatar\AvatarProvider\GravatarProvider::class,
			'after' => ['defaultAvatarProvider']
		);
	}
}