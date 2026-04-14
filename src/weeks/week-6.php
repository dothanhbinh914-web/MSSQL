<?php
$pageTitle  = 'Tuần 6 – Tổng hợp & Phân nhóm';
$basePath   = '../';
$phaseColor = 'phase2';
$isWeekPage = true;
$prevWeek   = 5;
$nextWeek   = 7;
require __DIR__ . '/../includes/header.php';
?>
<div class="container">
  <nav class="breadcrumb"><a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span><span style="color:var(--phase2);">Giai đoạn 2</span><span class="breadcrumb-sep">›</span><span>Tuần 6</span></nav>
  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase2-bg);color:var(--phase2);border:1px solid var(--phase2-border);">Giai đoạn 2 · T-SQL từ cơ bản đến thành thạo</div>
    <div class="lesson-week-num">Tuần 6 / 22</div>
    <h1 class="lesson-title">GROUP BY, HAVING &amp; Hàm tổng hợp</h1>
    <p class="lesson-desc">Thống kê và phân tích dữ liệu theo nhóm — nền tảng của mọi báo cáo.</p>
  </div>
  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="group-by">
        <div class="topic-heading"><span class="topic-icon">📊</span><h2>GROUP BY &amp; Hàm tổng hợp</h2><span class="topic-num">01</span></div>
        <div class="prose"><p>Hàm tổng hợp (aggregate functions) tính toán trên một nhóm dòng và trả về một giá trị duy nhất.</p></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">USE</span> AdventureWorks2022;

<span class="cmt">-- Đếm, tổng, trung bình, min, max theo danh mục sản phẩm</span>
<span class="kw">SELECT</span>
    pc.Name                      <span class="kw">AS</span> DanhMuc,
    <span class="fn">COUNT</span>(<span class="op">*</span>)                    <span class="kw">AS</span> SoSanPham,
    <span class="fn">AVG</span>(p.ListPrice)             <span class="kw">AS</span> GiaTrungBinh,
    <span class="fn">MIN</span>(p.ListPrice)             <span class="kw">AS</span> GiaThapNhat,
    <span class="fn">MAX</span>(p.ListPrice)             <span class="kw">AS</span> GiaCaoNhat,
    <span class="fn">SUM</span>(p.ListPrice)             <span class="kw">AS</span> TongGia
<span class="kw">FROM</span> Production.Product p
<span class="kw">INNER JOIN</span> Production.ProductSubcategory ps <span class="kw">ON</span> p.ProductSubcategoryID <span class="op">=</span> ps.ProductSubcategoryID
<span class="kw">INNER JOIN</span> Production.ProductCategory pc   <span class="kw">ON</span> ps.ProductCategoryID   <span class="op">=</span> pc.ProductCategoryID
<span class="kw">WHERE</span> p.ListPrice <span class="op">></span> <span class="num">0</span>
<span class="kw">GROUP BY</span> pc.Name
<span class="kw">ORDER BY</span> SoSanPham <span class="kw">DESC</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="having">
        <div class="topic-heading"><span class="topic-icon">🔍</span><h2>HAVING – Lọc sau khi GROUP BY</h2><span class="topic-num">02</span></div>
        <div class="prose">
          <p><code>HAVING</code> lọc kết quả <em>sau khi</em> đã GROUP BY — khác với WHERE (lọc trước GROUP BY).</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – WHERE vs HAVING</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- WHERE: lọc dòng trước khi group</span>
<span class="cmt">-- HAVING: lọc nhóm sau khi group</span>
<span class="kw">SELECT</span>
    YEAR(soh.OrderDate)    <span class="kw">AS</span> Nam,
    MONTH(soh.OrderDate)   <span class="kw">AS</span> Thang,
    <span class="fn">COUNT</span>(<span class="op">*</span>)              <span class="kw">AS</span> SoDonHang,
    <span class="fn">SUM</span>(soh.TotalDue)     <span class="kw">AS</span> DoanhThu
