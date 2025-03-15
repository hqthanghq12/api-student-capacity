<form action="{{ route('upload-gv') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="">
    <br>
    Role: <select name="role" id="">
        <option value="">Chọn role</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <br>
    Cột mã cơ sở: <input type="text" name="campus_code_col" id="">
    <br>
    Cột tên giảng viên: <input type="text" name="name_col" id="">
    <br>
    Cột mail fe: <input type="text" name="email_fe_col" id="">
    <button type="submit">Upload</button>
</form>
