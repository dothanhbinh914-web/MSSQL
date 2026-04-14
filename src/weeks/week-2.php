<?php
$pageTitle  = 'Tuần 2 – Kiến trúc & Dữ liệu';
$basePath   = '../';
$phaseColor = 'phase1';
$isWeekPage = true;
$prevWeek   = 1;
$nextWeek   = 3;
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
  <nav class="breadcrumb">
    <a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span>
    <span style="color:var(--phase1);">Giai đoạn 1</span><span class="breadcrumb-sep">›</span>
    <span>Tuần 2</span>
  </nav>

  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase1-bg);color:var(--phase1);border:1px solid var(--phase1-border);">Giai đoạn 1 · Nền tảng &amp; môi trường</div>
    <div class="lesson-week-num">Tuần 2 / 22</div>
    <h1 class="lesson-title">Kiến trúc SQL Server &amp; Kiểu dữ liệu</h1>
    <p class="lesson-desc">Hiểu cấu trúc bên trong SQL Server: instance, database, schema, các file vật lý và hệ thống kiểu dữ liệu.</p>
  </div>

  <div class="lesson-layout">
    <div class="lesson-content">

      <!-- Topic 1 -->
      <section class="topic-section" id="instance-db-schema">
        <div class="topic-heading"><span class="topic-icon">🏗️</span><h2>Instance, Database, Schema</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p>SQL Server tổ chức dữ liệu theo 3 cấp độ phân cấp: <strong>Instance → Database → Schema → Object</strong>. Hiểu rõ phân cấp này là nền tảng của mọi thao tác DBA.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">PHÂN CẤP</span><button class="copy-btn">Copy</button></div>
          <pre><code>SQL Server Instance  (tiến trình sqlservr.exe đang chạy trên máy)
├── Database: master
├── Database: QuanLyNhanVien   ← do bạn tạo
│   ├── Schema: dbo            ← schema mặc định
│   │   ├── Table: NhanVien
│   │   ├── Table: PhongBan
│   │   └── View: v_BaoCaoLuong
│   ├── Schema: HR
│   │   └── Table: ChamCong
│   └── Schema: Finance
│       └── Table: BangLuong
└── Database: Sales</code></pre>
        </div>
        <div class="prose">
          <h3>Instance là gì?</h3>
          <p>Một <strong>Instance</strong> là một tiến trình SQL Server đang chạy trên máy chủ. Một máy có thể chạy <em>nhiều instance</em> cùng lúc.</p>
          <ul>
            <li><strong>Default Instance</strong>: kết nối bằng tên máy hoặc <code>localhost</code></li>
            <li><strong>Named Instance</strong>: kết nối bằng <code>TenMay\TenInstance</code>, ví dụ <code>SERVER1\SQLEXPRESS</code></li>
          </ul>
          <h3>Database là gì?</h3>
          <p>Một <strong>Database</strong> là tập hợp các đối tượng dữ liệu (tables, views, stored procedures...) được nhóm lại có chủ đích. Mỗi database hoạt động độc lập — backup, restore, security đều được quản lý riêng.</p>
          <h3>Schema là gì?</h3>
          <p>Một <strong>Schema</strong> là namespace dùng để nhóm các đối tượng trong database. Giúp tổ chức code và phân quyền theo nhóm chức năng.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Tạo schema mới</span>
<span class="kw">CREATE SCHEMA</span> HR;
<span class="kw">CREATE SCHEMA</span> Finance;

<span class="cmt">-- Tạo table trong schema cụ thể</span>
<span class="kw">CREATE TABLE</span> HR.ChamCong (
    MaChamCong <span class="type">INT</span>  <span class="kw">PRIMARY KEY</span>,
    MaNV       <span class="type">INT</span>,
    NgayCham   <span class="type">DATE</span>
);

<span class="cmt">-- Truy vấn bảng với schema prefix</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> HR.ChamCong;
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> dbo.NhanVien;  <span class="cmt">-- dbo là schema mặc định</span>

