<?php
$pageTitle  = 'Tuần 3 – Ràng buộc & Quan hệ';
$basePath   = '../';
$phaseColor = 'phase1';
$isWeekPage = true;
$prevWeek   = 2;
$nextWeek   = 4;
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
  <nav class="breadcrumb">
    <a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span>
    <span style="color:var(--phase1);">Giai đoạn 1</span><span class="breadcrumb-sep">›</span>
    <span>Tuần 3</span>
  </nav>

  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase1-bg);color:var(--phase1);border:1px solid var(--phase1-border);">Giai đoạn 1 · Nền tảng &amp; môi trường</div>
    <div class="lesson-week-num">Tuần 3 / 22</div>
    <h1 class="lesson-title">Ràng buộc &amp; Quan hệ giữa các bảng</h1>
    <p class="lesson-desc">Thiết kế database đúng chuẩn với các ràng buộc toàn vẹn dữ liệu và mối quan hệ giữa các bảng.</p>
  </div>

  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="primary-foreign-key">
        <div class="topic-heading"><span class="topic-icon">🔑</span><h2>Primary Key &amp; Foreign Key</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p><strong>Primary Key (PK)</strong> là cột (hoặc tổ hợp cột) xác định duy nhất mỗi dòng trong bảng. Mọi bảng đều nên có Primary Key.</p>
          <p><strong>Foreign Key (FK)</strong> là cột tham chiếu đến Primary Key của bảng khác, tạo ra mối quan hệ giữa hai bảng và đảm bảo tính toàn vẹn tham chiếu.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Bảng cha: PhongBan</span>
<span class="kw">CREATE TABLE</span> dbo.PhongBan (
    MaPB    <span class="type">INT</span>           <span class="kw">IDENTITY</span>(<span class="num">1</span>,<span class="num">1</span>) <span class="kw">PRIMARY KEY</span>,
    TenPB   <span class="type">NVARCHAR</span>(<span class="num">100</span>) <span class="kw">NOT NULL</span>,
    MaTruongPhong <span class="type">INT</span>   <span class="kw">NULL</span>
);

<span class="cmt">-- Bảng con: NhanVien có FK trỏ đến PhongBan</span>
<span class="kw">CREATE TABLE</span> dbo.NhanVien (
    MaNV    <span class="type">INT</span>           <span class="kw">IDENTITY</span>(<span class="num">1</span>,<span class="num">1</span>) <span class="kw">PRIMARY KEY</span>,
    HoTen   <span class="type">NVARCHAR</span>(<span class="num">100</span>) <span class="kw">NOT NULL</span>,
    MaPB    <span class="type">INT</span>           <span class="kw">NULL</span>,

    <span class="kw">CONSTRAINT</span> FK_NhanVien_PhongBan
        <span class="kw">FOREIGN KEY</span> (MaPB) <span class="kw">REFERENCES</span> dbo.PhongBan(MaPB)
        <span class="kw">ON DELETE SET NULL</span>   <span class="cmt">-- khi xóa phòng ban thì set NULL</span>
        <span class="kw">ON UPDATE CASCADE</span>    <span class="cmt">-- khi đổi MaPB thì tự cập nhật</span>
);

<span class="cmt">-- ON DELETE / ON UPDATE options:
-- NO ACTION   : báo lỗi nếu vi phạm (mặc định)
-- CASCADE     : tự động xóa/cập nhật các dòng liên quan
-- SET NULL    : đặt cột FK = NULL
-- SET DEFAULT : đặt cột FK = giá trị DEFAULT</span></code></pre>
        </div>
      </section>

      <section class="topic-section" id="unique-check-default">
        <div class="topic-heading"><span class="topic-icon">✅</span><h2>UNIQUE, CHECK, DEFAULT</h2><span class="topic-num">02</span></div>
        <div class="prose">
          <p>Ngoài PK và FK, SQL Server còn có 3 loại ràng buộc khác giúp đảm bảo chất lượng dữ liệu:</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE TABLE</span> dbo.SanPham (
    MaSP      <span class="type">INT</span>             <span class="kw">PRIMARY KEY</span>,
    MaSKU     <span class="type">VARCHAR</span>(<span class="num">20</span>)    <span class="kw">NOT NULL</span>,
    TenSP     <span class="type">NVARCHAR</span>(<span class="num">200</span>)  <span class="kw">NOT NULL</span>,
    Gia       <span class="type">DECIMAL</span>(<span class="num">18</span>,<span class="num">2</span>) <span class="kw">NOT NULL</span>,
    SoLuong   <span class="type">INT</span>             <span class="kw">NOT NULL</span>,
    PhanLoai  <span class="type">VARCHAR</span>(<span class="num">20</span>)    <span class="kw">NOT NULL</span>,

    <span class="cmt">-- UNIQUE: mỗi giá trị chỉ xuất hiện 1 lần</span>
    <span class="kw">CONSTRAINT</span> UQ_SanPham_SKU  <span class="kw">UNIQUE</span> (MaSKU),

    <span class="cmt">-- CHECK: giá phải > 0 và < 1 tỷ</span>
    <span class="kw">CONSTRAINT</span> CK_SanPham_Gia  <span class="kw">CHECK</span> (Gia <span class="op">></span> <span class="num">0</span> <span class="kw">AND</span> Gia <span class="op">&lt;</span> <span class="num">1000000000</span>),

    <span class="cmt">-- CHECK: số lượng không được âm</span>
    <span class="kw">CONSTRAINT</span> CK_SanPham_SoLuong <span class="kw">CHECK</span> (SoLuong <span class="op">>=</span> <span class="num">0</span>),

    <span class="cmt">-- CHECK: chỉ chấp nhận các giá trị trong danh sách</span>
    <span class="kw">CONSTRAINT</span> CK_SanPham_PhanLoai
        <span class="kw">CHECK</span> (PhanLoai <span class="kw">IN</span> (<span class="str">'ĐiệnTử'</span>, <span class="str">'ThựcPhẩm'</span>, <span class="str">'MayMặc'</span>))
);

