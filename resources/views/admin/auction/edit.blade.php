@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
                <a href="{{ route('admin.auctions.index') }}"><i class="icon-back"></i>  İlan Listesine Dön</a>
            </div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><b>Kategori: Anasayfa</b></li>
            @foreach($auction['category']['ancestors'] AS $ancestor)
                    <li class="breadcrumb-item">{{ $ancestor['name'] }}</li>
                @endforeach
                    <li class="breadcrumb-item active" aria-current="page">{{ $auction['category']['name'] }}</li>
            </ol>
        </nav>
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            #{{ $auction['id'] }}İlan detayı
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>{{ $auction['title'] }}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md">
                                            @if($auction['profile_picture'] != null)
                                                <img
                                                    src="{{ url(env('WEB_CLIENT_URL') . '/storage/'.$auction['id'].'/'.$auction['profile_picture']) }}"
                                                    class="img-thumbnail" id="big-image"/>
                                            @else
                                                <img src="https://via.placeholder.com/500" class="img-fluid" id="big-image">
                                            @endif

                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($auction['images'] AS $image)
                                            <div class="col-md-2">
                                                <a href="javascript:;" class="img-sm"
                                                   data-img="{{  url(env('WEB_CLIENT_URL') .'/storage/'.$auction['id'].'/'.$image['file_name']) }}">
                                                    <img
                                                        src="{{ url(env('WEB_CLIENT_URL') . '/storage/'.$auction['id'].'/'.str_replace('_org.', '_thumb.', $image['file_name'])) }}"
                                                        class="img-thumbnail img-sm"
                                                        data-img="{{  url(env('WEB_CLIENT_URL') .'/storage/'.$auction['id'].'/'.$image['file_name']) }}"
                                                    />
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ $auction['user']['name'] }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($auction['direction'] == 0)
                                                {{ number_format($auction['price'],2) }} {{ $auction['currency'] }}
                                            @else
                                                {{ number_format($auction['min_price'], 2) }}
                                                - {{ number_format($auction['max_price'],2) }} {{ $auction['currency'] }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    {!! $auction['description'] !!}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ url(env('WEB_CLIENT_URL') . '/'.$auction['slug'].'/'.$auction['id']) }}"
                                       target="_blank" class="btn btn-outline-success"><i class="icon-video"></i> İlan Detayı</a>
                                    <a href="javascript:;" class="btn btn-primary btn-accept-auction" data-toggle="modal" data-target="#onayModal"><i class="icon-ok-circled"></i> Onayla</a>
                                    <a href="javascript:;" class="btn btn-danger" data-toggle="modal" data-target="#redModal"><i class="icon-cancel-circled"></i> Reddet</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">İlan Güncellemeleri</div>
                    </div>
                    <div class="card-body">
                            <h4>İlan Güncellemeleri</h4>
                            <div class="list-group">
                                @foreach($auction['logs'] AS $log)
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start @if($log['status'] == 1) bg-success @else bg-danger @endif">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $log['user']['name'] }}</h5>
                                            <small>{{\Carbon\Carbon::createFromTimeStamp(strtotime($log['created_at']))->diffForHumans()}}</small>
                                        </div>
                                        <p class="mb-1">{{ $log['status_message'] }}</p>
                                        <small>Güncelleme: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $log['created_at'])->format('d-m-Y H:i:s') }}</small>
                                    </a>
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>

    </div>

    <div class="modal fade" id="onayModal" tabindex="-1" role="dialog" aria-labelledby="onayModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-ok-circled"></i> Onayla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bu ilanı onaylamak üzeresiniz, ilanı onayladığınızda binlerce kullanıcı aynı anda ilanı görmeye başlayacak.</p>
                    <p>Bu kararın doğruluğundan emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.auction.update', ['id' => $auction['id']]) }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" value="{{ $auction['id'] }}" name="auction_id" />
                        <input type="hidden" value="1" name="status" />
                    <button type="submit" class="btn btn-primary">Evet Onayla</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="redModal" tabindex="-1" role="dialog" aria-labelledby="redModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-ok-circled"></i> Reddet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.auction.update', ['id' => $auction['id']]) }}" method="post">

                <div class="modal-body">
                    <p>Bu ilanı reddetmek üzeresiniz, lütfen sebebini belirtin</p>
                    <textarea class="form-control" rows="3" name="status_message"></textarea>
                    <p>Bu kararın doğruluğundan emin misiniz?</p>
                </div>
                <div class="modal-footer">
                        @csrf
                        @method('patch')
                        <input type="hidden" value="{{ $auction['id'] }}" name="auction_id" />
                        <input type="hidden" value="2" name="status" />
                        <button type="submit" class="btn btn-primary">İlanı Reddet</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            $('.img-sm').on('click', function () {
                $('#big-image').prop('src', $(this).data('img'));
            });

            $('.add-to-cart').on('click', function () {
                var auction_id = $(this).data('id');

                $.ajax({
                    type: 'post',
                    url: '/ajx/cart/',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "auction_id": auction_id
                    },
                    success: function (data) {

                    }
                });
            });

            $('.btn-accept-auction').on('click', function () {

            });
        });


    </script>
@endpush

