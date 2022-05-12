<form class="form" method="POST" action="/admin/client/{{$user->id}}/update" >
    @csrf
    @method('PATCH')
    @include('web.partials.user_profile')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group text-center mt-5 mb-4">
                <button class="btn btn-lg btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>
