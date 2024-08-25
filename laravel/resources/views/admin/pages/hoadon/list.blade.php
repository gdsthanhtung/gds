@php
use App\Helpers\Template;
use App\Helpers\Modal;
use App\Helpers\Highlight;
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Hợp đồng</th>
                    <th class="column-title" colspan="2">Đại diện thuê phòng</th>
                    <th class="column-title" colspan="2">Thông tin thuê phòng</th>
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
                                $maHopDong      = Highlight::show($item['ma_hop_dong'], $params['filter'], 'ma_hop_dong');
                                $ptName         = Highlight::show($item['pt_name'],     $params['filter'], 'pt_name');
                                $cdFullname     = Highlight::show($item['cd_fullname'], $params['filter'], 'cd_fullname');
                                $note           = Highlight::show($item['ghi_chu'],     $params['filter'], 'ghi_chu');

                                $cdStatus       = ucfirst($item['cd_status']);
                                $fromDate       = Template::showDate($item['tu_ngay']);
                                $toDate         = Template::showDate($item['den_ngay']);
                                $avatar         = ($item['cd_avatar']) ? 'avatar/'.$item['cd_avatar'] : Config::get("custom.enum.defaultPath.avatar");
                                $avatar         = Template::showItemAvatar('congdan', $avatar, $item['cd_avatar']);

                                $numberE        = Template::numberFormat($item['chi_so_dien'] - $item['chi_so_dien_ky_truoc']);
                                $numberW        = Template::numberFormat($item['chi_so_nuoc'] - $item['chi_so_nuoc_ky_truoc']);

                                $tongCong       = Template::showNum($item['tong_cong'], true);

                                $status         = Template::showItemStatusHoaDon($ctrl, $id, $item['status']);
                                $createdHis     = Template::showItemHistory($item['created_by_name'], $item['created']);
                                $modifiedHis    = Template::showItemHistory($item['modified_by_name'], $item['modified']);
                                $actionBtn      = Template::showActionButton($ctrl, $id);
                            @endphp

                            <td>{{ $no }}</td>
                            <td width='300px'>
                                <p><strong>Phòng:</strong> {!! $ptName !!}</p>
                                <p><strong>Hóa đơn từ:</strong> {!! $fromDate !!} - {!! $toDate !!}</p>
                                <p><strong>Hợp đồng số:</strong> {!! $maHopDong !!}</p>
                            </td>
                            <td width='140px' style="text-align: center">{!! $avatar !!}</td>
                            <td>
                                <p><strong>Họ tên:</strong> {!! $cdFullname !!}</p>
                                <p><strong>Trạng thái:</strong> {!! $cdStatus !!}</p>
                            </td>
                            <td>
                                <p><strong>Số Điện đã dùng:</strong> {!! $numberE !!}</p>
                                <p><strong>Số Nước đã dùng:</strong> {!! $numberW !!}</p>
                            </td>
                            <td>
                                <p><strong>Tổng cộng:</strong> {!! $tongCong !!}</p>
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
