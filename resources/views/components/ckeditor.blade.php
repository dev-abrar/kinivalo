<script src="{{asset('back-end/ckeditor/ckeditor.js')}}"></script>

<script>
    function ckeditor(id) {
        CKEDITOR.replace(id, {
                filebrowserUploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                filebrowserUploadMethod: "form"
        });
    }
</script>