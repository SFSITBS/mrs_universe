<section class="title">
	<h4><?php echo lang('divgroup_title'); ?></h4>
</section>

<section class="item">
	
	<?php if ($division_groups): ?>

		<?php //echo form_open('admin/categories/delete'); ?>

		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="20"><?php //echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				
				<th width="250"><?php echo lang('divgroup:divgroup_name_label'); ?></th>
				<th width="250"><?php echo lang('divgroup:divgroup_home_warehouse_label'); ?></th>
				<th width="250"><?php echo lang('divgroup:divgroup_approver_label'); ?></th>
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
				<?php foreach ($division_groups as $division_group): ?>
				<tr>
					<td><?php //echo form_checkbox('action_to[]', $category->id); ?></td>
					<td><?php echo $division_group->division_group_name; ?></td>
					<td><?php echo $this->navigation_m->get_group($division_group->home_warehouse)->title; ?></td>
					<td><?php echo $division_group->approver_fname.' '.$division_group->approver_lname; ?></td>

					<td><?php //echo $category_m->count_category_items($category->id) ?></td>
					<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/divgroups/edit/'.$division_group->id, lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/divgroups/delete/'.$division_group->id, lang('global:delete'), 'class="confirm button delete"') ;?>
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
		<div class="no_data"><?php echo lang('divgroup:no_division_group'); ?></div>
	<?php endif; ?>
</section>
