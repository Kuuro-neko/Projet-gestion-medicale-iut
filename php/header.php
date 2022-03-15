<header>
		<img class="logo" src="../images/logo.png" alt="logo" height="55">
		<nav class="menu">
			<input type="checkbox" id="menuToggle">
			<label for="menuToggle" class="menu-icon"><img src="./images/menu_icon.png" alt="Menu de navigation déroulant" height="60"></label>
			<ul>
				<li><a href="accueil.php">Accueil</a>
				</li>
				<li><a href="patients.php">Gestion des patients</a>
				</li>
				<li><a href="medecins.php">Gestion des médecins</a>
				</li>
				<li><a href="rdv.php">Gestion des rendez-vous</a>
				</li>
				<li><a href="<?php echo $thisPage; ?>.php?disconnect=true">Se déconnecter</a>
				</li>
			</ul>
		</nav>
	</header>