<span class="cmt">-- Xem tất cả schema trong database hiện tại</span>
<span class="kw">SELECT</span> name, schema_id <span class="kw">FROM</span> sys.schemas;</code></pre>
        </div>
      </section>

      <!-- Topic 2 -->
      <section class="topic-section" id="files-mdf-ldf">
        <div class="topic-heading"><span class="topic-icon">📁</span><h2>File .mdf, .ndf, .ldf là gì</h2><span class="topic-num">02</span></div>
        <div class="prose">
          <p>Mỗi database SQL Server được lưu thành <strong>file vật lý</strong> trên ổ đĩa. Có 3 loại file:</p>
        </div>
        <table class="compare-table">
          <thead><tr><th>Loại file</th><th>Phần mở rộng</th><th>Mô tả</th><th>Số lượng</th></tr></thead>
          <tbody>
            <tr><td><strong>Primary Data File</strong></td><td><code>.mdf</code></td><td>File dữ liệu chính — chứa data, metadata, con trỏ đến các file khác</td><td>1 file duy nhất / DB</td></tr>
            <tr><td><strong>Secondary Data File</strong></td><td><code>.ndf</code></td><td>File dữ liệu phụ — dùng khi DB lớn, phân tán trên nhiều ổ đĩa</td><td>0 hoặc nhiều file</td></tr>
            <tr><td><strong>Transaction Log File</strong></td><td><code>.ldf</code></td><td>File log giao dịch — ghi lại mọi thay đổi, dùng cho backup &amp; recovery</td><td>1 hoặc nhiều file</td></tr>
          </tbody>
        </table>
        <div class="prose">
          <h3>Tại sao file .ldf quan trọng?</h3>
          <p>File <code>.ldf</code> (Transaction Log) ghi lại <em>mọi thao tác</em> thay đổi dữ liệu (INSERT, UPDATE, DELETE) theo thứ tự thời gian. Nhờ file này, SQL Server có thể:</p>
          <ul>
            <li>Rollback (hủy) một transaction bị lỗi</li>
            <li>Khôi phục database về một thời điểm bất kỳ (Point-in-time Restore)</li>
            <li>Đồng bộ dữ liệu sang server standby (Always On, Log Shipping)</li>
          </ul>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Xem file vật lý của database</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Xem thông tin file của database đang dùng</span>
<span class="kw">USE</span> QuanLyNhanVien;

<span class="kw">SELECT</span>
    name          <span class="kw">AS</span> TenLogic,
    physical_name <span class="kw">AS</span> DuongDanVatLy,
    type_desc     <span class="kw">AS</span> LoaiFile,
    size <span class="op">*</span> <span class="num">8</span> / <span class="num">1024</span>  <span class="kw">AS</span> KichThuocMB
