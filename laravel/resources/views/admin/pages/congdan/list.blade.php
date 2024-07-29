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
                    <th class="column-title">Thông tin CCCD</th>
                    <th class="column-title">Thông tin Công dân</th>
                    <th class="column-title">Phòng</th>
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

                                $cccd_dos           = date(Config::get('custom.format.shortTime'), strtotime($item['cccd_dos']));
                                $dob                = $item['dob'];
                                $gender             = Config::get("custom.enum.gender.".$item['gender']);
                                $address            = $item['address'];

                                $avatar             = ($item['avatar']) ? 'avatar/'.$item['avatar'] : Config::get("custom.enum.defaultPath.avatar");
                                $avatar             = Template::showItemAvatar($ctrl, $avatar, $item['name']);
                                $status             = Template::showItemStatus($ctrl, $id, $item['status']);

                                $cccd_image_front   = 'cccd_front/'.$item['cccd_image_front'];
                                $cccd_image_rear    = 'cccd_rear/'.$item['cccd_image_rear'];

                                $room               = "N/A";
                                $dktt_status        = "N/A";
                                $dktt_from_date     = "N/A";
                                $dktt_to_date       = "N/A";

                                $createdHis = Template::showItemHistory($item['created_by_name'], $item['created']);
                                $modifiedHis = Template::showItemHistory($item['modified_by_name'], $item['modified']);
                                $actionBtn  = Template::showActionButton($ctrl, $id);
                            @endphp

                            <td width="20px">{{ $no }}</td>
                            <td width="5%">{!! $avatar !!}</td>
                            <td width="15%">
                                <p><strong>ID No.:</strong> {!! $cccd_number !!}</p>
                                <p><strong>ID DoS:</strong> {!! $cccd_dos !!}</p>
                                <p><strong>ID Card:</strong> <a href="#"><i class="fa fa-eye"></i> View</a></p>
                            </td>
                            <td width="25%">
                                <p><strong>Họ tên:</strong> {!! $fullname !!}</p>
                                <p><strong>Đ/C thường trú:</strong> {!! $address !!}</p>
                                <p><strong>Giới tính:</strong> {!! $gender !!}</p>
                            </td>
                            <td><a href="#"><i class="fa fa-home"></i> {!! $room !!}</a></td>
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
                    @include('admin.templates.list_empty', ['colspan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>
