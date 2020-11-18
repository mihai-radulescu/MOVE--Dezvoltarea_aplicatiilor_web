<?php 
	session_start();
?>

<div class="container">
	<ul class="nav nav-pills">
	  <li class="nav-item">
	    <a class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>" href="index.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link <?php if ($CURRENT_PAGE == "About") {?>active<?php }?>" href="about.php">About Us</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link <?php if ($CURRENT_PAGE == "Contact") {?>active<?php }?>" href="contact.php">Contact</a>
	  </li>
	  <?php
		if(!isset($_SESSION["userid"])){

			$active = '';
			if ($CURRENT_PAGE == "Login") {$active = 'active'; }

			echo '<li class="nav-item">';
			echo '<a class="nav-link ' . $active .'" href="login.php">Login</a>';
			echo '</li>';
		}
		else{

			$active = '';
			if ($CURRENT_PAGE == "Login") {$active = 'active'; }

			echo '<li class="nav-item">';
			echo '<a class="nav-link '. $active .'" href="addresses.php">Addresses</a>';
			echo '</li>';

			echo '<li class="nav-item">';
			echo '<a class="nav-link '. $active .'" href="includes/logout-inc.php">Logout</a>';
			echo '</li>';
		}
	  ?>
	</ul>
</div>