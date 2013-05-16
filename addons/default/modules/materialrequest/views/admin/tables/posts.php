<?php if ($items) : ?>
	<table border="0" class="table-list">
		<thead>
			<tr>
<!--
				<th width="20"><?php //echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
-->
				<th><?php echo lang('items:item_code_label'); ?></th>
				<th class="collapse"><?php echo lang('items:item_short_desc_label'); ?></th>
				<th width="180"></th>
			</tr>
		</thead>
		<tfoot >
			<tr>
				<td colspan="7" >
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>	
		</tfoot>
		<tbody>
			<?php foreach ($items as $item) : ?>
				<tr>
					
					<td><?php echo $item->barcode; ?></td>
					<td class="collapse"><?php echo $item->description; ?></td>
					<td>
						
                        <?php //if($post->status=='live') : ?>
                            <?php //echo anchor('blog/' . date('Y/m',$post->created_on). '/'. $post->slug, lang('global:view'), 'class="btn green" target="_blank"');?>
                        <?php //else: ?>
                            <?php //echo anchor('blog/preview/' . $post->preview_hash, lang('global:preview'), 'class="btn green" target="_blank"');?>
                        <?php //endif; ?>
						<?php echo anchor('admin/materialrequest/add_item_to_mr/' . $item->id, 'Add', 'class="btn green"'); ?>
						<?php //echo anchor('admin/blog/delete/' . $post->id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<div class="no_data"><?php echo lang('items:currently_no_posts'); ?></div>
<?php endif; ?>
