<?php if ($material_requests): ?>
		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="400"><?php echo lang('approvegroup:request_label'); ?></th>
				<th width="250"><?php echo lang('approvegroup:request_status_label'); ?></th>
				<th width="100"><?php echo lang('approvegroup:created_by_label'); ?></th>
				<th width="140"><?php echo lang('approvegroup:approved_by'); ?></th>
				<th><?php echo lang('category:cat_items_count_label'); ?></th>
				<th width="40"></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($material_requests as $mr):  { ?>
				<tr>
					<td><a href="admin/approvedivgroup/view_mr/<?php echo $mr->id; ?>"><?php echo $mr->title; ?></a></td>
					<td><?php if($mr_status){ foreach($mr_status as $mr_stat){ if($mr->status==$mr_stat->id){echo $mr_stat->desc;} }}?></td>
					<td><?php if($users){ foreach($users as $user){ if($user->id==$mr->requestor)echo $user->username; }}?></td>
					<!--<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/categories/edit/'.$mr->id, lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/categories/delete/'.$mr->id, lang('global:delete'), 'class="confirm button delete"') ;?>
						<?php //echo anchor('admin/categories/approve/'.$mr->id, lang('global:approve'), 'class="button approve"'); ?>
					</td>-->
				
				</tr>
				<?php } endforeach; ?>
			</tbody>
		</table>

		<div class="table_action_buttons">
		<?php //$this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>

		<?php //echo form_close(); ?>

	<?php else: ?>
		<div class="no_data"><?php echo lang('approvegroup:no_pending'); ?></div>
	<?php endif; ?>
