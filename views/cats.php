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
	<b><p class="head-body">Join Result</p></b>
	<?php foreach($join as $cat): ?>
		<p class="head-body-description"><?php echo $cat['cat'].' a '.$cat['breed']; ?></p>
	<?php endforeach; ?>
	<b><p class="head-body">Or Result</p></b>
	<?php foreach($or as $cat): ?>
		<p class="head-body-description"><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>
	<b><p class="head-body">And Result</p></b>
	<?php foreach($and as $cat): ?>
		<p class="head-body-description"><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>
	<b><p class="head-body">Where_and Result</p></b>
	<?php foreach($where_and as $cat): ?>
		<p class="head-body-description"><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>
	<b><p class="head-body">Where_or Result</p></b>
	<?php foreach($where_or as $cat): ?>
		<p class="head-body-description"><?php echo $cat['name']; ?></p>
	<?php endforeach; ?>
	<b><p class="head-body">Multiple Join</p></b>
	<?php foreach($multiple_join as $cat): ?>
		<p class="head-body-description"><?php echo $cat['cat'] .' is own by ' . $cat['owner']; ?></p>
	<?php endforeach; ?>
<?php endblock('content') ?>