<span class="kw">FROM</span> sys.database_files;</code></pre>
        </div>
        <div class="callout info">
          <span class="callout-icon">💡</span>
          <div class="callout-body">
            <div class="callout-title">File .ldf tự động tăng kích thước</div>
            <div class="callout-text">Nếu không cấu hình đúng, file .ldf sẽ tăng liên tục và lấp đầy ổ đĩa — một vấn đề DBA thường gặp. Bạn sẽ học cách kiểm soát điều này ở tuần 16 (Backup &amp; Recovery Model).</div>
          </div>
        </div>
      </section>

      <!-- Topic 3 -->
      <section class="topic-section" id="kieu-du-lieu">
        <div class="topic-heading"><span class="topic-icon">🔢</span><h2>Kiểu dữ liệu: INT, VARCHAR, DATE...</h2><span class="topic-num">03</span></div>
        <div class="prose">
          <p>SQL Server có hơn 30 kiểu dữ liệu. Chọn đúng kiểu dữ liệu ảnh hưởng đến <strong>dung lượng lưu trữ</strong>, <strong>hiệu năng query</strong> và <strong>tính chính xác</strong> của dữ liệu.</p>
          <h3>Kiểu số nguyên</h3>
        </div>
        <table class="compare-table">
          <thead><tr><th>Kiểu</th><th>Kích thước</th><th>Phạm vi</th><th>Dùng khi nào</th></tr></thead>
          <tbody>
            <tr><td><code>TINYINT</code></td><td>1 byte</td><td>0 → 255</td><td>Mã trạng thái nhỏ</td></tr>
            <tr><td><code>SMALLINT</code></td><td>2 byte</td><td>-32,768 → 32,767</td><td>Số lượng nhỏ</td></tr>
            <tr><td><code>INT</code></td><td>4 byte</td><td>-2.1 tỷ → 2.1 tỷ</td><td>ID, số lượng thông thường</td></tr>
            <tr><td><code>BIGINT</code></td><td>8 byte</td><td>±9.2 × 10¹⁸</td><td>ID rất lớn, thống kê lớn</td></tr>
          </tbody>
        </table>
        <div class="prose"><h3>Kiểu chuỗi văn bản</h3></div>
        <table class="compare-table">
          <thead><tr><th>Kiểu</th><th>Ký tự</th><th>Unicode?</th><th>Dùng khi nào</th></tr></thead>
          <tbody>
            <tr><td><code>CHAR(n)</code></td><td>Cố định n ký tự</td><td>Không</td><td>Mã cố định: mã quốc gia 'VN'</td></tr>
            <tr><td><code>VARCHAR(n)</code></td><td>Tối đa n ký tự</td><td>Không</td><td>Tiếng Anh, email, code</td></tr>
            <tr><td><code>NCHAR(n)</code></td><td>Cố định n ký tự</td><td>Có (UTF-16)</td><td>Mã cố định tiếng Việt/Chinese</td></tr>
            <tr><td><code>NVARCHAR(n)</code></td><td>Tối đa n ký tự</td><td>Có (UTF-16)</td><td><strong>Tiếng Việt</strong>, họ tên, địa chỉ</td></tr>
            <tr><td><code>NVARCHAR(MAX)</code></td><td>~2GB</td><td>Có</td><td>Nội dung dài: mô tả, bài viết</td></tr>
          </tbody>
        </table>
        <div class="prose"><h3>Kiểu ngày giờ</h3></div>
        <table class="compare-table">
          <thead><tr><th>Kiểu</th><th>Phạm vi</th><th>Độ chính xác</th><th>Dùng khi nào</th></tr></thead>
          <tbody>
            <tr><td><code>DATE</code></td><td>0001-01-01 → 9999-12-31</td><td>Ngày</td><td>Ngày sinh, ngày hết hạn</td></tr>
            <tr><td><code>TIME</code></td><td>00:00:00 → 23:59:59</td><td>100ns</td><td>Giờ làm việc</td></tr>
            <tr><td><code>DATETIME</code></td><td>1753 → 9999</td><td>3.33ms</td><td>Thời điểm tạo bản ghi (legacy)</td></tr>
            <tr><td><code>DATETIME2</code></td><td>0001 → 9999</td><td>100ns</td><td><strong>Khuyến nghị</strong> thay DATETIME</td></tr>
            <tr><td><code>DATETIMEOFFSET</code></td><td>0001 → 9999</td><td>100ns</td><td>Lưu cả timezone offset</td></tr>
          </tbody>
        </table>
        <div class="prose"><h3>Kiểu số thập phân</h3></div>
        <table class="compare-table">
          <thead><tr><th>Kiểu</th><th>Mô tả</th><th>Dùng khi nào</th></tr></thead>
          <tbody>
            <tr><td><code>DECIMAL(p,s)</code></td><td>Chính xác tuyệt đối, p chữ số, s chữ số thập phân</td><td><strong>Tiền tệ, giá cả</strong></td></tr>
            <tr><td><code>NUMERIC(p,s)</code></td><td>Tương đương DECIMAL</td><td>Tiền tệ</td></tr>
            <tr><td><code>FLOAT</code></td><td>Dấu phẩy động, có sai số</td><td>Khoa học, không dùng cho tiền</td></tr>
            <tr><td><code>MONEY</code></td><td>4 chữ số thập phân, 8 byte</td><td>Tiền (nhưng DECIMAL tốt hơn)</td></tr>
          </tbody>
        </table>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Ví dụ sử dụng kiểu dữ liệu</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE TABLE</span> SanPham (
    MaSP        <span class="type">INT</span>              <span class="kw">IDENTITY</span>(<span class="num">1</span>,<span class="num">1</span>) <span class="kw">PRIMARY KEY</span>,
    TenSP       <span class="type">NVARCHAR</span>(<span class="num">200</span>)   <span class="kw">NOT NULL</span>,
    MaSKU       <span class="type">CHAR</span>(<span class="num">8</span>)         <span class="kw">NOT NULL</span>,
    GiaBan      <span class="type">DECIMAL</span>(<span class="num">18</span>,<span class="num">2</span>)  <span class="kw">NOT NULL</span>,
    SoLuong     <span class="type">INT</span>              <span class="kw">DEFAULT</span> <span class="num">0</span>,
    NgayNhap    <span class="type">DATE</span>             <span class="kw">NOT NULL</span>,
    ThoiGianTao <span class="type">DATETIME2</span>        <span class="kw">DEFAULT</span> <span class="fn">SYSDATETIME</span>(),
    CoHang      <span class="type">BIT</span>              <span class="kw">DEFAULT</span> <span class="num">1</span>
);</code></pre>
        </div>
      </section>

      <!-- Topic 4 -->
      <section class="topic-section" id="null-not-null">
        <div class="topic-heading"><span class="topic-icon">∅</span><h2>NULL và NOT NULL</h2><span class="topic-num">04</span></div>
        <div class="prose">
          <p><strong>NULL</strong> trong SQL không phải là 0, không phải chuỗi rỗng — NULL có nghĩa là <em>"không biết"</em> hoặc <em>"không có giá trị"</em>. Đây là khái niệm quan trọng và dễ gây nhầm lẫn.</p>
          <h3>Đặc điểm của NULL</h3>
          <ul>
            <li>NULL <strong>không bằng</strong> bất cứ thứ gì, kể cả chính NULL</li>
            <li>Mọi phép tính với NULL đều cho kết quả là NULL</li>
            <li>Để kiểm tra NULL, phải dùng <code>IS NULL</code> hoặc <code>IS NOT NULL</code></li>
          </ul>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – NULL trong thực tế</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- NULL KHÔNG bằng NULL !</span>
