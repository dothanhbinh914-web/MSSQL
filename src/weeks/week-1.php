<?php
$pageTitle  = 'Tuần 1 – Cài đặt & Làm quen';
$basePath   = '../';
$phaseColor = 'phase1';
$isWeekPage = true;
$prevWeek   = null;
$nextWeek   = 2;
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
  <nav class="breadcrumb">
    <a href="../index.php">Trang chủ</a>
    <span class="breadcrumb-sep">›</span>
    <span style="color:var(--phase1);">Giai đoạn 1</span>
    <span class="breadcrumb-sep">›</span>
    <span>Tuần 1</span>
  </nav>

  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase1-bg);color:var(--phase1);border:1px solid var(--phase1-border);">
      Giai đoạn 1 · Nền tảng &amp; môi trường
    </div>
    <div class="lesson-week-num">Tuần 1 / 22</div>
    <h1 class="lesson-title">Cài đặt &amp; Làm quen SQL Server</h1>
    <p class="lesson-desc">Thiết lập môi trường phát triển hoàn chỉnh, làm quen với các công cụ quản lý và chạy truy vấn đầu tiên trên SQL Server.</p>
  </div>

  <div class="lesson-layout">
    <div class="lesson-content">

      <!-- Topic 1 -->
      <section class="topic-section" id="cai-sql-server">
        <div class="topic-heading">
          <span class="topic-icon">⚙️</span>
          <h2>Cài đặt SQL Server Developer Edition</h2>
          <span class="topic-num">01</span>
        </div>
        <div class="prose">
          <p><strong>SQL Server Developer Edition</strong> là phiên bản miễn phí của Microsoft, có đầy đủ tính năng như bản Enterprise nhưng chỉ được dùng để phát triển và test — không được dùng cho production. Đây là lựa chọn tốt nhất để học.</p>
          <h3>Các phiên bản SQL Server phổ biến</h3>
        </div>
        <table class="compare-table">
          <thead><tr><th>Phiên bản</th><th>Chi phí</th><th>Mục đích</th><th>Giới hạn</th></tr></thead>
          <tbody>
            <tr><td><strong>Developer</strong> <span class="tag blue">Học tập</span></td><td>Miễn phí</td><td>Phát triển, test</td><td>Không dùng production</td></tr>
            <tr><td><strong>Express</strong></td><td>Miễn phí</td><td>App nhỏ</td><td>10GB DB, 1GB RAM, 4 cores</td></tr>
            <tr><td><strong>Standard</strong></td><td>Trả phí</td><td>SMB</td><td>128GB RAM, 24 cores</td></tr>
            <tr><td><strong>Enterprise</strong></td><td>Trả phí cao</td><td>Production lớn</td><td>Không giới hạn</td></tr>
          </tbody>
        </table>
        <div class="prose">
          <h3>Các bước cài đặt</h3>
          <ol>
            <li>Truy cập trang Microsoft và tải <strong>SQL Server Developer 2022</strong></li>
            <li>Chọn chế độ cài đặt <strong>Basic</strong> (đơn giản nhất cho người mới)</li>
            <li>Chấp nhận điều khoản và chọn thư mục cài đặt</li>
            <li>Chờ quá trình cài đặt hoàn tất (~10-15 phút)</li>
            <li>Lưu lại <strong>connection string</strong> được hiển thị cuối cài đặt</li>
          </ol>
        </div>
        <div class="callout info">
          <span class="callout-icon">💡</span>
          <div class="callout-body">
            <div class="callout-title">Tên server mặc định</div>
            <div class="callout-text">Sau khi cài xong, tên server thường là <code>localhost</code> hoặc <code>.\SQLEXPRESS</code> hoặc tên máy tính của bạn.</div>
          </div>
        </div>
      </section>

      <!-- Topic 2 -->
      <section class="topic-section" id="cai-ssms">
        <div class="topic-heading">
          <span class="topic-icon">🖥️</span>
          <h2>Cài đặt SSMS &amp; Azure Data Studio</h2>
          <span class="topic-num">02</span>
        </div>
        <div class="prose">
          <p>SQL Server chỉ là <em>engine</em> (động cơ) chạy ngầm. Để tương tác với nó, bạn cần công cụ quản lý giao diện đồ họa (GUI).</p>
          <h3>So sánh SSMS vs Azure Data Studio</h3>
        </div>
        <table class="compare-table">
          <thead><tr><th>Tính năng</th><th>SSMS</th><th>Azure Data Studio</th></tr></thead>
          <tbody>
            <tr><td>Hệ điều hành</td><td>Windows only</td><td>Windows, Mac, Linux</td></tr>
            <tr><td>Mục đích chính</td><td>DBA &amp; quản trị</td><td>Developer &amp; query</td></tr>
            <tr><td>Execution Plan</td><td>✅ Chi tiết</td><td>✅ Cơ bản</td></tr>
            <tr><td>SQL Agent</td><td>✅ Đầy đủ</td><td>❌ Không có</td></tr>
            <tr><td>Notebook support</td><td>❌</td><td>✅ (như Jupyter)</td></tr>
            <tr><td>Extension system</td><td>Hạn chế</td><td>Phong phú</td></tr>
          </tbody>
        </table>
        <div class="callout tip">
          <span class="callout-icon">✅</span>
          <div class="callout-body">
            <div class="callout-title">Gợi ý cho người mới</div>
            <div class="callout-text">Cài cả hai — dùng <strong>SSMS</strong> cho công việc DBA hàng ngày (backup, restore, agent jobs), dùng <strong>Azure Data Studio</strong> để viết query với giao diện đẹp hơn.</div>
          </div>
        </div>
      </section>

      <!-- Topic 3 -->
      <section class="topic-section" id="tao-database">
        <div class="topic-heading">
          <span class="topic-icon">🗄️</span>
          <h2>Tạo Database đầu tiên</h2>
          <span class="topic-num">03</span>
        </div>
        <div class="prose">
          <p>Sau khi kết nối vào SQL Server, có 2 cách tạo database: qua giao diện đồ họa hoặc dùng lệnh T-SQL. Nên học cả hai.</p>
          <h3>Cách 1: Dùng T-SQL (khuyến khích)</h3>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Tạo database mới tên là "QuanLyNhanVien"</span>
