<?php
/***************************************************************
 *  Copyright notice
*
*  (c) 2010 Georg Ringer <typo3@ringerge.org>
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
/*
 * modified 2014 by Kurt Gusbeth
*/
namespace Quizpalme\Camaliga\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Quizpalme\Camaliga\Utility\TemplateLayout;
use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;

/**
 * Userfunc: Individuelles...
 *
 * @package camaliga
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ItemsProcFunc {
	/**
	 * Itemsproc for templateLayouts
	 *
	 * @param array &$config configuration array
	 * @return void
	 */
	public function user_templateLayout(array &$config): void {
	    $row = BackendUtilityCore::getRecord('tt_content', $config['row']['uid']);
        if (isset($row['pid'])) {
            $pid = $row['pid'];
        } else {
            $pid = 0;
        }
	    $templateLayoutsUtility = GeneralUtility::makeInstance(TemplateLayout::class);
	    $templateLayouts = $templateLayoutsUtility->getAvailableTemplateLayouts($pid);
	    foreach ($templateLayouts as $layout) {
	        $additionalLayout = [
	            htmlspecialchars((string) $this->getLanguageService()->sL($layout[0])),
	            $layout[1]
	        ];
	        array_push($config['items'], $additionalLayout);
	    }
	}
	
	/**
	 * Returns LanguageService
	 *
	 * @return \TYPO3\CMS\Lang\LanguageService
	 */
	protected function getLanguageService()
	{
	    return $GLOBALS['LANG'];
	}
}