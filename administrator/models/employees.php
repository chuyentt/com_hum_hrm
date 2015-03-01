<?php

/**
 * @version     1.0.0
 * @package     com_humg_hrm
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chuyen Trung Tran <chuyentt@gmail.com> - http://www.geomatics.vn
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Humg_hrm records.
 */
class Humg_hrmModelEmployees extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'guid', 'a.guid',
                'lastname', 'a.lastname',
                'firstname', 'a.firstname',
                'fullname', 'a.fullname',
                'gender', 'a.gender',
                'department_guid', 'a.department_guid',
                'birthdate', 'a.birthdate',
                'idtype_guid', 'a.idtype_guid',
                'idtype_number', 'a.idtype_number',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering gender
		$this->setState('filter.gender', $app->getUserStateFromRequest($this->context.'.filter.gender', 'filter_gender', '', 'string'));

		//Filtering department_guid
		$this->setState('filter.department_guid', $app->getUserStateFromRequest($this->context.'.filter.department_guid', 'filter_department_guid', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_humg_hrm');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.fullname', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__humg_hrm_employee` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the foreign key 'department_guid'
		$query->select('#__humg_hrm_department_1733855.title AS departments_title_1733855');
		$query->join('LEFT', '#__humg_hrm_department AS #__humg_hrm_department_1733855 ON #__humg_hrm_department_1733855.guid = a.department_guid');
		// Join over the foreign key 'idtype_guid'
		$query->select('#__humg_hrm_idtype_1733863.title AS idtypes_title_1733863');
		$query->join('LEFT', '#__humg_hrm_idtype AS #__humg_hrm_idtype_1733863 ON #__humg_hrm_idtype_1733863.guid = a.idtype_guid');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.fullname LIKE '.$search.'  OR  a.department_guid LIKE '.$search.' )');
            }
        }

        

		//Filtering gender
		$filter_gender = $this->state->get("filter.gender");
		if ($filter_gender) {
			$query->where("a.gender = '".$db->escape($filter_gender)."'");
		}

		//Filtering department_guid
		$filter_department_guid = $this->state->get("filter.department_guid");
		if ($filter_department_guid) {
			$query->where("a.department_guid = '".$db->escape($filter_department_guid)."'");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {
					$oneItem->gender = JText::_('COM_HUMG_HRM_EMPLOYEES_GENDER_OPTION_' . strtoupper($oneItem->gender));

			if (isset($oneItem->department_guid)) {
				$values = explode(',', $oneItem->department_guid);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__humg_hrm_department`')
							->where($db->quoteName('guid') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->department_guid = !empty($textValue) ? implode(', ', $textValue) : $oneItem->department_guid;

			}

			if (isset($oneItem->idtype_guid)) {
				$values = explode(',', $oneItem->idtype_guid);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__humg_hrm_idtype`')
							->where($db->quoteName('guid') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->idtype_guid = !empty($textValue) ? implode(', ', $textValue) : $oneItem->idtype_guid;

			}
		}
        return $items;
    }

}
