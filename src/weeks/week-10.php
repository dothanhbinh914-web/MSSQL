<?php
$pageTitle  = 'Tuần 10 – Stored Procedure';
$basePath   = '../';
$phaseColor = 'phase3';
$isWeekPage = true;
$prevWeek   = 9;
$nextWeek   = 11;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase3);">Giai đoạn 3</span><span class="breadcrumb-sep">›</span><span>Tuần 10</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase3-bg);color:var(--phase3);border:1px solid var(--phase3-border);">Giai đoạn 3 · Lập trình T-SQL nâng cao</div>
    <div class="lesson-week-num">Tuần 10 / 22</div>
    <h1 class="lesson-title">Stored Procedure</h1>
    <p class="lesson-desc">Stored Procedure là chương trình T-SQL được lưu trên server — tái sử dụng, bảo mật và hiệu năng tốt hơn.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="create-sp">
        <div class="topic-heading"><span class="topic-icon">⚙️</span><h2>Tạo và gọi Stored Procedure</h2><span class="topic-num">01</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – CREATE OR ALTER PROCEDURE</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Tạo SP (SQL Server 2016+ dùng CREATE OR ALTER)</span>
<span class="kw">CREATE OR ALTER PROCEDURE</span> dbo.usp_LayDanhSachNhanVien
    <span class="cmt">-- Tham số INPUT (có giá trị mặc định)</span>
    @MaPhong    <span class="type">INT</span>  <span class="op">=</span> <span class="kw">NULL</span>,
    @TuKhoa     <span class="type">NVARCHAR</span>(<span class="num">100</span>) <span class="op">=</span> <span class="kw">NULL</span>
<span class="kw">AS</span>
<span class="kw">BEGIN</span>
    <span class="kw">SET NOCOUNT ON</span>;  <span class="cmt">-- tắt thông báo "X rows affected"</span>

    <span class="kw">SELECT</span>
        nv.MaNV,
        nv.HoTen,
        pb.TenPB
    <span class="kw">FROM</span> dbo.NhanVien nv
    <span class="kw">LEFT JOIN</span> dbo.PhongBan pb <span class="kw">ON</span> nv.MaPB <span class="op">=</span> pb.MaPB
    <span class="kw">WHERE</span>
        (@MaPhong <span class="kw">IS NULL</span> <span class="kw">OR</span> nv.MaPB <span class="op">=</span> @MaPhong)
        <span class="kw">AND</span> (@TuKhoa <span class="kw">IS NULL</span> <span class="kw">OR</span> nv.HoTen <span class="kw">LIKE</span> <span class="str">'%'</span> <span class="op">+</span> @TuKhoa <span class="op">+</span> <span class="str">'%'</span>)
    <span class="kw">ORDER BY</span> nv.HoTen;
<span class="kw">END</span>;

<span class="cmt">-- Gọi SP</span>
<span class="kw">EXEC</span> dbo.usp_LayDanhSachNhanVien;                    <span class="cmt">-- tất cả NV</span>
<span class="kw">EXEC</span> dbo.usp_LayDanhSachNhanVien @MaPhong <span class="op">=</span> <span class="num">1</span>;       <span class="cmt">-- lọc theo phòng</span>
<span class="kw">EXEC</span> dbo.usp_LayDanhSachNhanVien @TuKhoa <span class="op">=</span> N<span class="str">'Nguyễn'</span>; <span class="cmt">-- tìm kiếm</span></code></pre>
        </div>
      </section>

      <section class="topic-section" id="output-params">
        <div class="topic-heading"><span class="topic-icon">📤</span><h2>Tham số OUTPUT &amp; RETURN</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – OUTPUT parameter</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE OR ALTER PROCEDURE</span> dbo.usp_ThemNhanVien
    @HoTen      <span class="type">NVARCHAR</span>(<span class="num">100</span>),
    @Email      <span class="type">VARCHAR</span>(<span class="num">150</span>),
    @MaNV_Moi   <span class="type">INT</span>  <span class="kw">OUTPUT</span>   <span class="cmt">-- tham số OUTPUT</span>
