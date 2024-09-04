@php
use App\Helpers\Template;
use App\Helpers\Highlight;
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-hover jambo_table">
            <thead>
                <tr class="headings">
                    <th class="column-title text-center">#</th>
                    <th class="column-title">Hình Ảnh</th>
                    <th class="column-title" colspan="2">Thông tin Công dân</th>
                    <th class="column-title">Đăng ký tạm trú</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Lịch sử</th>
                    <th class="column-title">Xuất file</th>
                    <th class="column-title text-center">Chức năng</th>
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

                                $exportCT01NEW      = Template::ct01($id, 'NEW');
                                $exportCT01GH       = Template::ct01($id, 'GH');

                                $createdHis         = Template::showItemHistory($item['created_by_name'], $item['created']);
                                $modifiedHis        = Template::showItemHistory($item['modified_by_name'], $item['modified']);
                                $actionBtn          = Template::showActionButton($ctrl, $id);
                            @endphp

                            <td width="20px" class="text-center">{{ $no }}</td>
                            <td width="5%">{!! $avatar !!}</td>
                            <td width="15%">
                                <small>
                                    <span><strong>Họ tên:</strong> {!! $fullname !!}</span><br>
                                    <span><strong>Số CCCD:</strong> {!! $cccd_number !!}</span><br>
                                    <span><strong>Ngày cấp:</strong> {!! $cccd_dos !!}</span><br>
                                    <span><strong>Hình CCCD:</strong>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#cccdModal" data-cccdfront="{{ $cccd_image_front }}" data-cccdrear="{{ $cccd_image_rear }}">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </span>
                                </small>
                            </td>
                            <td width="20%">
                                <small>
                                    <span><strong>Đ/C thường trú:</strong> {!! $address !!}</span><br>
                                    <span><strong>Hộ khẩu:</strong> {!! $isCity !!}</span><br>
                                    <span><strong>Giới tính:</strong> {!! $gender !!}</span>
                                </small>
                            </td>
                            <td>
                                <small>
                                    <span><strong>Trạng thái ĐKTT:</strong> {!! $dktt_status !!}</span><br>
                                    <span><strong>Thời hạn:</strong> {!! $dktt_from_date !!} - {!! $dktt_to_date !!}</span>
                                </small>
                            </td>
                            <td>{!! $status !!}</td>
                            <td><small><b>Tạo bởi:</b><br>{!! $createdHis !!}<br><b>Điều chỉnh:</b><br>{!! $modifiedHis !!}</small></td>
                            <td class="last">{!! $exportCT01NEW !!} <br> {!! $exportCT01GH !!}</td>
                            <td class="last text-center">{!! $actionBtn !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 100])
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class='modal fade cccdModal' id='cccdModal' tabindex='-1' aria-hidden="true">
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class="modal-title">THÔNG TIN CĂN CƯỚC CÔNG DÂN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class='modal-body'>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="col text-center" id="modal-cccd-front"></div>
                        </div>
                        <div class="col">
                            <div class="col text-center" id="modal-cccd-rear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
