<html>
<body>
 
	<?php echo anchor('welcome/logout', 'Logout', 'class="uppercase"') ?>

	<?php 
	$array = $this->user_model->getUserTwitterInfo($session['username']);
	?>
	<p>Hello</p>
	<p><?php var_dump($array) ?> </p>

<p>session data</p>
	<p> <?php var_dump($_SESSION) ?>

<?php
	$data = $this->idea_model->getIdeas();
	?>
	<p>ideas?</p>
	<p><?php var_dump($data) ?> </p>

</body>
</html>