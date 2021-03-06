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

jimport('joomla.application.component.controllerform');

/**
 * Positiontype controller class.
 */
class Humg_hrmControllerPositiontype extends JControllerForm
{

    function __construct() {
        $this->view_list = 'positiontypes';
        parent::__construct();
    }

}