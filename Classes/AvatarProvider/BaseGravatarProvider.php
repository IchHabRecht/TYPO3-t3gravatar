<?php
namespace IchHabRecht\T3gravatar\AvatarProvider;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * BaseGravatarProvider
 */
class BaseGravatarProvider {

	/**
	 * @var array
	 */
	static protected $defaultConfiguration = ['fallback' => '', 'fallbackImageUrl' => '', 'forceProvider' => FALSE, 'cacheLocal' => FALSE];

	/**
	 * @var array
	 */
	static protected $configuration;

	/**
	 * Get Gravatar configuration
	 *
	 * @return array
	 */
	static protected function getConfiguration() {
		if (self::$configuration === NULL) {
			// Extension Configuration
			self::$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3gravatar']);

			if (!is_array(self::$configuration) || empty(self::$configuration)) {
				self::$configuration = self::$defaultConfiguration;
			}
		}
		return self::$configuration;
	}

	/**
	 * Get Image
	 *
	 * @param array $backendUser be_users record
	 * @param int $size
	 * @return string
	 */
	public function getImage(array $backendUser, $size) {
		$image = NULL;
		$configuration = self::getConfiguration();
		if (empty($backendUser['email']) && empty($configuration['forceProvider'])) {
			return $image;
		}

		$fallback = $configuration['fallback'] === 'url' ? $configuration['fallbackImageUrl'] : $configuration['fallback'];
		if ($fallback === '') {
			$fallback = 'blank';
		}

		$size = min(2048, $size);
		$gravatarUrl = 'https://www.gravatar.com/avatar/' . md5(strtolower($backendUser['email'] ?: $backendUser['username'])) . '?s=' . $size . '&d=' . urlencode($fallback);
		if ($configuration['cacheLocal']) {
			$gravatarUrl = $this->getCachedGravatarUrl($gravatarUrl);
		} elseif ($fallback === '404' && !GeneralUtility::getUrl($gravatarUrl)) {
			$gravatarUrl = '';
		}
		return $gravatarUrl;
	}

	/**
	 * Get url to chacked url
	 *
	 * @param string $gravatarUrl
	 * @return string
	 */
	protected function getCachedGravatarUrl($gravatarUrl) {
		$cachedFilePath = PATH_site . 'typo3temp/t3gravatar/';
		$cachedFileName = sha1($gravatarUrl) . '.jpg';
		if (!file_exists($cachedFilePath . $cachedFileName)) {
			$gravatarImage = GeneralUtility::getUrl($gravatarUrl);
			if (empty($gravatarImage)) {
				return '';
			}
			GeneralUtility::writeFileToTypo3tempDir($cachedFilePath . $cachedFileName, $gravatarImage);
		}

		return PathUtility::getAbsoluteWebPath($cachedFilePath) . $cachedFileName;
	}
}