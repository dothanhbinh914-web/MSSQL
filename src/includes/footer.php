<?php
/**
 * Footer include
 * Optional variables:
 *   $prevWeek  - int|null  previous week number
 *   $nextWeek  - int|null  next week number
 *   $basePath  - relative path to root
 */
$prevWeek = $prevWeek ?? null;
$nextWeek = $nextWeek ?? null;
$basePath = $basePath ?? './';
?>

<?php if ($prevWeek !== null || $nextWeek !== null): ?>
<div class="lesson-nav-bottom container">
  <?php if ($prevWeek !== null): ?>
    <a href="<?= $basePath ?>weeks/week-<?= $prevWeek ?>.php" class="nav-btn prev">
      ← Tuần <?= $prevWeek ?>
    </a>
  <?php else: ?>
    <span></span>
  <?php endif; ?>

  <?php if ($nextWeek !== null): ?>
    <a href="<?= $basePath ?>weeks/week-<?= $nextWeek ?>.php" class="nav-btn next">
      Tuần <?= $nextWeek ?> →
    </a>
  <?php endif; ?>
</div>
<?php endif; ?>

<footer class="site-footer">
  <div class="footer-inner">
    <p>SQL Server DBA · Lộ trình 22 tuần · Made with PHP + ❤️</p>
  </div>
</footer>

<script src="<?= $basePath ?>assets/script.js"></script>
</body>
</html>
