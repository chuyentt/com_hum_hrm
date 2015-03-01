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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_humg_hrm', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_humg_hrm/assets/js/form.js');


?>
</style>
<script type="text/javascript">
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function() {
        jQuery(document).ready(function() {
            jQuery('#form-position').submit(function(event) {
                
            });

            
			jQuery('input:hidden.employee_guid').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('employee_guidhidden')){
					jQuery('#jform_employee_guid option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_employee_guid").trigger("liszt:updated");
			jQuery('input:hidden.positiontype_guid').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('positiontype_guidhidden')){
					jQuery('#jform_positiontype_guid option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_positiontype_guid").trigger("liszt:updated");
			jQuery('input:hidden.department_guid').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('department_guidhidden')){
					jQuery('#jform_department_guid option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_department_guid").trigger("liszt:updated");
        });
    });

</script>

<div class="position-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-position" action="<?php echo JRoute::_('index.php?option=com_humg_hrm&task=position.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<input type="hidden" name="jform[guid]" value="<?php echo $this->item->guid; ?>" />
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('employee_guid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('employee_guid'); ?></div>
	</div>
	<?php foreach((array)$this->item->employee_guid as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="employee_guid" name="jform[employee_guidhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('positiontype_guid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('positiontype_guid'); ?></div>
	</div>
	<?php foreach((array)$this->item->positiontype_guid as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="positiontype_guid" name="jform[positiontype_guidhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('department_guid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('department_guid'); ?></div>
	</div>
	<?php foreach((array)$this->item->department_guid as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="department_guid" name="jform[department_guidhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('start'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('start'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('end'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('end'); ?></div>
	</div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_humg_hrm&task=positionform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_humg_hrm" />
        <input type="hidden" name="task" value="positionform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>