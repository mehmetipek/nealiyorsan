@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Yeni Arama Oluştur</div>
                            <div class="col-md text-md-right"><a href="{{ route('admin.search.index') }}"
                                                                 class="btn btn-warning btn-sm">Arama Listesi</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="user_id">Kullanıcı</label>
                                    <select class="selectpicker form-control"  data-style="btn-warning"
                                            data-live-search="true" required="required" name="user_id" id="user_id" title="Kullanıcı Seçin">
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category_id">Kategori</label>
                                    <select class="selectpicker form-control"  data-style="btn-info"
                                            data-live-search="true" required="required" name="category_id"
                                            id="category_id" title="Kategori Seçin">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Arama Kelimeleri</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="arama, kelimelerini, virgülle, ayırın">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="start_price">Min Fiyat</label>
                                    <input name="start_price" type="number" class="form-control" id="start_price">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end_price">Maks Fiyat</label>
                                    <input name="end_price" type="number" class="form-control" id="end_price">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Arama Kaydı Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endpush

@push('js')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/field_types.js') }}"></script>
@endpush
