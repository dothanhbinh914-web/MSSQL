<?php
$pageTitle  = 'Tuần 7 – DML & Thao tác dữ liệu';
$basePath   = '../';
$phaseColor = 'phase2';
$isWeekPage = true;
$prevWeek   = 6;
$nextWeek   = 8;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase2);">Giai đoạn 2</span><span class="breadcrumb-sep">›</span><span>Tuần 7</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase2-bg);color:var(--phase2);border:1px solid var(--phase2-border);">Giai đoạn 2 · T-SQL từ cơ bản đến thành thạo</div>
    <div class="lesson-week-num">Tuần 7 / 22</div>
    <h1 class="lesson-title">DML – INSERT, UPDATE, DELETE, MERGE</h1>
    <p class="lesson-desc">Thao tác ghi dữ liệu: thêm, sửa, xóa và upsert (MERGE) với các kỹ thuật an toàn.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="insert">
        <div class="topic-heading"><span class="topic-icon">➕</span><h2>INSERT</h2><span class="topic-num">01</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – INSERT các kiểu</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- INSERT một dòng</span>
<span class="kw">INSERT INTO</span> dbo.NhanVien (HoTen, Email, NgaySinh)
<span class="kw">VALUES</span> (N<span class="str">'Nguyễn Văn An'</span>, <span class="str">'an@company.com'</span>, <span class="str">'1990-05-15'</span>);

<span class="cmt">-- INSERT nhiều dòng cùng lúc (SQL Server 2008+)</span>
<span class="kw">INSERT INTO</span> dbo.PhongBan (TenPB)
<span class="kw">VALUES</span>
    (N<span class="str">'Phòng Kỹ thuật'</span>),
    (N<span class="str">'Phòng Kinh doanh'</span>),
    (N<span class="str">'Phòng Nhân sự'</span>);

<span class="cmt">-- INSERT ... SELECT: copy dữ liệu từ bảng khác</span>
<span class="kw">INSERT INTO</span> dbo.NhanVienBackup (HoTen, Email)
<span class="kw">SELECT</span> HoTen, Email
<span class="kw">FROM</span> dbo.NhanVien
<span class="kw">WHERE</span> TrangThai <span class="op">=</span> <span class="num">0</span>;  <span class="cmt">-- backup nhân viên đã nghỉ</span>

<span class="cmt">-- SELECT INTO: tạo bảng mới từ kết quả SELECT</span>
<span class="kw">SELECT</span> p.ProductID, p.Name, p.ListPrice
<span class="kw">INTO</span> dbo.SanPhamGiaCao
<span class="kw">FROM</span> Production.Product p
<span class="kw">WHERE</span> p.ListPrice <span class="op">></span> <span class="num">1000</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="update">
        <div class="topic-heading"><span class="topic-icon">✏️</span><h2>UPDATE</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – UPDATE an toàn</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Luôn có WHERE khi UPDATE — không có WHERE sẽ update TẤT CẢ dòng!</span>
<span class="kw">UPDATE</span> dbo.NhanVien
<span class="kw">SET</span>
    HoTen     <span class="op">=</span> N<span class="str">'Nguyễn Văn Bình'</span>,
    NgayCapNhat <span class="op">=</span> <span class="fn">SYSDATETIME</span>()
<span class="kw">WHERE</span> MaNV <span class="op">=</span> <span class="num">42</span>;

<span class="cmt">-- UPDATE dùng JOIN (cập nhật từ bảng khác)</span>
<span class="kw">UPDATE</span> nv
<span class="kw">SET</span> nv.TenPhong <span class="op">=</span> pb.TenPB
<span class="kw">FROM</span> dbo.NhanVien nv
<span class="kw">INNER JOIN</span> dbo.PhongBan pb <span class="kw">ON</span> nv.MaPB <span class="op">=</span> pb.MaPB;

<span class="cmt">-- Tăng giá sản phẩm danh mục Bikes lên 10%</span>
<span class="kw">UPDATE</span> p
<span class="kw">SET</span> p.ListPrice <span class="op">=</span> p.ListPrice <span class="op">*</span> <span class="num">1.10</span>
<span class="kw">FROM</span> Production.Product p
<span class="kw">INNER JOIN</span> Production.ProductSubcategory ps <span class="kw">ON</span> p.ProductSubcategoryID <span class="op">=</span> ps.ProductSubcategoryID
<span class="kw">INNER JOIN</span> Production.ProductCategory pc   <span class="kw">ON</span> ps.ProductCategoryID   <span class="op">=</span> pc.ProductCategoryID
<span class="kw">WHERE</span> pc.Name <span class="op">=</span> <span class="str">'Bikes'</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="delete-truncate">
        <div class="topic-heading"><span class="topic-icon">🗑️</span><h2>DELETE &amp; TRUNCATE</h2><span class="topic-num">03</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – DELETE vs TRUNCATE</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- DELETE: xóa có điều kiện, ghi vào transaction log</span>
