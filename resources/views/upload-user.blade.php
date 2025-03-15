<form action="{{ route('upload-user') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="">
    <button type="submit">Upload</button>
</form>
