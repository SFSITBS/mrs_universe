<section class="title">
	<?php //echo $this->uri->uri_string(); die();?>
	<?php //print_r($category); die();?>
	<?php if ($this->controller == 'admin' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('category:edit_title'), $category->unit_name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('category:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="unit_of_measure"'); ?>
	
<div class="form_inputs" style="width:70%;">

	<ul>
		<li>
			<label for="description"><?php echo lang('category:cat_desc_label');?> <span>*</span></label>
			<div class="input">
				<?php echo  form_input('unit_name', $category->unit_name); ?> 
				<br/><span class="side-info">Max of 50 characters in length</span>
			</div>
		</li>
		
		<!-- Ready GL account assignment for future version -->	
			<?php echo  form_hidden('stockact', '0'); ?>
			<?php echo  form_hidden('wipact', '0'); ?>
			<?php echo  form_hidden('adjglact', '0'); ?>
			<?php echo  form_hidden('issueglact', '0'); ?>
			<?php echo  form_hidden('purchpricevaract', '0'); ?>
			<?php echo  form_hidden('materialuseagevarac', '0'); ?>
			
			<?php echo  form_hidden('method', $this->method); ?>
		

	</ul>
	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>
</div>
<!--
	<div style="clear:both"></div>
-->
	

<?php echo form_close(); ?>
</section>
