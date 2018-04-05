<?php include_template('layout.master') ?>

<?php startblock('title') ?>
	Cat List
<?php endblock('title') ?>

<?php startblock('content') ?>
	<br>
	<p class="head-title">Singapura</p>
	<b><p class="head-body">List of Cats</p></b>
	<br>
	<?php foreach($cats as $cat): ?>
		<p class="head-body-description"><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>

	<hr>
	<br>
	<b><p class="head-body">Filtered Cats</p></b>
	<?php foreach($cat_filtered as $cat): ?>
		<p class="head-body-description"><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>
<?php endblock('content') ?>