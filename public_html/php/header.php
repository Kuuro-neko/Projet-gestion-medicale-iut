<header>
		<img class="logo" src="../images/logo.png" alt="logo" height="55">
		<nav class="menu">
			<input type="checkbox" id="menuToggle">
			<ul>
				<li><a href="accueil.php">Accueil</a>
				</li>
				<li><a href="patients.php">Patients</a>
				</li>
				<li><a href="medecins.php">Médecins</a>
				</li>
				<li><a href="consultations.php">Consultations</a>
				</li>
				<li><a href="<?php echo $thisPage; ?>.php?disconnect=true">Se déconnecter</a>
				</li>
			</ul>
		</nav>
	</header>