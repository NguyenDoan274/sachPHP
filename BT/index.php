<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài tập thực hành PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; } 
        .lab-card { transition: transform 0.2s; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .lab-card:hover { transform: translateY(-5px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .card-header { background-color: #0d6efd; color: white; font-weight: bold; }
        .list-group-item a { text-decoration: none; color: #333; display: block; }
        .list-group-item a:hover { color: #0d6efd; font-weight: 500; }
        .badge-folder { background-color: #ffc107; color: #000; margin-left: 5px; font-size: 0.7rem;}
    </style>
</head>
<body>
<?php require_once '../header.php'; ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Danh sách bài tập PHP</h1>
        <p class="lead text-muted">Tổng hợp các bài Lab thực hành</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
        <div class="col">
            <div class="card lab-card h-100">
                <div class="card-header">LAB 01: Giới thiệu PHP</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab01/index.php">index.php (Bài chính)</a></li>
                    <li class="list-group-item"><a href="lab01/1index.php">1index.php</a></li>
                    <li class="list-group-item"><a href="lab01/aha.php">aha.php</a></li>
                    <li class="list-group-item"><a href="lab01/myindex.php">myindex.php</a></li>
                    <li class="list-group-item"><a href="lab01/phpinfo.php">phpinfo.php (Cấu hình PHP)</a></li>
                    <li class="list-group-item"><a href="lab01/news/1.html">news/1.html</a></li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card lab-card h-100">
                <div class="card-header">LAB 02: Form & Cú pháp</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab02/lab2_1a.html">Bài 1a (HTML Form)</a></li>
                    <li class="list-group-item"><a href="lab02/lab2_1b.php">Bài 1b (Xử lý PHP)</a></li>
                    <li class="list-group-item"><a href="lab02/lab2_2.php">Bài 2</a></li>
                    <li class="list-group-item"><a href="lab02/lab2_3.php">Bài 3</a></li>
                    <li class="list-group-item"><a href="lab02/lab2_4.php">Bài 4</a></li>
                    <li class="list-group-item"><a href="lab02/lab2_5.php">Bài 5</a></li>
                    <li class="list-group-item"><a href="lab02/lab2_6.php">Bài 6</a></li>
                    <li class="list-group-item bg-light fw-bold text-muted small">Ví dụ thêm:</li>
                    <li class="list-group-item"><a href="lab02/vd4_5.php">Ví dụ 4.5</a></li>
                    <li class="list-group-item"><a href="lab02/vd4_6.php">Ví dụ 4.6</a></li>
                    <li class="list-group-item"><a href="lab02/vd5_1.php">Ví dụ 5.1</a></li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card lab-card h-100">
                <div class="card-header">LAB 03: Mảng & Hàm</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab03/lab3_1.php">Bài 3.1</a></li>
                    <li class="list-group-item"><a href="lab03/lab3_2.php">Bài 3.2</a></li>
                    <li class="list-group-item"><a href="lab03/lab3_3.php">Bài 3.3</a></li>
                    <li class="list-group-item"><a href="lab03/lab3_4.php">Bài 3.4</a></li>
                    <li class="list-group-item"><a href="lab03/lab3_5.php">Bài 3.5</a></li>
                    <li class="list-group-item bg-light fw-bold text-muted small">Phần 4 & 5:</li>
                    <li class="list-group-item"><a href="lab03/lab4_1.php">Bài 4.1</a></li>
                    <li class="list-group-item"><a href="lab03/lab5_1.php">Bài 5.1</a></li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card lab-card h-100">
                <div class="card-header">LAB 04: Chuỗi & Session</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab04/lab4_1.php">Bài 4.1</a></li>
                    <li class="list-group-item"><a href="lab04/lab4_2.php">Bài 4.2</a></li>
                    <li class="list-group-item"><a href="lab04/lab4_3.php">Bài 4.3</a></li>
                    <li class="list-group-item"><a href="lab04/lap4_4.php">Bài 4.4</a></li>
                    <li class="list-group-item"><a href="lab04/lab5_1.php">Bài 5.1</a></li>
                    <li class="list-group-item"><a href="lab04/lab5_2.php">Bài 5.2</a></li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card lab-card h-100">
                <div class="card-header bg-success">LAB 05: MySQL & Dự án</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab05/lab5_1.php">Bài 5.1 (Kết nối DB)</a></li>
                    <li class="list-group-item"><a href="lab05/lab5_2.php">Bài 5.2 (Hiển thị)</a></li>
                    <li class="list-group-item bg-light fw-bold text-muted small">Bài 5.3 (Thư mục):</li>
                    <li class="list-group-item"><a href="lab05/lab5_3/1.php">File 1.php</a></li>
                    <li class="list-group-item"><a href="lab05/lab5_3/2.php">File 2.php</a></li>
                    <li class="list-group-item bg-info bg-opacity-10">
                        <a href="lab05/lab5_4/index.php" class="fw-bold text-primary">
                            Bài 5.4: Dự án BookStore
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card lab-card h-100">
                <div class="card-header">LAB 06: Hướng đối tượng (OOP)</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab06/lab06_1.php">Bài 6.1</a></li>
                    <li class="list-group-item"><a href="lab06/lab06_2.php">Bài 6.2</a></li>
                    <li class="list-group-item"><a href="lab06/lab06_3.php">Bài 6.3</a></li>
                    <li class="list-group-item"><a href="lab06/4.3.php">Bài 4.3 (OOP)</a></li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card lab-card h-100 border-primary">
                <div class="card-header bg-primary">LAB 08: Tổng hợp & Nâng cao</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="lab08/lab8_1.php">Bài 8.1</a></li>
                    <li class="list-group-item"><a href="lab08/lab8_2.php">Bài 8.2</a></li>
                    <li class="list-group-item"><a href="lab08/lab8_3.php">Bài 8.3</a></li>
                    <li class="list-group-item"><a href="lab08/lab8_31.php">Bài 8.3 (Mở rộng)</a></li>
                    <li class="list-group-item bg-warning bg-opacity-10">
                        <a href="lab08/lab8_4/index.php" class="fw-bold text-dark">
                            Lab 8.4 
                        </a>
                    </li>
                    <li class="list-group-item bg-success bg-opacity-10">
                        <a href="lab08/lab8_5/index.php" class="fw-bold text-dark">
                            Lab 8.5 
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    
    <div class="text-center mt-5 text-muted small">
        &copy; <?php echo date("Y"); ?> - Tổng hợp bài tập PHP
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>