<div>
    <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">{{ $title }}</h3>
    <ul class="space-y-1">
        @foreach($links as $link)
            <li>
                <a href="{{ $link['url'] }}" class="hover:text-white transition">{{ $link['text'] }}</a>
            </li>
        @endforeach
    </ul>
</div> 