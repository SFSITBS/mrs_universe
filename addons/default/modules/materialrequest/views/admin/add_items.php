<script type="text/javascript">
	function DoSubmit(line){
	
    	quantity = 	 document.getElementById("quantity"+line).value;
		if(quantity  == null || quantity == "" || quantity == false || isNaN (quantity-0))		
			{quantity = 0;}
		window.location = "admin/materialrequest/edit_item/"+line+"/"+quantity;
	      }
	function submitform(mr_id)
	{
	window.location = "admin/materialrequest/submit_requisition/"+mr_id;
	}
		  
</script>

<section class="title">
	<h4><?php echo 'Add Items to Request'; ?></h4>
</section>

<section class="item">
	
	<div class="form_inputs" >
		
				<fieldset id="filters">
					
	<h4>Request Details</h4>  
	<?php if($mr->status == 1 ||$mr->status == 5)
	{?>
		<a href = "admin/materialrequest/edit_mr_details/<?php echo $mr->id; ?>">Edit</a>
		<?php } ?>
		
	
		<ul>
			<li> 
				<label for="purpose"><?php echo lang('matreq:purpose_label'); ?><span>*</span></label>
				<div class="input"><?php foreach($purposes as $purpose)
									{ if($mr->accounting_cat=== $purpose->id) 
										 echo $purpose->name;
									}?>
							<?php //echo $mr->accounting_cat; ?></div>
			</li>
			
			<li>
				<label for="title"><?php echo lang('matreq:title_label'); ?> <span>*</span></label>
				<div class="input"><?php echo $mr->title; ?></div>				
			</li>
			
			<li>
				<label for="narrative"><?php echo lang('matreq:narrative_label'); ?> <span>*</span></label>
				<div class="input"><?php echo $mr->narrative; ?></div>
			</li>
			<li>
				<label for="date_needed"><?php echo lang('matreq:date_needed_label'); ?> <span>*</span></label>
				<div class="input"><?php echo $mr->date_needed;  ?></div>
			</li>
			
			
	
			
		<h4>Items on Requests</h4>
		<?php if(!$data['cart']){?>
			<div class="no_data">
				<?php echo lang('matreq:no_items_selected'); ?>
				Add items below<?php //echo anchor('admin/users/create', 'here'); ?>
			</div>
		<?php }else{
				//print_r($data['cart']);
			?>
			<table border="0" class="table-list">
				<thead>
					<tr>
					<th ><?php echo 'Description'; ?></th>
					<th ><?php echo 'Quantity' ?></th>
					<th width="100px" ><?php echo " "; ?></th>
					
					</tr>
				</thead>
				<tbody>

				<?php
					foreach(array_reverse($data['cart'], true) as $line=>$item1)
					{
						$cur_item_info = $this->item_m->get($item1['item_id']);	
						//$attributes = array('id' => 'cart_item', 'name' => 'item_edit');
						//echo form_open("materialrequest/edit_item/$line",$attributes);
					?>
						<form id="cart_item" name="cart_item" method="post" action="admin/materialrequest/edit_item/<?php echo $line.'/'.$item1['quantity'];?>">
						<?php //echo "<script>alert('".$item1['description']."');</script>"; ?>
						<input type="hidden" name="item_id" value="<?php echo $item1['item_id']; ?>">
						<tr>
						<td><?php echo $item1['description']; ?></td>

						<td>
						<input type="text" id ="<?php echo "quantity".$line;?>" name="<?php echo "quantity".$line;?>" value="<?php echo $item1['quantity']; ?>" onchange="DoSubmit(<?php echo $line;?>)">
						<?php //echo form_input(array('name'=>'quantity','value'=>$item1['quantity'],'size'=>'2'));?>
						</td>
						<td><?php echo anchor("admin/materialrequest/delete_item/$line",'Delete');?> <?php //echo form_submit("edit", 'Edit');?> </td>
						<input type="submit" value="edit" style="display:none;">
						</tr>
						</form>
					<?php
					}
				
				?>
				</tbody>
			</table>
			
			<?php }?>
		
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
					<?php //}?>
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


</fieldset>
		<div class="buttons">
			<input type ="submit"   value="Submit For Approval" class="btn blue" onclick="submitform(<?php echo $mr->id; ?>)"/>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('cancel'))); ?>						
		</div>
	</div>
	
	<?php template_partial('filters'); ?>

	<?php //echo form_open('admin/item/action'); ?>

		<div id="filter-stage">
			<?php template_partial('tables/posts'); ?>
		</div>

		<div class="table_action_buttons">
			<?php //$this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
			
		</div>

	<?php //echo form_close(); ?>

</section>
