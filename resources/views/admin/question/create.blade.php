@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="post">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="selectCategory">Kategori Seçiniz</label>
                    <select class="form-control" id="selectCategory" name="question_category">
                        <option selected>Seçiniz</option>
                        @foreach($categories AS $category)
                            <option
                                value="{{$category['question_category']}}">{{$category['question_category']}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="newCategory" >Kategori Seçiniz (Yeni bir kategori eklemeyecekseniz lütfen bu alanı boş bırakın)</label>
                    <input type="text" name="new_category" id="newCategory" placeholder="Yeni Kategori">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="question">Soru</label>
                    <input type="text" class="form-control" id="question" name="question" required="required">
                    <br>
                    <label for="answer">Cevap</label>
                    <input type="text" class="form-control" id="answer" name="answer" required="required">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>
@endsection
