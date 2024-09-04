<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quill and Laravel Sample</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0-dev.3/quill.min.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0-dev.3/quill.snow.min.css" rel="stylesheet">
    <script src="https://unpkg.com/quill-table-ui@1.0.5/dist/umd/index.js" type="text/javascript"></script>
    <link href="https://unpkg.com/quill-table-ui@1.0.5/dist/index.css" rel="stylesheet">
</head>

<body>
    <h1>Quill画像アップロードテスト</h1>

    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <button type="button" id="insert-table">表を追加</button>
        <div id="editor-container"></div>
        <input type="hidden" name="content" id="editor-content">
        <input type="file" name="image" id="image-upload" style="margin-top: 10px;">
        <div id="image-preview" style="margin-top: 10px;">
            <img id="preview-img" src="" alt="Image Preview" style="max-width: 30%; height: auto; display: none;">
        </div>
        <br>
        <button type="submit">Save</button>
    </form>

    <p>ーーーーーー以下、データベースに保存されたデーターーーーーー</p>
    @foreach ($posts as $post)
    <div class="post">
        <div class="content">
            {!! $post->content !!}
        </div>
        @if ($post->image_path)
        <div class="image">
            <img src="{{ asset($post->image_path) }}" alt="Image" style="max-width: 30%; height: auto;">
        </div>
        @endif
    </div>
    @endforeach

    <script>
        document.querySelector('#insert-table').addEventListener('click', function() {
            table.insertTable(3, 3);
        });
        
        Quill.register({
            'modules/tableUI': quillTableUI.default
        }, true);

        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                table: true,
                tableUI: true,
            }
        });

        const table = quill.getModule('table');

        document.querySelector('form').addEventListener('submit', function() {
            var editorContent = document.querySelector('#editor-content');
            editorContent.value = quill.root.innerHTML;
        });

        //画像プレビュー
        document.querySelector('#image-upload').addEventListener('change', function(event) {
            var previewImg = document.querySelector('#preview-img');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
        });
    </script>
</body>

</html>