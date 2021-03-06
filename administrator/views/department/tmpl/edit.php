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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_humg_hrm/assets/css/humg_hrm.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
	js('input:hidden.department_guid').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('department_guidhidden')){
			js('#jform_department_guid option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_department_guid").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'department.cancel') {
            Joomla.submitform(task, document.getElementById('department-form'));
        }
        else {
            
            if (task != 'department.cancel' && document.formvalidator.isValid(document.id('department-form'))) {
                
                Joomla.submitform(task, document.getElementById('department-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_humg_hrm&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="department-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_HUMG_HRM_TITLE_DEPARTMENT', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>				
				<input type="hidden" name="jform[guid]" value="<?php echo $this->item->guid; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('department_guid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('department_guid'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->department_guid as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="department_guid" name="jform[department_guidhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>

                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>