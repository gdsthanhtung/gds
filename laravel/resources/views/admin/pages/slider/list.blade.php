@php
    use App\Helpers\Template;
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Slider Info</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
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
                                $name = $item['name'];
                                $link = $item['link'];
                                $description = $item['description'];

                                $thumb = Template::showItemThumb($ctrl, $item['thumb'], $item['name']);
                                $status = Template::showItemStatus($ctrl, $id, $item['status']);
                                $createdHis = Template::showItemHistory($item['created_by'], $item['created']);
                                $modifiedHis = Template::showItemHistory($item['modified_by'], $item['modified']);
                                $actionBtn = Template::showActionButton($ctrl, $id);
                            @endphp

                            <td>{{ $no }}</td>
                            <td width="40%">
                                <p><strong>Name:</strong> {{ $name }}</p>
                                <p><strong>Description:</strong> {{ $description }}</p>
                                <p><strong>Link:</strong> {{ $link }}</p>
                                <p>{!! $thumb !!}</p>
                            </td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createdHis !!}</td>
                            <td>{!! $modifiedHis !!}</td>
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