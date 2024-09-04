@php
use App\Helpers\Template;
use App\Helpers\Modal;
use App\Helpers\Highlight;
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-hover jambo_table">
            <thead>
                <tr class="headings">
                    <th class="column-title text-center">#</th>
                    <th class="column-title">Hợp đồng</th>
                    <th class="column-title">Thông tin thuê phòng</th>
                    <th class="column-title" colspan="2">Đại diện thuê phòng</th>
                    <th class="column-title">Nhân khẩu</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Lịch sử</th>
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
                                $maHopDong      = Highlight::show($item['ma_hop_dong'], $params['filter'], 'ma_hop_dong');
                                $ptName         = Highlight::show($item['pt_name'], $params['filter'], 'pt_name');
                                $cdFullname     = Highlight::show($item['cd_fullname'], $params['filter'], 'cd_fullname');
                                $cdCccdNumber   = Highlight::show($item['cd_cccd_number'], $params['filter'], 'cd_cccd_number');
                                $note           = Highlight::show($item['ghi_chu'], $params['filter'], 'ghi_chu');

                                $cdStatus       = ucfirst($item['cd_status']);
                                $fromDate       = Template::showDate($item['thue_tu_ngay']);
                                $toDate         = Template::showDate($item['thue_den_ngay'], $compareToday = true);
                                $approveE       = ($item['huong_dinh_muc_dien']) ? 'Có' : 'Không';
                                $approveW       = ($item['huong_dinh_muc_nuoc']) ? 'Có' : 'Không';
                                $avatar         = ($item['cd_avatar']) ? 'avatar/'.$item['cd_avatar'] : Config::get("custom.enum.defaultPath.avatar");
                                $avatar         = Template::showItemAvatar('congdan', $avatar, $item['cd_avatar']);

                                $price          = Template::showNum($item['gia_phong'], true);
                                $numberE        = Template::showNum($item['chi_so_dien']);
                                $numberW        = Template::showNum($item['chi_so_nuoc']);

                                $status         = Template::showItemStatus($ctrl, $id, $item['status']);
                                $createdHis     = Template::showItemHistory($item['created_by_name'], $item['created']);
                                $modifiedHis    = Template::showItemHistory($item['modified_by_name'], $item['modified']);
                                $actionBtn      = Template::showActionButton($ctrl, $id);

                                $nhanKhau       = (isset($nkInHopDong[$id])) ? $nkInHopDong[$id] : null;
                                $nhanKhauInfo   = Modal::showNhanKhau($id, $nhanKhau);
                            @endphp

                            <td class="text-center">{{ $no }}</td>
                            <td width='250px'>
                                <small>
                                    <span><strong>Hợp đồng số:</strong> {!! $maHopDong !!}</span><br>
                                    <span><strong>Hiệu lực:</strong> {!! $fromDate !!} - {!! $toDate !!}</span><br>
                                    <span><strong>Hưởng đ.mức Điện:</strong> {!! $approveE !!}</span><br>
                                    <span><strong>Hưởng đ.mức Nước:</strong> {!! $approveW !!}</span><br>
                                    @if($note)
                                        <span><strong>Ghi chú:</strong> {!! $note !!}</span>
                                    @endif
                                <small>
                            </td>
                            <td>
                                <small>
                                    <span><strong>Phòng:</strong> {!! $ptName !!}</span><br>
                                    <span><strong>Chỉ số Điện:</strong> {!! $numberE !!}</span><br>
                                    <span><strong>Chỉ số Nước:</strong> {!! $numberW !!}</span><br>
                                    <span><strong>Giá Phòng:</strong> {!! $price !!}</span>
                                </small>
                            </td>
                            <td width='140px' class="text-center">{!! $avatar !!}</td>
                            <td width='250px'>
                                <small>
                                    <span><strong>Họ tên:</strong> {!! $cdFullname !!}</span><br>
                                    <span><strong>CCCD:</strong> {!! $cdCccdNumber !!}</span><br>
                                    <span><strong>Trạng thái:</strong> {!! $cdStatus !!}</span>
                                </small>
                            </td>
                            <td><small>{!! $nhanKhauInfo !!}</small></td>
                            <td>{!! $status !!}</td>
                            <td><small><b>Tạo bởi:</b><br>{!! $createdHis !!}<br><b>Điều chỉnh:</b><br>{!! $modifiedHis !!}</small></td>
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
