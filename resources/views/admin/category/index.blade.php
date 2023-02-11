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

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Adı</th>
                                    <th>Durum</th>
                                    <th>İlan Sayısı</th>
                                    <th>Düzenle</th>
                                    <th>Alt Kategoriler</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($categories AS $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @can('status categories')
                                            <a href="{{ route('admin.category.status', ['category_id' => $category->id]) }}">
                                                {!! \App\Helpers\Helpers::badgeStatus($category->status) !!}
                                            </a>
                                            @else

                                            {!! \App\Helpers\Helpers::badgeStatus($category->status) !!}
                                            <a href="javascript:void(0)"  data-trigger="hover" data-toggle="popover" title="Yardım" data-content="Kategori Açma/Kapama yetkiniz yok. Lütfen yöneticiniz ile görüşün.">
                                                <i class="icon-help-circled text-danger"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td></td>
                                    <td>
                                        @can('edit categories')
                                        <a href="{{ route('admin.category.edit', ['category_id' => $category->id]) }}" class="btn btn-success btn-sm">Düzenle</a>
                                            @else
                                            <a type="button" class="" data-trigger="hover" data-toggle="popover" title="Yardım" data-content="Kategori Düzenleme yetkiniz yok. Lütfen yöneticiniz ile görüşün.">
                                            <i class="icon-help-circled text-danger"></i>
                                            </a>
                                            @endcan
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.category.index', ['parent_id' => $category->id]) }}" class="btn btn-success btn-sm">Alt Kategoriler</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    {{ $categories->render() }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover();

        });
    </script>
    @endpush
