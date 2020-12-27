@if(count($children)>0)
    <ul class="menuChildrenList notVisible">
        @foreach($children as $child)
                <li>
                    <a href="{{ url(''.$child->href) }}">{{ $child->text }}</a>

                    @foreach($menuLinks as $menuLink)
                        @if($menuLink->id == $child->id)
                            @component('partials.menu_children', [
                            'children' => $menuLink->childrenLinks,
                            'menuLinks' => $menuLinks])
                            @endcomponent
                        @endif
                    @endforeach
                </li>
        @endforeach
    </ul>
    @endif

