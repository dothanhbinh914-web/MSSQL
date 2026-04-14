<?php
$pageTitle  = 'Tuần 8 – Hàm tích hợp';
$basePath   = '../';
$phaseColor = 'phase2';
$isWeekPage = true;
$prevWeek   = 7;
$nextWeek   = 9;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase2);">Giai đoạn 2</span><span class="breadcrumb-sep">›</span><span>Tuần 8</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase2-bg);color:var(--phase2);border:1px solid var(--phase2-border);">Giai đoạn 2 · T-SQL từ cơ bản đến thành thạo</div>
    <div class="lesson-week-num">Tuần 8 / 22</div>
    <h1 class="lesson-title">Hàm tích hợp – Chuỗi, Ngày, Số</h1>
    <p class="lesson-desc">SQL Server cung cấp hàng trăm hàm tích hợp. Tuần này học các hàm dùng nhiều nhất trong thực tế.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="string-functions">
        <div class="topic-heading"><span class="topic-icon">🔤</span><h2>Hàm chuỗi</h2><span class="topic-num">01</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – String functions</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">SELECT</span>
    <span class="fn">LEN</span>(<span class="str">'Hello World'</span>)                        <span class="kw">AS</span> ChieuDai,        <span class="cmt">-- 11</span>
    <span class="fn">TRIM</span>(<span class="str">'  Hello  '</span>)                         <span class="kw">AS</span> XoaKhoang,       <span class="cmt">-- 'Hello'</span>
    <span class="fn">LTRIM</span>(<span class="str">'  Hello  '</span>)                        <span class="kw">AS</span> XoaTrai,         <span class="cmt">-- 'Hello  '</span>
    <span class="fn">RTRIM</span>(<span class="str">'  Hello  '</span>)                        <span class="kw">AS</span> XoaPhai,         <span class="cmt">-- '  Hello'</span>
    <span class="fn">UPPER</span>(<span class="str">'hello'</span>)                             <span class="kw">AS</span> ChuHoa,          <span class="cmt">-- 'HELLO'</span>
    <span class="fn">LOWER</span>(<span class="str">'HELLO'</span>)                             <span class="kw">AS</span> ChuThuong,       <span class="cmt">-- 'hello'</span>
    <span class="fn">SUBSTRING</span>(<span class="str">'Hello World'</span>, <span class="num">1</span>, <span class="num">5</span>)            <span class="kw">AS</span> CatChuoi,        <span class="cmt">-- 'Hello'</span>
    <span class="fn">LEFT</span>(<span class="str">'Hello World'</span>, <span class="num">5</span>)                    <span class="kw">AS</span> LayTrai,         <span class="cmt">-- 'Hello'</span>
    <span class="fn">RIGHT</span>(<span class="str">'Hello World'</span>, <span class="num">5</span>)                   <span class="kw">AS</span> LayPhai,         <span class="cmt">-- 'World'</span>
    <span class="fn">REPLACE</span>(<span class="str">'Hello World'</span>, <span class="str">'World'</span>, <span class="str">'SQL'</span>)   <span class="kw">AS</span> ThayThe,         <span class="cmt">-- 'Hello SQL'</span>
    <span class="fn">CHARINDEX</span>(<span class="str">'World'</span>, <span class="str">'Hello World'</span>)        <span class="kw">AS</span> ViTriXuatHien,  <span class="cmt">-- 7</span>
    <span class="fn">CONCAT</span>(<span class="str">'Hello'</span>, <span class="str">' '</span>, <span class="str">'World'</span>)             <span class="kw">AS</span> NoiChuoi,        <span class="cmt">-- 'Hello World'</span>
    <span class="fn">FORMAT</span>(<span class="num">1234567.89</span>, <span class="str">'N2'</span>)                  <span class="kw">AS</span> DinhDang;        <span class="cmt">-- '1,234,567.89'</span></code></pre>
        </div>
      </section>

      <section class="topic-section" id="date-functions">
        <div class="topic-heading"><span class="topic-icon">📅</span><h2>Hàm ngày giờ</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Date functions</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">SELECT</span>
    <span class="fn">GETDATE</span>()                              <span class="kw">AS</span> HienTai,
    <span class="fn">SYSDATETIME</span>()                          <span class="kw">AS</span> HienTaiChinXac,
    <span class="fn">DATEADD</span>(<span class="kw">DAY</span>,    <span class="num">30</span>, <span class="fn">GETDATE</span>())         <span class="kw">AS</span> Sau30Ngay,
    <span class="fn">DATEADD</span>(<span class="kw">MONTH</span>, -<span class="num">3</span>, <span class="fn">GETDATE</span>())         <span class="kw">AS</span> Truoc3Thang,
    <span class="fn">DATEDIFF</span>(<span class="kw">DAY</span>,  <span class="str">'2024-01-01'</span>, <span class="fn">GETDATE</span>()) <span class="kw">AS</span> SoNgayTuDau2024,
    <span class="fn">YEAR</span>(<span class="fn">GETDATE</span>())                        <span class="kw">AS</span> Nam,
    <span class="fn">MONTH</span>(<span class="fn">GETDATE</span>())                       <span class="kw">AS</span> Thang,
    <span class="fn">DAY</span>(<span class="fn">GETDATE</span>())                         <span class="kw">AS</span> Ngay,
    <span class="fn">DATENAME</span>(<span class="kw">WEEKDAY</span>, <span class="fn">GETDATE</span>())         <span class="kw">AS</span> ThuTrongTuan,
    <span class="fn">EOMONTH</span>(<span class="fn">GETDATE</span>())                    <span class="kw">AS</span> NgayMotThang,
    <span class="fn">FORMAT</span>(<span class="fn">GETDATE</span>(), <span class="str">'dd/MM/yyyy HH:mm'</span>)  <span class="kw">AS</span> DinhDangVN;

