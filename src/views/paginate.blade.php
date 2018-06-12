<input name="current_Page" type="hidden" value="{{$collection->currentPage()}}">
<div class="col-sm-5">
    <div aria-live="polite" class="dataTables_info" id="datatable_info" role="status">
        @isset($collection)
            Showing {{$collection->firstItem()}} to {{$collection->lastItem()}} of {{$collection->total()}} entries
        @endisset()
    </div>
</div>
<div class="col-sm-7">
    <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
        @isset($collection)
            {!! $collection->links(); !!}
        @endisset()
    </div>
</div>
