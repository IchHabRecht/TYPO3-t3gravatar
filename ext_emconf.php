<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3gravatar".
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'TYPO3 Gravatar',
	'description' => 'Extends user profiles with avatar images from Gravatar',
	'category' => 'be',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'author' => 'Nicole Cordes',
	'author_email' => 'typo3@cordes.co',
	'author_company' => 'CPS-IT GmbH',
	'version' => '0.3.0',
	'constraints' =>
	array (
		'depends' =>
		array (
			'typo3' => '7.4.0-7.99.99',
		),
		'conflicts' =>
		array (
		),
		'suggests' =>
		array (
		),
	)
);

