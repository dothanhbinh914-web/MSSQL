<?php
$pageTitle  = 'Tuần 5 – JOIN & Kết hợp bảng';
$basePath   = '../';
$phaseColor = 'phase2';
$isWeekPage = true;
$prevWeek   = 4;
$nextWeek   = 6;
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
  <nav class="breadcrumb">
    <a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span>
    <span style="color:var(--phase2);">Giai đoạn 2</span><span class="breadcrumb-sep">›</span>
    <span>Tuần 5</span>
  </nav>

  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase2-bg);color:var(--phase2);border:1px solid var(--phase2-border);">Giai đoạn 2 · T-SQL từ cơ bản đến thành thạo</div>
    <div class="lesson-week-num">Tuần 5 / 22</div>
    <h1 class="lesson-title">JOIN – Kết hợp nhiều bảng</h1>
    <p class="lesson-desc">Kỹ thuật JOIN là trái tim của SQL — kết hợp dữ liệu từ nhiều bảng thành một kết quả thống nhất.</p>
  </div>

  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="inner-join">
        <div class="topic-heading"><span class="topic-icon">🔗</span><h2>INNER JOIN</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p><strong>INNER JOIN</strong> chỉ trả về các dòng <em>khớp với nhau</em> ở cả hai bảng. Đây là loại JOIN phổ biến nhất.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – INNER JOIN</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">USE</span> AdventureWorks2022;

<span class="cmt">-- INNER JOIN: lấy nhân viên kèm tên đầy đủ</span>
<span class="kw">SELECT</span>
    e.BusinessEntityID,
    p.FirstName <span class="op">+</span> <span class="str">' '</span> <span class="op">+</span> p.LastName <span class="kw">AS</span> FullName,
    e.JobTitle,
    e.HireDate
<span class="kw">FROM</span> HumanResources.Employee e
<span class="kw">INNER JOIN</span> Person.Person p
    <span class="kw">ON</span> e.BusinessEntityID <span class="op">=</span> p.BusinessEntityID
<span class="kw">ORDER BY</span> e.HireDate <span class="kw">DESC</span>;

<span class="cmt">-- JOIN 3 bảng cùng lúc</span>
<span class="kw">SELECT</span>
    soh.SalesOrderID,
    p.FirstName <span class="op">+</span> <span class="str">' '</span> <span class="op">+</span> p.LastName <span class="kw">AS</span> Customer,
    soh.OrderDate,
    soh.TotalDue
<span class="kw">FROM</span> Sales.SalesOrderHeader soh
<span class="kw">INNER JOIN</span> Sales.Customer c       <span class="kw">ON</span> soh.CustomerID       <span class="op">=</span> c.CustomerID
<span class="kw">INNER JOIN</span> Person.Person p        <span class="kw">ON</span> c.PersonID           <span class="op">=</span> p.BusinessEntityID
<span class="kw">ORDER BY</span> soh.TotalDue <span class="kw">DESC</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="left-right-join">
        <div class="topic-heading"><span class="topic-icon">↔️</span><h2>LEFT JOIN &amp; RIGHT JOIN</h2><span class="topic-num">02</span></div>
        <div class="prose">
          <p><strong>LEFT JOIN</strong> trả về <em>tất cả dòng từ bảng trái</em>, kèm dòng khớp từ bảng phải (NULL nếu không có).<br>
          <strong>RIGHT JOIN</strong> ngược lại — tất cả từ bảng phải.</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – LEFT JOIN</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- LEFT JOIN: hiển thị TẤT CẢ sản phẩm, kể cả chưa có trong đơn hàng</span>
<span class="kw">SELECT</span>
    p.ProductID,
    p.Name <span class="kw">AS</span> ProductName,
    sod.SalesOrderID,
    sod.OrderQty
<span class="kw">FROM</span> Production.Product p
<span class="kw">LEFT JOIN</span> Sales.SalesOrderDetail sod
    <span class="kw">ON</span> p.ProductID <span class="op">=</span> sod.ProductID
<span class="kw">ORDER BY</span> sod.SalesOrderID;

