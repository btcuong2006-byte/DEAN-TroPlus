<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: rgb(249, 251, 255);
        }

        .nav-hover {
            color: gray;
        }

        .nav-hover:hover {
            color: blue;
        }

        .nhato {
            border-radius: 20px;
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .highlight {
            color: blue;
        }

        .stats-list {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .stats-number {
            font-weight: 700;
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: -6px;
        }

        .end-number {
            font-size: 0.8em;
            color: #6c757d;
        }

        .a {
            font-weight: 700;
            font-size: 1rem;
            color: #1a1a2e;
            margin: 0;
            line-height: 1.3;
        }

        .b {
            font-size: 0.7em;
            color: #6c757d;
            margin: 0;
        }

        .slogan {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .badge-tag {
            border-radius: 999px;
            color: rgba(25, 135, 84, 0.7);
            background-color: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.4);
            font-size: 0.90em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 6px 16px;
            pointer-events: none;
            /* ✅ bỏ hover */
        }

        .box {
            padding: 12px 16px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: absolute;
            /* ✅ nằm đè lên ảnh */
            bottom: 20px;
            /* ✅ cách đáy ảnh 20px */
            left: 20px;
            /* ✅ cách lề trái 20px */
            right: 20px;

            z-index: 10;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .box-2 {
            padding: 12px 16px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: absolute;
            /* ✅ nằm đè lên ảnh */
            top: -20px;
            /* ✅ cách đáy ảnh 20px */
            width: auto;
            /* ✅ cách lề trái 20px */
            right: -20px;
            z-index: 10;
            animation: bounce 2s ease-in-out infinite;
            /* ✅ thêm dòng này */

        }

        .img-wrapper {
            position: relative;
            /* ✅ làm cha cho box */
            display: inline-block;
            width: 100%;
        }

        .nhato {
            border-radius: 20px;
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .icon-wrap {
            background-color: #d1fae5;
            border-radius: 10px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .find {
            width: 1000px;
            height: 120px;
            border-radius: 10px;
            display: flex;
        
            align-items: center;
            /* ✅ căn giữa theo chiều dọc */
            justify-content: center;
            /* ✅ căn giữa theo chiều ngang */
            gap: 10px;
            /* ✅ khoảng cách giữa các select */
            padding: 0 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-top: 70px;
        }

        .find select {
            height: 40px;
            width: 180px;
            flex-shrink: 0;
            border-radius: 7px;
            padding: 10px;
            margin-bottom: 20px;
            border: #6c757d solid 2px;
        }

        .find button {
            height: 40px;
            flex-shrink: 0;
            width: 180px;
        }

        .find label {
            color: #6c757d;
            padding-bottom: 5px;
        }

        .banner {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px;
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="btn btn-primary me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                </svg>
            </button>
            <a class="navbar-brand" href="#">TroPlus</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link nav-hover" href="#">Trang chủ</a>
                    <a class="nav-link nav-hover" href="#">Tìm Phòng</a>
                    <a class="nav-link nav-hover" href="#">Bản Đồ</a>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn nav-hover">Đăng Nhập</button>
                    <button class="btn btn-primary">Đăng Ký</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header>
        <div class="container pt-4">
            <div class="row align-items-center">

                <!-- Cột trái -->
                <div class="col d-flex flex-column align-items-start text-start">
                    <p class="badge-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                        </svg>
                        Nền tảng thuê phòng #1 Việt Nam
                    </p>

                    <h1><b>Tìm phòng trọ <br>
                            <span class="highlight">Nhanh Chóng</span> và <br>
                            <span class="highlight">Minh Bạch</span>
                        </b></h1>

                    <p class="slogan">Hàng ngàn phòng trọ được xác minh, đánh giá thực từ khách thuê. Kết nối trực tiếp với chủ trọ uy tín.</p>

                    <div class="d-flex gap-2">
                        <button class="btn btn-dark ps-4 pe-4 p-2 rounded-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                            <span class="m-2">Tìm phòng ngay</span>
                        </button>
                        <button class="btn btn-outline-secondary ps-4 pe-4 p-2 rounded-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                            <span class="m-2">Xem bản đồ</span>
                        </button>
                    </div>

                    <ul class="stats-list">
                        <li>
                            <p class="stats-number">5,000+</p>
                            <p class="end-number">Phòng Trọ</p>
                        </li>
                        <li>
                            <p class="stats-number">5,000+</p>
                            <p class="end-number">Người Thuê</p>
                        </li>
                        <li>
                            <p class="stats-number">5,000+</p>
                            <p class="end-number">Hài Lòng</p>
                        </li>
                    </ul>
                </div>

                <!-- Cột phải -->
                <div class="col">
                    <div class="img-wrapper">
                        <div class="box-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="a">4.8/5</p>
                                    <p class="b">Đánh giá</p>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="#198754" class="bi bi-shield-check" viewBox="0 0 16 16">
                                        <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56" />
                                        <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                    </svg>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="a">Phòng đã xác minh</p>
                                    <p class="b">Tất cả phòng được kiểm tra thực tế</p>
                                </div>
                            </div>
                        </div>

                        <img class="nhato" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- Thanh tìm kiếm -->
        <div class="banner">
            <div class="find">
                <div class="sleclect-group">
                    <label for="ThanhPho">Thành Phố
                        <select name="ThanhPho" id="ThanhPho">
                            <option value="ThanhPho">Tất Cả Thành Phố </option>
                            <option value="ThanhPho">Hồ Chí minh</option>
                            <option value="ThanhPho">Hà Nội</option>
                            <option value="ThanhPho">Thanh Hoá</option>
                            <option value="ThanhPho">Nam Định</option>
                        </select></label>
                </div>
                <div class="sleclect-group">
                    <label for="Quan/Huyen">Quận / Huyện
                        <select name="Quan/Huyen" id="">
                            <option value="Quan/Huyen">Tất Cả Quận/Huyện</option>

                        </select>
                    </label>
                </div>
                <div class="sleclect-group">
                    <label for="LoaiPhong">Loại Phòng
                        <select name="LoaiPhong" id="">
                            <option value="LoaiPhong">Tất Cả Loại Phòng </option>

                        </select>
                    </label>
                </div>
                <div class="sleclect-group">
                    <label for="KhoangGia">Khoảng Giá
                        <select name="KhoangGia" id="">
                            <option value="KhoangGia">Tất Cả Giá </option>
                        </select>
                    </label>
                </div>
                <button class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
</svg> tìm kiếm</button>
            </div>
        </div>

        <!-- Card -->
    


    </header>

</body>

</html>