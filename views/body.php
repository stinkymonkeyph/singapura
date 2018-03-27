<?php include 'master.php' ?>

<?php startblock('title') ?>
	Welcome Meow
<?php endblock('title') ?>

<?php startblock('content') ?>
	<div class="container">
		<p class="head-title">Singapura</p>
		<p class="head-description"><b>A Micro PHP Web Framework</b></p>
		<p class="head-love">Made with &#10084 from <a href="https://github.com/stinkymonkeyph/singapura" class="link"><b>github</b></a></p>
		<center>
			<img src="<?php Helper::link_asset('asset/image/who.jpg') ?>" class="singapura" />
		</center>
		<b><p class="head-body">Propositum</p></b>
		<p class="head-body-description">
			Develop a micro php fucking web framework, that doesn't come <br> with unnecessary packages
		</p>
		<b><p class="head-body">Cliché</p></b>
		<p class="head-body-description">
			Reinventing the wheel ! Another piece of shit
		</p>
	
	</div>
<?php endblock('content') ?>