@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Aramalar</div>
                            <div class="col-md text-md-right"><a href="{{ route('admin.search.create') }}" class="btn btn-success btn-sm">Yeni Arama
                                    Oluştur</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                            <th>id</th>
                            <th>Kullanıcı</th>
                            <th>Kategori</th>
                            <th>Kelimeler</th>
                            <th>Durum</th>
                            </thead>
                            <tbody>
                            @foreach($searchlogs AS $search)
                            <tr>
                                <td>{{ $search->id }}</td>
                                <td>{{ $search->user->name }}</td>
                                <td>{{ $search->category->name }}</td>
                                <td>{{ $search->keywords }}</td>
                                <td>{{ $search->status }}</td>
                            </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">{{ $searchlogs->render() }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
