@foreach($items as $item)
    <a class="list-group-item list-group-item-action outItem" href="#list-item-1" data-toggle="modal" data-target="#addNewItem">{{$item->item}}
        <input type="hidden" id="itemId" value="{{$item->id}}">
    </a>
@endforeach
<div class="mt-3">
    {{$items->links()}}
</div>