@php
    $fontPathN = public_path('admin/asset/fonts/Times New Roman.ttf');
    $fontPathI = public_path('admin/asset/fonts/Times New Roman Italic.ttf');
    $fontPathB = public_path('admin/asset/fonts/Times New Roman Bold.ttf');
    $fontPathA = public_path('admin/asset/fonts/Times New Roman Bold Italic.ttf');
    $qrThanhToan = public_path('images/hoadon/qr-thanh-toan/scb-hvs.jpg');

    use App\Helpers\Template;
    use App\Helpers\Calc;
    use Carbon\Carbon;
@endphp

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VĂN BẢN CHO Ở NHỜ NHÀ</title>
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

        .height-high-5 {
            height: 5px;
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
    @php
        //dd($data, $nkInHopDong);
        $day    = Carbon::now()->format('d');
        $month  = Carbon::now()->format('m');
        $year   = Carbon::now()->format('Y');

        $benAdctht = '467/62A Nơ Trang Long, P. 13, Q. Bình Thạnh, TP. Hồ Chí Minh';
        $benAhoten = 'HUỲNH VĂN SƠN';
        $benAcccd = '079063014994';

        $benBdctht = $data['cd_address'];
        $benBhoten = $data['cd_fullname'];
        $benBcccd = $data['cd_cccd_number'];
        $benBcccdDos = Carbon::parse($data['cd_cccd_dos'])->format('d/m/Y');
        $benBcccdNC = 'CCSQLHCVTTXH';

        $countNK = (count($nkInHopDong[$id]) < 10) ? '0'.count($nkInHopDong[$id]) : count($nkInHopDong[$id]);
    @endphp
    <div class="page-content">
        <div class="height-high"></div>
        <p class="center normal-text font-size13"><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
        <p class="center normal-text font-size11"><strong>Độc lập – Tự do – Hạnh phúc</strong></p>
        <p class="center normal-text font-size11"><strong>---o0o---</strong></p>
        <div class="height-high"></div>
        <p class="center normal-text font-size17"><strong>VĂN BẢN CHO Ở NHỜ NHÀ</strong></p>
        <div class="height-normal"></div>
        <p class="normal-text font-size13">Hôm nay, ngày <i>{{$day}}</i> tháng <i>{{$month}}</i> năm <i>{{$year}}</i>, tại địa chỉ <i>{{$benAdctht}}.</i></p>
        <div class="height-high-5"></div>
        <p class="normal-text font-size13">Chúng tôi gồm có:</p>
        <p class="normal-text font-size13"><strong>Bên cho ở nhờ (gọi tắt là Bên A):</strong></p>
        <p class="normal-text font-size13">Họ và tên: <strong>{{$benAhoten}}</strong></p>
        <p class="normal-text font-size13">Số CCCD: <strong>{{$benAcccd}}</strong></p>
        <p class="normal-text font-size13">Hộ khẩu thường trú: {{$benAdctht}}.</p>
        <p class="normal-text font-size13">Là chủ nhà số: {{$benAdctht}}.</p>
        <div class="height-high-5"></div>
        <p class="normal-text font-size13"><strong>Bên ở nhờ (gọi tắt là Bên B):</strong></p>
        <p class="normal-text font-size13">Họ và tên: <strong>{{$benBhoten}}</strong></p>
        <p class="normal-text font-size13">Số CCCD: <strong>{{$benBcccd}}</strong><span class="white"> ---------- </span>Ngày cấp: <strong>{{$benBcccdDos}}</strong></p>
        <p class="normal-text font-size13">Nơi cấp: <strong>{{$benBcccdNC}}</strong></p>
        <p class="normal-text font-size13">Hộ khẩu thường trú: {{$benBdctht}}.</p>
        <p class="normal-text font-size13">Hiện đang ở tại: {{$benAdctht}}.</p>
        <div class="height-high-5"></div>
        <p class="normal-text font-size13"><strong>Hai bên tự thỏa thuận và thống nhất như sau:</strong></p>
        <p class="normal-text font-size13">Bên A đồng ý cho Bên B ở nhờ tại địa chỉ: {{$benAdctht}}.</p>
        <p class="normal-text font-size13">Thời hạn ở nhờ: <strong>{{$thoiHanONho}} tháng</strong>, kể từ ngày <strong>{{$thoiHanTuNgay}}</strong></p>
        <p class="normal-text font-size13">Bên B gồm có <strong>{{$countNK}}</strong> nhân khẩu được ở nhờ, bao gồm:</p>

        <div class="row">
            <table class="table table-bordered tb-nhan-khau">
                <tbody>
                    @for($i=0;$i<=5;$i++)
                        @if(isset($nkInHopDong[$id][$i]))
                            <tr>
                                <td class="tdh-nhan-khau" width="20px">{{ $i+1 }}.</td>
                                <td class="tdh-nhan-khau"><strong>{{ $nkInHopDong[$id][$i]['fullname'] }}</strong></td>
                                <td class="tdh-nhan-khau">Sinh ngày: {{ Template::showDate($nkInHopDong[$id][$i]['dob']) }}</td>
                                <td class="tdh-nhan-khau">CCCD: {{ $nkInHopDong[$id][$i]['cccd_number'] }}</td>
                            </tr>
                        @endif

                    @endfor
                </tbody>
            </table>
        </div>

        <div class="height-high-5"></div>
        <p class="normal-text font-size13">Quyền lợi Bên B: Được quyền ở, đăng ký tạm trú, gia hạn tạm trú trong thời gian ghi ở phần trên. Bên B không được tranh chấp nhà, yêu cầu gì về tài sản của Bên A (Hay bên được ủy quyền của Bên A).</p>
        <p class="normal-text font-size13">Văn bản cho ở nhờ nhà này được lập thành 02 bản, mỗi bên giữ 01 bản ./.</p>
        <table class="center" style="width: 100%">
            <tr>
                <td width="50%">
                    <p class="font-size13"><strong>BÊN CHO Ở NHỜ NHÀ (BÊN A)</strong><br><span class="font-size12">(Ký và ghi rõ họ tên)</span></p>
                    <br>
                    <p class="font-size12"><strong>HUỲNH VĂN SƠN</strong></p>
                </td>
                <td width="50%">
                    <p class="font-size13"><strong>BÊN Ở NHỜ NHÀ (BÊN B)</strong><br><span class="font-size12">(Ký và ghi rõ họ tên)</span></p>
                    <br><div class="height-high-5"></div>
                    <p class="font-size12"><strong>{{$benBhoten}}</strong></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
