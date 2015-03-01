<?php
/**
 * @version     1.0.0
 * @package     com_humg_hrm
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chuyen Trung Tran <chuyentt@gmail.com> - http://www.geomatics.vn
 */
// no direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_humg_hrm');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_humg_hrm')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_GUID'); ?></th>
			<td><?php echo $this->item->guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_LASTNAME'); ?></th>
			<td><?php echo $this->item->lastname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_FIRSTNAME'); ?></th>
			<td><?php echo $this->item->firstname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_FULLNAME'); ?></th>
			<td><?php echo $this->item->fullname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_GENDER'); ?></th>
			<td><?php echo $this->item->gender; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_DEPARTMENT_GUID'); ?></th>
			<td><?php echo $this->item->department_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_BIRTHDATE'); ?></th>
			<td><?php echo $this->item->birthdate; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_IDTYPE_GUID'); ?></th>
			<td><?php echo $this->item->idtype_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_EMPLOYEE_IDTYPE_NUMBER'); ?></th>
			<td><?php echo $this->item->idtype_number; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_humg_hrm&task=employee.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_HUMG_HRM_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_humg_hrm')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_humg_hrm&task=employee.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_HUMG_HRM_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_HUMG_HRM_ITEM_NOT_LOADED');
endif;
?>
