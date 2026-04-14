<?php
/**
 * build.php — Render tất cả trang PHP thành HTML tĩnh vào thư mục dist/
 * Chạy: php build.php
 */

define('BUILDING', true);

$srcDir  = __DIR__ . '/src';
$distDir = __DIR__ . '/dist';

// Danh sách các trang cần build: [file PHP nguồn, file HTML đích]
$pages = [
    // Trang chủ
    ['src' => 'index.php',              'dist' => 'index.html'],

    // Weeks 1–13
    ['src' => 'weeks/week-1.php',       'dist' => 'weeks/week-1.html'],
    ['src' => 'weeks/week-2.php',       'dist' => 'weeks/week-2.html'],
    ['src' => 'weeks/week-3.php',       'dist' => 'weeks/week-3.html'],
    ['src' => 'weeks/week-4.php',       'dist' => 'weeks/week-4.html'],
    ['src' => 'weeks/week-5.php',       'dist' => 'weeks/week-5.html'],
    ['src' => 'weeks/week-6.php',       'dist' => 'weeks/week-6.html'],
    ['src' => 'weeks/week-7.php',       'dist' => 'weeks/week-7.html'],
    ['src' => 'weeks/week-8.php',       'dist' => 'weeks/week-8.html'],
    ['src' => 'weeks/week-9.php',       'dist' => 'weeks/week-9.html'],
    ['src' => 'weeks/week-10.php',      'dist' => 'weeks/week-10.html'],
    ['src' => 'weeks/week-11.php',      'dist' => 'weeks/week-11.html'],
    ['src' => 'weeks/week-12.php',      'dist' => 'weeks/week-12.html'],
    ['src' => 'weeks/week-13.php',      'dist' => 'weeks/week-13.html'],
];

/**
 * Chuyển đuôi .php → .html trong nội dung HTML
 * Chỉ thay trong href="..." và href='...' để tránh ảnh hưởng code blocks
 */
function convertPhpLinks(string $html): string {
    // href="something.php" và href="something.php#anchor"
    $html = preg_replace('/href="([^"]*?)\.php(#[^"]*)?"/i', 'href="$1.html$2"', $html);
    $html = preg_replace("/href='([^']*?)\.php(#[^']*)?'/i", "href='$1.html$2'", $html);
    return $html;
}

// Tạo thư mục dist nếu chưa có
if (!is_dir($distDir)) mkdir($distDir, 0777, true);
if (!is_dir("$distDir/weeks")) mkdir("$distDir/weeks", 0777, true);

// Copy assets
$assetsDistDir = "$distDir/assets";
if (!is_dir($assetsDistDir)) mkdir($assetsDistDir, 0777, true);

foreach (['styles.css', 'script.js'] as $asset) {
    $src  = __DIR__ . "/assets/$asset";
    $dest = "$assetsDistDir/$asset";
    if (file_exists($src)) {
        copy($src, $dest);
        echo "  Copied asset: $asset\n";
    }
}

// Build mỗi trang
$ok    = 0;
$fails = 0;

foreach ($pages as $page) {
    $srcFile  = "$srcDir/{$page['src']}";
    $distFile = "$distDir/{$page['dist']}";

    if (!file_exists($srcFile)) {
        echo "  SKIP (not found): {$page['src']}\n";
        continue;
    }

    // Render PHP file thành HTML
    ob_start();
    try {
        include $srcFile;
        $html = ob_get_clean();
    } catch (Throwable $e) {
        ob_end_clean();
        echo "  ERROR {$page['src']}: " . $e->getMessage() . "\n";
        $fails++;
        continue;
    }

    // Chuyển link .php → .html
    $html = convertPhpLinks($html);

    // Ghi file HTML
    $destDir = dirname($distFile);
    if (!is_dir($destDir)) mkdir($destDir, 0777, true);

    file_put_contents($distFile, $html);
    echo "  Built: {$page['dist']}\n";
    $ok++;
}

echo "\nXong! $ok trang OK, $fails lỗi.\n";
echo "Output: $distDir\n";
