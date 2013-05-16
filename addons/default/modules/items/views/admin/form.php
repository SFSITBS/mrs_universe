<?php 
 //print_r($categories);
 //~ foreach($categories as $category)
	//~ {
		//~ echo $category->id.'<br/>';
	//~ }
 //~ die();
?>

<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('blog:create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('blog:edit_title'), $item->title); ?></h4>
<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open_multipart(); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#blog-content-tab"><span><?php echo lang('blog:content_label'); ?></span></a></li>
<!--
		<li><a href="#blog-options-tab"><span><?php echo lang('blog:options_label'); ?></span></a></li>
-->
	</ul>
	
	<!-- Content tab -->
	<div class="form_inputs" id="blog-content-tab">
		
		<fieldset style="width:60%;">
	
		<ul>
<!--
			<li>
				<label for="title"><?php //echo lang('global:title'); ?> <span>*</span></label>
				<div class="input"><?php //echo form_input('title', htmlspecialchars_decode($item->title), 'maxlength="100" id="title"'); ?></div>				
			</li>
-->
			
			<li>
				<label for="description"><?php echo lang('blog:description_label'); ?> <span>*</span></label>
				<br style="clear: both;" />
				<div class="input"><?php echo form_input('description', $item->description, 'maxlength="50"'); ?></div>				
			</li>
			
			<li>
				<label for="long_description"><?php echo lang('blog:long_description_label'); ?></label>
				<br style="clear: both;" />
				<?php echo form_textarea(array('name' => 'long_description', 'value' => $item->long_description, 'rows' => 3, 'cols' => 3)); ?>
			</li>
			
			<li>
				<label for="category"><?php echo lang('blog:category_label'); ?></label>
				<br style="clear: both;" />
				<div class="input">
					<select name="category">
							<?php foreach($categories as $category){?>
									<option value="<?php echo $category->id;?>" ><?php echo $category->cat_name;?></option>
							<?php }?>
					</select>
				</div>
			</li>
			
			<li>
				<label for="unit"><?php echo lang('blog:unit_label'); ?></label>
				<br style="clear: both;" />
				<div class="input">
					<select name="unit">
							<?php foreach($uoms as $uom){?>
									<option value="<?php echo $uom->unit_name;?>" ><?php echo $uom->unit_name;?></option>
							<?php }?>
					</select>
				</div>
			</li>
			
			<li>
				<label for="volume"><?php echo lang('blog:volume_label'); ?> <span>*</span></label>
				<br style="clear: both;" />
				<div class="input"><?php echo form_input('volume', $item->volume, 'maxlength="50"'); ?></div>				
			</li>
			
			<li>
				<label for="weight"><?php echo lang('blog:weight_label'); ?> <span>*</span></label>
				<br style="clear: both;" />
				<div class="input"><?php echo form_input('weight', $item->weight, 'maxlength="50"'); ?></div>				
			</li>
			
			<li>
				<label for="is_serialized"><?php echo lang('blog:is_serialized_label'); ?></label>
				<br style="clear: both;" />
				<div class="input">
					<select name="is_serialized">
						<option value="1" >Yes</option>
						<option value="2" >No</option>
					</select>
				</div>
			</li>
			
<!--
			<li>
				<label for="slug"><?php echo lang('global:slug'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', $item->slug, 'maxlength="100" class="width-20"'); ?></div>
			</li>
-->
			
<!--
			<li>
				<label for="status"><?php echo lang('blog:status_label'); ?></label>
				<div class="input"><?php echo form_dropdown('status', array('draft' => lang('blog:draft_label'), 'live' => lang('blog:live_label')), $item->status) ?></div>
			</li>
-->
			
<!--
			<li>
				<label for="intro"><?php //echo lang('blog:intro_label'); ?></label>
				<br style="clear: both;" />
				<?php //echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $item->intro, 'rows' => 5, 'class' => 'blog wysiwyg-simple')); ?>
			</li>
-->
			
<!--
			<li class="editor">
				<label for="body"><?php echo lang('blog:content_label'); ?></label>
				
				<div class="input">
					<?php echo form_dropdown('type', array(
						'html' => 'html',
						'markdown' => 'markdown',
						'wysiwyg-simple' => 'wysiwyg-simple',
						'wysiwyg-advanced' => 'wysiwyg-advanced',
					), $item->type); ?>
				</div>
				
				<br style="clear:both"/>
				
				<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $item->body, 'rows' => 30, 'class' => $item->type)); ?>
				
			</li>
-->
		</ul>
        <?php //echo form_hidden('preview_hash',$item->preview_hash)?>
		</fieldset>
		
	</div>

	<!-- Options tab -->
<!--
	<div class="form_inputs" id="blog-options-tab">
	
		<fieldset style="width:60%;">
		
-->
<!--
		<ul>
			<li>
				<label for="category_id"><?php //echo lang('blog:category_label'); ?></label>
				<div class="input">
				<?php //echo form_dropdown('category_id', array(lang('blog:no_category_select_label')) + $categories, @$item->category_id) ?>
					[ <?php //echo anchor('admin/blog/categories/create', lang('blog:new_category_label'), 'target="_blank"'); ?> ]
				</div>
			</li>
			
			<li>
				<label for="keywords"><?php //echo lang('global:keywords'); ?></label>
				<div class="input"><?php //echo form_input('keywords', $item->keywords, 'id="keywords"') ?></div>
			</li>
						
			<li class="date-meta">
				<label><?php //echo lang('blog:date_label'); ?></label>
				
				<div class="input datetime_input">
				<?php //echo form_input('created_on', date('Y-m-d', $item->created_on), 'maxlength="10" id="datepicker" class="text width-20"'); ?> &nbsp;
				<?php //echo form_dropdown('created_on_hour', $hours, date('H', $item->created_on)) ?> : 
				<?php //echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($item->created_on, '0'))) ?>
				
				</div>
			</li>
			
			<li>
				<label for="comments_enabled"><?php //echo lang('blog:comments_enabled_label');?></label>
				<div class="input"><?php //echo form_checkbox('comments_enabled', 1, ($this->method == 'create' && ! $_item) or $item->comments_enabled == 1, 'id="comments_enabled"'); ?></div>
			</li>
		</ul>
-->
<!--

		</fieldset>
		
	</div>
-->

</div>

<div class="buttons">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>

<style type="text/css">
form.crudli.date-meta div.selector {
    float: left;
    width: 30px;
}
form.crud li.date-meta div input#datepicker { width: 8em; }
form.crud li.date-meta div.selector { width: 5em; }
form.crud li.date-meta div.selector span { width: 1em; }
form.crud li.date-meta label.time-meta { min-width: 4em; width:4em; }
</style>
