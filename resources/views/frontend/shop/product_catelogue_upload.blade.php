<?php if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {?>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('catelogueupload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button class="btn btn-warning" type="submit">Import CSV</button>
</form>
<?php } ?>