@if (Session::has('alert'))
    <div class="alert alert-{{ Session::get('alert.type') === 'success' ? 'success' : 'danger' }} alert-icon mb-3">
        <em class="icon ni ni-{{ Session::get('alert.type') === 'success' ? 'check' : 'cross' }}-circle"></em> {{ Session::get('alert.message') }}.
    </div>
@endif
@if($errors->all())
    <div class="alert alert-danger" role="alert">
        <p>Oops! We've got an error!</p>
        <ul class="mb-0">
            @foreach($errors->all() as $message)
                <li>• {{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
