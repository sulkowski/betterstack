<!DOCTYPE html>
<html>
  <head>
  	<meta charset="UTF-8">
  	
    <title>User Management</title>
    
	<link href="favicon.ico" type="image/x-icon" rel="icon" />
	<link href="favicon.ico" type="image/x-icon" rel="shortcut icon" />	
	<link rel="stylesheet" href="css/tailwind.css">
	<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

  </head>
  <body class="min-h-screen bg-slate-100 py-10 sm:py-14">
	<main class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
		<?= $content ?>
	</main>
	<?php if (isset($scripts)) { ?>
		<?= $scripts ?>
	<?php } ?>
  </body>
</html>