<span class="kw">SELECT</span> <span class="kw">CASE WHEN</span> <span class="kw">NULL</span> <span class="op">=</span> <span class="kw">NULL</span> <span class="kw">THEN</span> <span class="str">'Bang nhau'</span>
             <span class="kw">ELSE</span> <span class="str">'Khong bang nhau'</span> <span class="kw">END</span>;
<span class="cmt">-- Kết quả: 'Khong bang nhau'</span>

<span class="cmt">-- Cách đúng để so sánh NULL</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> NhanVien <span class="kw">WHERE</span> NgaySinh <span class="kw">IS NULL</span>;
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> NhanVien <span class="kw">WHERE</span> NgaySinh <span class="kw">IS NOT NULL</span>;

<span class="cmt">-- NULL trong phép tính</span>
<span class="kw">SELECT</span> <span class="num">100</span> <span class="op">+</span> <span class="kw">NULL</span>;               <span class="cmt">-- Kết quả: NULL</span>
<span class="kw">SELECT</span> <span class="fn">ISNULL</span>(<span class="kw">NULL</span>, <span class="num">0</span>) <span class="op">+</span> <span class="num">100</span>;   <span class="cmt">-- Kết quả: 100</span>

<span class="cmt">-- NULL trong COUNT</span>
<span class="kw">SELECT</span>
    <span class="fn">COUNT</span>(<span class="op">*</span>)        <span class="kw">AS</span> TongSoBanGhi,
    <span class="fn">COUNT</span>(NgaySinh) <span class="kw">AS</span> CoNgaySinh    <span class="cmt">-- bỏ qua NULL</span>