<span class="kw">AS</span>
<span class="kw">BEGIN</span>
    <span class="kw">SET NOCOUNT ON</span>;

    <span class="kw">INSERT INTO</span> dbo.NhanVien (HoTen, Email)
    <span class="kw">VALUES</span> (@HoTen, @Email);

    <span class="kw">SET</span> @MaNV_Moi <span class="op">=</span> <span class="fn">SCOPE_IDENTITY</span>();  <span class="cmt">-- lấy ID vừa tạo</span>

    <span class="kw">RETURN</span> <span class="num">0</span>;  <span class="cmt">-- 0 = thành công</span>
<span class="kw">END</span>;

<span class="cmt">-- Gọi SP và nhận OUTPUT</span>
<span class="kw">DECLARE</span> @ID <span class="type">INT</span>;
<span class="kw">EXEC</span> dbo.usp_ThemNhanVien
    @HoTen    <span class="op">=</span> N<span class="str">'Lê Thị Cúc'</span>,
    @Email    <span class="op">=</span> <span class="str">'cuc@company.com'</span>,
    @MaNV_Moi <span class="op">=</span> @ID <span class="kw">OUTPUT</span>;

<span class="kw">SELECT</span> @ID <span class="kw">AS</span> MaNhanVienMoiTao;  <span class="cmt">-- in ID vừa tạo</span></code></pre>
        </div>
      </section>

      <section class="topic-section" id="try-catch">
        <div class="topic-heading"><span class="topic-icon">🛡️</span><h2>TRY...CATCH – Xử lý lỗi</h2><span class="topic-num">03</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – TRY CATCH trong SP</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">CREATE OR ALTER PROCEDURE</span> dbo.usp_ChuyenPhong
    @MaNV    <span class="type">INT</span>,
    @MaPBMoi <span class="type">INT</span>
<span class="kw">AS</span>
<span class="kw">BEGIN</span>
    <span class="kw">SET NOCOUNT ON</span>;

    <span class="kw">BEGIN TRY</span>
        <span class="kw">BEGIN TRANSACTION</span>;

        <span class="cmt">-- Kiểm tra nhân viên tồn tại</span>
        <span class="kw">IF NOT EXISTS</span> (<span class="kw">SELECT</span> <span class="num">1</span> <span class="kw">FROM</span> dbo.NhanVien <span class="kw">WHERE</span> MaNV <span class="op">=</span> @MaNV)
            <span class="kw">THROW</span> <span class="num">50001</span>, <span class="str">N'Nhân viên không tồn tại'</span>, <span class="num">1</span>;

        <span class="kw">UPDATE</span> dbo.NhanVien
        <span class="kw">SET</span> MaPB <span class="op">=</span> @MaPBMoi
        <span class="kw">WHERE</span> MaNV <span class="op">=</span> @MaNV;

        <span class="kw">COMMIT TRANSACTION</span>;
        <span class="kw">SELECT</span> <span class="str">'Chuyển phòng thành công'</span> <span class="kw">AS</span> KetQua;

    <span class="kw">END TRY</span>
    <span class="kw">BEGIN CATCH</span>
        <span class="kw">IF</span> @@TRANCOUNT <span class="op">></span> <span class="num">0</span>
            <span class="kw">ROLLBACK TRANSACTION</span>;

        <span class="kw">SELECT</span>
            ERROR_NUMBER()  <span class="kw">AS</span> MaLoi,
            ERROR_MESSAGE() <span class="kw">AS</span> NoiDungLoi,
            ERROR_LINE()    <span class="kw">AS</span> DongLoi;
    <span class="kw">END CATCH</span>;
<span class="kw">END</span>;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 10</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">CREATE SP</div><div class="summary-item-value">CREATE OR ALTER PROCEDURE</div></div>
            <div class="summary-item"><div class="summary-item-label">Tham số</div><div class="summary-item-value">INPUT · OUTPUT · RETURN</div></div>
            <div class="summary-item"><div class="summary-item-label">Lỗi</div><div class="summary-item-value">TRY...CATCH · THROW</div></div>
            <div class="summary-item"><div class="summary-item-label">Best practice</div><div class="summary-item-value">SET NOCOUNT ON · SCOPE_IDENTITY</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 10</div>
        <ul class="toc-list">
          <li><a href="#create-sp">1. Tạo và gọi SP</a></li>
          <li><a href="#output-params">2. Tham số OUTPUT</a></li>
          <li><a href="#try-catch">3. TRY...CATCH</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
