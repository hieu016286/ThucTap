@if($categoryParent->children->count())
    <ul role="menu" class="sub-menu">
        @foreach($categoryParent->children as $categoryChild)
            <li><a href="shop.html">{{$categoryChild->name}}</a></li>
            @if($categoryChild->children->count())
                @include('components.child_menu',['categoryParent' => $categoryChild])
            @endif
        @endforeach
    </ul>
@endif