<span class="cmt">-- Tìm sản phẩm CHƯA từng được bán</span>
<span class="kw">SELECT</span> p.ProductID, p.Name
<span class="kw">FROM</span> Production.Product p
<span class="kw">LEFT JOIN</span> Sales.SalesOrderDetail sod
    <span class="kw">ON</span> p.ProductID <span class="op">=</span> sod.ProductID
<span class="kw">WHERE</span> sod.SalesOrderID <span class="kw">IS NULL</span>;  <span class="cmt">-- không có đơn hàng → chưa bán</span></code></pre>
        </div>
        <table class="compare-table">
          <thead><tr><th>Loại JOIN</th><th>Bảng trái</th><th>Bảng phải</th><th>Dùng khi nào</th></tr></thead>
          <tbody>
            <tr><td><code>INNER JOIN</code></td><td>Chỉ khớp</td><td>Chỉ khớp</td><td>Chỉ muốn dữ liệu đầy đủ 2 bên</td></tr>
            <tr><td><code>LEFT JOIN</code></td><td>Tất cả</td><td>Khớp hoặc NULL</td><td>Muốn giữ tất cả từ bảng trái</td></tr>
            <tr><td><code>RIGHT JOIN</code></td><td>Khớp hoặc NULL</td><td>Tất cả</td><td>Muốn giữ tất cả từ bảng phải</td></tr>
            <tr><td><code>FULL OUTER JOIN</code></td><td>Tất cả</td><td>Tất cả</td><td>Muốn giữ tất cả từ cả hai bảng</td></tr>
          </tbody>
        </table>
      </section>

      <section class="topic-section" id="full-outer-cross">
        <div class="topic-heading"><span class="topic-icon">⊕</span><h2>FULL OUTER JOIN &amp; CROSS JOIN</h2><span class="topic-num">03</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- FULL OUTER JOIN: tất cả từ cả hai bảng</span>
<span class="kw">SELECT</span>
    COALESCE(e.BusinessEntityID, v.BusinessEntityID) <span class="kw">AS</span> ID,
    p_e.FirstName <span class="kw">AS</span> EmployeeName,
    p_v.FirstName <span class="kw">AS</span> VendorName
<span class="kw">FROM</span> HumanResources.Employee e
<span class="kw">FULL OUTER JOIN</span> Purchasing.Vendor v
    <span class="kw">ON</span> e.BusinessEntityID <span class="op">=</span> v.BusinessEntityID
<span class="kw">LEFT JOIN</span> Person.Person p_e <span class="kw">ON</span> e.BusinessEntityID  <span class="op">=</span> p_e.BusinessEntityID
<span class="kw">LEFT JOIN</span> Person.Person p_v <span class="kw">ON</span> v.BusinessEntityID  <span class="op">=</span> p_v.BusinessEntityID;

<span class="cmt">-- CROSS JOIN: tích Đề-các (mọi tổ hợp của 2 bảng)</span>
<span class="cmt">-- 5 màu × 3 kích cỡ = 15 tổ hợp</span>
<span class="kw">SELECT</span> c.Color, s.Size
<span class="kw">FROM</span> (
    <span class="kw">SELECT DISTINCT</span> Color <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> Color <span class="kw">IS NOT NULL</span>
) c
<span class="kw">CROSS JOIN</span> (
    <span class="kw">SELECT DISTINCT</span> Size <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> Size <span class="kw">IS NOT NULL</span>
) s
<span class="kw">ORDER BY</span> c.Color, s.Size;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="self-join">
        <div class="topic-heading"><span class="topic-icon">🔄</span><h2>SELF JOIN</h2><span class="topic-num">04</span></div>
        <div class="prose">
          <p><strong>SELF JOIN</strong> là JOIN bảng với chính nó — hữu ích cho dữ liệu phân cấp như cây quản lý nhân viên (ai quản lý ai).</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – SELF JOIN (cây quản lý)</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Tìm nhân viên và người quản lý trực tiếp của họ</span>