<span class="kw">DELETE FROM</span> dbo.NhanVien
<span class="kw">WHERE</span> TrangThai <span class="op">=</span> <span class="num">0</span> <span class="kw">AND</span> NgayNghi <span class="op">&lt;</span> <span class="str">'2020-01-01'</span>;

<span class="cmt">-- DELETE dùng JOIN</span>
<span class="kw">DELETE</span> sod
<span class="kw">FROM</span> Sales.SalesOrderDetail sod
<span class="kw">INNER JOIN</span> Sales.SalesOrderHeader soh <span class="kw">ON</span> sod.SalesOrderID <span class="op">=</span> soh.SalesOrderID
<span class="kw">WHERE</span> soh.Status <span class="op">=</span> <span class="num">6</span>;  <span class="cmt">-- xóa chi tiết đơn hàng đã hủy</span>

<span class="cmt">-- TRUNCATE: xóa toàn bộ, nhanh hơn, không ghi log từng dòng</span>
<span class="kw">TRUNCATE TABLE</span> dbo.TempData;</code></pre>
        </div>
        <table class="compare-table">
          <thead><tr><th>Thuộc tính</th><th>DELETE</th><th>TRUNCATE</th></tr></thead>
          <tbody>
            <tr><td>Điều kiện WHERE</td><td>✅ Có thể</td><td>❌ Không</td></tr>
            <tr><td>Ghi transaction log</td><td>Mỗi dòng</td><td>Chỉ deallocate page</td></tr>
            <tr><td>Tốc độ</td><td>Chậm hơn</td><td>Nhanh hơn nhiều</td></tr>
            <tr><td>IDENTITY reset</td><td>Không</td><td>Có (về seed ban đầu)</td></tr>
            <tr><td>Trigger kích hoạt</td><td>✅ Có</td><td>❌ Không</td></tr>
            <tr><td>Có thể ROLLBACK</td><td>✅ Có</td><td>✅ Có (trong transaction)</td></tr>
          </tbody>
        </table>
      </section>

      <section class="topic-section" id="merge-output">
        <div class="topic-heading"><span class="topic-icon">🔀</span><h2>MERGE &amp; OUTPUT</h2><span class="topic-num">04</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – MERGE (upsert)</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- MERGE: UPDATE nếu tồn tại, INSERT nếu chưa có</span>
<span class="kw">MERGE</span> dbo.SanPham <span class="kw">AS</span> target
<span class="kw">USING</span> dbo.SanPhamMoi <span class="kw">AS</span> source
    <span class="kw">ON</span> target.MaSKU <span class="op">=</span> source.MaSKU

<span class="kw">WHEN MATCHED THEN</span>
    <span class="kw">UPDATE SET</span>
        target.TenSP   <span class="op">=</span> source.TenSP,
        target.GiaBan  <span class="op">=</span> source.GiaBan,
        target.NgayCapNhat <span class="op">=</span> <span class="fn">SYSDATETIME</span>()

<span class="kw">WHEN NOT MATCHED BY TARGET THEN</span>
    <span class="kw">INSERT</span> (MaSKU, TenSP, GiaBan)
    <span class="kw">VALUES</span> (source.MaSKU, source.TenSP, source.GiaBan)

<span class="kw">WHEN NOT MATCHED BY SOURCE THEN</span>
    <span class="kw">DELETE</span>

<span class="kw">OUTPUT</span>  <span class="cmt">-- OUTPUT: xem những gì đã thay đổi</span>
    $action <span class="kw">AS</span> ThaoTac,
    DELETED.MaSKU <span class="kw">AS</span> SKU_Cu,
    INSERTED.MaSKU <span class="kw">AS</span> SKU_Moi;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 7</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">INSERT</div><div class="summary-item-value">1 dòng · nhiều dòng · từ SELECT</div></div>
            <div class="summary-item"><div class="summary-item-label">UPDATE</div><div class="summary-item-value">Luôn dùng WHERE hoặc JOIN</div></div>
            <div class="summary-item"><div class="summary-item-label">DELETE vs TRUNCATE</div><div class="summary-item-value">Có điều kiện vs toàn bộ nhanh</div></div>
            <div class="summary-item"><div class="summary-item-label">MERGE</div><div class="summary-item-value">Upsert: UPDATE hoặc INSERT</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 7</div>
        <ul class="toc-list">
          <li><a href="#insert">1. INSERT</a></li>
          <li><a href="#update">2. UPDATE</a></li>
          <li><a href="#delete-truncate">3. DELETE &amp; TRUNCATE</a></li>
          <li><a href="#merge-output">4. MERGE &amp; OUTPUT</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
