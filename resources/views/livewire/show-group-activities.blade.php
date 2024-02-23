<?php
/** @var \App\Models\Activity[] $activities */

?>
<div>
    <style>
        pre {
            outline: 1px solid #ccc;
            padding: 5px;
            margin: 5px;
        }

        .string {
            color: green;
        }

        .number {
            color: darkorange;
        }

        .boolean {
            color: blue;
        }

        .null {
            color: magenta;
        }

        .key {
            color: red;
        }
    </style>



    <div class="card">
        <div class="card-header">
            قاثمة التحديثات
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>تسلسل</th>
                    <th>اسم الشخص</th>
                    <th>الكائن</th>
                    <th>الحدث</th>
                    <th>التاريخ</th>
                    <th>تفاصيل المبرمج</th>
                </tr>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ $activity?->causer?->name }}</td>
                        <td>{{ $activity->getSubjectInfoString() }}</td>
                        <td>{{ $activity->getArabicEvent() }}</td>
                        <td>{{ $activity->created_at }}</td>
                        <td>
                            <pre class="result-{{ $activity->id }}"></pre>

                            <script>
                                let json_{{$activity->id}} = syntaxHighlight(JSON.stringify(@json($activity->properties), undefined, 4));
                                $(".result-{{ $activity->id }}").html(json_{{$activity->id}})
                            </script>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="card-footer">
            {!! $activities->links() !!}
        </div>
    </div>


</div>
