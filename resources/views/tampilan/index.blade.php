@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
{{-- Modal Trigger --}}
  <div class="row">
    <div class="col-md-6">
      <button type="button" class="btn btn-primary btn-user btn-block mb-3" data-toggle="modal" data-target="#modal_tugas">
        Buat Pertanyaan Baru
      </button>
    </div>

    <div class="col-md-6">
      <a class="btn btn-primary mb-3 btn-user btn-block" href="/index/all" role="button">Lihat List Pertanyaan</a>
    </div>
  </div>
    
  @if (session("success"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <h4>{{session("success")}}</h4>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    </div>
  @endif

  {{-- <div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Contoh List Tugas</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                        <div class="dropdown-header">Setting:</div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_tugas_edit">Edit Pertanyaan</a>
                        <a class="dropdown-item" href="/index/show">Show</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#">Delete Pertanyaan</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <p>Nama Materi: bla bla bla</p>
                <p>Tugas: buatlah diagram flow terus di kumpulkan dalam bentuk gambar</p>
                <div class="dropdown-divider"></div>
                <div class="d-flex justify-content-between">
                  <a class="like" href="#">100&nbsp;<i class="far fa-thumbs-up"></i></a>
                  <a class="dislike" href="#">50&nbsp;<i class="far fa-thumbs-down"></i></a>
                </div>
            </div> --}}
  {{-- <button type="button" class="btn btn-primary btn-user btn-block mb-3" data-toggle="modal" data-target="#modal_tugas">
    Buat Pertanyaan Baru
  </button> --}}

<div class="row">
  @forelse ($listPertanyaan as $key => $isi)
  <div class="col-lg-4">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{$isi->judul_pertanyaan}}</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                    <div class="dropdown-header">Setting:</div>
                    {{-- <a class="dropdown-item" href="{{route('pertanyaan.show', ['pertanyaan'=>$isi->id_pertanyaan])}}">Show</a> --}}
                    <a class="dropdown-item" href="/pertanyaan/{{$isi->id_pertanyaan}}/edit" data-toggle="modal" data-target="#modal_tugas_edit{{$isi->id_pertanyaan}}">Edit</a>
                    <a class="dropdown-item" href="{{route('pertanyaan.show', ['pertanyaan'=>$isi->id_pertanyaan])}}">Show</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/pertanyaan/{{$isi->id_pertanyaan}}" data-toggle="modal" data-target="#modal_tugas_hapus{{$isi->id_pertanyaan}}">Delete</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <p>Keterangan: {{$isi->isi_pertanyaan}}</p>
            <p>File: {{old('default', $isi->file_pertanyaan ?? 'Tidak ada Attachement')}}</p>
        </div>
    </div>
</div>
  @empty
      <div class="col-lg-12">
        <h3>Tidak ada pertanyaan yang dibuat</h3>
      </div>
  @endforelse
    
</div>


{{-- Modal untuk buat pertanyaan--}}
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


{{-- Modal untuk edit tugas --}}
@forelse ($listPertanyaan as $key => $isi)
  <div class="modal fade" id="modal_tugas_edit{{$isi->id_pertanyaan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Edit Pertanyaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/pertanyaan/{{$isi->id_pertanyaan}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="judul_pertanyaan">Judul Pertanyaan</label>
              <input type="text" class="form-control"
              id="judul_pertanyaan" name="judul_pertanyaan"
              placeholder="Judul Pertanyaan" value = "{{old('judul_pertanyaan', $isi->judul_pertanyaan ?? '')}}">
            </div>

            <div class="form-group">
              <label for="judul_pertanyaan">Isi Pertanyaan</label>
              <input type="text" class="form-control"
              id="isi_pertanyaan" name="isi_pertanyaan"
              placeholder="Isi Pertanyaan" value = "{{old('judul_pertanyaan', $isi->isi_pertanyaan ?? '')}}">
            </div>

            <div class="form-group">
              <label for="judul_pertanyaan">Upload File (Jika Diperlukan) </label>
              <div class="custom-file">
                  <input type="file" class="dropify" data-height="100" id="input_file" name="input_file" value = "{{old('judul_pertanyaan', $isi->input_file ?? '')}}">
                </div>
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
@empty
    
@endforelse

{{-- Modal untuk Delete tugas --}}
@forelse ($listPertanyaan as $key => $isi)
  <div class="modal fade" id="modal_tugas_hapus{{$isi->id_pertanyaan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Hapus Pertanyaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/pertanyaan/{{$isi->id_pertanyaan}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('DELETE')
            <div class="form-group">
              <h2>Apakah anda yakin ingin menghapus pertanyaan ini?</h2>
              <h3>Judul Pertanyaan: {{$isi->judul_pertanyaan}} </h3>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <form action="/pertanyaan/{{$isi->id_pertanyaan}}" method="POST">
                  @csrf
                  @method('DELETE')        
                  <input type="submit" name="delete" id="delete" value='Hapus' class="btn btn-danger btn-sm">
                </form>
              </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>
@empty
    
@endforelse

@endsection

@push('dropify')
<script src="{{ asset('dropify/dist/js/dropify.js' )}}"></script>
<script type="text/javascript">
        $(document).ready(function(){
            $('.dropify').dropify();
        });
</script>
@endpush