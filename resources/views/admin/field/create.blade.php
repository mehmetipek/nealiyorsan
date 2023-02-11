@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Kategori Özelliği Oluştur</div>
                            <div class="col-md text-md-right"><a href="{{ route('admin.field.create') }}"
                                                                 class="btn btn-success btn-sm">Yeni Kategori Alanı</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="form" method="post" action="{{ route('admin.field.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="category_id">Kategori:</label>
                                    <select name="category_id" id="category_id" class="selectpicker form-control"
                                            data-live-search="true" required="required">
                                        <option value="">Kategori Seçin</option>
                                        @php

                                            $traverse = function ($categories, $prefix = '<li>', $suffix = '</option>') use (&$traverse) {
                                                foreach ($categories as $category) {
                                                    echo '<option value="'.$category->id.'">'.\App\Helpers\Helpers::repeatChar(count($category->ancestors)).$category->name.$suffix;

                                                    $hasChildren = (count($category->children) > 0);

/*                                                    if($hasChildren) {
                                                        echo('<option data-divider="true"></option>');
                                                    }
*/
                                                    $traverse($category->children);

/*                                                    if($hasChildren) {
                                                        echo('  <option data-divider="true"></option>');
                                                    }*/
                                                }
                                            };

                                            $traverse($categories);
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Özellik Adı:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Özellik Adı Yaz"
                                           id="name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="slug">id:</label>
                                    <input type="text" name="slug" class="form-control" placeholder="Kolay isim"
                                           id="slug">
                                    <small class="text-muted">Boş bırakabilirsin</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="type">Tip:</label>
                                    <select name="type" id="type" class="selectpicker form-control"
                                            data-live-search="true">
                                        <option value="">Seçiniz</option>
                                        <option value="text">Yazı</option>
                                        <option value="number">Rakam</option>
                                        <option value="select">Seçim</option>
                                        <option value="select-multi">Çoklu Seçim</option>
                                        <option value="range">Sayı Aralığı</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="radio">Radio Button</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="field_options">

                                </div>
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

    <div id="field_options_template" style="display: none;">

        <div class="row m-0 p-0" id="seperator">
            <div class="col-5 m-0 p-0">
                <hr>
            </div>
            <div class="col-3 m-0 p-0 text-center">VEYA</div>
            <div class="col-4 m-0 p-0">
                <hr>
            </div>
        </div>

        <div class="row" id="static_values_field">
            <div class="col-12">
                <div class="form-group">
                    <label for="slug">Sabit Değerler:</label>
                    <textarea type="text" name="static_values" class="form-control" placeholder="link adi"
                              id="static_values"></textarea>
                    <small class="text-muted">Virgülle ayırarak (Evet,Hayır)</small>
                </div>
            </div>
        </div>


        <div class="row" id="related_field">
            <div class="col-12">
                <div class="form-group">
                    <label for="related">Related:</label>
                    <select name="related" id="related" class="selectpicker form-control"
                            data-live-search="true">
                        <option value="">Seçiniz</option>
                        <option value="App\User">App\User</option>
                        <option value="App\Category">App\Category</option>
                        <option value="App\Country">App\Country</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="related_pluck">Related Pluck:</label>
                    <textarea type="text" name="related_pluck" class="form-control" placeholder="name,id"
                              id="related_pluck">name,id</textarea>
                    <small class="text-muted">Virgülle ayırarak (name,id)</small>
                </div>
            </div>
        </div>


        <div class="row" id="range_field">
            <div class="col-12">
                <div class="form-group">
                    <label for="slug">Aralık Değer:</label>
                    <div class="row m-0 p-0">
                        <div class="col-6 p-0">
                            <input type="number" name="range_start" class="form-control" placeholder="Başlangıç"
                                   id="range_start">
                        </div>
                        <div class="col-6 p-0">
                            <input type="number" name="range_end" class="form-control" placeholder="Bitiş"
                                   id="range_end">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" id="checkbox_field">
            <div class="col-12">
                <div class="form-group">
                    <label for="checkbox_values">Checkbox:</label>
                    <input type="text" name="checkbox_values" id="checkbox_values" class="form-control">
                    <small class="text-muted">Virgülle ayırarak (name1,name2)</small>
                </div>
            </div>
        </div>

        <div class="row" id="radio_field">
            <div class="col-12">
                <div class="form-group">
                    <label for="related_pluck">Radio:</label>
                    <input type="text" name="radio" class="form-control">
                    <small class="text-muted">Virgülle ayırarak (name|value,name|value)</small>
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
