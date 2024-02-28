@php use App\Models\Settings; @endphp
<?php
/** @var \App\Models\Order $order */
?>
<div class="text-end">
     <span class="mt-2 d-block mt-5 "
           style="cursor: pointer;border: 1px solid;display: inline-block !important;background-color: #fea84b;border-radius: 5px;padding: 10px;font-size: 14px;font-weight: bold;"
           href="javascript:void(0);"
           data-bs-toggle="modal" data-bs-target="#complain-modal">
             إنشاء تذكرة بسبب مشكلة في طلبي
</span>
</div>

<div class="modal fade" id="complain-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('client.complain.store',$order) }}" method="post" class="modal-content w-color"
              style="background-color: #131416">
            <div class="smartwizard">
                <ul class="nav">
                    <li class="nav-item">
                            <span class="nav-link" href="#step-1">
                                <div class="num">1</div>
                                الشروط و الاحكام
                            </span>
                    </li>
                    <li class="nav-item">
                            <span class="nav-link" href="#step-2">
                                <span class="num">2</span>
                                اكتب مشكلتك
                            </span>
                    </li>
                    <li class="nav-item">
                            <span class="nav-link" href="#step-3">
                                <span class="num">3</span>
                                اوافق علي الشروط
                            </span>
                    </li>

                </ul>

                <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                        @if($order->hasAccount())
                            {!! Settings::valueByKey('complain_account_terms_and_conditions') !!}
                        @else
                            {!! Settings::valueByKey('complain_coupon_terms_and_conditions') !!}
                        @endif
                    </div>
                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="exampleModalLabel">اشرح مشكلتك بالتفصيل</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="complainType" class="form-label w-color">نوع المشكلة</label>
                                <select class="form-control complain-input" name="complain_type_id" id="complainType">
                                    @foreach($complainTypes as $complainType)
                                        <option @if(old('complain_type_id') == $complainType->id) selected @endif
                                        value="{{ $complainType->id }}">{{ $complainType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="complainDescription" class="form-label w-color">
                                    الوصف (متبقي <span class="description-char-count">100</span> حرف)
                                </label>
                                <textarea class="form-control complain-input complain-description"
                                          name="description"
                                          id="complainDescription" rows="5">{{ old('description') }}</textarea>
                                <div class="invalid-feedback complain-error">
                                    الرجاء ادخال الوصف
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label style="color: gray" for="order_id" class="font-weight-bold">
                                            من فضلك ادخل الكود التالي
                                        </label>
                                        <input type="text" class="form-control" name="captcha"
                                               id="complain-captcha"
                                               style="background: #131416; color: gray"
                                               placeholder="الرمز" required>
                                        <div class="invalid-feedback complain-captcha-error">
                                            الرجاء ادخال الكود
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <label style="color: gray" for="order_id" class="font-weight-bold">
                                        الكود
                                    </label>
                                    <div class="form-group">
                                                            <span id="captcha-image">
                                                                {!!  captcha_img()  !!}
                                                            </span>
                                        <button type="button"
                                                style="background: #fea84b;padding: 3px 15px;;font-weight: bold;font-size: 15px;"
                                                class="btn  reload-captcha">اعادة تحميل
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer border-0" style="background-color: #131416;">

                        </div>
                    </div>
                    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                        <div class="">
                            @if($order->hasAccount())
                                {!! Settings::valueByKey('accept_complain_account_terms_and_conditions') !!}
                            @else
                                {!! Settings::valueByKey('accept_complain_coupon_terms_and_conditions') !!}
                            @endif
                        </div>
                        <label class="form-check-label" for="flexSwitchCheckDefault"> اوافق على الشروط و الاحكام</label>
                        <div class="form-switch d-inline-block">
                            <input class="form-check-input" required type="checkbox" id="flexSwitchCheckDefault">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary" style="background-color: #fea84b;">ارسال
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Include optional progressbar HTML -->
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
            </div>
        </form>
    </div>
</div>
