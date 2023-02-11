@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Kategoriler</div>
                            <div class="col-md text-md-right"><a href="{{ route('admin.field.create') }}" class="btn btn-success btn-sm">Yeni Kategori Alanı Ekle</a></div>
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
                                    <th>Adı</th>
                                    <th>Tipi</th>
                                    <th>Kategori</th>
                                    <th>Düzenle</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($fields AS $field)
                                <tr>
                                    <td>{{ $field->name }}</td>
                                    <td>{{ $field->type }}</td>
                                    <td>{{ $field->category->name }}</td>
                                    <td>
                                        @can('edit categories')
                                        <a href="{{ route('admin.field.edit', ['field_type_id' => $field->id]) }}" class="btn btn-success btn-sm">Düzenle</a>
                                            @else
                                            <a type="button" class="" data-trigger="hover" data-toggle="popover" title="Yardım" data-content="Alan Düzenleme yetkiniz yok. Lütfen yöneticiniz ile görüşün.">
                                            <i class="icon-help-circled text-danger"></i>
                                            </a>
                                            @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">
                                    {{ $fields->render() }}
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