<span class="kw">FROM</span> NhanVien;</code></pre>
        </div>
        <div class="callout warning">
          <span class="callout-icon">⚠️</span>
          <div class="callout-body">
            <div class="callout-title">NOT NULL là mặc định tốt hơn</div>
            <div class="callout-text">Khi thiết kế bảng, hãy đặt <code>NOT NULL</code> cho mọi cột có thể, chỉ cho phép NULL khi thực sự cần thiết. Điều này giúp tránh bug và giúp query optimizer tối ưu tốt hơn.</div>
          </div>
        </div>
      </section>

      <!-- Topic 5 -->
      <section class="topic-section" id="create-drop-table">
        <div class="topic-heading"><span class="topic-icon">📋</span><h2>Tạo và xóa Table</h2><span class="topic-num">05</span></div>
        <div class="prose">
          <p>Lệnh <code>CREATE TABLE</code> là một trong những lệnh DDL (Data Definition Language) quan trọng nhất. Cú pháp đầy đủ:</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – CREATE TABLE đầy đủ</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE TABLE</span> dbo.NhanVien (
    MaNV        <span class="type">INT</span>              <span class="kw">IDENTITY</span>(<span class="num">1</span>,<span class="num">1</span>) <span class="kw">NOT NULL</span>,
    HoTen       <span class="type">NVARCHAR</span>(<span class="num">100</span>)   <span class="kw">NOT NULL</span>,
    Email       <span class="type">VARCHAR</span>(<span class="num">150</span>)    <span class="kw">NOT NULL</span>,
    SoDienThoai <span class="type">VARCHAR</span>(<span class="num">20</span>)     <span class="kw">NULL</span>,
    NgaySinh    <span class="type">DATE</span>             <span class="kw">NULL</span>,
    NgayTao     <span class="type">DATETIME2</span>        <span class="kw">NOT NULL</span> <span class="kw">DEFAULT</span> <span class="fn">SYSDATETIME</span>(),
    TrangThai   <span class="type">TINYINT</span>          <span class="kw">NOT NULL</span> <span class="kw">DEFAULT</span> <span class="num">1</span>,

    <span class="kw">CONSTRAINT</span> PK_NhanVien        <span class="kw">PRIMARY KEY</span> (MaNV),
    <span class="kw">CONSTRAINT</span> UQ_NhanVien_Email  <span class="kw">UNIQUE</span> (Email)
);

<span class="cmt">-- Xem cấu trúc bảng vừa tạo</span>
<span class="kw">EXEC</span> sp_help <span class="str">'dbo.NhanVien'</span>;</code></pre>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Sửa và xóa table</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Thêm cột mới vào bảng đã có</span>
<span class="kw">ALTER TABLE</span> dbo.NhanVien
<span class="kw">ADD</span> MaPhongBan <span class="type">INT</span> <span class="kw">NULL</span>;

<span class="cmt">-- Đổi tên cột</span>
<span class="kw">EXEC</span> sp_rename <span class="str">'dbo.NhanVien.TrangThai'</span>, <span class="str">'TinhTrang'</span>, <span class="str">'COLUMN'</span>;

<span class="cmt">-- Xóa cột</span>
<span class="kw">ALTER TABLE</span> dbo.NhanVien
<span class="kw">DROP COLUMN</span> SoDienThoai;

<span class="cmt">-- Xóa toàn bộ bảng</span>
<span class="kw">DROP TABLE IF EXISTS</span> dbo.NhanVien;</code></pre>
        </div>
        <div class="callout danger">
          <span class="callout-icon">🚫</span>
          <div class="callout-body">
            <div class="callout-title">DROP TABLE xóa vĩnh viễn!</div>
            <div class="callout-text"><code>DROP TABLE</code> xóa cả cấu trúc lẫn dữ liệu, không thể Ctrl+Z. Trong môi trường production, luôn <strong>backup trước khi DROP</strong> và cần ít nhất 2 người approve.</div>
          </div>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 2</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Phân cấp</div><div class="summary-item-value">Instance → DB → Schema</div></div>
            <div class="summary-item"><div class="summary-item-label">File vật lý</div><div class="summary-item-value">.mdf / .ndf / .ldf</div></div>
            <div class="summary-item"><div class="summary-item-label">Kiểu dữ liệu</div><div class="summary-item-value">INT, NVARCHAR, DATE...</div></div>
            <div class="summary-item"><div class="summary-item-label">NULL</div><div class="summary-item-value">"Không biết", dùng IS NULL</div></div>
          </div>
        </div>
      </section>

    </div><!-- /lesson-content -->

    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 2</div>
        <ul class="toc-list">
          <li><a href="#instance-db-schema">1. Instance, Database, Schema</a></li>
          <li><a href="#files-mdf-ldf">2. File .mdf, .ndf, .ldf</a></li>
          <li><a href="#kieu-du-lieu">3. Kiểu dữ liệu</a></li>
          <li><a href="#null-not-null">4. NULL và NOT NULL</a></li>
          <li><a href="#create-drop-table">5. Tạo và xóa Table</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
