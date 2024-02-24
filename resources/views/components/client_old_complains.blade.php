<?php
/** @var $order \App\Models\Order */
?>
<style>
    .dark-bg {
        background-color: #131416;
    }

    .complains-table tr th, .complains-table tr td {
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
        background-color: #131416;
    }
</style>
<div class="container mt-4">
    <!-- New Section for Previous Tickets -->
    <div class="row">
        <h4 class="text-center text-white mb-4">التذاكر السابقة</h4>
        <div class="card mb-3 dark-bg">
            <div class="card-body">
                <!-- Ticket Table -->
                <div class="table-responsive">
                    <table class="table table-dark table-bordered mb-0 dark-bg complains-table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">رقم التذكرة</th>
                            <th scope="col">الحالة</th>
                            <th scope="col">تاريخ الانشاء</th>
                            <th scope="col">نوع المشكلة</th>
                            <th scope="col">الرد علي تذكرتك</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $complains = $order->complains()->orderByDesc("id")->get();
                        ?>
                        @foreach($complains as $complain)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $complain->code }} </td>
                                <td>
                                    @component("livewire.components.complainStatus")
                                        @slot("orderComplain", $complain)
                                    @endcomponent
                                </td>
                                <td>
                                    {{ $complain->created_at }}
                                </td>
                                <td>
                                    {{ $complain->type->name }}
                                </td>
                                <td>
                                    @if($complain->complain_answer)
                                        <!-- Button trigger modal -->
                                        <button style="cursor: pointer;border: 1px solid;display: inline-block !important;background-color: #fea84b;border-radius: 5px;font-size: 14px;font-weight: bold;"
                                            type="button" class="btn complain-show-replay btn-sm" data-bs-toggle="modal" data-bs-target="#replayModal"
                                                data-replay="{{ $complain->complain_answer }}"
                                        >
                                            اظهار الرد
                                        </button>
                                    @else
                                        <span class="w-color">لا يوجد رد</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <!-- Add more rows for additional tickets -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="replayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: rgb(19, 20, 22)">
            <div class="modal-header">
                <h5 class="modal-title w-color" >الرد علي تذكرتك</h5>
                <button type="button"
                        style="background-color: #fea84b"
                        class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-color complain-answer-modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.complain-show-replay').click(function() {
                var replay = $(this).data('replay');
                $('.complain-answer-modal-body').text(replay);
            });
        });
    </script>
@endpush
