<!DOCTYPE html>
<html>

<head>
    <title>Kiểm tra mã sinh viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css
">
</head>

<body class="container mt-3">
    <!-- <h2>Nhập mã sinh viên để kiểm tra</h2>
    <form method="post" class="mb-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" class="form-control" name="ma_sv" placeholder="VD: DH52123456" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Kiểm tra</button>
            </div>
        </div>
    </form> -->

    <h2>Nhập mã sinh viên để kiểm tra</h2>
    <form method="post" class="mb-3">
        <div class="d-flex gap-2 align-items-center">
            <input type="text" class="form-control form-control-md" name="ma_sv" placeholder="VD: DH52123456" required>
            <button type="submit" class="btn btn-primary btn-md w-50">Kiểm tra</button>
        </div>
    </form>
    <?php
    // Khai báo bảng ánh xạ hệ đào tạo bên ngoài hàm
    $heMap = [
        'DH' => 'Đại học',
        'CD' => 'Cao đẳng',
        'LT' => 'Liên thông'
    ];

    // Khai báo bảng ánh xạ mã khoa bên ngoài hàm
    $khoaMap = [
        '5' => 'Công nghệ thông tin',
        '6' => 'Cơ khí',
        '7' => 'Quản trị kinh doanh',
        '8' => 'Công nghệ thực phẩm'
    ];

    // Xử lý khi form được gửi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maSV = strtoupper(trim($_POST["ma_sv"]));
        kiemTraMaSinhVien($maSV, $heMap, $khoaMap);
    }

    // Hàm kiểm tra mã sinh viên
    function kiemTraMaSinhVien($maSV, $heMap, $khoaMap)
    {
        // Biểu thức Regex: hệ (DH|CD|LT) + mã khoa (1 ký tự) + mã khóa (1 ký tự) + 6 số
        $regex = '/^(DH|CD|LT)(\d)(\d{2})(\d{5})$/';

        if (preg_match($regex, $maSV, $matches)) {
            $heDaoTao = $matches[1];     // DH, CD, LT
            $maKhoa = $matches[2];       // 5, 6, 7, 8
            $maKhoaHoc = $matches[3];    // 2 ký tự
            $soDinhDanh = $matches[4];   //5 số cuối

            // Tra cứu hệ đào tạo và khoa
            $he = $heMap[$heDaoTao] ?? 'Không xác định';
            $khoa = $khoaMap[$maKhoa] ?? 'Không xác định';

            // Tính năm khóa học
            $namKhoa = 2000 + intval($maKhoaHoc);

            // Hiển thị kết quả
            echo "<h3>Kết quả kiểm tra:</h3>";
            echo "<ul>";
            echo "<li>📌 MSSV: <strong>$maSV</strong></li>";
            echo "<li>✅ Hệ đào tạo: <strong>$he</strong></li>";
            echo "<li>🏫 Khoa: <strong>$khoa</strong></li>";
            echo "<li>🎓 Khóa học: <strong>$namKhoa</strong></li>";
            echo "<li>🔢 Số định danh: <strong>$soDinhDanh</strong></li>";
            echo "</ul>";
            $index0 = $matches[0];
            echo $index0;
        } else {
            echo "<p style='color:red;'>❌ Mã sinh viên không hợp lệ. Mã hợp lệ gồm: 10 ký tự. <br/> Vui lòng nhập đúng định dạng.</p>";
        }
    }
    echo '<pre>';
    print_r($heMap);
    print_r($khoaMap);
    ?>
</body>

</html>