<span class="kw">CREATE DATABASE</span> QuanLyNhanVien;

<span class="cmt">-- Chuyển sang dùng database đó</span>
<span class="kw">USE</span> QuanLyNhanVien;

<span class="cmt">-- Kiểm tra xem đang dùng database nào</span>
<span class="kw">SELECT</span> DB_NAME() <span class="kw">AS</span> CurrentDatabase;

<span class="cmt">-- Xem tất cả các database trên server</span>
<span class="kw">SELECT</span> name, create_date, state_desc
<span class="kw">FROM</span> sys.databases
<span class="kw">ORDER BY</span> name;</code></pre>
        </div>
        <div class="prose">
          <h3>Cách 2: Qua giao diện SSMS</h3>
          <ol>
            <li>Trong Object Explorer, chuột phải vào <strong>Databases</strong></li>
            <li>Chọn <strong>New Database...</strong></li>
            <li>Nhập tên database và nhấn <strong>OK</strong></li>
          </ol>
          <h3>Quy tắc đặt tên database</h3>
          <ul>
            <li>Không chứa dấu cách (dùng underscore <code>_</code> hoặc PascalCase)</li>
            <li>Không bắt đầu bằng số hoặc ký tự đặc biệt</li>
            <li>Độ dài tối đa 128 ký tự</li>
            <li>Case-insensitive (SQL Server không phân biệt hoa thường tên DB)</li>
          </ul>
        </div>
        <div class="callout warning">
          <span class="callout-icon">⚠️</span>
          <div class="callout-body">
            <div class="callout-title">Không nên đặt tên có dấu cách</div>
            <div class="callout-text">Nếu tên database có dấu cách như <code>Quan Ly Nhan Vien</code>, bạn phải luôn bọc nó trong dấu ngoặc vuông: <code>[Quan Ly Nhan Vien]</code> — rất bất tiện.</div>
          </div>
        </div>
      </section>

      <!-- Topic 4 -->
      <section class="topic-section" id="object-explorer">
        <div class="topic-heading">
          <span class="topic-icon">🔍</span>
          <h2>Hiểu giao diện Object Explorer</h2>
          <span class="topic-num">04</span>
        </div>
        <div class="prose">
          <p><strong>Object Explorer</strong> là panel bên trái của SSMS — nơi bạn quản lý toàn bộ các đối tượng trong SQL Server theo dạng cây phân cấp.</p>
          <h3>Cấu trúc phân cấp trong Object Explorer</h3>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">CẤU TRÚC</span><button class="copy-btn">Copy</button></div>
          <pre><code>Server (ví dụ: MYPC\SQLEXPRESS)
