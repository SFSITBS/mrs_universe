<fieldset id="filters">
	
	<legend>Request Details</legend>
		
		<ul>
			<li> 
				<label for="purpose"><?php echo lang('matreq:purpose_label'); ?><span>*</span></label>
				<div class="input"><?php echo $mr->accounting_cat; ?></div>
			</li>
			
			<li>
				<label for="title"><?php echo lang('matreq:title_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('title', htmlspecialchars_decode($matreq->title), 'maxlength="60" id="title" style="width:500px;"'); ?></div>				
			</li>
			
			<li>
				<label for="narrative"><?php echo lang('matreq:narrative_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_textarea(array('name'=>'narrative', 'value' => $matreq->narrative,'rows' => 5)); ?></div>
			</li>
			<li>
				<label for="date_needed"><?php echo lang('matreq:date_needed_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('date_needed', $matreq->date_needed, 'maxlength="10" id="datepicker" class="text width-20"');  ?></div>
			</li>
			
		
<!--	<hr/>
		<h4>Items</h4>
			<div class="no_data">
				<?php //echo lang('matreq:no_items_selected'); ?>
				Add Items <?php //echo anchor('admin/users/create', 'here'); ?>
			</div>
-->
			
		</ul>
	
	
	
	<?php //echo form_open(''); ?>
	<?php //echo form_hidden('f_module', $module_details['slug']); ?>
<!--
		<ul>  
<!--
			<li>
        		<?php //echo lang('blog_status_label', 'f_status'); ?>
        		<?php //echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('blog_draft_label'), 'live'=>lang('blog_live_label'))); ?>
    		</li>
		
-->
<!--
			<li>
        		<?php //echo lang('category:cat_code_label', 'f_category'); ?>
        		<?php //echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories); ?>
-->
<!--
        		<select name="f_category">
					<option value="0"><?php //echo lang('global:select-all')?></option>
					<?php //foreach($categories as $category){?>
					<option value="<?php// echo $category->id?>"><?php echo $category->cat_name;?></option>
					<?php }?>
        		</select>
-->
<!--
    		</li>
			
			<li>
				<?php //echo ' Part '.lang('items:item_code_label').' / Part '.lang('items:item_short_desc_label'); ?>
				<?php //echo form_input('f_keywords'); ?>
			</li>
			<li><?php //echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
		</ul>
-->

	<?php //echo form_close(); ?>
</fieldset>
