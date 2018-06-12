@foreach($collection as $model)
    <tr>
        @if ($checkbox == true)
            <td class="">
                <input id="{{$model->id}}" name="btSelect" type="checkbox">
            </td>
        @endif

        @foreach($tableColumns as $tableColumn)
            {!! $tableColumn->getTableColumn($model) !!}
        @endforeach

        @isset($actionButtons)
            <td class="tbl-action-col">
                @foreach($actionButtons as $actionButton)
                    <span class="tbl-action-item">
                        <a href="javascript:void(0)" class="{{ $actionButton['icon'] }} {{ $actionButton['class'] }}" data-id="{{$model->id}}"></a>
                    </span>
                @endforeach
            </td>
        @endisset

    </tr>
@endforeach
