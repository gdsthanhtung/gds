@php
use App\Helpers\Template;
use App\Helpers\Highlight;
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Hình Ảnh</th>
                    <th class="column-title" colspan="2">Thông tin Công dân</th>
                    <th class="column-title">Đăng ký tạm trú</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Lịch sử</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) > 0)
                    @foreach ($data as $key => $item)
                        <tr class="odd pointer">
                            @php
                                $no = ++$key;
                                $id = $item['id'];
                                $cccd_number        = Highlight::show($item['cccd_number'],    $params['filter'], 'cccd_number');
                                $fullname           = Highlight::show($item['fullname'],    $params['filter'], 'fullname');
                                $phone              = Highlight::show($item['phone'],    $params['filter'], 'phone');

                                $cccd_dos           = Template::showDate($item['cccd_dos']);
                                $dob                = $item['dob'];
                                $gender             = Config::get("custom.enum.gender.".$item['gender']);
                                $address            = $item['address'];

                                $avatar             = ($item['avatar']) ? 'avatar/'.$item['avatar'] : Config::get("custom.enum.defaultPath.avatar");
                                $avatar             = Template::showItemAvatar($ctrl, $avatar, $item['name']);
                                $status             = Template::showItemStatus($ctrl, $id, $item['status']);
                                $isCity             = Config::get("custom.enum.isCity.".$item['is_city']);
                                $isCity             = Config::get("custom.enum.isCity.".$item['is_city']);

                                $pathImage          = Config::get("custom.enum.path.$ctrl");
                                $cccd_image_front   = json_encode(Template::showItemCCCD('', $pathImage['cccd_image_front'].'/'.$item['cccd_image_front'], $fullname));
                                $cccd_image_rear    = json_encode(Template::showItemCCCD('', $pathImage['cccd_image_rear'].'/'.$item['cccd_image_rear'], $fullname));



                                $dktt_status        = Config::get("custom.enum.selectStatusDKTT.".$item['dktt_status']);
                                $dktt_from_date     = Template::showDate($item['dktt_tu_ngay']);
                                $dktt_to_date       = Template::showDateDKTT($item['dktt_den_ngay'], $compareMonthAgo = 1);

                                $createdHis         = Template::showItemHistory($item['created_by_name'], $item['created']);
                                $modifiedHis        = Template::showItemHistory($item['modified_by_name'], $item['modified']);
                                $actionBtn          = Template::showActionButton($ctrl, $id);
                            @endphp

                            <td width="20px">{{ $no }}</td>
                            <td width="5%">{!! $avatar !!}</td>
                            <td width="15%">
                                <p><strong>Họ tên:</strong> {!! $fullname !!}</p>
                                <p><strong>Số CCCD:</strong> {!! $cccd_number !!}</p>
                                <p><strong>Ngày cấp:</strong> {!! $cccd_dos !!}</p>
                                <p><strong>Hình CCCD:</strong>
                                    <a href="#" data-toggle="modal" data-target="#cccdModal" data-cccdfront="{{ $cccd_image_front }}" data-cccdrear="{{ $cccd_image_rear }}">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </p>
                            </td>
                            <td width="25%">
                                <p><strong>Đ/C thường trú:</strong> {!! $address !!}</p>
                                <p><strong>Hộ khẩu:</strong> {!! $isCity !!}</p>
                                <p><strong>Giới tính:</strong> {!! $gender !!}</p>
                            </td>
                            <td>
                                <p><strong>Trạng thái:</strong> {!! $dktt_status !!}</p>
                                <p><strong>Thời hạn:</strong> {!! $dktt_from_date !!} - {!! $dktt_to_date !!}</p>
                            </td>
                            <td>{!! $status !!}</td>
                            <td><b>Tạo bởi:</b> {!! $createdHis !!} <b>Điều chỉnh:</b> {!! $modifiedHis !!}</td>
                            <td class="last">{!! $actionBtn !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 100])
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class='modal fade cccdModal' id='cccdModal' tabindex='-1' role='dialog' aria-labelledby='CCCD'>
    <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title' id='myModalLabel'>THÔNG TIN CĂN CƯỚC CÔNG DÂN</h4>
            </div>
            <div class='modal-body'>
                <div class='content'>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 text-center" id="modal-cccd-front"></div>
                            <div class="col-md-6 text-center" id="modal-cccd-rear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>