<span class="kw">FROM</span> Sales.SalesOrderHeader soh
<span class="kw">WHERE</span> soh.Status <span class="op">=</span> <span class="num">5</span>                 <span class="cmt">-- WHERE: chỉ lấy đơn hàng hoàn thành</span>
<span class="kw">GROUP BY</span>
    YEAR(soh.OrderDate),
    MONTH(soh.OrderDate)
<span class="kw">HAVING</span> <span class="fn">SUM</span>(soh.TotalDue) <span class="op">></span> <span class="num">500000</span>  <span class="cmt">-- HAVING: chỉ lấy tháng doanh thu > 500k</span>
<span class="kw">ORDER BY</span> Nam, Thang;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="rollup-cube">
        <div class="topic-heading"><span class="topic-icon">📈</span><h2>ROLLUP &amp; GROUPING SETS</h2><span class="topic-num">03</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- ROLLUP: tạo subtotal theo chiều phân cấp</span>
<span class="kw">SELECT</span>
    ISNULL(pc.Name, <span class="str">'TỔNG CỘNG'</span>)   <span class="kw">AS</span> DanhMuc,
    ISNULL(ps.Name, <span class="str">'Tất cả'</span>)      <span class="kw">AS</span> PhanMuc,
    <span class="fn">COUNT</span>(<span class="op">*</span>)                         <span class="kw">AS</span> SoSanPham,
    <span class="fn">SUM</span>(p.ListPrice)                  <span class="kw">AS</span> TongGia
<span class="kw">FROM</span> Production.Product p
<span class="kw">INNER JOIN</span> Production.ProductSubcategory ps <span class="kw">ON</span> p.ProductSubcategoryID <span class="op">=</span> ps.ProductSubcategoryID
<span class="kw">INNER JOIN</span> Production.ProductCategory pc   <span class="kw">ON</span> ps.ProductCategoryID   <span class="op">=</span> pc.ProductCategoryID
<span class="kw">WHERE</span> p.ListPrice <span class="op">></span> <span class="num">0</span>
<span class="kw">GROUP BY ROLLUP</span>(pc.Name, ps.Name)
<span class="kw">ORDER BY</span> pc.Name, ps.Name;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="subquery">
        <div class="topic-heading"><span class="topic-icon">🔲</span><h2>Subquery</h2><span class="topic-num">04</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Subquery</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Subquery trong WHERE: sản phẩm có giá > giá trung bình</span>
<span class="kw">SELECT</span> Name, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="op">></span> (
    <span class="kw">SELECT</span> <span class="fn">AVG</span>(ListPrice) <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> ListPrice <span class="op">></span> <span class="num">0</span>
)
<span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>;

<span class="cmt">-- Subquery trong SELECT: so sánh với tổng</span>
<span class="kw">SELECT</span>
    Name,
    ListPrice,
    ListPrice <span class="op">/</span> (<span class="kw">SELECT</span> <span class="fn">SUM</span>(ListPrice) <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> ListPrice <span class="op">></span> <span class="num">0</span>) <span class="op">*</span> <span class="num">100</span>
        <span class="kw">AS</span> PhanTramGia
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="op">></span> <span class="num">0</span>
<span class="kw">ORDER BY</span> PhanTramGia <span class="kw">DESC</span>;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 6</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Hàm tổng hợp</div><div class="summary-item-value">COUNT · SUM · AVG · MIN · MAX</div></div>
            <div class="summary-item"><div class="summary-item-label">Phân nhóm</div><div class="summary-item-value">GROUP BY + HAVING</div></div>
            <div class="summary-item"><div class="summary-item-label">Subtotal</div><div class="summary-item-value">ROLLUP · CUBE · GROUPING SETS</div></div>
            <div class="summary-item"><div class="summary-item-label">Lồng nhau</div><div class="summary-item-value">Subquery trong WHERE/SELECT</div></div>
          </div>
        </div>
      </section>

    </div>
    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 6</div>
        <ul class="toc-list">
          <li><a href="#group-by">1. GROUP BY &amp; Aggregate</a></li>
          <li><a href="#having">2. HAVING</a></li>
          <li><a href="#rollup-cube">3. ROLLUP &amp; GROUPING SETS</a></li>
          <li><a href="#subquery">4. Subquery</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
