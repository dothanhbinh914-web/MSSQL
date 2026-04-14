<?php
$pageTitle  = 'Tuần 13 – Trigger & Event';
$basePath   = '../';
$phaseColor = 'phase3';
$isWeekPage = true;
$prevWeek   = 12;
$nextWeek   = 14;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase3);">Giai đoạn 3</span><span class="breadcrumb-sep">›</span><span>Tuần 13</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase3-bg);color:var(--phase3);border:1px solid var(--phase3-border);">Giai đoạn 3 · Lập trình T-SQL nâng cao</div>
    <div class="lesson-week-num">Tuần 13 / 22</div>
    <h1 class="lesson-title">Trigger &amp; Event</h1>
    <p class="lesson-desc">Trigger tự động thực thi T-SQL khi có thay đổi dữ liệu — dùng cho audit log, business rules.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="after-trigger">
        <div class="topic-heading"><span class="topic-icon">⚡</span><h2>AFTER Trigger – Ghi audit log</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p>Trigger <code>AFTER</code> chạy <em>sau</em> khi thao tác DML hoàn thành. SQL Server cung cấp 2 bảng ảo: <strong>INSERTED</strong> (dữ liệu mới/sau) và <strong>DELETED</strong> (dữ liệu cũ/trước).</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – AFTER trigger audit</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Bảng audit log</span>
<span class="kw">CREATE TABLE</span> dbo.AuditLog (
    LogID       <span class="type">INT</span>           <span class="kw">IDENTITY</span>(<span class="num">1</span>,<span class="num">1</span>) <span class="kw">PRIMARY KEY</span>,
    TenBang     <span class="type">NVARCHAR</span>(<span class="num">100</span>),
    ThaoTac     <span class="type">VARCHAR</span>(<span class="num">10</span>),   <span class="cmt">-- INSERT / UPDATE / DELETE</span>
    GiaTriCu    <span class="type">NVARCHAR</span>(<span class="num">MAX</span>),
    GiaTriMoi   <span class="type">NVARCHAR</span>(<span class="num">MAX</span>),
    ThoiGian    <span class="type">DATETIME2</span>     <span class="kw">DEFAULT</span> <span class="fn">SYSDATETIME</span>(),
    NguoiThaoTac <span class="type">NVARCHAR</span>(<span class="num">100</span>) <span class="kw">DEFAULT</span> <span class="fn">SYSTEM_USER</span>
);

<span class="cmt">-- Trigger AFTER UPDATE ghi log thay đổi lương</span>
<span class="kw">CREATE OR ALTER TRIGGER</span> trg_NhanVien_AfterUpdate
<span class="kw">ON</span> dbo.NhanVien
<span class="kw">AFTER UPDATE</span>
<span class="kw">AS</span>
<span class="kw">BEGIN</span>
    <span class="kw">SET NOCOUNT ON</span>;

    <span class="cmt">-- Chỉ log khi trường LuongCoBan bị thay đổi</span>
    <span class="kw">IF UPDATE</span>(LuongCoBan)
    <span class="kw">BEGIN</span>
        <span class="kw">INSERT INTO</span> dbo.AuditLog (TenBang, ThaoTac, GiaTriCu, GiaTriMoi)
        <span class="kw">SELECT</span>
            <span class="str">'NhanVien'</span>,
            <span class="str">'UPDATE'</span>,
            <span class="str">'Luong: '</span> <span class="op">+</span> <span class="kw">CAST</span>(d.LuongCoBan <span class="kw">AS</span> <span class="type">VARCHAR</span>),
            <span class="str">'Luong: '</span> <span class="op">+</span> <span class="kw">CAST</span>(i.LuongCoBan <span class="kw">AS</span> <span class="type">VARCHAR</span>)
        <span class="kw">FROM</span> DELETED d
        <span class="kw">INNER JOIN</span> INSERTED i <span class="kw">ON</span> d.MaNV <span class="op">=</span> i.MaNV
        <span class="kw">WHERE</span> d.LuongCoBan <span class="op">&lt;></span> i.LuongCoBan;
    <span class="kw">END</span>
<span class="kw">END</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="instead-of">
        <div class="topic-heading"><span class="topic-icon">🔄</span><h2>INSTEAD OF Trigger</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – INSTEAD OF trigger trên View</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- INSTEAD OF cho phép UPDATE/INSERT/DELETE qua View</span>
<span class="kw">CREATE OR ALTER TRIGGER</span> trg_v_NhanVien_InsteadOfUpdate
<span class="kw">ON</span> dbo.v_BaoCaoNhanVien
<span class="kw">INSTEAD OF UPDATE</span>
<span class="kw">AS</span>
<span class="kw">BEGIN</span>
    <span class="kw">SET NOCOUNT ON</span>;

    <span class="cmt">-- Redirect update về bảng gốc</span>
    <span class="kw">UPDATE</span> nv
    <span class="kw">SET</span> nv.HoTen <span class="op">=</span> i.HoTen
    <span class="kw">FROM</span> dbo.NhanVien nv
    <span class="kw">INNER JOIN</span> INSERTED i <span class="kw">ON</span> nv.MaNV <span class="op">=</span> i.MaNV;
<span class="kw">END</span>;</code></pre>
        </div>
        <div class="callout warning">
          <span class="callout-icon">⚠️</span>
          <div class="callout-body">
            <div class="callout-title">Khi nào KHÔNG nên dùng Trigger?</div>
            <div class="callout-text">Trigger chạy ẩn — khó debug, khó trace hiệu năng. Nếu logic có thể đặt trong SP hoặc application layer, hãy ưu tiên đó. Chỉ dùng trigger cho audit log và business rules bắt buộc phải ở database layer.</div>
          </div>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 13</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">AFTER trigger</div><div class="summary-item-value">Chạy sau DML, ghi audit log</div></div>
            <div class="summary-item"><div class="summary-item-label">INSERTED/DELETED</div><div class="summary-item-value">Bảng ảo chứa dữ liệu mới/cũ</div></div>
            <div class="summary-item"><div class="summary-item-label">INSTEAD OF</div><div class="summary-item-value">Thay thế thao tác, dùng trên View</div></div>
            <div class="summary-item"><div class="summary-item-label">Lưu ý</div><div class="summary-item-value">Dùng hạn chế — khó debug</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 13</div>
        <ul class="toc-list">
          <li><a href="#after-trigger">1. AFTER Trigger</a></li>
          <li><a href="#instead-of">2. INSTEAD OF Trigger</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
