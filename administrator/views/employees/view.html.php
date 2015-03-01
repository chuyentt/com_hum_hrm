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

jimport('joomla.application.component.view');

/**
 * View class for a list of Humg_hrm.
 */
class Humg_hrmViewEmployees extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        Humg_hrmHelper::addSubmenu('employees');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/humg_hrm.php';

        $state = $this->get('State');
        $canDo = Humg_hrmHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_HUMG_HRM_TITLE_EMPLOYEES'), 'employees.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/employee';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('employee.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('employee.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('employees.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('employees.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'employees.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('employees.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('employees.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'employees.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('employees.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_humg_hrm');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_humg_hrm&view=employees');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

		//Filter for the field gender
		$select_label = JText::sprintf('COM_HUMG_HRM_FILTER_SELECT_LABEL', 'Giới tính');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "male";
		$options[0]->text = "Nam";
		$options[1] = new stdClass();
		$options[1]->value = "female";
		$options[1]->text = "Nữ";
		$options[2] = new stdClass();
		$options[2]->value = "other";
		$options[2]->text = "Khác";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_gender',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.gender'), true)
		);
                                                
        //Filter for the field department_guid;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_humg_hrm.employee', 'employee');

        $field = $form->getField('department_guid');

        $query = $form->getFieldAttribute('filter_department_guid','query');
        $translate = $form->getFieldAttribute('filter_department_guid','translate');
        $key = $form->getFieldAttribute('filter_department_guid','key_field');
        $value = $form->getFieldAttribute('filter_department_guid','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Đơn vị công tác',
            'filter_department_guid',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.department_guid')),
            true
        );
    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.fullname' => JText::_('COM_HUMG_HRM_EMPLOYEES_FULLNAME'),
		'a.gender' => JText::_('COM_HUMG_HRM_EMPLOYEES_GENDER'),
		'a.department_guid' => JText::_('COM_HUMG_HRM_EMPLOYEES_DEPARTMENT_GUID'),
		'a.birthdate' => JText::_('COM_HUMG_HRM_EMPLOYEES_BIRTHDATE'),
		);
	}

}
