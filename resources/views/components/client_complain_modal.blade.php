<span class="text-decoration-underline mt-2 d-block" style="cursor: pointer;color: #fea84b"
      href="javascript:void(0);"
      data-bs-toggle="modal" data-bs-target="#complain-modal">
            لدي مشكلة في الطلب
        </span>

<div class="modal fade" id="complain-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('client.complain.store',$order) }}" method="post" class="modal-content w-color"
              style="background-color: #131416">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
            <div class="modal-header border-0">
                <button type="button" style="background-color: #fea84b !important" class="btn-close w-color"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="exampleModalLabel">اشرح مشكلتك بالتفصيل</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="complainType" class="form-label w-color">نوع المشكلة</label>
                    <select class="form-control complain-input" name="complain_type_id" id="complainType">
                        @foreach($complainTypes as $complainType)
                            <option
                                @if(old('complain_type_id') == $complainType->id) selected @endif
                            value="{{ $complainType->id }}">{{ $complainType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="complainDescription" class="form-label w-color">
                        الوصف (متبقي <span class="description-char-count">100</span> حرف)
                    </label>
                    <textarea class="form-control complain-input complain-description" name="description"
                              id="complainDescription" rows="5">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label style="color: gray" for="order_id" class="font-weight-bold">
                                من فضلك ادخل الكود التالي
                            </label>
                            <input type="text" class="form-control" name="captcha"
                                   style="background: #131416; color: gray"
                                   placeholder="الرمز" required>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label style="color: gray" for="order_id" class="font-weight-bold">
                            الكود
                        </label>
                        <div class="form-group">
                                    <span>
                                        {!!  captcha_img()  !!}
                                    </span>
                            <button id="reload-captcha" type="button"
                                    style="background: #fea84b;padding: 3px 15px;;font-weight: bold;font-size: 15px;"
                                    class="btn captcha-image">اعادة تحميل
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-0" style="background-color: #131416;">
                <button type="button" class="btn btn-secondary w-color" data-bs-dismiss="modal">
                    اغلاق
                </button>
                <button type="submit" class="btn btn-primary" style="background-color: #fea84b;">ارسال</button>
            </div>
        </form>
    </div>
</div>
