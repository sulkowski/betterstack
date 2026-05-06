<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title>User Management</title>
    <link href="favicon.ico" type="image/x-icon" rel="icon">
    <link href="favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
  </head>
  <body class="min-h-screen bg-slate-100 py-10 sm:py-14">
    <?php include __DIR__.'/../shared/notifications.php'; ?>
    <main class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
      <?= $content ?>
    </main>
    <footer class="mx-auto flex w-full max-w-6xl flex-col px-4 sm:mt-8 sm:px-6 lg:px-8">
      <h2 class="sr-only">Service status</h2>
      <iframe src="https://sulkowski-dev.betteruptime.com/badge?theme=light" width="250" height="30" frameborder="0" scrolling="no" style="color-scheme: normal" title="Service uptime status"></iframe>
    </footer>
    <script src="js/notifications.js" defer></script>
    <?php if (isset($scripts)) { ?>
      <?= $scripts ?>
    <?php } ?>
  </body>
</html>
