<?php
namespace IchHabRecht\T3gravatar\Xclass;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Nicole Cordes <typo3@cordes.co>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use IchHabRecht\T3gravatar\AvatarProvider\BaseGravatarProvider;
use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * Adds Gravatar support to profile image
 */
class Avatar extends \TYPO3\CMS\Backend\Backend\Avatar\Avatar {

	/**
	 * @param array|NULL $backendUser
	 * @param int $size
	 * @param bool $showIcon
	 * @return string
	 */
	public function render(array $backendUser = NULL, $size = 32, $showIcon = FALSE) {
		$size = (int)$size;
		if (!is_array($backendUser)) {
			$backendUser = $this->getBackendUser()->user;
		}

		$image = parent::render($backendUser, $size, $showIcon);

		if (!StringUtility::beginsWith($image, '<span class="avatar"><span class="avatar-image"></span>')) {
			return $image;
		}

		// Get Gravatar Url
		$gravatarUrl = GeneralUtility::makeInstance(BaseGravatarProvider::class)->render(
				$backendUser,
				$size
			);

		if (!$gravatarUrl) {
			return $image;
		}

		// Icon
		$icon = '';
		if ($showIcon) {
			$icon = '<span class="avatar-icon">' . IconUtility::getSpriteIconForRecord('be_users', $backendUser) . '</span>';
		}

		// Make url relative to current script when no valid url
		if(!GeneralUtility::isValidUrl($gravatarUrl)) {
			$absolutePathToContainingFolder = PathUtility::dirname(PATH_site . $gravatarUrl);
			$pathPart = PathUtility::getRelativePathTo($absolutePathToContainingFolder);
			$filePart = substr(PATH_site . $gravatarUrl, strlen($absolutePathToContainingFolder) + 1);
			$gravatarUrl = $pathPart . $filePart;
		}

		return '<span class="avatar"><span class="avatar-image">'
			. '<img src="' . $gravatarUrl . '" width="' . $size . '" height="' . $size . '" /></span>' . $icon . '</span>';
	}
}
