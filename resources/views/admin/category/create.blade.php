@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Kategoriler</div>
                            <div class="col-md text-md-right"><a href="{{ route('admin.category.create', ['parent_id' => $parent_id]) }}" class="btn btn-success btn-sm">Yeni Kategori Ekle</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="form" method="post" action="{{ route('admin.category.store', ['parent_id' => $parent_id]) }}">
                            @csrf
                            <div class="form-group">
                                @if($parent_id != null)
                                    <h3>Üst Kategori: {{ $parent->name }}</h3>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Kategori Adı:</label>
                                <input type="text" name="name" class="form-control" placeholder="Kategori Adı Yaz" id="name">
                            </div>
                            <div class="form-group">
                                <label for="slug">Link Adı:</label>
                                <input type="text" name="slug" class="form-control" placeholder="link adi" id="slug">
                                <small class="text-muted">Boş bırakabilirsin</small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-lg" type="submit">Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