<span class="cmt">-- Tính tuổi nhân viên</span>
<span class="kw">SELECT</span>
    HoTen,
    NgaySinh,
    <span class="fn">DATEDIFF</span>(<span class="kw">YEAR</span>, NgaySinh, <span class="fn">GETDATE</span>())
        <span class="op">-</span> <span class="kw">CASE WHEN</span> <span class="fn">DATEADD</span>(<span class="kw">YEAR</span>, <span class="fn">DATEDIFF</span>(<span class="kw">YEAR</span>, NgaySinh, <span class="fn">GETDATE</span>()), NgaySinh) <span class="op">></span> <span class="fn">GETDATE</span>()
              <span class="kw">THEN</span> <span class="num">1</span> <span class="kw">ELSE</span> <span class="num">0</span> <span class="kw">END</span> <span class="kw">AS</span> Tuoi
<span class="kw">FROM</span> dbo.NhanVien;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="conversion-isnull">
        <div class="topic-heading"><span class="topic-icon">🔄</span><h2>CAST, CONVERT, ISNULL, CASE WHEN</h2><span class="topic-num">03</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- CAST: chuyển kiểu dữ liệu (chuẩn SQL)</span>
<span class="kw">SELECT</span> <span class="kw">CAST</span>(<span class="str">'2024-12-31'</span> <span class="kw">AS</span> <span class="type">DATE</span>)     <span class="kw">AS</span> NgayText_ThanhDate;
<span class="kw">SELECT</span> <span class="kw">CAST</span>(<span class="num">3.14</span>            <span class="kw">AS</span> <span class="type">INT</span>)      <span class="kw">AS</span> ThapPhan_ThanhInt;  <span class="cmt">-- 3</span>

<span class="cmt">-- CONVERT: chuyển kiểu (T-SQL, nhiều định dạng hơn)</span>
<span class="kw">SELECT</span> <span class="kw">CONVERT</span>(<span class="type">VARCHAR</span>(<span class="num">10</span>), <span class="fn">GETDATE</span>(), <span class="num">103</span>) <span class="kw">AS</span> NgayKieuVN;  <span class="cmt">-- dd/mm/yyyy</span>

<span class="cmt">-- ISNULL / COALESCE: thay thế NULL</span>
<span class="kw">SELECT</span>
    <span class="fn">ISNULL</span>(<span class="kw">NULL</span>, <span class="str">'Chưa có'</span>)               <span class="kw">AS</span> GiaTriThayThe,
    <span class="fn">COALESCE</span>(<span class="kw">NULL</span>, <span class="kw">NULL</span>, <span class="str">'Giá trị đầu tiên không NULL'</span>) <span class="kw">AS</span> CoalesceEx;

<span class="cmt">-- CASE WHEN: điều kiện phân nhánh</span>
<span class="kw">SELECT</span>
    Name,
    ListPrice,
    <span class="kw">CASE</span>
        <span class="kw">WHEN</span> ListPrice <span class="op">=</span> <span class="num">0</span>            <span class="kw">THEN</span> <span class="str">'Miễn phí'</span>
        <span class="kw">WHEN</span> ListPrice <span class="op">&lt;</span> <span class="num">100</span>         <span class="kw">THEN</span> <span class="str">'Rẻ'</span>
        <span class="kw">WHEN</span> ListPrice <span class="kw">BETWEEN</span> <span class="num">100</span> <span class="kw">AND</span> <span class="num">1000</span> <span class="kw">THEN</span> <span class="str">'Trung bình'</span>
        <span class="kw">ELSE</span>                                  <span class="str">'Đắt'</span>
    <span class="kw">END</span> <span class="kw">AS</span> PhanLoaiGia
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="kw">IS NOT NULL</span>;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 8</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Chuỗi</div><div class="summary-item-value">LEN · TRIM · REPLACE · CONCAT</div></div>
            <div class="summary-item"><div class="summary-item-label">Ngày</div><div class="summary-item-value">DATEADD · DATEDIFF · FORMAT</div></div>
            <div class="summary-item"><div class="summary-item-label">Chuyển đổi</div><div class="summary-item-value">CAST · CONVERT</div></div>
            <div class="summary-item"><div class="summary-item-label">Điều kiện</div><div class="summary-item-value">CASE WHEN · ISNULL · COALESCE</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 8</div>
        <ul class="toc-list">
          <li><a href="#string-functions">1. Hàm chuỗi</a></li>
          <li><a href="#date-functions">2. Hàm ngày giờ</a></li>
          <li><a href="#conversion-isnull">3. CAST · CONVERT · CASE WHEN</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
