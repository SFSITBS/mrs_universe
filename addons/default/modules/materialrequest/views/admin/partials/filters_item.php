<fieldset id="filters">
	
	<legend><?php echo lang('global:filters'); ?></legend>
	
	<?php echo form_open(''); ?>
	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
<!--
			<li>
        		<?php //echo lang('blog_status_label', 'f_status'); ?>
        		<?php //echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('blog_draft_label'), 'live'=>lang('blog_live_label'))); ?>
    		</li>
		
-->
			<li>
        		<?php echo lang('category:cat_code_label', 'f_category'); ?>
        		<?php //echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories); ?>
        		<select name="f_category">
					<option value="0"><?php echo lang('global:select-all')?></option>
					<?php foreach($categories as $category){?>
					<option value="<?php echo $category->id?>"><?php echo $category->cat_name;?></option>
					<?php }?>
        		</select>
    		</li>
			
			<li>
				<?php echo ' Part '.lang('items:item_code_label').' / Part '.lang('items:item_short_desc_label'); ?>
				<?php echo form_input('f_keywords'); ?>
			</li>
			<li><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>
