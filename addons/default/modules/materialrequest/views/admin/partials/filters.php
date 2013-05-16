<fieldset id="filters">
	
	<legend><?php echo lang('global:filters'); ?></legend>
	
	<?php echo form_open(''); ?>
	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
<!--
			
			<li>
        		<?php //echo lang('blog_status_label', 'f_status'); ?>
        		<?php //echo form_dropdown('f_status', array(" " => lang('global:select-all')) + $statuses); ?>
    		</li>
-->
    		
    		<li>
        		<?php echo lang('matreq:status_label', 'f_status'); ?>
        		<?php //echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories); ?>
        		<select name="f_status">
					<?php foreach($statuses as $status){?>
					<option value="<?php echo $status->id?>"><?php echo $status->desc;?></option>
					<?php }?>
        		</select>
    		</li>
			
			<li>
				<?php echo lang('matreq:keywords_label', 'f_status'); ?>
				<?php echo form_input('f_keywords'); ?>
			</li>
			
			<li><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>
