<?php
$pageTitle  = 'Tuần 12 – Transaction & Lock';
$basePath   = '../';
$phaseColor = 'phase3';
$isWeekPage = true;
$prevWeek   = 11;
$nextWeek   = 13;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase3);">Giai đoạn 3</span><span class="breadcrumb-sep">›</span><span>Tuần 12</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase3-bg);color:var(--phase3);border:1px solid var(--phase3-border);">Giai đoạn 3 · Lập trình T-SQL nâng cao</div>
    <div class="lesson-week-num">Tuần 12 / 22</div>
    <h1 class="lesson-title">Transaction &amp; Isolation Level</h1>
    <p class="lesson-desc">Transaction đảm bảo tính toàn vẹn dữ liệu. Isolation Level kiểm soát cách các transaction tương tác với nhau.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="transaction">
        <div class="topic-heading"><span class="topic-icon">🔒</span><h2>BEGIN TRAN, COMMIT, ROLLBACK</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p>Transaction đảm bảo tính <strong>ACID</strong>: Atomicity (tất cả hoặc không gì), Consistency, Isolation, Durability.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Transaction</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Chuyển tiền: trừ tài khoản A, cộng tài khoản B</span>
<span class="kw">BEGIN TRANSACTION</span>;

<span class="kw">BEGIN TRY</span>
    <span class="cmt">-- Trừ tiền từ tài khoản nguồn</span>
    <span class="kw">UPDATE</span> dbo.TaiKhoan
    <span class="kw">SET</span> SoDu <span class="op">=</span> SoDu <span class="op">-</span> <span class="num">1000000</span>
    <span class="kw">WHERE</span> MaTK <span class="op">=</span> <span class="str">'TK001'</span>;

    <span class="cmt">-- Kiểm tra số dư không âm</span>
    <span class="kw">IF</span> (<span class="kw">SELECT</span> SoDu <span class="kw">FROM</span> dbo.TaiKhoan <span class="kw">WHERE</span> MaTK <span class="op">=</span> <span class="str">'TK001'</span>) <span class="op">&lt;</span> <span class="num">0</span>
        <span class="kw">THROW</span> <span class="num">50002</span>, <span class="str">N'Số dư không đủ'</span>, <span class="num">1</span>;

    <span class="cmt">-- Cộng tiền vào tài khoản đích</span>
    <span class="kw">UPDATE</span> dbo.TaiKhoan
    <span class="kw">SET</span> SoDu <span class="op">=</span> SoDu <span class="op">+</span> <span class="num">1000000</span>
    <span class="kw">WHERE</span> MaTK <span class="op">=</span> <span class="str">'TK002'</span>;

    <span class="kw">COMMIT TRANSACTION</span>;
    <span class="kw">SELECT</span> <span class="str">'Chuyển tiền thành công'</span> <span class="kw">AS</span> KetQua;

<span class="kw">END TRY</span>
<span class="kw">BEGIN CATCH</span>
    <span class="kw">ROLLBACK TRANSACTION</span>;
    <span class="kw">SELECT</span> ERROR_MESSAGE() <span class="kw">AS</span> LoiXayRa;
<span class="kw">END CATCH</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="savepoint">
        <div class="topic-heading"><span class="topic-icon">📌</span><h2>SAVEPOINT</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – SAVEPOINT</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">BEGIN TRANSACTION</span>;

<span class="kw">INSERT INTO</span> dbo.LogHoatDong (MoTa) <span class="kw">VALUES</span> (<span class="str">'Bắt đầu xử lý'</span>);

<span class="kw">SAVE TRANSACTION</span> DiemLuu1;  <span class="cmt">-- đặt điểm lưu</span>

<span class="kw">UPDATE</span> dbo.NhanVien <span class="kw">SET</span> TrangThai <span class="op">=</span> <span class="num">2</span> <span class="kw">WHERE</span> MaNV <span class="op">=</span> <span class="num">99</span>;

<span class="cmt">-- Nếu muốn hủy chỉ UPDATE (không hủy INSERT)</span>
<span class="kw">ROLLBACK TRANSACTION</span> DiemLuu1;  <span class="cmt">-- chỉ rollback về điểm lưu</span>

<span class="kw">COMMIT TRANSACTION</span>;  <span class="cmt">-- commit INSERT, hủy UPDATE</span></code></pre>
        </div>
      </section>

      <section class="topic-section" id="isolation">
        <div class="topic-heading"><span class="topic-icon">🎚️</span><h2>Isolation Level</h2><span class="topic-num">03</span></div>
        <table class="compare-table">
          <thead><tr><th>Level</th><th>Dirty Read</th><th>Non-repeatable Read</th><th>Phantom Read</th><th>Mô tả</th></tr></thead>
          <tbody>
            <tr><td><code>READ UNCOMMITTED</code></td><td>✅ Có</td><td>✅ Có</td><td>✅ Có</td><td>Đọc cả dữ liệu chưa commit — nguy hiểm</td></tr>
            <tr><td><code>READ COMMITTED</code></td><td>❌</td><td>✅ Có</td><td>✅ Có</td><td>Mặc định của SQL Server</td></tr>
            <tr><td><code>REPEATABLE READ</code></td><td>❌</td><td>❌</td><td>✅ Có</td><td>Dữ liệu đã đọc không thay đổi</td></tr>
            <tr><td><code>SERIALIZABLE</code></td><td>❌</td><td>❌</td><td>❌</td><td>Cô lập hoàn toàn, hiệu năng thấp nhất</td></tr>
            <tr><td><code>SNAPSHOT</code></td><td>❌</td><td>❌</td><td>❌</td><td>Dùng versioning, không block đọc</td></tr>
          </tbody>
        </table>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Set Isolation Level</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Đặt isolation level cho session hiện tại</span>
<span class="kw">SET TRANSACTION ISOLATION LEVEL</span> READ COMMITTED;   <span class="cmt">-- mặc định</span>
<span class="kw">SET TRANSACTION ISOLATION LEVEL</span> READ UNCOMMITTED; <span class="cmt">-- nhanh nhất, ít an toàn nhất</span>

<span class="cmt">-- Hoặc dùng table hint cho từng query</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> dbo.NhanVien <span class="kw">WITH</span> (NOLOCK);   <span class="cmt">-- tương đương READ UNCOMMITTED</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> dbo.NhanVien <span class="kw">WITH</span> (UPDLOCK); <span class="cmt">-- lock trước khi update</span></code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 12</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">ACID</div><div class="summary-item-value">Atomicity · Consistency · Isolation · Durability</div></div>
            <div class="summary-item"><div class="summary-item-label">Transaction</div><div class="summary-item-value">BEGIN · COMMIT · ROLLBACK</div></div>
            <div class="summary-item"><div class="summary-item-label">Điểm lưu</div><div class="summary-item-value">SAVE TRANSACTION + ROLLBACK TO</div></div>
            <div class="summary-item"><div class="summary-item-label">Isolation</div><div class="summary-item-value">4 mức + SNAPSHOT</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 12</div>
        <ul class="toc-list">
          <li><a href="#transaction">1. BEGIN TRAN · COMMIT · ROLLBACK</a></li>
          <li><a href="#savepoint">2. SAVEPOINT</a></li>
          <li><a href="#isolation">3. Isolation Level</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
