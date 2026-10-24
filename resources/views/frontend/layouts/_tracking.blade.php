@if (filled(config('settings.g_tag')) && config('settings.g_tag') !== 'data or value has not been set')
    {!! config('settings.g_tag') !!}
@endif
@if (filled(config('settings.script')) && config('settings.script') !== 'data or value has not been set')
    {!! config('settings.script') !!}
@endif
