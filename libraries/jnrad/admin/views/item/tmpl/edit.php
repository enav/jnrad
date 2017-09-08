<?php
/**
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
extract(JnRadHelper::prepare($this->jnrad));
// --- rad ---

$fields = $jnrad_vars["fields"];

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tabstate');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == '<?php echo $jnrad_assetL; ?>.cancel') {
			Joomla.submitform(task, document.getElementById('<?php echo $jnrad_assetL; ?>-form'));
		}
		else {

			if (task != '<?php echo $jnrad_assetL; ?>.cancel' && document.formvalidator.isValid(document.id('<?php echo $jnrad_assetL; ?>-form'))) {

				Joomla.submitform(task, document.getElementById('<?php echo $jnrad_assetL; ?>-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_("index.php?option=com_$jnrad_nameL&layout=edit&id=".(int) $this->item->id); ?>"
	method="post"
	enctype="multipart/form-data"
	name="adminForm"
	id="<?php echo $jnrad_assetL; ?>-form"
	class="form-validate form-horizontal"
	>
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'basic')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'basic', JText::_("COM_{$jnrad_nameU}_TAB_BASIC", true)); ?>
			<!-- regular fields -->
			<?php
			foreach ($fields as $field){
				$type = $this->form->getField($field)->getAttribute("type");
				if($type == "hidden") continue;
				echo $this->form->renderField($field);
			}
			?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<!-- hidden fields -->
	<?php
	foreach ($fields as $field){
		$type = $this->form->getField($field)->getAttribute("type");
		if($type != "hidden") continue;
		echo $this->form->renderField($field);
	}
	?>
	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</form>
