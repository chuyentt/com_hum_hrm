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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Department controller class.
 */
class Humg_hrmControllerDepartmentForm extends Humg_hrmController {

    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @since	1.6
     */
    public function edit() {
        $app = JFactory::getApplication();

        // Get the previous edit id (if any) and the current edit id.
        $previousId = (int) $app->getUserState('com_humg_hrm.edit.department.id');
        $editId = JFactory::getApplication()->input->getInt('id', null, 'array');

        // Set the user id for the user to edit in the session.
        $app->setUserState('com_humg_hrm.edit.department.id', $editId);

        // Get the model.
        $model = $this->getModel('DepartmentForm', 'Humg_hrmModel');

        // Check out the item
        if ($editId) {
            $model->checkout($editId);
        }

        // Check in the previous user.
        if ($previousId) {
            $model->checkin($previousId);
        }

        // Redirect to the edit screen.
        $this->setRedirect(JRoute::_('index.php?option=com_humg_hrm&view=departmentform&layout=edit', false));
    }

    /**
     * Method to save data.
     *
     * @return	void
     * @since	1.6
     */
    public function save() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('DepartmentForm', 'Humg_hrmModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');
        $ajax = $data['ajax'];
        $ajaxMsg = '';

        // Validate the posted data.
        $form = $model->getForm();
        if (!$form) {
            JError::raiseError(500, $model->getError());
            if (!$ajax) return false; else $ajaxMsg = $model->getError();
        }

        // Validate the posted data.
        $data = $model->validate($form, $data);

        // Check for errors.
        if ($data === false) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                    $errorMsg[$i] = $errors[$i]->getMessage();
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                    $errorMsg[$i] = $errors[$i];
                }
            }

            $input = $app->input;
            $jform = $input->get('jform', array(), 'ARRAY');

            // Save the data in the session.
            $app->setUserState('com_humg_hrm.edit.department.data', $jform, array());
            
            if (!$ajax) {
            	// Redirect back to the edit screen.
            	$id = (int) $app->getUserState('com_humg_hrm.edit.department.id');
            	$this->setRedirect(JRoute::_('index.php?option=com_humg_hrm&view=departmentform&layout=edit&id=' . $id, false));
            	return false;
            } else {
                $ajaxMsg = implode(';',$errorMsg);
                $status = (!$ajaxMsg) ? true : false;
                echo json_encode(array('status'=>$status,'message'=>$ajaxMsg));
                jexit();
            }
        }

        // Attempt to save the data.
        $return = $model->save($data);

        // Check for errors.
        if ($return === false) {
            // Save the data in the session.
            $app->setUserState('com_humg_hrm.edit.department.data', $data);
            $id = (int) $app->getUserState('com_humg_hrm.edit.department.id');
            $this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
            if (!$ajax) {
                // Redirect back to the edit screen.
                $this->setRedirect(JRoute::_('index.php?option=com_humg_hrm&view=departmentform&layout=edit&id=' . $id, false));
                return false;
            } else {
                $ajaxMsg = implode(';',$errorMsg);
                $status = (!$ajaxMsg) ? true : false;
                echo json_encode(array('status'=>$status,'message'=>$ajaxMsg));
                jexit();
            }
        }


        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }

        // Clear the profile id from the session.
        $app->setUserState('com_humg_hrm.edit.department.id', null);
        $this->setMessage(JText::_('COM_HUMG_HRM_ITEM_SAVED_SUCCESSFULLY'));
        $ajaxMsg = JText::_('COM_HUMG_HRM_ITEM_SAVED_SUCCESSFULLY');

        if (!$ajax) {
            // Redirect to the list screen.
            $menu = JFactory::getApplication()->getMenu();
            $item = $menu->getActive();
            $url = (empty($item->link) ? 'index.php?option=com_humg_hrm&view=departments' : $item->link);
            $this->setRedirect(JRoute::_($url, false));
            
            // Flush the data from the session.
            $app->setUserState('com_humg_hrm.edit.department.data', null);
        } else {
            echo json_encode(array('status'=>$return,'message'=>$ajaxMsg));
            jexit();
        }
    }

    function cancel() {
        
        $app = JFactory::getApplication();

        // Get the current edit id.
        $editId = (int) $app->getUserState('com_humg_hrm.edit.department.id');

        // Get the model.
        $model = $this->getModel('DepartmentForm', 'Humg_hrmModel');

        // Check in the item
        if ($editId) {
            $model->checkin($editId);
        }
        
        $menu = JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $url = (empty($item->link) ? 'index.php?option=com_humg_hrm&view=departments' : $item->link);
        $this->setRedirect(JRoute::_($url, false));
    }

    public function remove() {

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('DepartmentForm', 'Humg_hrmModel');

        // Get the user data.
        $data = array();
        $data['id'] = $app->input->getInt('id');

        // Check for errors.
        if (empty($data['id'])) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            // Save the data in the session.
            $app->setUserState('com_humg_hrm.edit.department.data', $data);

            // Redirect back to the edit screen.
            $id = (int) $app->getUserState('com_humg_hrm.edit.department.id');
            $this->setRedirect(JRoute::_('index.php?option=com_humg_hrm&view=department&layout=edit&id=' . $id, false));
            return false;
        }

        // Attempt to save the data.
        $return = $model->delete($data);

        // Check for errors.
        if ($return === false) {
            // Save the data in the session.
            $app->setUserState('com_humg_hrm.edit.department.data', $data);

            // Redirect back to the edit screen.
            $id = (int) $app->getUserState('com_humg_hrm.edit.department.id');
            $this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
            $this->setRedirect(JRoute::_('index.php?option=com_humg_hrm&view=department&layout=edit&id=' . $id, false));
            return false;
        }


        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }

        // Clear the profile id from the session.
        $app->setUserState('com_humg_hrm.edit.department.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_HUMG_HRM_ITEM_DELETED_SUCCESSFULLY'));
        $menu = JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $url = (empty($item->link) ? 'index.php?option=com_humg_hrm&view=departments' : $item->link);
        $this->setRedirect(JRoute::_($url, false));

        // Flush the data from the session.
        $app->setUserState('com_humg_hrm.edit.department.data', null);
    }

}