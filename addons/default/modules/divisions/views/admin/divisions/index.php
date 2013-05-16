<section class="title">
	<h4><?php echo lang('div_title'); ?></h4>
</section>

<section class="item">
	
	<?php if ($divisions): ?>

		<?php //echo form_open('admin/categories/delete'); ?>

		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="20"><?php //echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				
				<th width="250"><?php echo lang('divisions:div_name_label'); ?></th>
				<th width="250"><?php echo lang('divisions:div_group_label'); ?></th>
				<th width="200"><?php echo lang('divisions:div_approver_label'); ?></th>
				<th width="200"><?php echo lang('divisions:div_requestor_label'); ?></th>
				<th width="120"></th>
<!--
				<th width="500"><?php //echo lang('category:cat_desc_label'); ?></th>
				<th><?php //echo lang('category:cat_items_count_label'); ?></th>
-->
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
				<?php foreach ($divisions as $division): ?>
				<tr>
					<td><?php //echo form_checkbox('action_to[]', $category->id); ?></td>
					<td><?php echo $division->division_name; ?></td>
					<td><?php echo $this->divgroups_m->get($division->division_group)->division_group_name; ?></td>
					<?php $approver = $this->user_m->get(array('id'=>$division->approver));?>
					<?php $requestor = $this->user_m->get(array('id'=>$division->requestor));?>
					<td><?php echo $approver->first_name.' '.$approver->last_name; ?></td>
					<td><?php echo $requestor->first_name.' '.$requestor->last_name; ?></td>

					<td><?php //echo $category_m->count_category_items($category->id) ?></td>
					<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/divisions/edit/'.$division->id, lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/divisions/delete/'.$division->id, lang('global:delete'), 'class="confirm button delete"') ;?>
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
		<div class="no_data"><?php echo lang('divisions:no_division'); ?></div>
	<?php endif; ?>
</section>
