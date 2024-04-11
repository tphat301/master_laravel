<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="{{ url('resources/admin/js/fancybox.umd.js') }}"></script>
<script src="{{ url('resources/admin/js/adminlte.js') }}"></script>
<script src="{{ url('resources/admin/js/priceFormat.js') }}"></script>
<script src="{{ url('resources/admin/select2/select2.full.js') }}"></script>
<script src="{{ url('resources/admin/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ url('resources/admin/js/apexchart.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
<script type="text/javascript"
    src='https://cdn.tiny.cloud/1/6exkcycuzl4n4cx1xx4333jpg4l4ahsk8nxrjw2d1kveux33/tinymce/5/tinymce.min.js'
    referrerpolicy="origin"></script>
<script type="text/javascript">
    var CHARTS = {!! !empty($charts) ? json_encode($charts) : '{}' !!};
    var editor_config = {
        path_absolute: "{{ url('/') }}/",
        selector: "textarea.tiny",
        relative_urls: false,
        height: 350,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback: function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                'body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document
                .getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };
    tinymce.init(editor_config);
</script>

<script src="{{ url('resources/admin/js/app.js') }}"></script>
