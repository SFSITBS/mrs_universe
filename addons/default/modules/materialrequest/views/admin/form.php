<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('matreq:create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('matreq:edit_title'), $mr->title); ?></h4>
<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open_multipart(); ?>

<div class="tabs">

<!--
	<ul class="tab-menu">
		<li><a href="#blog-content-tab"><span>Details</span></a></li>
		<li><a href="#blog-options-tab"><span>Add Items</span></a></li>
	</ul>
-->
	
	<!-- Content tab -->
	<div class="form_inputs" id="blog-content-tab">
		
		<fieldset>
		<h4>Request Details</h4>
		<ul>
			<li> 
				<label for="purpose"><?php echo lang('matreq:purpose_label'); ?><span>*</span></label>
				<div class="input">
					<select name="purpose">
					<option value="" >--Select--</option>
							<?php foreach($purposes as $purpose){?>
									<option value="<?php echo $purpose->id;?>" <?php if($mr) if($mr->accounting_cat == $purpose->id) { echo 'selected="selected"';} ?>>
										<?php echo $purpose->name;  ?>
									</option>
							<?php }?>
					</select></div>
			</li>
			
			<li>
				<label for="title"><?php echo lang('matreq:title_label'); ?> <span>*</span></label>
				<div class="input"><?php if(!$mr) echo form_input('title', htmlspecialchars_decode(''), 'maxlength="60" id="title" style="width:500px;"');
						else echo form_input('title', htmlspecialchars_decode($mr->title), 'maxlength="60" id="title" style="width:500px;"');
						?></div>				
			</li>
			
			<li>
				<label for="narrative"><?php echo lang('matreq:narrative_label'); ?> <span>*</span></label>
				<div class="input"><?php if($mr) echo  form_textarea(array('name'=>'narrative', 'value' => $mr->narrative,'rows' => 5));
						else  echo  form_textarea(array('name'=>'narrative', 'value' => '','rows' => 5)); ?></div>
			</li>
			<li>
				<label for="date_needed"><?php echo lang('matreq:date_needed_label'); ?> <span>*</span></label>
				<div class="input"><?php if($mr) echo form_input('date_needed', $mr->date_needed, 'maxlength="10" id="datepicker" class="text width-20" value="'.now().'"'); 
				else 
					echo form_input('date_needed', '', 'maxlength="10" id="datepicker" class="text width-20" value="'.now().'"'); ?></div>
			</li>
			
		
<!--	<hr/>
		<h4>Items</h4>
			<div class="no_data">
				<?php //echo lang('matreq:no_items_selected'); ?>
				Add Items <?php echo anchor('admin/users/create', 'here'); ?>
			</div>
-->
			
		</ul>
        <?php //echo form_hidden('preview_hash',$post->preview_hash)?>
		</fieldset>
		
	</div>
	
</div>
	
	
	
<div class="buttons">

<?php 
if($mr)
{
if($mr->status== 1) 
	$this->load->view('admin/partials/buttons', array('buttons' => array('save_then_add_items','save_draft', 'cancel'))); 
if($mr->status== 5) 
	$this->load->view('admin/partials/buttons', array('buttons' => array('save_then_add_items','cancel'))); 
}
else
$this->load->view('admin/partials/buttons', array('buttons' => array('save_then_add_items','save_draft', 'cancel'))); 
	?>

	</div>

<?php echo form_close(); ?>

	

</section>



<style type="text/css">
form.crudli.date-meta div.selector {
    float: left;
    width: 30px;
}
form.crud li.date-meta div input#datepicker { width: 8em; }
form.crud li.date-meta div.selector { width: 5em; }
form.crud li.date-meta div.selector span { width: 1em; }
form.crud li.date-meta label.time-meta { min-width: 4em; width:4em; }
</style>
