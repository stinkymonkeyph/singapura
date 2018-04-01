<?php include_template('layout.master') ?>

<?php startblock('title') ?>
	Cat List
<?php endblock('title') ?>

<?php startblock('content') ?>
	<?php foreach($cats as $cat): ?>
		<p><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>
<?php endblock('content') ?>