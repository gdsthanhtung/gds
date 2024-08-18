@php
    $fontPathN = public_path('admin/asset/fonts/Times New Roman.ttf');
    $fontPathI = public_path('admin/asset/fonts/Times New Roman Italic.ttf');
    $fontPathB = public_path('admin/asset/fonts/Times New Roman Bold.ttf');
    $fontPathA = public_path('admin/asset/fonts/Times New Roman Bold Italic.ttf');

    use App\Helpers\Template;
    $genderEnum = Config::get('custom.enum.gender');

    $case = ($case == 'GH') ? 'Xin gia hạn' : 'Xin đăng ký';
    $fullname = $data['fullname'];
    $dob = Template::showDate($data['dob'], false, '/');
    $gender = $genderEnum[$data['gender']];
    $cccd = str_split($data['cccd_number']);

    $fontSizeChuHo = (in_array($id, Config::get('custom.enum.longNameId'))) ? 'size12' : 'size13';
@endphp

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CT01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: 'Times New Roman';
            src: url({{ $fontPathN }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: url({{ $fontPathB }}) format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: url({{ $fontPathI }}) format('truetype');
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: url({{ $fontPathA }}) format('truetype');
            font-weight: bold;
            font-style: italic;
        }

        body {
            font-family: 'Times New Roman';
            /* border: 1px solid black; */
            line-height: 90%;
        }

        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }

        .normal-text {
            margin: 5px;
        }

        .height-high {
            height: 5px;
        }

        .height-normal {
            height: 3px;
        }

        .font-size10 {
            font-size: 10pt;
        }
        .font-size11 {
            font-size: 11pt;
        }
        .font-size12 {
            font-size: 12pt;
        }

        .font-size13 {
            font-size: 13pt;
        }
        .font-size14 {
            font-size: 14pt;
        }
        .font-size15 {
            font-size: 15pt;
        }

        .font-size16 {
            font-size: 16pt;
        }.font-size17 {
            font-size: 17pt;
        }

        .cccd {
            border: 1px solid black;
            margin-right: -1px;
            padding-top: 5px;
            height: 35px !important;
            width: 30px !important;
            flex: 0;
            font-weight: bold;
        }

        .white {
            color: #fff;
        }

        .padding-top-5 {
            padding-top: 5px;
        }

        .table {
            border-collapse: collapse;
            line-height: 90%;
        }

        .td-cccd{
            font-size: 14pt;
            border: 1px solid black;
            padding: 1px;
            height: 30px !important;
            width: 25px !important;
            font-weight: bold;
        }

        .tdh-nhan-khau {
            border: 1px solid black;
            height: 30px;
        }

        .tb-nhan-khau{
            width: 100%;
            font-size: 12pt;
        }


    </style>
</head>

