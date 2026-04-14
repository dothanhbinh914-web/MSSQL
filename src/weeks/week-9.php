<?php
$pageTitle  = 'Tuần 9 – CTE & Window Functions';
$basePath   = '../';
$phaseColor = 'phase2';
$isWeekPage = true;
$prevWeek   = 8;
$nextWeek   = 10;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase2);">Giai đoạn 2</span><span class="breadcrumb-sep">›</span><span>Tuần 9</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase2-bg);color:var(--phase2);border:1px solid var(--phase2-border);">Giai đoạn 2 · T-SQL từ cơ bản đến thành thạo</div>
    <div class="lesson-week-num">Tuần 9 / 22</div>
    <h1 class="lesson-title">CTE &amp; Window Functions</h1>
    <p class="lesson-desc">CTE giúp viết query phức tạp dễ đọc hơn. Window Functions phân tích dữ liệu theo nhóm mà không mất từng dòng.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="cte">
        <div class="topic-heading"><span class="topic-icon">🔧</span><h2>CTE – Common Table Expression</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p>CTE (WITH ... AS) tạo ra một "bảng tạm" tồn tại trong phạm vi một câu query — giúp viết code SQL dễ đọc hơn nhiều so với subquery.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – CTE cơ bản</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- CTE: đặt tên cho subquery, dùng lại được</span>
<span class="kw">WITH</span> DoanhThuThang <span class="kw">AS</span> (
    <span class="kw">SELECT</span>
        YEAR(OrderDate)  <span class="kw">AS</span> Nam,
        MONTH(OrderDate) <span class="kw">AS</span> Thang,
        <span class="fn">SUM</span>(TotalDue)    <span class="kw">AS</span> DoanhThu
    <span class="kw">FROM</span> Sales.SalesOrderHeader
    <span class="kw">WHERE</span> Status <span class="op">=</span> <span class="num">5</span>
    <span class="kw">GROUP BY</span> YEAR(OrderDate), MONTH(OrderDate)
)
<span class="kw">SELECT</span>
    d.Nam,
    d.Thang,
    d.DoanhThu,
    d.DoanhThu <span class="op">-</span> <span class="fn">LAG</span>(d.DoanhThu) <span class="kw">OVER</span> (<span class="kw">ORDER BY</span> d.Nam, d.Thang) <span class="kw">AS</span> TangGiam
<span class="kw">FROM</span> DoanhThuThang d
<span class="kw">ORDER BY</span> d.Nam, d.Thang;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="recursive-cte">
        <div class="topic-heading"><span class="topic-icon">🌳</span><h2>Recursive CTE – Duyệt cây phân cấp</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Recursive CTE</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Duyệt cây tổ chức nhân viên (ai quản lý ai)</span>
<span class="kw">WITH</span> CayToChuc <span class="kw">AS</span> (
    <span class="cmt">-- Anchor: lấy CEO (cấp cao nhất, không có quản lý)</span>
    <span class="kw">SELECT</span>
        MaNV, HoTen, MaQuanLy,
        <span class="num">0</span>           <span class="kw">AS</span> Cap,
        <span class="kw">CAST</span>(HoTen <span class="kw">AS</span> <span class="type">NVARCHAR</span>(<span class="num">1000</span>)) <span class="kw">AS</span> DuongDan
    <span class="kw">FROM</span> dbo.NhanVien
    <span class="kw">WHERE</span> MaQuanLy <span class="kw">IS NULL</span>

    <span class="kw">UNION ALL</span>

    <span class="cmt">-- Recursive: lấy cấp dưới kế tiếp</span>
    <span class="kw">SELECT</span>
        nv.MaNV, nv.HoTen, nv.MaQuanLy,
        ct.Cap <span class="op">+</span> <span class="num">1</span>,
        <span class="kw">CAST</span>(ct.DuongDan <span class="op">+</span> <span class="str">' → '</span> <span class="op">+</span> nv.HoTen <span class="kw">AS</span> <span class="type">NVARCHAR</span>(<span class="num">1000</span>))
    <span class="kw">FROM</span> dbo.NhanVien nv
    <span class="kw">INNER JOIN</span> CayToChuc ct <span class="kw">ON</span> nv.MaQuanLy <span class="op">=</span> ct.MaNV
)
<span class="kw">SELECT</span>
    REPLICATE(<span class="str">'  '</span>, Cap) <span class="op">+</span> HoTen <span class="kw">AS</span> CayToChuc,
    DuongDan
