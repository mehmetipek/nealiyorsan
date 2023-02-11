@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Kategoriler</div>
                            <div class="col-md text-md-right">&nbsp;</div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="form" method="post" action="{{ route('admin.category.update', ['category_id' => $category->id]) }}">
                            @csrf
                            <div class="form-group">

                                    <small>{{ $category->ancestors->count() ? implode(' > ', $category->ancestors->pluck('name')->toArray()) : 'Top Level' }}
                                 > {{ $category->name }}</small>
                            </div>
                            <div class="form-group">
                                <label for="name">Kategori Adı:</label>
                                <input type="text" name="name" class="form-control" placeholder="Kategori Adı Yaz" id="name" value="{{ $category->name }}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Link Adı:</label>
                                <input type="text" name="slug" class="form-control" placeholder="link adi" id="slug" value="{{ $category->slug}}">
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