<span class="cmt">-- DEFAULT: giá trị mặc định khi INSERT không chỉ định</span>
<span class="kw">ALTER TABLE</span> dbo.SanPham
    <span class="kw">ADD</span> NgayTao <span class="type">DATETIME2</span> <span class="kw">NOT NULL</span> <span class="kw">DEFAULT</span> <span class="fn">SYSDATETIME</span>();</code></pre>
        </div>
        <div class="callout tip">
          <span class="callout-icon">✅</span>
          <div class="callout-body">
            <div class="callout-title">Đặt tên constraint có ý nghĩa</div>
            <div class="callout-text">Luôn đặt tên explicit cho constraint: <code>PK_TenBang</code>, <code>FK_Bang1_Bang2</code>, <code>UQ_Bang_Cot</code>, <code>CK_Bang_Cot</code>. Khi có lỗi vi phạm, SQL Server sẽ báo đúng tên constraint, dễ debug hơn.</div>
          </div>
        </div>
      </section>

      <section class="topic-section" id="quan-he">
        <div class="topic-heading"><span class="topic-icon">🔗</span><h2>Quan hệ 1-1, 1-nhiều, nhiều-nhiều</h2><span class="topic-num">03</span></div>
        <div class="prose">
          <h3>1. Quan hệ một-nhiều (1:N) — phổ biến nhất</h3>
          <p>Một phòng ban có <em>nhiều</em> nhân viên. Một nhân viên chỉ thuộc <em>một</em> phòng ban.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">SƠ ĐỒ – 1:N</span><button class="copy-btn">Copy</button></div>
          <pre><code>PhongBan: MaPB(PK) | TenPB
NhanVien: MaNV(PK) | HoTen | MaPB(FK → PhongBan.MaPB)</code></pre>
        </div>
        <div class="prose">
          <h3>2. Quan hệ nhiều-nhiều (N:N) — cần bảng trung gian</h3>
          <p>Một nhân viên có thể tham gia <em>nhiều</em> dự án. Một dự án có <em>nhiều</em> nhân viên. Cần bảng trung gian.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – N:N với bảng trung gian</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE TABLE</span> dbo.DuAn (
    MaDA    <span class="type">INT</span>           <span class="kw">PRIMARY KEY</span>,
    TenDA   <span class="type">NVARCHAR</span>(<span class="num">200</span>) <span class="kw">NOT NULL</span>
);

<span class="cmt">-- Bảng trung gian: NhanVien_DuAn</span>
<span class="kw">CREATE TABLE</span> dbo.NhanVien_DuAn (
    MaNV    <span class="type">INT</span>          <span class="kw">NOT NULL</span>,
    MaDA    <span class="type">INT</span>          <span class="kw">NOT NULL</span>,
    VaiTro  <span class="type">NVARCHAR</span>(<span class="num">50</span>),
    NgayThamGia <span class="type">DATE</span>,

    <span class="kw">CONSTRAINT</span> PK_NhanVien_DuAn <span class="kw">PRIMARY KEY</span> (MaNV, MaDA),
    <span class="kw">CONSTRAINT</span> FK_NVDA_NV <span class="kw">FOREIGN KEY</span> (MaNV) <span class="kw">REFERENCES</span> dbo.NhanVien(MaNV),
    <span class="kw">CONSTRAINT</span> FK_NVDA_DA <span class="kw">FOREIGN KEY</span> (MaDA) <span class="kw">REFERENCES</span> dbo.DuAn(MaDA)
);