<span class="kw">FROM</span> CayToChuc
<span class="kw">ORDER BY</span> DuongDan;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="window-functions">
        <div class="topic-heading"><span class="topic-icon">🪟</span><h2>Window Functions</h2><span class="topic-num">03</span></div>
        <div class="prose">
          <p>Window Functions (hàm cửa sổ) tính toán trên một "cửa sổ" dữ liệu mà <strong>không gộp dòng lại</strong> — khác với GROUP BY sẽ thu gọn dữ liệu.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – ROW_NUMBER, RANK, DENSE_RANK</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">SELECT</span>
    Name <span class="kw">AS</span> SanPham,
    ListPrice,
    ProductSubcategoryID,
    <span class="cmt">-- ROW_NUMBER: số thứ tự duy nhất (không bao giờ trùng)</span>
    <span class="fn">ROW_NUMBER</span>() <span class="kw">OVER</span> (<span class="kw">PARTITION BY</span> ProductSubcategoryID <span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>) <span class="kw">AS</span> STT,
    <span class="cmt">-- RANK: xếp hạng, bỏ số nếu trùng (1,2,2,4,...)</span>
    <span class="fn">RANK</span>()       <span class="kw">OVER</span> (<span class="kw">PARTITION BY</span> ProductSubcategoryID <span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>) <span class="kw">AS</span> Hang,
    <span class="cmt">-- DENSE_RANK: xếp hạng, không bỏ số (1,2,2,3,...)</span>
    <span class="fn">DENSE_RANK</span>() <span class="kw">OVER</span> (<span class="kw">PARTITION BY</span> ProductSubcategoryID <span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>) <span class="kw">AS</span> HangDay
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="op">></span> <span class="num">0</span> <span class="kw">AND</span> ProductSubcategoryID <span class="kw">IS NOT NULL</span>;</code></pre>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – LAG, LEAD (giá trị kỳ trước/sau)</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">WITH</span> DoanhThuThang <span class="kw">AS</span> (
    <span class="kw">SELECT</span>
        YEAR(OrderDate)   <span class="kw">AS</span> Nam,
        MONTH(OrderDate)  <span class="kw">AS</span> Thang,
        <span class="fn">SUM</span>(TotalDue)     <span class="kw">AS</span> DoanhThu
    <span class="kw">FROM</span> Sales.SalesOrderHeader <span class="kw">WHERE</span> Status <span class="op">=</span> <span class="num">5</span>
    <span class="kw">GROUP BY</span> YEAR(OrderDate), MONTH(OrderDate)
)
<span class="kw">SELECT</span>
    Nam, Thang, DoanhThu,
    <span class="fn">LAG</span>(DoanhThu)  <span class="kw">OVER</span> (<span class="kw">ORDER BY</span> Nam, Thang)   <span class="kw">AS</span> ThangTruoc,
    <span class="fn">LEAD</span>(DoanhThu) <span class="kw">OVER</span> (<span class="kw">ORDER BY</span> Nam, Thang)   <span class="kw">AS</span> ThangSau,
    DoanhThu <span class="op">-</span> <span class="fn">LAG</span>(DoanhThu) <span class="kw">OVER</span> (<span class="kw">ORDER BY</span> Nam, Thang) <span class="kw">AS</span> TangGiam,
    <span class="fn">SUM</span>(DoanhThu)  <span class="kw">OVER</span> (<span class="kw">PARTITION BY</span> Nam <span class="kw">ORDER BY</span> Thang) <span class="kw">AS</span> LuyKeNam
<span class="kw">FROM</span> DoanhThuThang
<span class="kw">ORDER BY</span> Nam, Thang;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Mốc Giai đoạn 2 hoàn thành!</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">CTE</div><div class="summary-item-value">WITH ... AS (query)</div></div>
            <div class="summary-item"><div class="summary-item-label">Recursive CTE</div><div class="summary-item-value">Duyệt cây phân cấp</div></div>
            <div class="summary-item"><div class="summary-item-label">Ranking</div><div class="summary-item-value">ROW_NUMBER · RANK · DENSE_RANK</div></div>
            <div class="summary-item"><div class="summary-item-label">So sánh kỳ</div><div class="summary-item-value">LAG · LEAD · SUM OVER</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 9</div>
        <ul class="toc-list">
          <li><a href="#cte">1. CTE cơ bản</a></li>
          <li><a href="#recursive-cte">2. Recursive CTE</a></li>
          <li><a href="#window-functions">3. Window Functions</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
