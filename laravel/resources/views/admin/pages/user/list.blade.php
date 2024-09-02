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
                    <th class="column-title text-center">Avatar</th>
                    <th class="column-title">Thông tin</th>
                    <th class="column-title text-center">Level</th>
                    <th class="column-title text-center">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
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
                                $username   = Highlight::show($item['username'],    $params['filter'], 'username');
                                $fullname   = Highlight::show($item['fullname'],    $params['filter'], 'fullname');
                                $email      = Highlight::show($item['email'],       $params['filter'], 'email');

                                $avatar     = Template::showItemAvatar($ctrl, $item['avatar'], $item['name']);
                                $status     = Template::showItemStatus($ctrl, $id, $item['status']);
                                $level      = Template::showItemSelect($ctrl, $id, $item['level'], 'level');
                                $createdHis = Template::showItemHistory($item['created_by_name'], $item['created']);
                                $modifiedHis = Template::showItemHistory($item['modified_by_name'], $item['modified']);
                                $actionBtn  = Template::showActionButton($ctrl, $id);
                            @endphp

                            <td class="text-center">{{ $no }}</td>
                            <td class="text-center">{!! $avatar !!}</td>
                            <td width="20%">
                                <small>
                                    <span><strong>Name:</strong> {!! $username !!}</span><br>
                                    <span><strong>Fullname:</strong> {!! $fullname !!}</span><br>
                                    <span><strong>Email:</strong> {!! $email !!}</span>
                                </small>
                            </td>
                            <td class="text-center">{!! $level !!}</td>
                            <td class="text-center">{!! $status !!}</td>
                            <td>{!! $createdHis !!}</td>
                            <td>{!! $modifiedHis !!}</td>
                            <td class="text-center">{!! $actionBtn !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 100])
                @endif
            </tbody>
        </table>
    </div>
</div>
