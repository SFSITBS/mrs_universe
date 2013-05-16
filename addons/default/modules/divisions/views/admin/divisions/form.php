<section class="title">
	<?php //echo $this->uri->uri_string(); die();?>
	<?php //print_r($division); die();?>
	<?php if ($this->controller == 'admin' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('divisions:edit_title'), $division->division_name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('divisions:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="divisions"'); ?>
	
<div class="form_inputs" style="width:70%;">

	<ul>
		
		<li>
			<label for="division_name"><?php echo lang('divisions:div_name_label');?> <span>*</span></label>
			<div class="input">
				<?php //$data_cat_name = array('name' => 'cat_name','value' => $category->cat_name); ?>
				<?php echo  form_input('division_name', $division->division_name); ?> 
				<br/><span class="side-info" >Max of 60 characters in length</span>
			</div>
		</li>
		
		<li>
			<label for="division_group"><?php echo lang('divisions:div_group_label');?> <span>*</span></label>
			<div class="input">
				<select name="division_group">
					<option value="" >--Select--</option>
							<?php foreach($division_groups as $division_group){?>
									<option value="<?php echo $division_group->id;?>" <?php if($division->division_group === $division_group->id) { echo 'selected="selected"';} ?>>
										<?php echo $division_group->division_group_name;?>
									</option>
							<?php }?>
					</select>
				<br/><span class="side-info" >Please select one</span>
			</div>
		</li>
		
		<li>
			<label for="approver"><?php echo lang('divisions:div_approver_label');?> <span>*</span></label>
			<div class="input">
				<select name="approver">
					<option value="" >--Select--</option>
							<?php foreach($division_approvers as $division_approver){?>
									<option value="<?php echo $division_approver->id;?>" <?php if($division->approver === $division_approver->id) { echo 'selected="selected"';} ?>>
										<?php echo $division_approver->first_name.' '.$division_approver->last_name;?>
									</option>
							<?php }?>
					</select>
				<br/><span class="side-info" >Please select one</span>
			</div>
		</li>
		
		<li>
			<label for="approver_proxy"><?php echo lang('divisions:div_approver_proxy_label');?> </label>
			<div class="input">
				
				<?php if($this->method == 'edit'){?>
				<select name="approver_proxy">
					<option value="0" >--Select--</option>
							<?php foreach($division_approvers as $division_approver){
								if($division_approver->id !== $division->approver){?>
									<option value="<?php echo $division_approver->id;?>" <?php if($division->approver_proxy === $division_approver->id){ echo 'selected="selected"';}?>>
										<?php echo $division_approver->first_name.' '.$division_approver->last_name;?>
									</option>
								<?php } //end if?>
							<?php } //end foreach?>
					</select>
				<br/><span class="side-info" >This is optional. Note that <strong>Proxy Division Group Approver</strong> could not be the same as the <strong>Division Group Approver</strong></span>
				<?php } else {?>
					<select name="approver_proxy" >
						<option value="0" selected="selected">--</option>
					</select>
					<br/><span class="side-info" >This is optional. You could define this after the Division has been saved</span>
				<?php }?>
			</div>
		</li>
		
		<li>
			<label for="requestor"><?php echo lang('divisions:div_requestor_label');?> <span>*</span></label>
			<div class="input">
				<select name="requestor">
					<option value="" >--Select--</option>
							<?php foreach($division_requestors as $division_requestor){
								if($division->requestor === $division_requestor->id){
								?>
									<option value="<?php echo $division_requestor->id;?>" <?php if($division->requestor === $division_requestor->id) { echo 'selected="selected"';} ?>>
										<?php echo $division_requestor->first_name.' '.$division_requestor->last_name;?>
									</option>
								<?php }else{ ?>
								<?php if(!$this->divisions_m->is_requestor_assigned($division_requestor->id)){?>
									<option value="<?php echo $division_requestor->id;?>" >
										<?php echo $division_requestor->first_name.' '.$division_requestor->last_name;?>
									</option>
									<?php } //end if?>
								<?php } //end else?>
							<?php }?>
					</select>
				<br/><span class="side-info" >Note that it is requisite that a <strong>requestor/proxy requestor</strong> should be exclusively assigned to a division. If no requestor is available for assignment, create one <?php echo anchor('admin/users/create', 'here'); ?></span>
			</div>
		</li>
		
		<li>
			<label for="requestor_proxy"><?php echo lang('divisions:div_requestor_proxy_label');?> </label>
			<div class="input">
				
				<?php if($this->method == 'edit'){?>
				<select name="requestor_proxy">
					<option value="0" >--Select--</option>
							<?php foreach($division_requestors as $division_requestor){
								if(!$this->divisions_m->is_requestor_assigned($division_requestor->id)){
								if($division_requestor->id !== $division->requestor){?>
									<option value="<?php echo $division_requestor->id;?>" <?php if($division->requestor_proxy === $division_requestor->id){ echo 'selected="selected"';}?>>
										<?php echo $division_requestor->first_name.' '.$division_requestor->last_name;?>
									</option>
								<?php } //end if?>
								<?php } //end if?>
							<?php } //end foreach?>
					</select>
				<br/><span class="side-info" >This is optional. Note that the <strong> Proxy Division Requestor</strong> could not be the same as the <strong>Proxy Division Requestor</strong></span>
				<?php } else {?>
					<select name="requestor_proxy" >
						<option value="0" selected="selected">--</option>
					</select>
					<br/><span class="side-info" >This is optional. You could define this after the Division has been saved</span>
				<?php }?>
			</div>
		</li>
		
		
	
	</ul>
	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>
</div>
<!--
	<div style="clear:both"></div>
-->
	

<?php echo form_close(); ?>
</section>