<span class="kw">SELECT</span>
    nv.BusinessEntityID        <span class="kw">AS</span> MaNV,
    p_nv.FirstName <span class="op">+</span> <span class="str">' '</span> <span class="op">+</span> p_nv.LastName <span class="kw">AS</span> TenNhanVien,
    nv.JobTitle,
    p_ql.FirstName <span class="op">+</span> <span class="str">' '</span> <span class="op">+</span> p_ql.LastName <span class="kw">AS</span> TenQuanLy
<span class="kw">FROM</span> HumanResources.Employee nv
<span class="kw">LEFT JOIN</span> HumanResources.Employee ql
    <span class="kw">ON</span> nv.OrganizationNode.GetAncestor(<span class="num">1</span>) <span class="op">=</span> ql.OrganizationNode
<span class="kw">INNER JOIN</span> Person.Person p_nv <span class="kw">ON</span> nv.BusinessEntityID <span class="op">=</span> p_nv.BusinessEntityID
<span class="kw">LEFT JOIN</span>  Person.Person p_ql <span class="kw">ON</span> ql.BusinessEntityID <span class="op">=</span> p_ql.BusinessEntityID
<span class="kw">ORDER BY</span> nv.OrganizationLevel;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="bai-tap-join">
        <div class="topic-heading"><span class="topic-icon">📝</span><h2>Bài tập thực hành JOIN</h2><span class="topic-num">05</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Báo cáo đơn hàng chi tiết</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Báo cáo đơn hàng: khách hàng, sản phẩm, số lượng, thành tiền</span>
<span class="kw">SELECT</span>
    soh.SalesOrderID,
    soh.OrderDate,
    p.FirstName <span class="op">+</span> <span class="str">' '</span> <span class="op">+</span> p.LastName   <span class="kw">AS</span> KhachHang,
    pr.Name                              <span class="kw">AS</span> TenSanPham,
    sod.OrderQty                         <span class="kw">AS</span> SoLuong,
    sod.UnitPrice                        <span class="kw">AS</span> DonGia,
    sod.OrderQty <span class="op">*</span> sod.UnitPrice         <span class="kw">AS</span> ThanhTien
<span class="kw">FROM</span> Sales.SalesOrderHeader soh
<span class="kw">INNER JOIN</span> Sales.SalesOrderDetail sod <span class="kw">ON</span> soh.SalesOrderID <span class="op">=</span> sod.SalesOrderID
<span class="kw">INNER JOIN</span> Production.Product pr      <span class="kw">ON</span> sod.ProductID     <span class="op">=</span> pr.ProductID
<span class="kw">INNER JOIN</span> Sales.Customer c           <span class="kw">ON</span> soh.CustomerID    <span class="op">=</span> c.CustomerID
<span class="kw">LEFT JOIN</span>  Person.Person p            <span class="kw">ON</span> c.PersonID        <span class="op">=</span> p.BusinessEntityID
<span class="kw">WHERE</span> soh.OrderDate <span class="op">>=</span> <span class="str">'2014-01-01'</span>
<span class="kw">ORDER BY</span> soh.OrderDate <span class="kw">DESC</span>, ThanhTien <span class="kw">DESC</span>;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 5</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">INNER JOIN</div><div class="summary-item-value">Chỉ lấy dòng khớp hai bảng</div></div>
            <div class="summary-item"><div class="summary-item-label">LEFT JOIN</div><div class="summary-item-value">Giữ tất cả từ bảng trái</div></div>
            <div class="summary-item"><div class="summary-item-label">CROSS JOIN</div><div class="summary-item-value">Tích Đề-các (mọi tổ hợp)</div></div>
            <div class="summary-item"><div class="summary-item-label">SELF JOIN</div><div class="summary-item-value">Bảng tự JOIN với chính nó</div></div>
          </div>
        </div>
      </section>

    </div>

    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 5</div>
        <ul class="toc-list">
          <li><a href="#inner-join">1. INNER JOIN</a></li>
          <li><a href="#left-right-join">2. LEFT JOIN &amp; RIGHT JOIN</a></li>
          <li><a href="#full-outer-cross">3. FULL OUTER &amp; CROSS JOIN</a></li>
          <li><a href="#self-join">4. SELF JOIN</a></li>
          <li><a href="#bai-tap-join">5. Bài tập thực hành</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
