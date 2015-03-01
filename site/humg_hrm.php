<?php
/**
 * @version     1.0.0
 * @package     com_humg_hrm
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chuyen Trung Tran <chuyentt@gmail.com> - http://www.geomatics.vn
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Hook for remote login
$input = JFactory::getApplication()->input;
$task = $input->getString('task', '');
if ($task == 'login') {
    $username = $input->getVar('username');
    $password = $input->getVar('password');

    if (empty($password))
	{
		$response->status = JAuthentication::STATUS_FAILURE;
		$response->error_message = JText::_('JGLOBAL_AUTH_EMPTY_PASS_NOT_ALLOWED');
		header('HTTP/1.0 401 Unauthorized');
		header('Content-type: application/json');
		echo json_encode($response);
		JFactory::getApplication()->close();
	}
	
	$result = JFactory::getApplication()->login(array('username'=>$username,'password'=>$password),array('remember'=>false));
	if($result)
	{
		$response->email = JFactory::getUser()->email;
		$response->status = JAuthentication::STATUS_SUCCESS;
		header('Content-type: application/json');
		header('token:'.JSession::getFormToken());
		echo json_encode($response);
	}
	else
	{
		$response->status = JAuthentication::STATUS_FAILURE;
		$response->error_message = JText::_('JGLOBAL_AUTH_INCORRECT');
		header('HTTP/1.0 401 Unauthorized');
		header('Content-type: application/json');
		echo json_encode($response);
	}
	JFactory::getApplication()->close();
}
else if ($task == 'logout') 
{
	$app = JFactory::getApplication();              
	$user = JFactory::getUser();
	$user_id = $user->get('id');            
	$app->logout($user_id, array());
	header('Content-type: application/json');
	header('token:'.JSession::getFormToken());
	echo json_encode($app);
	JFactory::getApplication()->close();
}

// Execute the task.
$controller	= JControllerLegacy::getInstance('Humg_hrm');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();