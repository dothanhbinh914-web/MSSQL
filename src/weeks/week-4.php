<?php
$pageTitle  = 'Tuần 4 – SELECT Cơ bản';
$basePath   = '../';
$phaseColor = 'phase2';
$isWeekPage = true;
$prevWeek   = 3;
$nextWeek   = 5;
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
  <nav class="breadcrumb">
    <a href="../index.php">Trang chủ</a><span class="breadcrumb-sep">›</span>
    <span style="color:var(--phase2);">Giai đoạn 2</span><span class="breadcrumb-sep">›</span>
    <span>Tuần 4</span>
  </nav>

  <div class="lesson-header">
    <div class="lesson-phase-badge" style="background:var(--phase2-bg);color:var(--phase2);border:1px solid var(--phase2-border);">Giai đoạn 2 · T-SQL từ cơ bản đến thành thạo</div>
    <div class="lesson-week-num">Tuần 4 / 22</div>
    <h1 class="lesson-title">SELECT – Truy vấn dữ liệu cơ bản</h1>
    <p class="lesson-desc">Nắm vững lệnh SELECT là nền tảng của mọi kỹ năng SQL. Học từ truy vấn đơn giản đến lọc, sắp xếp dữ liệu.</p>
  </div>

  <div class="lesson-layout">
    <div class="lesson-content">

      <section class="topic-section" id="select-from-where">
        <div class="topic-heading"><span class="topic-icon">📊</span><h2>SELECT, FROM, WHERE</h2><span class="topic-num">01</span></div>
        <div class="prose">
          <p>Cú pháp SELECT cơ bản và thứ tự thực thi logic (khác thứ tự viết code):</p>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Cú pháp SELECT & thứ tự thực thi</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Thứ tự thực thi logic (số trong ngoặc)</span>
<span class="kw">SELECT</span>   [5] cot1, cot2, bieu_thuc       <span class="cmt">-- chọn cột nào</span>
<span class="kw">FROM</span>     [1] ten_bang                    <span class="cmt">-- từ bảng nào</span>
<span class="kw">WHERE</span>    [2] dieu_kien_loc               <span class="cmt">-- lọc dòng</span>
<span class="kw">GROUP BY</span> [3] cot_nhom                    <span class="cmt">-- nhóm (tuần 6)</span>
<span class="kw">HAVING</span>   [4] dieu_kien_nhom             <span class="cmt">-- lọc nhóm (tuần 6)</span>
<span class="kw">ORDER BY</span> [6] cot_sap_xep;               <span class="cmt">-- sắp xếp</span>

<span class="cmt">-- Ví dụ thực tế với AdventureWorks</span>
<span class="kw">USE</span> AdventureWorks2022;

<span class="kw">SELECT</span>
    p.FirstName <span class="op">+</span> <span class="str">' '</span> <span class="op">+</span> p.LastName  <span class="kw">AS</span> FullName,
    e.JobTitle,
    e.HireDate
<span class="kw">FROM</span> HumanResources.Employee e
<span class="kw">INNER JOIN</span> Person.Person p <span class="kw">ON</span> e.BusinessEntityID <span class="op">=</span> p.BusinessEntityID
<span class="kw">WHERE</span> e.JobTitle <span class="kw">LIKE</span> <span class="str">'%Engineer%'</span>
<span class="kw">ORDER BY</span> p.LastName, p.FirstName;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="operators">
        <div class="topic-heading"><span class="topic-icon">🔎</span><h2>AND, OR, NOT, IN, BETWEEN</h2><span class="topic-num">02</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="kw">USE</span> AdventureWorks2022;

<span class="cmt">-- AND: tất cả điều kiện phải đúng</span>
<span class="kw">SELECT</span> ProductID, Name, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="op">></span> <span class="num">100</span>
  <span class="kw">AND</span> ListPrice <span class="op">&lt;</span> <span class="num">500</span>
  <span class="kw">AND</span> ProductSubcategoryID <span class="kw">IS NOT NULL</span>;

<span class="cmt">-- IN: thay nhiều OR (ngắn gọn hơn)</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> Color <span class="kw">IN</span> (<span class="str">'Red'</span>, <span class="str">'Blue'</span>, <span class="str">'Silver'</span>);

