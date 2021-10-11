<div>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {{ session()->get('success') }}
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {{ session()->get('error') }}
        </div>
    </div>
    @endif
</div>