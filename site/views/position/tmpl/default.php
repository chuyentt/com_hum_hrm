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
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_EMPLOYEE_GUID'); ?></th>
			<td><?php echo $this->item->employee_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_POSITION_GUID'); ?></th>
			<td><?php echo $this->item->positiontype_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_DEPARTMENT_GUID'); ?></th>
			<td><?php echo $this->item->department_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_START'); ?></th>
			<td><?php echo $this->item->start; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_HUMG_HRM_FORM_LBL_POSITION_END'); ?></th>
			<td><?php echo $this->item->end; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_humg_hrm&task=position.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_HUMG_HRM_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_humg_hrm')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_humg_hrm&task=position.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_HUMG_HRM_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_HUMG_HRM_ITEM_NOT_LOADED');
endif;
?>
