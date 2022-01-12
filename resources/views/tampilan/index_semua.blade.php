@extends('layouts.master')

@section('title')
    List Pertanyaan
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-user btn-block mb-3" data-toggle="modal" data-target="#modal_tugas">
                Buat Pertanyaan Baru
            </button>
        </div>

        <div class="col-md-6">
            <a class="btn btn-primary mb-3 btn-user btn-block" href="/pertanyaan" role="button">Pertanyaan oleh {{Auth::user()->name}} </a>
        </div>
    </div>

    <div class="row">
      @forelse ($listPertanyaan as $key => $isi)
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><a href="{{route('jawaban.show', ['jawaban'=>$isi->id_pertanyaan])}}">{{$isi->judul_pertanyaan}}</a></h6>
              </div>

              <div class="card-body">
                <p>Keterangan: {{$isi->isi_pertanyaan}}</p>
                <p>File: {{old('default', $isi->file_pertanyaan ?? 'Tidak ada Attachement')}}</p>
                <p>Pembuat Pertanyaan: {{$isi->PertanyaanMilik->name}}</p>
                {{-- <p><a href="{{route('pertanyaan.show', ['pertanyaan'=>$isi->id_pertanyaan])}}" class="btn btn-primary" type="button">Detail Pertanyaan</a></p> --}}
              </div>
          </div>
        </div>
      @empty
        <div class="col-lg-12">
          <h3>Tidak ada pertanyaan yang dibuat</h3>
        </div>
      @endforelse
    </div>

    {{-- Modal Buat Pertanyaan --}}
    <div class="modal fade" id="modal_tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Pertanyaan Baru</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" action="/pertanyaan" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="judul_pertanyaan">Judul Pertanyaan</label>
                  <input type="text" class="form-control"
                        id="judul_pertanyaan" name="judul_pertanyaan"
                        placeholder="Judul Pertanyaan">
                </div>
    
                <div class="form-group">
                  <label for="isi_pertanyaan">Isi Pertanyaan</label>
                    <input type="text" class="form-control"
                        id="isi_pertanyaan" name="isi_pertanyaan"
                        placeholder="Keterangan Pertanyaan">
                </div>
    
                <div class="form-group">
                  <label for="file">Upload File (Jika Diperlukan)</label>
                  <input type="file" class="dropify" data-height="300" id="input_file" name="input_file">
                </div>
    
                <div class="form-group">
                  <label for="materi">Materi Terkait</label>
                  <input type="text" class="form-control"
                      id="materi" name="materi"
                      placeholder="Pisahkan dengan tanda koma jika lebih dari 1 materi. Cth: matematika,fisika,kimia">
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