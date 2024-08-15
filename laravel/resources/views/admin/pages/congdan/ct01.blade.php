@php
    use App\Helpers\Template;
    $genderEnum = Config::get('custom.enum.gender');

    $case = ($case == 'GH') ? 'Xin gia hạn' : 'Xin đăng ký';
    $fullname = $data['fullname'];
    $dob = Template::showDate($data['dob'], false, '/');
    $gender = $genderEnum[$data['gender']];
    $cccd = str_split($data['cccd_number']);
@endphp

<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }

        .normal-text {
            font-family: 'Times New Roman, serif, sans-serif';
            margin: 5px;
        }

        .height-high {
            height: 5px;
        }

        .height-normal {
            height: 3px;
        }

        .font-size11 {
            font-size: 11pt;
        }

        .font-size13 {
            font-size: 13pt;
        }

        .font-size14 {
            font-size: 14pt;
        }

        .font-size16 {
            font-size: 16pt;
        }

        .body {
            border: 1px solid black;
            padding: 10px 25px;
            margin: 10px;
        }

        .cccd {
            border: 1px solid black;
            margin-right: -1px;
            padding-top: 5px;
            height: 40px !important;
            width: 35px !important;
            flex: 0;
            font-weight: bold;
        }

        .white {
            color: #fff;
        }

        .line-cccd {
            height: 50px;
        }

        .line-square-cccd{
            height: 40px;
        }

        .padding-top-5 {
            padding-top: 5px;
        }
        .nhan-khau-table .col {
            border: 1px solid black;
            margin-right: -1px;
            padding-top: 5px;
            font-weight: bold;
        }
        .nhan-khau-table {
            margin: 0px 8px;
        }

        .tb-tt, .tb-gender {
            flex: 0;
        }
        .table {
            border: 1px solid black;
            font-size: 14pt;
            font-family: 'Times New Roman, serif, sans-serif';

        }
    </style>
</head>

<body class="body">
    <div class="height-high"></div>
    <p class="center normal-text font-size11">Mẫu CT01 ban hành kèm theo Thông tư số 66/2023/TT-BCA <br> ngày 17/11/2023 của Bộ trưởng Bộ Công an</p>
    <div class="height-high"></div>
    <p class="center normal-text font-size14"><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM <br> <u>Độc lập – Tự do – Hạnh phúc</u></strong></p>
    <div class="height-high"></div>
    <p class="center normal-text font-size16"><strong>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</strong></p>
    <div class="height-normal"></div>
    <p class="center normal-text font-size14">Kính gửi: CÔNG AN PHƯỜNG 13, QUẬN BÌNH THẠNH</p>
    <div class="height-normal"></div>
    <span class="normal-text font-size14">1. Họ, chữ đệm và tên: <strong>{{ $fullname }}</strong></span>

    <div class="row">
        <div class="col-5">
            <p class="normal-text font-size14">2. Ngày, tháng, năm sinh: <strong>{{ $dob }}</strong></p>
        </div>
        <div class="col-5">
            <p class="normal-text font-size14">3. Giới tính: <strong>{{ $gender }}</strong></p>
        </div>
    </div>
    <div class="row line-cccd">
        <div class="col-3">
            <p class="normal-text font-size14 padding-top-5">4. Số định danh cá nhân: </p>
        </div>
        <div class="col-8 container text-center normal-text font-size14">
            <div class="row line-square-cccd">
                <div class="col cccd">0</div>
                @foreach ($cccd as $item)
                    <div class="col cccd">{{ $item }}</div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <p class="normal-text font-size14">5. Số điện thoại liên hệ: ........................................ </p>
        </div>
        <div class="col-5">
            <p class="normal-text font-size14">6. Email: ......................... </p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p class="normal-text font-size14">7. Họ, chữ đệm và tên chủ hộ: <strong>{{ $fullname }}</strong> </p>
        </div>
        <div class="col-4">
            <p class="normal-text font-size14">8. Mối quan hệ với chủ hộ: <strong>Chủ Hộ</strong> </p>
        </div>
    </div>
    <div class="row line-cccd">
        <div class="col-4">
            <p class="normal-text font-size14 padding-top-5">9. Số định danh cá nhân của chủ hộ: </p>
        </div>
        <div class="col-7 container text-center normal-text font-size14">
            <div class="row line-square-cccd">
                <div class="col cccd">0</div>
                @foreach ($cccd as $item)
                    <div class="col cccd">{{ $item }}</div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-11">
            <p class="normal-text font-size14">10. Nội dung đề nghị: <strong>{{ $case }} tạm trú tại số nhà 467/62A Nơ Trang Long, phường 13, quận Bình Thạnh, thành phố Hồ Chí Minh.</strong></p>
        </div>
    </div>
    <div class="row">
        <div class="col-11">
            <p class="normal-text font-size14">11. Những thành viên trong hộ gia đình cùng thay đổi:</strong></p>
        </div>
    </div>
    <div class="row nhan-khau-table center">
        <table class="table table-bordered center">
            <thead>
              <tr>
                <th scope="col">Số<br>TT</th>
                <th scope="col">Họ, chữ đệm<br>và tên</th>
                <th scope="col">Ngày, tháng, <br>năm sinh</th>
                <th scope="col">Giới<br>tính</th>
                <th scope="col">Số định danh<br>cá nhân</th>
                <th scope="col">Mối quan hệ<br>với chủ hộ</th>
              </tr>
            </thead>
            <tbody>
                @for($i=1;$i<=5;$i++)
                    <tr>
                        <th scope="row">{{$i}}</th>
                        <td>HUỲNH THANH TÙNG</td>
                        <td>27/12/1990</td>
                        <td>Nam</td>
                        <td>079090021500</td>
                        <td>Chủ Hộ</td>
                    </tr>
                @endfor
            </tbody>
          </table>
    </div>
    <div class="row center">
        <div class="col">
            <p class="normal-text font-size11"><i>.....,ngày.......tháng....năm.......</i><br><strong>Ý KIẾN CỦA CHỦ HỘ</strong></p>
        </div>
        <div class="col">
            <p class="normal-text font-size11"><i>.....,ngày.......tháng....năm.......</i><br><strong>Ý KIẾN CỦA CHỦ SỞ HỮU<br>CHỖ Ở HỢP PHÁP</strong></p>
            <br><br><br><br><br><br>
        </div>
        <div class="col">
            <p class="normal-text font-size11"><i>.....,ngày.......tháng....năm.......</i><br><strong>Ý KIẾN CỦA CHA, MẸ<br>HOẶC NGƯỜI GIÁM HỘ</strong></p>
        </div>
        <div class="col">
            <p class="normal-text font-size11"><i>.....,ngày.......tháng....năm.......</i><br><strong>NGƯỜI KÊ KHAI</strong></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
