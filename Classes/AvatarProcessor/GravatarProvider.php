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
use TYPO3\CMS\Backend\Backend\Avatar\Image;
use TYPO3\CMS\Backend\Backend\Avatar\AvatarProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * GravatarProvider image provider
 */
class GravatarProvider extends BaseGravatarProvider implements AvatarProviderInterface {

	/**
	 * Get Image
	 *
	 * @param array $backendUser be_users record
	 * @param int $size
	 * @return Image|NULL
	 */
	public function getImage(array $backendUser, $size) {
		$gravatarUrl = parent::getImage($backendUser, $size);
		if (!$gravatarUrl) {
			return NULL;
		}

		return GeneralUtility::makeInstance(
			Image::class,
			$gravatarUrl,
			$size,
			$size
		);
	}

}