├── Databases
│   ├── System Databases (master, model, msdb, tempdb)
│   └── QuanLyNhanVien  ← database của bạn
│       ├── Tables
│       ├── Views
│       ├── Stored Procedures
│       ├── Functions
│       └── Security (Users, Roles)
├── Security (Logins)
├── Server Objects
└── SQL Server Agent (Jobs, Alerts)</code></pre>
        </div>
        <div class="prose">
          <h3>4 System Databases quan trọng</h3>
          <ul>
            <li><strong>master</strong> — lưu thông tin cấu hình toàn server, logins, danh sách databases</li>
            <li><strong>model</strong> — template khi tạo database mới (mọi DB mới đều copy từ model)</li>
            <li><strong>msdb</strong> — lưu lịch sử backup, SQL Agent jobs, schedules</li>
            <li><strong>tempdb</strong> — bộ nhớ tạm, tái tạo mỗi lần restart SQL Server</li>
          </ul>
        </div>
        <div class="callout danger">
          <span class="callout-icon">🚫</span>
          <div class="callout-body">
            <div class="callout-title">Không sửa System Databases</div>
            <div class="callout-text">Đặc biệt <strong>đừng bao giờ xóa hay sửa database master</strong> — SQL Server sẽ không khởi động được nếu master bị hỏng.</div>
          </div>
        </div>
      </section>

      <!-- Topic 5 -->
      <section class="topic-section" id="query-dau-tien">
        <div class="topic-heading">
          <span class="topic-icon">⌨️</span>
          <h2>Chạy truy vấn đầu tiên</h2>
          <span class="topic-num">05</span>
        </div>
        <div class="prose">
          <p>Mở cửa sổ query mới trong SSMS bằng cách nhấn <strong>Ctrl+N</strong> hoặc nút <em>New Query</em> trên toolbar. Thử các lệnh sau:</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Truy vấn đầu tiên</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- 1. Xem phiên bản SQL Server đang dùng</span>
<span class="kw">SELECT</span> @@VERSION;

<span class="cmt">-- 2. Xem tên server</span>
<span class="kw">SELECT</span> @@SERVERNAME;

<span class="cmt">-- 3. Xem thời gian hiện tại</span>
<span class="kw">SELECT</span> <span class="fn">GETDATE</span>() <span class="kw">AS</span> ThoiGianHienTai;

<span class="cmt">-- 4. Tạo bảng đầu tiên</span>
<span class="kw">USE</span> QuanLyNhanVien;

<span class="kw">CREATE TABLE</span> NhanVien (
    MaNV       <span class="type">INT</span>           <span class="kw">IDENTITY</span>(<span class="num">1</span>,<span class="num">1</span>) <span class="kw">PRIMARY KEY</span>,
    HoTen      <span class="type">NVARCHAR</span>(<span class="num">100</span>) <span class="kw">NOT NULL</span>,
    NgaySinh   <span class="type">DATE</span>,
    LuongCoBan <span class="type">DECIMAL</span>(<span class="num">18</span>,<span class="num">2</span>)
);

<span class="cmt">-- 5. Thêm và đọc dữ liệu</span>
<span class="kw">INSERT INTO</span> NhanVien (HoTen, NgaySinh, LuongCoBan)
<span class="kw">VALUES</span>
    (N<span class="str">'Nguyễn Văn An'</span>, <span class="str">'1990-01-15'</span>, <span class="num">15000000</span>),
    (N<span class="str">'Trần Thị Bình'</span>, <span class="str">'1992-05-20'</span>, <span class="num">18000000</span>);

<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> NhanVien;</code></pre>
        </div>
        <div class="prose"><h3>Phím tắt quan trọng trong SSMS</h3></div>
        <table class="compare-table">
          <thead><tr><th>Phím tắt</th><th>Chức năng</th></tr></thead>
          <tbody>
            <tr><td><code>F5</code></td><td>Chạy toàn bộ query trong cửa sổ</td></tr>
            <tr><td><code>Ctrl+E</code></td><td>Chạy phần query đang được chọn</td></tr>
            <tr><td><code>Ctrl+N</code></td><td>Mở cửa sổ query mới</td></tr>
            <tr><td><code>Ctrl+K, Ctrl+C</code></td><td>Comment đoạn code được chọn</td></tr>
            <tr><td><code>Ctrl+K, Ctrl+U</code></td><td>Bỏ comment đoạn code được chọn</td></tr>
            <tr><td><code>Ctrl+L</code></td><td>Xem Execution Plan ước tính</td></tr>
          </tbody>
        </table>

        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 1</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Đã học</div><div class="summary-item-value">5 kỹ năng cơ bản</div></div>
            <div class="summary-item"><div class="summary-item-label">Công cụ</div><div class="summary-item-value">SSMS + Azure Data Studio</div></div>
            <div class="summary-item"><div class="summary-item-label">Kết quả</div><div class="summary-item-value">Tạo được DB đầu tiên</div></div>
          </div>
        </div>
      </section>

    </div><!-- /lesson-content -->

    <!-- Sidebar TOC -->
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 1</div>
        <ul class="toc-list">
          <li><a href="#cai-sql-server">1. Cài đặt SQL Server</a></li>
          <li><a href="#cai-ssms">2. SSMS &amp; Azure Data Studio</a></li>
          <li><a href="#tao-database">3. Tạo Database đầu tiên</a></li>
          <li><a href="#object-explorer">4. Object Explorer</a></li>
          <li><a href="#query-dau-tien">5. Chạy truy vấn đầu tiên</a></li>
        </ul>
      </div>
    </aside>
  </div><!-- /lesson-layout -->
</div><!-- /container -->

<?php require __DIR__ . '/../includes/footer.php'; ?>
