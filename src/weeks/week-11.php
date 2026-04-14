<?php
$pageTitle  = 'Tuần 11 – Function & View';
$basePath   = '../';
$phaseColor = 'phase3';
$isWeekPage = true;
$prevWeek   = 10;
$nextWeek   = 12;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase3);">Giai đoạn 3</span><span class="breadcrumb-sep">›</span><span>Tuần 11</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase3-bg);color:var(--phase3);border:1px solid var(--phase3-border);">Giai đoạn 3 · Lập trình T-SQL nâng cao</div>
    <div class="lesson-week-num">Tuần 11 / 22</div>
    <h1 class="lesson-title">Function &amp; View</h1>
    <p class="lesson-desc">Function đóng gói logic tính toán tái sử dụng. View đơn giản hóa truy vấn phức tạp.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="scalar-function">
        <div class="topic-heading"><span class="topic-icon">🔢</span><h2>Scalar Function</h2><span class="topic-num">01</span></div>
        <div class="prose"><p><strong>Scalar Function</strong> nhận tham số và trả về một giá trị duy nhất — dùng được trong SELECT, WHERE, như hàm tích hợp.</p></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Scalar Function</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Hàm tính tuổi chính xác</span>
<span class="kw">CREATE OR ALTER FUNCTION</span> dbo.fn_TinhTuoi (@NgaySinh <span class="type">DATE</span>)
<span class="kw">RETURNS</span> <span class="type">INT</span>
<span class="kw">AS</span>
<span class="kw">BEGIN</span>
    <span class="kw">RETURN</span> <span class="fn">DATEDIFF</span>(<span class="kw">YEAR</span>, @NgaySinh, <span class="fn">GETDATE</span>())
        <span class="op">-</span> <span class="kw">CASE WHEN</span> <span class="fn">DATEADD</span>(<span class="kw">YEAR</span>, <span class="fn">DATEDIFF</span>(<span class="kw">YEAR</span>, @NgaySinh, <span class="fn">GETDATE</span>()), @NgaySinh) <span class="op">></span> <span class="fn">GETDATE</span>()
              <span class="kw">THEN</span> <span class="num">1</span> <span class="kw">ELSE</span> <span class="num">0</span> <span class="kw">END</span>;
<span class="kw">END</span>;

<span class="cmt">-- Dùng trong SELECT</span>
<span class="kw">SELECT</span> HoTen, NgaySinh, dbo.fn_TinhTuoi(NgaySinh) <span class="kw">AS</span> Tuoi
<span class="kw">FROM</span> dbo.NhanVien;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="tvf">
        <div class="topic-heading"><span class="topic-icon">📋</span><h2>Table-valued Function (TVF)</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Inline TVF + CROSS APPLY</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Inline TVF: trả về một bảng (như view có tham số)</span>
<span class="kw">CREATE OR ALTER FUNCTION</span> dbo.fn_LayNhanVienPhong (@MaPB <span class="type">INT</span>)
<span class="kw">RETURNS TABLE</span>
<span class="kw">AS</span>
<span class="kw">RETURN</span> (
    <span class="kw">SELECT</span> nv.MaNV, nv.HoTen, nv.Email
    <span class="kw">FROM</span> dbo.NhanVien nv
    <span class="kw">WHERE</span> nv.MaPB <span class="op">=</span> @MaPB
);

<span class="cmt">-- Dùng với CROSS APPLY: lấy 3 NV đầu của mỗi phòng</span>
<span class="kw">SELECT</span> pb.TenPB, nv.HoTen
<span class="kw">FROM</span> dbo.PhongBan pb
<span class="kw">CROSS APPLY</span> dbo.fn_LayNhanVienPhong(pb.MaPB) nv;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="view">
        <div class="topic-heading"><span class="topic-icon">👁️</span><h2>View</h2><span class="topic-num">03</span></div>
        <div class="prose"><p><strong>View</strong> là một câu SELECT được đặt tên và lưu trên server. View không lưu dữ liệu (chỉ lưu định nghĩa query) — mỗi lần query view là chạy lại query gốc.</p></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – View</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Tạo View</span>
<span class="kw">CREATE OR ALTER VIEW</span> dbo.v_BaoCaoNhanVien
<span class="kw">AS</span>
    <span class="kw">SELECT</span>
        nv.MaNV,
        nv.HoTen,
        pb.TenPB,
        dbo.fn_TinhTuoi(nv.NgaySinh) <span class="kw">AS</span> Tuoi
    <span class="kw">FROM</span> dbo.NhanVien nv
    <span class="kw">LEFT JOIN</span> dbo.PhongBan pb <span class="kw">ON</span> nv.MaPB <span class="op">=</span> pb.MaPB;

<span class="cmt">-- Dùng View như một bảng thông thường</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> dbo.v_BaoCaoNhanVien <span class="kw">WHERE</span> TenPB <span class="op">=</span> N<span class="str">'Phòng Kỹ thuật'</span>;

<span class="cmt">-- Xóa View</span>
<span class="kw">DROP VIEW IF EXISTS</span> dbo.v_BaoCaoNhanVien;</code></pre>
        </div>
        <table class="compare-table">
          <thead><tr><th>Tiêu chí</th><th>Stored Procedure</th><th>Function</th><th>View</th></tr></thead>
          <tbody>
            <tr><td>Trả về</td><td>Nhiều kết quả</td><td>Scalar hoặc Table</td><td>Bảng ảo</td></tr>
            <tr><td>Dùng trong SELECT</td><td>❌</td><td>✅</td><td>✅</td></tr>
            <tr><td>Tham số</td><td>✅</td><td>✅</td><td>❌</td></tr>
            <tr><td>Có thể INSERT/UPDATE</td><td>✅</td><td>❌</td><td>Hạn chế</td></tr>
            <tr><td>Transaction</td><td>✅</td><td>❌</td><td>❌</td></tr>
          </tbody>
        </table>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 11</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Scalar Function</div><div class="summary-item-value">Trả về 1 giá trị, dùng trong SELECT</div></div>
            <div class="summary-item"><div class="summary-item-label">Inline TVF</div><div class="summary-item-value">Trả về bảng, có tham số</div></div>
            <div class="summary-item"><div class="summary-item-label">CROSS APPLY</div><div class="summary-item-value">Gọi TVF cho mỗi dòng</div></div>
            <div class="summary-item"><div class="summary-item-label">View</div><div class="summary-item-value">Query được đặt tên, không lưu data</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 11</div>
        <ul class="toc-list">
          <li><a href="#scalar-function">1. Scalar Function</a></li>
          <li><a href="#tvf">2. Table-valued Function</a></li>
          <li><a href="#view">3. View</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
