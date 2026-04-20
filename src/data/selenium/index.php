<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>PHP Selenium API - Hướng dẫn sử dụng</title>
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.55; margin: 32px; color: #222; }
    h1, h2, h3 { margin-top: 28px; }
    code { background: #f4f4f4; padding: 2px 6px; border-radius: 4px; }
    pre { background: #f7f7f7; padding: 14px; border-radius: 8px; overflow-x: auto; border: 1px solid #e5e5e5; }
    .box { background: #fafafa; border: 1px solid #e5e5e5; padding: 16px; border-radius: 8px; margin: 16px 0; }
    .ok { color: #0a7a2f; }
    .warn { color: #b26a00; }
    table { border-collapse: collapse; width: 100%; margin: 16px 0; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: top; }
    th { background: #f3f3f3; }
    a { color: #0b57d0; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h1>PHP Selenium API</h1>
  <p>Project này có 2 API chính:</p>
  <ul>
    <li><code>capture.php</code>: chụp ảnh website và trả về PNG</li>
    <li><code>render-html.php</code>: lấy HTML sau khi trang đã render bằng Chrome</li>
  </ul>

  <div class="box">
    <strong>Yêu cầu:</strong>
    <ul>
      <li>Container Selenium đang chạy ở <code>http://selenium:4444</code></li>
      <li>Project được đặt trong web root của Nginx/PHP</li>
      <li>PHP có extension cURL</li>
    </ul>
  </div>

  <h2>1. API chụp ảnh</h2>
  <p>Endpoint:</p>
  <pre>/capture.php?url=https://example.com</pre>

  <h3>Ví dụ</h3>
  <pre>/capture.php?url=https://example.com
/capture.php?url=https://example.com&full=1
/capture.php?url=https://example.com&wait=5
/capture.php?url=https://example.com&width=1440&height=900
/capture.php?url=https://example.com&debug=1</pre>

  <h3>Tham số hỗ trợ</h3>
  <table>
    <tr><th>Tham số</th><th>Bắt buộc</th><th>Mô tả</th><th>Ví dụ</th></tr>
    <tr><td><code>url</code></td><td>Có</td><td>URL cần chụp</td><td><code>?url=https://example.com</code></td></tr>
    <tr><td><code>full</code></td><td>Không</td><td>Nếu có thì chụp full page</td><td><code>&full=1</code></td></tr>
    <tr><td><code>wait</code></td><td>Không</td><td>Số giây chờ sau khi mở trang. Mặc định là 3</td><td><code>&wait=5</code></td></tr>
    <tr><td><code>width</code></td><td>Không</td><td>Chiều rộng browser. Mặc định 1366</td><td><code>&width=1440</code></td></tr>
    <tr><td><code>height</code></td><td>Không</td><td>Chiều cao viewport ban đầu. Mặc định 1000</td><td><code>&height=900</code></td></tr>
    <tr><td><code>debug</code></td><td>Không</td><td>Nếu có thì bỏ headless để xem browser qua cổng 7900</td><td><code>&debug=1</code></td></tr>
    <tr><td><code>user_agent</code></td><td>Không</td><td>Gắn user-agent tùy chỉnh cho Chrome</td><td><code>&user_agent=Mozilla...</code></td></tr>
  </table>

  <h3>Kết quả trả về</h3>
  <p>API này trả về trực tiếp file ảnh PNG với header <code>Content-Type: image/png</code>.</p>

  <h2>2. API HTML sau render</h2>
  <p>Endpoint:</p>
  <pre>/render-html.php?url=https://example.com</pre>

  <h3>Ví dụ</h3>
  <pre>/render-html.php?url=https://example.com
/render-html.php?url=https://example.com&wait=5
/render-html.php?url=https://example.com&pretty=1
/render-html.php?url=https://example.com&debug=1</pre>

  <h3>Tham số hỗ trợ</h3>
  <table>
    <tr><th>Tham số</th><th>Bắt buộc</th><th>Mô tả</th><th>Ví dụ</th></tr>
    <tr><td><code>url</code></td><td>Có</td><td>URL cần lấy HTML sau render</td><td><code>?url=https://example.com</code></td></tr>
    <tr><td><code>wait</code></td><td>Không</td><td>Số giây chờ sau khi mở trang. Mặc định là 3</td><td><code>&wait=5</code></td></tr>
    <tr><td><code>width</code></td><td>Không</td><td>Chiều rộng browser. Mặc định 1366</td><td><code>&width=1440</code></td></tr>
    <tr><td><code>height</code></td><td>Không</td><td>Chiều cao viewport ban đầu. Mặc định 1000</td><td><code>&height=900</code></td></tr>
    <tr><td><code>debug</code></td><td>Không</td><td>Nếu có thì bỏ headless để xem browser qua cổng 7900</td><td><code>&debug=1</code></td></tr>
    <tr><td><code>user_agent</code></td><td>Không</td><td>Gắn user-agent tùy chỉnh cho Chrome</td><td><code>&user_agent=Mozilla...</code></td></tr>
    <tr><td><code>pretty</code></td><td>Không</td><td>Nếu có thì escape HTML và hiển thị trong thẻ <code>&lt;pre&gt;</code> để dễ đọc</td><td><code>&pretty=1</code></td></tr>
  </table>

  <h3>Kết quả trả về</h3>
  <p>Mặc định API trả đúng HTML sau render. Nếu dùng <code>pretty=1</code> thì API hiển thị HTML dạng text để dễ copy/xem source.</p>

  <h2>3. Gợi ý dùng với cURL</h2>
  <pre>curl "http://localhost:8080/capture.php?url=https://example.com" --output shot.png

curl "http://localhost:8080/capture.php?url=https://example.com&full=1&wait=5" --output full.png

curl "http://localhost:8080/render-html.php?url=https://example.com&pretty=1"</pre>

  <h2>4. Debug qua cổng 7900</h2>
  <p>Nếu dùng <code>debug=1</code>, Chrome sẽ chạy có giao diện. Bạn có thể mở:</p>
  <pre>http://server-ip:7900</pre>
  <p>Password thường là <code>secret</code>.</p>

  <h2>5. Lỗi thường gặp</h2>
  <table>
    <tr><th>Lỗi</th><th>Nguyên nhân hay gặp</th><th>Cách xử lý</th></tr>
    <tr><td><code>Cannot create session</code></td><td>Selenium chưa sẵn sàng hoặc payload lỗi</td><td>Kiểm tra <code>http://selenium:4444/status</code></td></tr>
    <tr><td><code>Missing url</code></td><td>Thiếu tham số <code>url</code></td><td>Thêm <code>?url=https://...</code></td></tr>
    <tr><td><code>Invalid url</code></td><td>URL không hợp lệ</td><td>Dùng URL đầy đủ, có <code>http://</code> hoặc <code>https://</code></td></tr>
    <tr><td>Ảnh bị cắt</td><td>Viewport thấp hoặc chưa dùng full page</td><td>Thử <code>full=1</code> hoặc tăng <code>height</code></td></tr>
    <tr><td>Không thấy browser ở 7900</td><td>Đang chạy headless</td><td>Thêm <code>debug=1</code></td></tr>
  </table>

  <h2>6. File trong project</h2>
  <ul>
    <li><code>index.php</code>: trang hướng dẫn này</li>
    <li><code>common.php</code>: hàm gọi Selenium</li>
    <li><code>capture.php</code>: API chụp ảnh</li>
    <li><code>render-html.php</code>: API lấy HTML sau render</li>
  </ul>
</body>
</html>
