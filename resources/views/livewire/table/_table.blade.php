<div class="card-body p-3">
<table class="table table-striped gy-4 gs-4 table-hover" style="table-layout: fixed; width: 100%">
    @include('crud::livewire.table._table_header')

    @include('crud::livewire.table._table_body')
</table>
<div>
    <span style="float: right">
        @lang(':total items', ['total' => $collection->total()])
    </span>
</div>
<div class="pagination">
    {!! $collection->links() !!}
</div>
</div>