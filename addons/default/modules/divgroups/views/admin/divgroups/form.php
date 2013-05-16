<section class="title">
	<?php //echo $this->uri->uri_string(); die();?>
	<?php //print_r($division_group); die();?>
	<?php if ($this->controller == 'admin' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('category:edit_title'), $division_group->division_group_name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('category:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="divgroups"'); ?>
	
<div class="form_inputs" style="width:70%;">

	<ul>
		
		<li>
			<label for="division_group_name"><?php echo lang('divgroup:divgroup_name_label');?> <span>*</span></label>
			<div class="input">
				<?php //$data_cat_name = array('name' => 'cat_name','value' => $category->cat_name); ?>
				<?php echo  form_input('division_group_name', $division_group->division_group_name); ?> 
				<br/><span class="side-info" >Max of 60 characters in length</span>
			</div>
		</li>
		
		<li>
			<label for="approver"><?php echo lang('divgroup:divgroup_approver_label');?> <span>*</span></label>
			<div class="input">
				<select name="approver">
					<option value="" >--Select--</option>
							<?php foreach($division_group_approvers as $division_group_approver){?>
									<option value="<?php echo $division_group_approver->id;?>" <?php if($division_group->approver === $division_group_approver->id) { echo 'selected="selected"';} ?>>
										<?php echo $division_group_approver->first_name.' '.$division_group_approver->last_name;?>
									</option>
							<?php }?>
					</select>
				<br/><span class="side-info" >Please select one</span>
			</div>
		</li>
		
		<li>
			<label for="approver_proxy"><?php echo lang('divgroup:divgroup_approver_proxy_label');?> </label>
			<div class="input">
				
				<?php if($this->method == 'edit'){?>
				<select name="approver_proxy">
					<option value="0" >--Select--</option>
							<?php foreach($division_group_approvers as $division_group_approver){
								if($division_group_approver->id !== $division_group->approver){?>
									<option value="<?php echo $division_group_approver->id;?>" <?php if($division_group->approver_proxy === $division_group_approver->id){ echo 'selected="selected"';}?>>
										<?php echo $division_group_approver->first_name.' '.$division_group_approver->last_name;?>
									</option>
								<?php } //end if?>
							<?php } //end foreach?>
					</select>
				<br/><span class="side-info" >This is optional. The <strong>Proxy Division Group Approver</strong> could not be the same as the <strong>Division Group Approver</strong></span>
				<?php } else {?>
					<select name="approver_proxy" >
						<option value="0" selected="selected">--</option>
					</select>
					<br/><span class="side-info" >This is optional. You could define this after the Division Group has been made</strong></span>
				<?php }?>
			</div>
		</li>
		
		<li>
			<label for="home_warehouse"><?php echo lang('divgroup:divgroup_home_warehouse_label');?><span>*</span></label>
			<div class="input">
				<select name="home_warehouse">
					<option value="" >--Select--</option>
							<?php foreach($warehouses as $warehouse){?>
									<option value="<?php echo $warehouse->id;?>" <?php echo ($division_group->home_warehouse == $warehouse->id) ? 'selected="selected"' : ' ';?>>
									<?php echo $warehouse->title;?>
									</option>
							<?php }?>
					</select>
				<br/><span class="side-info" >Please select one. This is where the system will do Stock Evaluation whenever a request is made under this Division Group.</span>
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