<span class="cmt">-- Truy vấn: Nhân viên nào tham gia dự án nào?</span>
<span class="kw">SELECT</span> nv.HoTen, da.TenDA, nvda.VaiTro
<span class="kw">FROM</span> dbo.NhanVien nv
<span class="kw">INNER JOIN</span> dbo.NhanVien_DuAn nvda <span class="kw">ON</span> nv.MaNV <span class="op">=</span> nvda.MaNV
<span class="kw">INNER JOIN</span> dbo.DuAn da           <span class="kw">ON</span> nvda.MaDA <span class="op">=</span> da.MaDA;</code></pre>
        </div>
        <div class="prose">
          <h3>3. Quan hệ một-một (1:1) — ít gặp</h3>
          <p>Mỗi nhân viên có đúng một thẻ nhân viên. Thường dùng để tách thông tin nhạy cảm (lương, CMND) sang bảng riêng.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – 1:1</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE TABLE</span> dbo.ThongTinLuong (
    MaNV        <span class="type">INT</span>             <span class="kw">PRIMARY KEY</span>,  <span class="cmt">-- PK đồng thời là FK</span>
    LuongCoBan  <span class="type">DECIMAL</span>(<span class="num">18</span>,<span class="num">2</span>),
    PhuCap      <span class="type">DECIMAL</span>(<span class="num">18</span>,<span class="num">2</span>),
    TaiKhoanNH  <span class="type">VARCHAR</span>(<span class="num">20</span>),

    <span class="kw">CONSTRAINT</span> FK_ThongTinLuong_NhanVien
        <span class="kw">FOREIGN KEY</span> (MaNV) <span class="kw">REFERENCES</span> dbo.NhanVien(MaNV)
);</code></pre>
        </div>
      </section>

      <section class="topic-section" id="adventureworks">
        <div class="topic-heading"><span class="topic-icon">📦</span><h2>Import dữ liệu mẫu AdventureWorks</h2><span class="topic-num">04</span></div>
        <div class="prose">
          <p><strong>AdventureWorks</strong> là database mẫu của Microsoft mô phỏng công ty bán xe đạp — được dùng rộng rãi để luyện tập SQL. Có khoảng 70+ bảng với dữ liệu thực tế.</p>
          <h3>Các bước import AdventureWorks</h3>
          <ol>
            <li>Tải file <code>AdventureWorks2022.bak</code> từ GitHub của Microsoft</li>
            <li>Copy file vào thư mục backup của SQL Server</li>
            <li>Trong SSMS: chuột phải <strong>Databases</strong> → <strong>Restore Database</strong></li>
            <li>Chọn <strong>Device</strong> → chọn file <code>.bak</code> → OK</li>
          </ol>
          <h3>Hoặc dùng T-SQL:</h3>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Restore AdventureWorks</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">RESTORE DATABASE</span> AdventureWorks2022
<span class="kw">FROM DISK</span> <span class="op">=</span> <span class="str">N'C:\Backup\AdventureWorks2022.bak'</span>
<span class="kw">WITH</span>
    <span class="kw">MOVE</span> <span class="str">N'AdventureWorks2022'</span>     <span class="kw">TO</span> <span class="str">N'C:\SQL\AdventureWorks2022.mdf'</span>,
    <span class="kw">MOVE</span> <span class="str">N'AdventureWorks2022_log'</span> <span class="kw">TO</span> <span class="str">N'C:\SQL\AdventureWorks2022_log.ldf'</span>,
    <span class="kw">REPLACE</span>;

<span class="cmt">-- Khám phá database sau khi restore</span>
<span class="kw">USE</span> AdventureWorks2022;

<span class="kw">SELECT</span> TABLE_SCHEMA, TABLE_NAME
<span class="kw">FROM</span> INFORMATION_SCHEMA.TABLES
<span class="kw">WHERE</span> TABLE_TYPE <span class="op">=</span> <span class="str">'BASE TABLE'</span>
<span class="kw">ORDER BY</span> TABLE_SCHEMA, TABLE_NAME;

<span class="kw">SELECT TOP</span> <span class="num">10</span> <span class="op">*</span> <span class="kw">FROM</span> Person.Person;
<span class="kw">SELECT TOP</span> <span class="num">10</span> <span class="op">*</span> <span class="kw">FROM</span> Sales.SalesOrderHeader;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Mốc Giai đoạn 1 hoàn thành!</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Thành tựu</div><div class="summary-item-value">Tạo được CSDL quản lý nhân viên</div></div>
            <div class="summary-item"><div class="summary-item-label">Kỹ năng</div><div class="summary-item-value">PK, FK, Constraints</div></div>
            <div class="summary-item"><div class="summary-item-label">Chuẩn bị</div><div class="summary-item-value">AdventureWorks để luyện T-SQL</div></div>
          </div>
        </div>
      </section>

    </div><!-- /lesson-content -->

    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 3</div>
        <ul class="toc-list">
          <li><a href="#primary-foreign-key">1. Primary Key &amp; Foreign Key</a></li>
          <li><a href="#unique-check-default">2. UNIQUE, CHECK, DEFAULT</a></li>
          <li><a href="#quan-he">3. Quan hệ 1-1, 1-N, N-N</a></li>
          <li><a href="#adventureworks">4. Import AdventureWorks</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
