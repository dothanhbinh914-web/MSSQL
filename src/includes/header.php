<?php
/**
 * Header include
 * Required variables:
 *   $pageTitle   - page <title>
 *   $basePath    - relative path to root (e.g. './' or '../')
 * Optional:
 *   $phaseColor  - CSS var name e.g. 'phase1'
 *   $weekNum     - current week number (for progress bar color)
 *   $isWeekPage  - bool, true if inside weeks/
 */
$phaseColor  = $phaseColor  ?? 'phase1';
$isWeekPage  = $isWeekPage  ?? false;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?> | SQL Server DBA</title>
  <link rel="stylesheet" href="<?= $basePath ?>assets/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <?php if ($isWeekPage): ?>
  <style>
    #reading-progress { position:fixed; top:60px; left:0; height:3px; background:var(--<?= $phaseColor ?>); width:0; z-index:200; transition:width .1s; }
  </style>
  <?php endif; ?>
</head>
<body>
<?php if ($isWeekPage): ?>
<div id="reading-progress"></div>
<?php endif; ?>

<header class="site-header">
  <div class="header-inner">
    <a href="<?= $basePath ?>index.php" class="header-logo">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <ellipse cx="12" cy="5" rx="9" ry="3"/>
        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
      </svg>
      SQL Server <span>DBA</span>
    </a>
    <nav class="header-nav">
      <?php if ($isWeekPage): ?>
        <a href="<?= $basePath ?>index.php">← Lộ trình</a>
      <?php else: ?>
        <a href="<?= $basePath ?>index.php">Lộ trình</a>
        <a href="<?= $basePath ?>pages/resources.php">Tài nguyên</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
