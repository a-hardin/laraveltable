<tr>
    @if ($checkbox == true)
        <th class="tbl-select">
    		<input name="btSelectAll" type="checkbox">
    	</th>
    @endif

    @forelse ($tableColumns as $tableColumn)
        <th>{{ $tableColumn->getName() }}</th>
    @empty
        <th></th>
    @endforelse


    @isset($actionButtons)
        <th class="col-xs-1 tbl-action-col">Action</th>
    @endisset
</tr>
@if ($tableFilters == true)
    <tr class="modal-filters">

        @if ($checkbox == true)
            <td></td>
        @endif

        @forelse($tableColumns as $tableColumn)
            <td>
                @if ($tableColumn->isText())
                    <input name="{{ $tableColumn->getName() }}" type="text" maxlength="{{ $tableColumn->getLength() }}" value="{{ $request->{$tableColumn->getName()} or '' }}">
                @elseif (!$tableColumn->isText())
                    <select class="form-control" name="{{ $tableColumn->getName() }}">
                        <option value="0"> Default </option>
                        <option value="1"> Option 1</option>
                    </select>
                @endif

            </td>
        @empty
            <td>No tableHeader </td>
        @endforelse

        @isset($actionButtons)
            <td></td>
        @endisset
    </tr>
@endif
