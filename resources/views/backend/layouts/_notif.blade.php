@if (session()->has('flash_notification'))
<div class="alert alert-{{ session()->get('flash_notification.level') }} alert-has-icon" id="alert">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <button class="close" data-dismiss="#alert">
            <span>&times;</span>
        </button>
        <div class="alert-title">Info</div>
        {!! session()->get('flash_notification.message') !!}
    </div>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-has-icon" id="alert">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <button class="close" data-dismiss="#alert">
            <span>&times;</span>
        </button>
        <div class="alert-title">Info</div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif