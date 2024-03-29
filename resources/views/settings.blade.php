@php use App\Models\Settings; @endphp
@extends('layouts.app')
@push("styles")


@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>الاعدادات</h1>
                <form action="{{ route("settings.update") }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="coupon_privacy_policy">سياسة خصوصية الكوبونات</label>
                        <textarea class="form-control editor"
                                  name="coupon_privacy_policy">{{ Settings::valueByKey("coupon_privacy_policy") }}</textarea>
                    </div>
                    <br>
                    <hr>
                    <div class="form-group">
                        <label for="account_privacy_policy">سياسة خصوصية الحسابات</label>
                        <textarea class="form-control editor"
                                  name="account_privacy_policy">{{ Settings::valueByKey("account_privacy_policy") }}</textarea>
                    </div>
                    <br>
                    <hr>
                    <div class="form-group">
                        <label for="terms_and_conditions">الشروط والأحكام في المشاكل البروفايلات</label>
                        <textarea class="form-control editor" name="complain_account_terms_and_conditions">{{ Settings::valueByKey("complain_account_terms_and_conditions") }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="terms_and_conditions">اوافق الشروط والأحكام في المشاكل البروفايلات</label>
                        <textarea class="form-control editor" name="accept_complain_account_terms_and_conditions">{{ Settings::valueByKey("accept_complain_account_terms_and_conditions") }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="terms_and_conditions">الشروط والأحكام في المشاكل الكوبونات</label>
                        <textarea class="form-control editor" name="complain_coupon_terms_and_conditions">{{ Settings::valueByKey("complain_coupon_terms_and_conditions") }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="terms_and_conditions">اوافق الشروط والأحكام في المشاكل الكوبونات</label>
                        <textarea class="form-control editor" name="accept_complain_coupon_terms_and_conditions">{{ Settings::valueByKey("accept_complain_coupon_terms_and_conditions") }}</textarea>
                    </div>
                    <br>
                    <hr>
                    <div class="form-group">
                        <label for="telegram">تلجرام</label>
                        <input class="form-control" name="telegram" id="telegram" value="{{ Settings::valueByKey("telegram") }}">
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">الواتس اب</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ Settings::valueByKey("whatsapp") }}">
                    </div>

                    <br>
                    <hr>



                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <script>
        const editorElements = document.querySelectorAll('.editor');

        // Iterate over each editor element
        editorElements.forEach(element => {
            // Create ClassicEditor instance for each element
            ClassicEditor
                .create(element)
                .then(editor => {
                    // Editor created successfully
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
