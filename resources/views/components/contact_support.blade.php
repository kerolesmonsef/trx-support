@php use App\Models\Settings; @endphp
@push("styles")
    <style>
        .icon:hover {
            background-color: #f8c232;
            cursor: pointer;
        }

        .contact-info .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fea84b;
            color: #fff;
            text-align: center;
            line-height: 40px;
        }
    </style>
@endpush
<div class="contact-info" style="text-align: center;padding: 10px;border-radius: 5px;background-color: #131416;">
    <h1 class="w-color">يمكنك التواصل مع الدعم مباشرة من خلال</h1>
    <div class="contact-icons" style=" display: flex;justify-content: center;gap: 10px;">
        <a href=" https://wa.me/{{ Settings::valueByKey('whatsapp') }}" class="icon whatsapp">
            <img style="width: 100%;" src="{{ asset("images/whatsapp.png") }}" alt="واتس اب">
        </a>
        <a href="{{ Settings::valueByKey('telegram') }}" class="icon telegram">
            <img style="width: 100%;" src="{{ asset("images/telegram.png") }}" alt="تلجرام"></a>
    </div>
</div>
