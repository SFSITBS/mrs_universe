<?php if(is_array($unit_of_measure)): ?>
<ul>
	<?php foreach($unit_of_measure as $category): ?>
	<li>
		<?php echo anchor("blog/category/{$category->slug}", $category->title); ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
