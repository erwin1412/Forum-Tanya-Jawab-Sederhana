@extends('layouts.master')

@section('title')
    Show
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pertanyaan dari {{$show->PertanyaanMilik->name}} </h6>
        </div>

        <div class="card-body">
            <h6>Judul Pertanyaan: {{$show->judul_pertanyaan}} 
                <a class="btn-success btn-sm fa-pull-right" href="/likePertanyaan/{{ $show->id_pertanyaan }}">Like! <i class="far fa-thumbs-up"> {{$like}}</i></a>
            </h6> 
            <h6>Keterangan Pertanyaan: {{$show->isi_pertanyaan}} 
            </h6>
            <h6>File Pertanyaan: <a href="/filePertanyaan/{{$show->file_pertanyaan}}">{{$show->file_pertanyaan}}</a>
                <a class="btn-danger btn-sm fa-pull-right" href="/dislikePertanyaan/{{ $show->id_pertanyaan }}">Dislike! <i class="far fa-thumbs-down"> {{$dislike}}</i></a>
            </h6>
            <h6>Materi Terkait:  
                @foreach ($show->MateriTerkait as $materi)
                    <button class="btn btn-info btn-sm" type="button"> {{$materi->nama_materi}} </button>
                @endforeach
            </h6>
            <p>
                <a class="btn btn-primary" href="/index/all" role="button">Kembali ke halaman sebelumnya</a>
                <a class="btn btn-primary fa-pull-right" href="/pertanyaan" role="button" data-toggle="modal" data-target="#modal_jawab">Berikan Jawaban Anda</a>
            </p>

            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th style="width: 10px">No</th>
                        <th>Pemberi Jawaban</th>
                        <th>Keterangan Jawaban</th>
                        <th>File Jawaban</th>
                        <th style="width: 200px">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($show->DaftarJawaban as $key => $jawaban)
                    <tr>
                        <td> {{$key+1}}</td>
                        <td> {{$jawaban->PemberiJawaban->name}} </td>
                        <td> {!! $jawaban->isi_jawaban !!} </td>
                        <td> <a href="/fileJawaban/{{$jawaban->file_jawaban}}"> {{$jawaban->file_jawaban}} </a> </td>
                        <td>
                          <a class="btn-success btn-sm btn-block text-center" href="/likeJawaban/{{ $jawaban->id_jawaban }}">Like! <i class="far fa-thumbs-up"> {{$jawaban->jml_like}}</i></a>
                          <a class="btn-danger btn-sm btn-block text-center" href="/dislikeJawaban/{{ $jawaban->id_jawaban }}">Dislike! <i class="far fa-thumbs-down"> {{$jawaban->jml_dislike}}</i></a>
                        </td>
                    </tr>
                    @empty
                        <td colspan="5" align="center">Belum ada yang menjawab pertanyaan anda</td>       
                    @endforelse
                    
                </tbody>
            </table>
            
        </div>
    </div>

{{-- Modal untuk jawab pertanyaan--}}
<div class="modal fade" id="modal_jawab" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Jawaban Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" action="/jawaban" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id_pertanyaan" id="id_pertanyaan" value="{{$show->id_pertanyaan}}">

            <div class="form-group">
                <label for="isi_jawaban">Isi Jawaban</label>
                <textarea name="isi_jawaban" id="isi_jawaban" class="form-control my-editor">{!! old('isi_jawaban', $isi_jawaban ?? '') !!}</textarea>
            </div>

            <div class="form-group">
              <label for="file">Upload File (Jika Diperlukan)</label>
              <input type="file" class="dropify" data-height="300" id="input_file" name="input_file">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
          </form>
        </div>
        
      </div>
    </div>
</div>

@endsection

@push('dropify')
<script src="{{ asset('dropify/dist/js/dropify.js' )}}"></script>
<script type="text/javascript">
        $(document).ready(function(){
            $('.dropify').dropify();
        });
</script>
@endpush

@push('file_manager')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        var editor_config = {
          path_absolute : "/",
          selector: "textarea.my-editor",
          plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
          relative_urls: false,
          file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
      
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
              cmsURL = cmsURL + "&type=Images";
            } else {
              cmsURL = cmsURL + "&type=Files";
            }
      
            tinyMCE.activeEditor.windowManager.open({
              file : cmsURL,
              title : 'Filemanager',
              width : x * 0.8,
              height : y * 0.8,
              resizable : "yes",
              close_previous : "no"
            });
          }
        };
      
        tinymce.init(editor_config);
    </script>
@endpush