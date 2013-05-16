<?php if ($material_request) : ?>
	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="400px"><?php echo lang('matreq:title_label'); ?></th>
				<th class="250"><?php echo lang('matreq:status_label'); ?></th>
				<th class="100"><?php echo lang('matreq:created_on_label'); ?></th>
				<th><?php echo lang('blog_status_label'); ?></th>
				<th width="180"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($material_request as $post) : ?>
				<tr>
					<td><?php if($post->status==1 || $post->status==5 ) // draft, require changes
					{?> <a href="admin/materialrequest/add_items/<?php echo $post->id; ?>" ><?php }?>
					
					<?php if($post->status==2 || $post->status==3  || $post->status==4 ) //for approval
					{?><a href="admin/materialrequest/view_mr/<?php echo $post->id; ?>"><?php }?>
					
					
					<?php echo $post->title; ?>					
					</a></td>
					<td class="collapse"><?php if($mr_status){ foreach($mr_status as $mr_stat){ if($post->status==$mr_stat->id){echo $mr_stat->desc;} }}?></td>
					<td class="collapse"><?php echo $post->created; ?></td>
					<td class="collapse">
					<?php //if (isset($post->display_name)): ?>
						<?php //echo anchor('user/' . $post->author_id, $post->display_name, 'target="_blank"'); ?>
					<?php //else: ?>
						<?php //echo lang('blog_author_unknown'); ?>
					<?php //endif; ?>
					</td>
					<td><?php //echo lang('blog_'.$post->status.'_label'); ?></td>
					<td>

                        <?php //if($post->status=='live') : ?>
                            <?php //echo anchor('blog/' . date('Y/m',$post->created_on). '/'. $post->slug, lang('global:view'), 'class="btn green" target="_blank"');?>
                        <?php //else: ?>
                            <?php //echo anchor('blog/preview/' . $post->preview_hash, lang('global:preview'), 'class="btn green" target="_blank"');?>
                        <?php //endif; ?>
						<?php //echo anchor('admin/blog/edit/' . $post->id, lang('global:edit'), 'class="btn orange edit"'); ?>
						<?php //echo anchor('admin/blog/delete/' . $post->id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php  else: ?>
	<div class="no_data"><?php echo lang('blog:currently_no_posts'); ?></div>
<?php endif; ?>