<span class="cmt">-- NOT IN: không thuộc danh sách</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> Color <span class="kw">NOT IN</span> (<span class="str">'Black'</span>, <span class="str">'White'</span>);

<span class="cmt">-- BETWEEN: trong khoảng (bao gồm cả 2 đầu)</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="kw">BETWEEN</span> <span class="num">100</span> <span class="kw">AND</span> <span class="num">500</span>;
<span class="cmt">-- tương đương: WHERE ListPrice >= 100 AND ListPrice <= 500</span>

<span class="cmt">-- NOT: phủ định điều kiện</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> <span class="kw">NOT</span> (ListPrice <span class="op">></span> <span class="num">1000</span>);</code></pre>
        </div>
      </section>

      <section class="topic-section" id="like-isnull">
        <div class="topic-heading"><span class="topic-icon">🔡</span><h2>LIKE, IS NULL</h2><span class="topic-num">03</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – LIKE wildcards</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- LIKE: tìm kiếm pattern trong chuỗi
-- %  = khớp với 0 hoặc nhiều ký tự bất kỳ
-- _  = khớp với đúng 1 ký tự bất kỳ
-- [] = khớp với 1 ký tự trong tập hợp
-- [^]= khớp với 1 ký tự KHÔNG trong tập hợp</span>

<span class="cmt">-- Tên bắt đầu bằng 'Mo'</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> Name <span class="kw">LIKE</span> <span class="str">'Mo%'</span>;

<span class="cmt">-- Tên chứa chữ 'ike' ở bất kỳ vị trí</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> Name <span class="kw">LIKE</span> <span class="str">'%ike%'</span>;

<span class="cmt">-- Mã sản phẩm có đúng 4 ký tự bắt đầu bằng 'BK'</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> ProductNumber <span class="kw">LIKE</span> <span class="str">'BK__'</span>;

<span class="cmt">-- IS NULL / IS NOT NULL: kiểm tra giá trị rỗng</span>
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> Color <span class="kw">IS NULL</span>;
<span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span> Production.Product <span class="kw">WHERE</span> Color <span class="kw">IS NOT NULL</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="order-top-distinct">
        <div class="topic-heading"><span class="topic-icon">📐</span><h2>ORDER BY, TOP, DISTINCT</h2><span class="topic-num">04</span></div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- ORDER BY: sắp xếp kết quả</span>
<span class="kw">SELECT</span> Name, ListPrice, Color
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> ListPrice <span class="op">></span> <span class="num">0</span>
<span class="kw">ORDER BY</span>
    ListPrice <span class="kw">DESC</span>,   <span class="cmt">-- giảm dần theo giá</span>
    Name      <span class="kw">ASC</span>;    <span class="cmt">-- tăng dần theo tên (mặc định)</span>

<span class="cmt">-- TOP: lấy N dòng đầu tiên</span>
<span class="kw">SELECT TOP</span> <span class="num">10</span> Name, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>;  <span class="cmt">-- 10 sản phẩm đắt nhất</span>

<span class="cmt">-- TOP với PERCENT</span>
<span class="kw">SELECT TOP</span> <span class="num">10</span> <span class="kw">PERCENT</span> Name, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>;

<span class="cmt">-- TOP WITH TIES: lấy cả các dòng có giá trị bằng nhau ở cuối</span>
<span class="kw">SELECT TOP</span> <span class="num">5</span> <span class="kw">WITH TIES</span> Name, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>;

<span class="cmt">-- DISTINCT: loại bỏ dòng trùng lặp</span>
<span class="kw">SELECT DISTINCT</span> Color
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> Color <span class="kw">IS NOT NULL</span>
<span class="kw">ORDER BY</span> Color;

