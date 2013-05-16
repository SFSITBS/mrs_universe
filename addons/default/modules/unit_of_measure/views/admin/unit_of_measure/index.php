<section class="title">
	<h4><?php echo lang('cat_list_title'); ?></h4>
</section>

<section class="item">
	
	<?php if ($unit_of_measure): ?>

		<?php //echo form_open('admin/unit_of_measure/delete'); ?>

		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="20"><?php //echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				
				<th width="250"><?php echo lang('category:cat_name_label'); ?></th>
				<th width="120"></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($unit_of_measure as $category): ?>
				<tr>
					<td><?php //echo form_checkbox('action_to[]', $category->id); ?></td>
					<td><?php echo $category->unit_name; ?></td>
					<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/unit_of_measure/edit/'.$category->id, lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/unit_of_measure/delete/'.$category->id, lang('global:delete'), 'class="confirm button delete"') ;?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="table_action_buttons">
		<?php //$this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>

		<?php //echo form_close(); ?>

	<?php else: ?>
		<div class="no_data"><?php echo lang('category:cat_no_unit_of_measure'); ?></div>
	<?php endif; ?>
</section>
