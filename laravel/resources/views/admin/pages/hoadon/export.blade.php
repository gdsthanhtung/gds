@php
    $fontPathN = public_path('admin/asset/fonts/Times New Roman.ttf');
    $fontPathI = public_path('admin/asset/fonts/Times New Roman Italic.ttf');
    $fontPathB = public_path('admin/asset/fonts/Times New Roman Bold.ttf');
    $fontPathA = public_path('admin/asset/fonts/Times New Roman Bold Italic.ttf');
    $qrThanhToan = public_path('images/hoadon/qr-thanh-toan/scb-hvs.jpg');

    use App\Helpers\Template;
    use App\Helpers\Calc;
    use Carbon\Carbon;

    $i = 1;
@endphp

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HÓA ĐƠN TIỀN NHÀ</title>
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

        .page-break {
            page-break-after: always;
        }

        body {
            font-family: 'Times New Roman';
            line-height: 90%;
        }

        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }

        .normal-text {
            margin: 3px;
        }

        .height-high {
            height: 2px;
        }

        .height-normal {
            height: 1px;
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

        .white {
            color: #fff;
        }

        .padding-top-5 {
            padding-top: 5px;
        }

        p {
            line-height: 85%;
        }

        .table {
            border-collapse: collapse;
            line-height: 85%;
            width: 100%;
            font-weight: normal !important
        }

        .body-content{
            border-radius: 7px;
            border: 1px solid gray;
            padding: 10px 15px;
            margin-bottom: 20px
        }

        .break-line{
            border-bottom: 1px solid gray;
            margin: 5px 0;
        }

        .break-line-dotted{
            border-bottom: 1px dotted gray;
            margin: 20px 0;
        }

        .qr{
            border-radius: 5px;
        }
        .line-dotted{
            border-bottom: 1px dotted gray;
        }

        #detail-e-w td{
            vertical-align: top;
        }

        .chi-phi{
            padding-left: 10px
        }
    </style>
</head>

<body class="body">
    @foreach($dataHoaDon as $data)
        @php
            $hopDongId      = $data['hop_dong_id'];
            $fromDate       = $data['tu_ngay']; $fromDate   = Carbon::parse($fromDate)->format('d/m/Y');
            $toDate         = $data['den_ngay']; $toDate    = Carbon::parse($toDate)->format('d/m/Y');

            $numberEOld     = Template::showNum($data['chi_so_dien_ky_truoc']);
            $numberWOld     = Template::showNum($data['chi_so_nuoc_ky_truoc']);
            $numberE        = Template::showNum($data['chi_so_dien']);
            $numberW        = Template::showNum($data['chi_so_nuoc']);
            $usedE          = Template::showNum($data['chi_so_dien'] - $data['chi_so_dien_ky_truoc']);
            $usedW          = Template::showNum($data['chi_so_nuoc'] - $data['chi_so_nuoc_ky_truoc']);

            $tienPhong      = Template::showNum($data['tien_phong'], true);
            $tienDien       = Template::showNum($data['tien_dien'], true);
            $tienNuoc       = Template::showNum($data['tien_nuoc'], true);
            $tienNet        = Template::showNum($data['tien_net'], true);
            $tienRac        = Template::showNum($data['tien_rac'], true);
            $tienKhac       = Template::showNum($data['tien_khac'], true);
            $tongCong       = Template::showNum($data['tong_cong'], true);

            $chuPhong       = $data['cd_fullname'];
            $phong          = $data['pt_name'];
            $now            = Carbon::parse($data['created'])->format('d/m/Y H:i:s');
            $note           = ($data['ghi_chu']) ? "(".$data['ghi_chu'].")" : '';

            $detailE = Calc::calcE($data['range_dien'], $data['chi_so_dien'] - $data['chi_so_dien_ky_truoc'], true);
            $detailW = Calc::calcW($data['tien_nuoc_detail'], true);
        @endphp
        <div class="body-content">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <p class="left normal-text font-size17"><strong>HÓA ĐƠN TIỀN NHÀ</strong></p>
                            <p class="left normal-text font-size12">Từ ngày {{ $fromDate }} đến {{ $toDate }}</p>
                        </td>
                        <td rowspan="2" width="300px" class="center">
                            <img class="qr" src="{!! $qrThanhToan !!}" height="80px">
                            <p class="normal-text font-size11">CTK: HUYNH VAN SON<br>NH: Sacombank - STK: 060286635353</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <div class="height-high"></div>
                            <p class="normal-text font-size12"><strong>{{ $phong}} - {{ $chuPhong }}</strong></p>
                            <p class="left normal-text font-size11"><i>Ngày lập hóa đơn: {{ $now }}</i></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="break-line"></div>
            <div class="height-high"></div>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="right" width="30px">1. </td>
                        <td class="left chi-phi">Tiền phòng</td>
                        <td class="right" width="120px">{{ $tienPhong }}</td>
                    </tr>
                    <tr>
                        <td class="right">2. </td>
                        <td class="left chi-phi">Tiền điện (số cũ: {{ $numberEOld }} | số mới: {{ $numberE }} | đã dùng: {{ $usedE }} kw)</td>
                        <td class="right">{{ $tienDien }}</td>
                    </tr>
                    <tr>
                        <td class="right">3. </td>
                        <td class="left chi-phi">Tiền nước (số cũ: {{ $numberWOld }} | số mới: {{ $numberW }} | đã dùng: {{ $usedW }} m&sup3;)</td>
                        <td class="right">{{ $tienNuoc }}</td>
                    </tr>
                    <tr>
                        <td class="right">4. </td>
                        <td class="left chi-phi">Tiền rác</td>
                        <td class="right">{{ $tienRac }}</td>
                    </tr>
                    <tr>
                        <td class="right">5. </td>
                        <td class="left chi-phi">Tiền internet</td>
                        <td class="right">{{ $tienNet }}</td>
                    </tr>
                    <tr>
                        <td class="right">6. </td>
                        <td class="left chi-phi">Chi phí khác {{ $note }}</td></td>
                        <td class="right">{{ $tienKhac }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="height-normal break-line"></div>
            <table class="table">
                <tbody>
                    <tr >
                        <td class="right" width="30px"></td>
                        <td class="left chi-phi"><strong>TỔNG CỘNG</strong></td>
                        <td class="right" width="120px"><strong>{{ $tongCong }}</strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="height-normal break-line"></div>
            <div class="detail-e-w font-size11">
                <table class="table" id="detail-e-w">
                    <tr>
                        <td width="100px" >Chi tiết Điện:</td>
                        <td>{!! $detailE !!}</td>
                        <td class="white">---</td>
                        <td width="100px" class="right">Chi tiết Nước:</td>
                        <td>{!! $detailW !!}</td>
                    </tr>
                </table>
            </div>

            <div class="height-normal break-line"></div>
            <p class="center normal-text font-size11"><i>Đề nghị thanh toán đủ số tiền trên <u> trong vòng 3 ngày</u> kể từ khi nhận được hóa đơn này.<br>Mọi thắc mắc liên quan đến việc thanh toán vui lòng liên hệ: 0908.12.50.50 (chú Tài)</i></p>
        </div>

        @php
            $soDu = $i % 2;
            if($soDu !== 0) {
                echo '<div class="break-line-dotted"></div>';
            }else{
                if($i != count($dataHoaDon))
                    echo '<div class="page-break"></div>';
            }
            $i++;
        @endphp
    @endforeach
</body>
</html>
