@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Görsel</th>
                            <th>Başlık</th>
                            <th>Son Güncelleyen</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($auctions AS $auction)
                        <tr>
                            <td>#{{ $auction->id }}</td>
                            <td>Görsel</td>
                            <td>{{ $auction->title }}</td>
                            <td>{{ $auction->admin->name ?? ''}}</td>
                            <td>{!! \App\Helpers\Helpers::badgeStatus($auction->status) !!}</td>
                            <td><a href="{{ route('admin.auctions.edit', ['id' => $auction->id]) }}" class="btn btn-primary">İncele</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