<body class="body">
    <div class="height-high"></div>
    <p class="center normal-text font-size11">Mẫu CT01 ban hành kèm theo Thông tư số 66/2023/TT-BCA <br> ngày 17/11/2023 của Bộ trưởng Bộ Công an</p>
    <div class="height-high"></div>
    <p class="center normal-text font-size13"><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM <br> <u>Độc lập – Tự do – Hạnh phúc</u></strong></p>
    <div class="height-high"></div>
    <p class="center normal-text font-size17"><strong>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</strong></p>
    <div class="height-normal"></div>
    <p class="center normal-text font-size13">Kính gửi: CÔNG AN PHƯỜNG 13, QUẬN BÌNH THẠNH</p>
    <div class="height-normal"></div>
    <div class="row">
        <table>
            <tr>
                <td>
                    <p class="normal-text font-size13">1. Họ, chữ đệm và tên: <strong>{{ $fullname }}</strong></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table>
            <tr>
                <td>
                    <p class="normal-text font-size13">2. Ngày, tháng, năm sinh: <strong>{{ $dob }}</strong></p>
                </td>
                <td>
                    <p class="normal-text font-size13 white"> ---------- </p>
                </td>
                <td>
                    <p class="normal-text font-size13">3. Giới tính: <strong>{{ $gender }}</strong></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table>
            <tr>
                <td>
                    <p class="normal-text font-size13">4. Số định danh cá nhân: </p>
                </td>
                <td>
                    <p class="normal-text font-size13 white"> - </p>
                </td>
                <td>
                    <table class="table table-bordered center">
                        <tr>
                            @foreach ($cccd as $item)
                                <td class="td-cccd">
                                    {{ $item }}
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table>
            <tr>
                <td>
                    <p class="normal-text font-size13">5. Số điện thoại liên hệ: ........................................ </p>
                </td>
                <td>
                    <p class="normal-text font-size13 white"> --- </p>
                </td>
                <td>
                    <p class="normal-text font-size13">6. Email: ..................................... </p>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table>
            <tr>
                <td>
                    <p class="normal-text font-{{$fontSizeChuHo}}">
                        7. Họ, chữ đệm và tên chủ hộ: <strong>{{ $fullname }}</strong>
                        <span class="white">-</span>
                        8. Mối quan hệ với chủ hộ: <strong>Chủ Hộ</strong>
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table>
            <tr>
                <td>
                    <p class="normal-text font-size13">9. Số định danh cá nhân của chủ hộ: </p>
                </td>
                <td>
                    <p class="normal-text font-size13 white"> - </p>
                </td>
                <td>
                    <table class="table table-bordered center">
                        <tr>
                            @foreach ($cccd as $item)
                                <td class="td-cccd">
                                    {{ $item }}
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>


    <div class="row">
        <div class="col-11">
            <p class="normal-text font-size13">10. Nội dung đề nghị: <strong>{{ $case }} tạm trú tại số nhà 467/62A Nơ Trang Long, phường 13, quận Bình Thạnh, thành phố Hồ Chí Minh.</strong></p>
        </div>
    </div>
    <div class="row">
        <div class="col-11">
            <p class="normal-text font-size13">11. Những thành viên trong hộ gia đình cùng thay đổi:</strong></p>
        </div>
    </div>

    <div class="row">
        <table class="table table-bordered center tb-nhan-khau">
            <thead>
              <tr>
                <th class="tdh-nhan-khau" width="40px">TT</th>
                <th class="tdh-nhan-khau">Họ, chữ đệm<br>và tên</th>
                <th class="tdh-nhan-khau" width="100px">Ngày, tháng,<br>năm sinh</th>
                <th class="tdh-nhan-khau" width="50px">Giới<br>tính</th>
                <th class="tdh-nhan-khau" width="120px">Số định danh<br>cá nhân</th>
                <th class="tdh-nhan-khau" width="120px">Mối quan hệ<br>với chủ hộ</th>
              </tr>
            </thead>
            <tbody>
                @for($i=1;$i<=8;$i++)
                    @if($i == 1)
                        <tr>
                            <th class="tdh-nhan-khau">{{$i}}</th>
                            <td class="tdh-nhan-khau">NGUYỄN THỊ BÍCH VÂN</td>
                            <td class="tdh-nhan-khau">27/12/1990</td>
                            <td class="tdh-nhan-khau">Nam</td>
                            <td class="tdh-nhan-khau">079090021500</td>
                            <td class="tdh-nhan-khau">Mẹ</td>
                        </tr>
                    @elseif($i == 2)
                        <tr>
                            <th class="tdh-nhan-khau">{{$i}}</th>
                            <td class="tdh-nhan-khau">HUỲNH VĂN SƠN</td>
                            <td class="tdh-nhan-khau">27/12/1990</td>
                            <td class="tdh-nhan-khau">Nam</td>
                            <td class="tdh-nhan-khau">079090021500</td>
                            <td class="tdh-nhan-khau">Ba</td>
                        </tr>
                    @else
                    <tr>
                        <th class="tdh-nhan-khau"></th>
                        <th class="tdh-nhan-khau"></th>
                        <th class="tdh-nhan-khau"></th>
                        <th class="tdh-nhan-khau"></th>
                        <th class="tdh-nhan-khau"></th>
                        <th class="tdh-nhan-khau"></th>
                    </tr>
                    @endif

                @endfor
            </tbody>
          </table>
    </div>

    <div class="row">
        <table class="center" style="width: 100%">
            <tr>
                <td width="22%">
                    <p class="font-size10"><i>.....,ngày.......tháng....năm.......</i><br><strong>Ý KIẾN CỦA CHỦ HỘ</strong></p>
                    <span class="white">-</span>
                </td>
                <td width="28%">
                    <p class="font-size10"><i>.....,ngày.......tháng....năm.......</i><br><strong>Ý KIẾN CỦA CHỦ SỞ HỮU<br>CHỖ Ở HỢP PHÁP</strong></p>
                </td>
                <td width="28%">
                    <p class="font-size10"><i>.....,ngày.......tháng....năm.......</i><br><strong>Ý KIẾN CỦA CHA, MẸ<br>HOẶC NGƯỜI GIÁM HỘ</strong></p>
                </td>
                <td width="22%">
                    <p class="font-size10"><i>.....,ngày.......tháng....năm.......</i><br><strong>NGƯỜI KÊ KHAI</strong></p>
                    <span class="white">-</span>
                </td>
            </tr>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
