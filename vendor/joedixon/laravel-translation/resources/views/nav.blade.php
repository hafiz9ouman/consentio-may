<nav class="header" style="background: white;">

    <h1 class="text-lg px-6"><img src="{{ url('_organisation.png') }}" style="    width: 233px;
    margin-top: 3px;
    margin-bottom: 3px;"></h1>

    <ul class="flex-grow justify-end pr-2" >
        <li>
            <a href="{{ route('languages.index') }}" class="{{ set_active('') }}{{ set_active('/create') }}" style="color: black">
                @include('translation::icons.globe')
                {{ __('translation::translation.languages') }}
            </a>
        </li>
        <li>
            <a href="{{ route('languages.translations.index', config('app.locale')) }}" class="{{ set_active('*/translations') }}" style="color: black">
                @include('translation::icons.translate')
                {{ __('translation::translation.translations') }}
            </a>
        </li>
    </ul>

</nav>