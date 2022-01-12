@extends('layouts.master')

@section('title')
    Show
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Show Pertanyaan & Jawaban</h6>
        </div>

        <div class="card-body">
            <h6>Judul Pertanyaan: {{$show->judul_pertanyaan}} </h6>
            <h6>Keterangan Pertanyaan: {{$show->isi_pertanyaan}} </h6>
            <h6>File Pertanyaan: <a href="/filePertanyaan/{{$show->file_pertanyaan}}">{{$show->file_pertanyaan}}</a>  </h6>
            <h6>Materi Terkait:  
                @foreach ($show->MateriTerkait as $materi)
                    <button class="btn btn-info btn-sm" type="button"> {{$materi->nama_materi}} </button>
                @endforeach
            </h6>
            <p>
                <a class="btn btn-primary" href="/pertanyaan" role="button">Kembali ke halaman sebelumnya</a>
            </p>

            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th style="width: 10px">No</th>
                        <th>Pemberi Jawaban</th>
                        <th>Keterangan Jawaban</th>
                        <th>File Jawaban</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($show->DaftarJawaban as $key => $jawaban)
                    <tr>
                        <td> {{$key+1}}</td>
                        <td> {{$jawaban->PemberiJawaban->name}} </td>
                        <td> {!! $jawaban->isi_jawaban !!} </td>
                        <td> <a href="/fileJawaban/{{$jawaban->file_jawaban}}"> {{$jawaban->file_jawaban}} </a> </td>
                    </tr>
                    @empty
                        <td colspan="4" align="center">Belum ada yang menjawab pertanyaan anda</td>       
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection