<section class="title">
<?php //print_r($navigation_group); die();?>
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('nav_group_create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('nav_group_edit_title'), $navigation_group->title); ?></h4>
<?php endif; ?>

</section>

<section class="item">

    <?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

	<div class="form_inputs">
	
	    <ul>
			<!-- Location Name -->
		    <li class="even">
			    <label for="title"><?php echo lang('nav_group_label');?> <span>*</span></label>
			    <div class="input"><?php echo form_input('title', $navigation_group->title, 'class="text"'); ?>
			    <br/><span class="side-info" >Max of 30 charaters in length</span></div> 
			    
			  
		    </li>
<!--
	    
		    <li>
			    <label for="url"><?php echo lang('global:slug');?> <span>*</span></label>
			    <div class="input"><?php echo form_input('abbrev', $navigation_group->abbrev, 'class="text"'); ?></div>
		    </li>
		    
-->
		    <li>
			    <label for="delivery_address"><?php echo lang('nav_del_add_1_label');?> <span>*</span></label>
			    <?php $data_del_add = array('name' => 'del_add1','value' => $navigation_group->del_add1, 'style' => 'width:90%;' ); ?>
			    <div class="input"><?php echo form_input($data_del_add); ?></div>
		    </li>
		    
		    
		    <li>
			    <label for="telno"><?php echo lang('nav_tel_label');?> <span>*</span></label>
			    <div class="input"><?php echo form_input('tel', $navigation_group->tel, 'class="text"'); ?>
			    <br/><span class="side-info" >This may only contain numbers and dashes</span></div>
		    </li>
		    
		    <li>
			    <label for="contact_person"><?php echo lang('nav_contact_label');?> <span>*</span></label>
			    <div class="input"><?php echo form_input('contact', $navigation_group->contact, 'class="text"'); ?></div>
		    </li>
		    
		    <li>
			<label for="inventory_manager"><?php echo lang('nav_manager_label');?> <span>*</span></label>
			<div class="input">
				<select name="inventory_manager">
					<option value="" >--Select--</option>
					<?php if(count($inventory_managers) > 0){?>
							<?php foreach($inventory_managers as $inventory_manager){?>
									<option value="<?php echo $inventory_manager->id;?>" <?php if($navigation_group->inventory_manager === $inventory_manager->id) { echo 'selected="selected"';} ?>>
										<?php echo $inventory_manager->first_name.' '.$inventory_manager->last_name;?>
									</option>
							<?php } }?>
					</select>
				<br/><span class="side-info" >Note that it is requisite that an Inventory Manager is assigned to an Inventory Location. If no Inventory Manager is available for assignment, create one <?php echo anchor('admin/users/create', 'here'); ?></span>
			</div>
			</li>
		 
	    </ul>
	
	</div>
	    
	    <div class="buttons padding-top">       
		    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	    </div>
        
    <?php echo form_close(); ?>
    
</section>
    
