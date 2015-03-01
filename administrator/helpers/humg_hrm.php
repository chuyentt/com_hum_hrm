<?php

/**
 * @version     1.0.0
 * @package     com_humg_hrm
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chuyen Trung Tran <chuyentt@gmail.com> - http://www.geomatics.vn
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Humg_hrm helper.
 */
class Humg_hrmHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_HUMG_HRM_TITLE_EMPLOYEES'),
			'index.php?option=com_humg_hrm&view=employees',
			$vName == 'employees'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_HUMG_HRM_TITLE_POSITIONS'),
			'index.php?option=com_humg_hrm&view=positions',
			$vName == 'positions'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_HUMG_HRM_TITLE_DEPARTMENTS'),
			'index.php?option=com_humg_hrm&view=departments',
			$vName == 'departments'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_HUMG_HRM_TITLE_POSITIONTYPES'),
			'index.php?option=com_humg_hrm&view=positiontypes',
			$vName == 'positiontypes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_HUMG_HRM_TITLE_IDTYPES'),
			'index.php?option=com_humg_hrm&view=idtypes',
			$vName == 'idtypes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_HUMG_HRM_TITLE_CONTACTS'),
			'index.php?option=com_humg_hrm&view=contacts',
			$vName == 'contacts'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_humg_hrm';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
