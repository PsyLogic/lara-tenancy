<div class="col-sm-12">
    @if(session()->get('success'))
        <div class="alert alert-success">
        {{ session()->get('success') }}  
        </div>
    @elseif(session()->get('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}  
        </div>
    @endif
</div>