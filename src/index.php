<?php
$pageTitle = 'Lộ trình học SQL Server DBA từ A→Z';
$basePath  = './';
require __DIR__ . '/includes/header.php';
?>

<!-- Hero -->
<div class="hero">
  <h1 class="hero-title">Lộ trình học <span class="accent">SQL Server DBA</span><br>từ con số 0</h1>
  <p class="hero-subtitle">Chương trình 22 tuần bài bản, học 3 tiếng/ngày. Từ cài đặt đến vận hành hệ thống production — mỗi tuần một bài học chi tiết.</p>
  <div class="hero-stats">
    <div class="stat"><div class="stat-num">22</div><div class="stat-lbl">Tuần học</div></div>
    <div class="stat"><div class="stat-num">5</div><div class="stat-lbl">Giai đoạn</div></div>
    <div class="stat"><div class="stat-num">3h+</div><div class="stat-lbl">Mỗi ngày</div></div>
    <div class="stat"><div class="stat-num">DBA</div><div class="stat-lbl">Mục tiêu</div></div>
  </div>
</div>

<div class="container" style="padding-bottom: 64px;">

  <!-- Phase 1 -->
  <section class="phase-section phase-1">
    <div class="phase-label">
      <span class="phase-badge">Giai đoạn 1</span>
      <span class="phase-name">Nền tảng &amp; môi trường</span>
      <span class="phase-weeks">Tuần 1–3</span>
    </div>
    <div class="week-grid">
      <a href="weeks/week-1.php" class="week-card">
        <div class="week-num">Tuần 1</div>
        <div class="week-title">Cài đặt &amp; làm quen</div>
        <ul class="week-topics">
          <li>Cài SQL Server Developer (miễn phí)</li>
          <li>Cài SSMS &amp; Azure Data Studio</li>
          <li>Tạo database đầu tiên</li>
          <li>Hiểu giao diện Object Explorer</li>
          <li>Chạy truy vấn đầu tiên</li>
        </ul>
        <span class="arrow-icon">→</span>
      </a>
      <a href="weeks/week-2.php" class="week-card">
        <div class="week-num">Tuần 2</div>
        <div class="week-title">Kiến trúc &amp; dữ liệu</div>
        <ul class="week-topics">
          <li>Instance, Database, Schema</li>
          <li>File .mdf, .ndf, .ldf là gì</li>
          <li>Kiểu dữ liệu: INT, VARCHAR, DATE</li>
          <li>NULL và NOT NULL</li>
          <li>Tạo và xóa table</li>
        </ul>
        <span class="arrow-icon">→</span>
      </a>
      <a href="weeks/week-3.php" class="week-card">
        <div class="week-num">Tuần 3</div>
        <div class="week-title">Ràng buộc &amp; quan hệ</div>
        <ul class="week-topics">
          <li>Primary Key, Foreign Key</li>
          <li>UNIQUE, CHECK, DEFAULT</li>
          <li>Quan hệ 1-1, 1-nhiều, nhiều-nhiều</li>
          <li>Thiết kế schema đơn giản</li>
          <li>Import dữ liệu mẫu AdventureWorks</li>
        </ul>
        <div class="week-milestone">🎯 Mốc: Tạo được CSDL quản lý nhân viên</div>
      </a>
    </div>
  </section>

  <!-- Phase 2 -->
  <section class="phase-section phase-2">
    <div class="phase-label">
      <span class="phase-badge">Giai đoạn 2</span>
      <span class="phase-name">T-SQL từ cơ bản đến thành thạo</span>
      <span class="phase-weeks">Tuần 4–9</span>
    </div>
    <div class="week-grid">
      <?php
      $phase2 = [
        [4,'SELECT cơ bản',['SELECT, FROM, WHERE','AND, OR, NOT, IN, BETWEEN','LIKE, IS NULL','ORDER BY, TOP, DISTINCT','Luyện 30 bài tập SELECT']],
        [5,'JOIN &amp; kết hợp bảng',['INNER JOIN, LEFT JOIN','RIGHT JOIN, FULL OUTER JOIN','CROSS JOIN, SELF JOIN','JOIN nhiều bảng cùng lúc','Bài tập: báo cáo đơn hàng']],
        [6,'Tổng hợp &amp; phân nhóm',['GROUP BY, HAVING','COUNT, SUM, AVG, MIN, MAX','ROLLUP, CUBE, GROUPING SETS','Subquery trong SELECT','Bài tập: thống kê doanh thu']],
        [7,'DML &amp; thao tác dữ liệu',['INSERT, INSERT INTO SELECT','UPDATE với điều kiện phức tạp','DELETE, TRUNCATE','MERGE (upsert)','OUTPUT clause']],
        [8,'Hàm tích hợp',['Hàm chuỗi: LEN, TRIM, REPLACE, CONCAT','Hàm ngày: GETDATE, DATEADD, DATEDIFF','Hàm số: ROUND, CEILING, FLOOR','CAST, CONVERT, FORMAT','ISNULL, COALESCE, CASE WHEN']],
        [9,'CTE &amp; Window Functions',['CTE (WITH ... AS)','Recursive CTE','ROW_NUMBER, RANK, DENSE_RANK','LAG, LEAD, FIRST_VALUE','PARTITION BY, OVER']],
      ];
      foreach ($phase2 as $w):
        [$num, $title, $topics] = $w;
        $milestone = $num === 9 ? '<div class="week-milestone">🎯 Mốc: Viết được báo cáo doanh thu theo tháng/quý</div>' : '<span class="arrow-icon">→</span>';
      ?>
      <a href="weeks/week-<?= $num ?>.php" class="week-card">
        <div class="week-num">Tuần <?= $num ?></div>
        <div class="week-title"><?= $title ?></div>
        <ul class="week-topics">
          <?php foreach ($topics as $t): ?><li><?= $t ?></li><?php endforeach; ?>
        </ul>
        <?= $milestone ?>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Phase 3 -->
  <section class="phase-section phase-3">
    <div class="phase-label">
      <span class="phase-badge">Giai đoạn 3</span>
      <span class="phase-name">Lập trình T-SQL nâng cao</span>
      <span class="phase-weeks">Tuần 10–14</span>
    </div>
    <div class="week-grid">
      <?php
      $phase3 = [
        [10,'Stored Procedure',['Tạo, sửa, xóa SP','Tham số INPUT, OUTPUT','TRY...CATCH xử lý lỗi','RAISERROR, THROW','Thực hành: SP quản lý đặt hàng']],
        [11,'Function &amp; View',['Scalar Function','Table-valued Function (inline &amp; multi)','View cơ bản và Indexed View','Khi nào dùng SP vs Function','Thực hành: view báo cáo']],
        [12,'Transaction &amp; Lock',['BEGIN TRAN, COMMIT, ROLLBACK','SAVEPOINT','Isolation Level (4 mức)','Deadlock là gì và cách phòng','@@TRANCOUNT, XACT_STATE']],
        [13,'Trigger &amp; Event',['AFTER INSERT / UPDATE / DELETE','INSTEAD OF trigger','Bảng INSERTED và DELETED','DDL Trigger','Khi nào nên/không nên dùng trigger']],
        [14,'Dynamic SQL &amp; Cursor',['sp_executesql, EXEC','Tránh SQL Injection','CURSOR: FAST_FORWARD, STATIC','Thay thế cursor bằng set-based','Thực hành: báo cáo động']],
      ];
      foreach ($phase3 as $w):
        [$num, $title, $topics] = $w;
        $milestone = $num === 14 ? '<div class="week-milestone">🎯 Mốc: Xây dựng hệ thống SP quản lý bán hàng</div>' : '<span class="arrow-icon">→</span>';
      ?>
      <a href="weeks/week-<?= $num ?>.php" class="week-card">
        <div class="week-num">Tuần <?= $num ?></div>
        <div class="week-title"><?= $title ?></div>
        <ul class="week-topics">
          <?php foreach ($topics as $t): ?><li><?= $t ?></li><?php endforeach; ?>
        </ul>
        <?= $milestone ?>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Phase 4 -->
  <section class="phase-section phase-4">
    <div class="phase-label">
      <span class="phase-badge">Giai đoạn 4</span>
      <span class="phase-name">Quản trị DBA cốt lõi</span>
      <span class="phase-weeks">Tuần 15–19</span>
    </div>
    <div class="week-grid">
      <?php
      $phase4 = [
        [15,'Index &amp; tối ưu truy vấn',['Clustered vs Non-clustered Index','Composite Index, Covering Index','Đọc Execution Plan','Table Scan vs Index Seek/Scan','Index Fragmentation &amp; Rebuild']],
        [16,'Backup &amp; Restore',['Full Backup','Differential Backup','Transaction Log Backup','Recovery Model: Simple/Bulk/Full','Point-in-time Restore']],
        [17,'Bảo mật &amp; phân quyền',['Authentication: Windows vs SQL','Login, User, Role','GRANT, DENY, REVOKE','Schema-based permission','Row-Level Security, Dynamic Data Masking']],
        [18,'SQL Server Agent &amp; Job',['Tạo Job tự động','Schedule: hàng ngày/tuần/tháng','Alert khi có lỗi','Maintenance Plan','Database Mail (gửi email cảnh báo)']],
        [19,'Monitoring &amp; Troubleshoot',['DMV: sys.dm_exec_requests, dm_os_wait_stats','Activity Monitor','sp_who2, sp_BlitzFirst','Tìm truy vấn chậm (Query Store)','Giải quyết Deadlock thực tế']],
      ];
      foreach ($phase4 as $w):
        [$num, $title, $topics] = $w;
        $milestone = $num === 19 ? '<div class="week-milestone">🎯 Mốc: Quản trị được SQL Server production cơ bản</div>' : '<span class="arrow-icon">→</span>';
      ?>
      <a href="weeks/week-<?= $num ?>.php" class="week-card">
        <div class="week-num">Tuần <?= $num ?></div>
        <div class="week-title"><?= $title ?></div>
        <ul class="week-topics">
          <?php foreach ($topics as $t): ?><li><?= $t ?></li><?php endforeach; ?>
        </ul>
        <?= $milestone ?>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Phase 5 -->
  <section class="phase-section phase-5">
    <div class="phase-label">
      <span class="phase-badge">Giai đoạn 5</span>
      <span class="phase-name">DBA chuyên nghiệp</span>
      <span class="phase-weeks">Tuần 20–22+</span>
    </div>
    <div class="week-grid">
      <a href="weeks/week-20.php" class="week-card">
        <div class="week-num">Tuần 20–21</div>
        <div class="week-title">High Availability</div>
        <ul class="week-topics">
          <li>Always On Availability Groups</li>
          <li>Failover Cluster Instance (FCI)</li>
          <li>Log Shipping</li>
          <li>Database Mirroring (legacy)</li>
          <li>Thực hành lab: setup AG 2 node</li>
        </ul>
        <span class="arrow-icon">→</span>
      </a>
      <a href="weeks/week-21.php" class="week-card">
        <div class="week-num">Tuần 21–22</div>
        <div class="week-title">Hiệu năng nâng cao</div>
        <ul class="week-topics">
          <li>In-Memory OLTP (bảng trong RAM)</li>
          <li>Columnstore Index cho analytics</li>
          <li>Partition Table &amp; Partition Index</li>
          <li>TempDB tối ưu</li>
          <li>Memory configuration</li>
        </ul>
        <span class="arrow-icon">→</span>
      </a>
      <a href="weeks/week-22.php" class="week-card">
        <div class="week-num">Tiếp theo</div>
        <div class="week-title">Azure &amp; Cloud DBA</div>
        <ul class="week-topics">
          <li>Azure SQL Database</li>
          <li>Azure SQL Managed Instance</li>
          <li>Migrate on-premise lên Azure</li>
          <li>Elastic Pool</li>
          <li>Chứng chỉ: DP-300 (Azure DBA)</li>
        </ul>
        <div class="week-milestone">🎯 Mốc: Sẵn sàng ứng tuyển Junior DBA</div>
      </a>
    </div>
  </section>

  <!-- Resources & Certs -->
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;margin-top:48px;">
    <div style="background:var(--color-bg-card);border:1px solid var(--color-border);border-radius:var(--radius);padding:20px 24px;">
      <div style="font-size:15px;font-weight:600;margin-bottom:14px;">📚 Tài nguyên miễn phí</div>
      <ul style="list-style:none;display:flex;flex-direction:column;gap:8px;">
        <li style="font-size:13.5px;color:var(--color-text-muted);">• Microsoft Learn — SQL Server track</li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• AdventureWorks — dataset luyện tập</li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• Brent Ozar — blog DBA chuyên sâu</li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• SQLskills.com — bài viết chuyên gia</li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• YouTube: Kevin Stratvert (SSMS)</li>
      </ul>
    </div>
    <div style="background:var(--color-bg-card);border:1px solid var(--color-border);border-radius:var(--radius);padding:20px 24px;">
      <div style="font-size:15px;font-weight:600;margin-bottom:14px;">🏆 Chứng chỉ nên học</div>
      <ul style="list-style:none;display:flex;flex-direction:column;gap:8px;">
        <li style="font-size:13.5px;color:var(--color-text-muted);">• DP-900 — Azure Data Fundamentals</li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• DP-300 — Azure DBA Associate <span class="tag blue">Mục tiêu</span></li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• 70-764 — SQL Server DBA on-premise</li>
        <li style="font-size:13.5px;color:var(--color-text-muted);">• MCE: Microsoft Certified Expert</li>
      </ul>
    </div>
  </div>

</div>

<?php
$basePath = './';
require __DIR__ . '/includes/footer.php';
?>