<span class="cmt">-- DISTINCT nhiều cột: lấy tổ hợp duy nhất</span>
<span class="kw">SELECT DISTINCT</span> Color, ProductSubcategoryID
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> Color <span class="kw">IS NOT NULL</span>;</code></pre>
        </div>
      </section>

      <section class="topic-section" id="bai-tap">
        <div class="topic-heading"><span class="topic-icon">📝</span><h2>Bài tập thực hành</h2><span class="topic-num">05</span></div>
        <div class="prose">
          <p>Thực hành với database AdventureWorks2022. Tự giải trước khi xem đáp án:</p>
          <ol>
            <li>Lấy danh sách 20 sản phẩm có giá cao nhất, hiển thị tên, màu sắc, giá</li>
            <li>Tìm tất cả sản phẩm màu đỏ có giá từ 100 đến 1000</li>
            <li>Lấy danh sách các màu sắc duy nhất của sản phẩm (loại bỏ NULL)</li>
            <li>Tìm nhân viên được tuyển dụng từ năm 2010 đến 2015</li>
            <li>Lấy 10 đơn hàng gần nhất theo ngày đặt hàng</li>
          </ol>
        </div>
        <div class="code-block">
          <div class="code-header"><span class="code-lang">T-SQL – Đáp án tham khảo</span><button class="copy-btn">Copy</button></div>
          <pre><code><span class="cmt">-- Bài 1</span>
<span class="kw">SELECT TOP</span> <span class="num">20</span> Name, Color, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">ORDER BY</span> ListPrice <span class="kw">DESC</span>;

<span class="cmt">-- Bài 2</span>
<span class="kw">SELECT</span> Name, Color, ListPrice
<span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> Color <span class="op">=</span> <span class="str">'Red'</span>
  <span class="kw">AND</span> ListPrice <span class="kw">BETWEEN</span> <span class="num">100</span> <span class="kw">AND</span> <span class="num">1000</span>;

<span class="cmt">-- Bài 3</span>
<span class="kw">SELECT DISTINCT</span> Color <span class="kw">FROM</span> Production.Product
<span class="kw">WHERE</span> Color <span class="kw">IS NOT NULL</span> <span class="kw">ORDER BY</span> Color;

<span class="cmt">-- Bài 4</span>
<span class="kw">SELECT</span> BusinessEntityID, HireDate, JobTitle
<span class="kw">FROM</span> HumanResources.Employee
<span class="kw">WHERE</span> HireDate <span class="kw">BETWEEN</span> <span class="str">'2010-01-01'</span> <span class="kw">AND</span> <span class="str">'2015-12-31'</span>
<span class="kw">ORDER BY</span> HireDate;

<span class="cmt">-- Bài 5</span>
<span class="kw">SELECT TOP</span> <span class="num">10</span> SalesOrderID, OrderDate, TotalDue
<span class="kw">FROM</span> Sales.SalesOrderHeader
<span class="kw">ORDER BY</span> OrderDate <span class="kw">DESC</span>;</code></pre>
        </div>
        <div class="summary-box">
          <div class="summary-box-title">🎯 Tóm tắt tuần 4</div>
          <div class="summary-grid">
            <div class="summary-item"><div class="summary-item-label">Lệnh chính</div><div class="summary-item-value">SELECT · FROM · WHERE</div></div>
            <div class="summary-item"><div class="summary-item-label">Toán tử lọc</div><div class="summary-item-value">AND · OR · IN · BETWEEN</div></div>
            <div class="summary-item"><div class="summary-item-label">Chuỗi</div><div class="summary-item-value">LIKE (%, _, [])</div></div>
            <div class="summary-item"><div class="summary-item-label">Sắp xếp</div><div class="summary-item-value">ORDER BY · TOP · DISTINCT</div></div>
          </div>
        </div>
      </section>

    </div><!-- /lesson-content -->

    <aside class="lesson-sidebar">
      <div class="toc">
        <div class="toc-title">Nội dung tuần 4</div>
        <ul class="toc-list">
          <li><a href="#select-from-where">1. SELECT, FROM, WHERE</a></li>
          <li><a href="#operators">2. AND, OR, NOT, IN, BETWEEN</a></li>
          <li><a href="#like-isnull">3. LIKE, IS NULL</a></li>
          <li><a href="#order-top-distinct">4. ORDER BY, TOP, DISTINCT</a></li>
          <li><a href="#bai-tap">5. Bài tập thực hành</a></li>
        </ul>
      </div>
    </aside>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
