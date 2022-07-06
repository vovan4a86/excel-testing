<ul class="tree-lvl">
    @foreach($items as $item)
        @if ($item->parent_id == $parent)
            <li class="{{ $item->published != 1 ? 'dont-show' : '' }}" data-id="{{ $item->id }}">
                <div class="tree-item">
                    <span class="tree-handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span>
                    <a class="tree-item-name" href="{{ route('admin.stock.products', [$item->id]) }}" onclick="return catalogContent(this)">{{ $item->name }}</a>

                    <div class="tree-tools">
                        <a href="{{ route('admin.stock.catalogEdit').'?parent='.$item->id }}" onclick="return catalogContent(this)"><i class="fa fa-plus"></i></a>
                        <a href="{{ route('admin.stock.catalogEdit', [$item->id]) }}" onclick="return catalogContent(this)"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('admin.stock.catalogDel', [$item->id]) }}" onclick="return catalogDel(this)"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
                @include('admin::stock.tree_lvl', ['parent' => $item->id, 'items' => $items])
            </li>
        @endif
    @endforeach
</ul>
