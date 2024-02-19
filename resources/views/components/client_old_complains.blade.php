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
                            <th scope="col">نوع المشكلة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->complains as $complain)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $complain->id }}</td>
                                <td>
                                    @component("livewire.components.complainStatus")
                                        @slot("orderComplain", $complain)
                                    @endcomponent
                                </td>
                                <td>
                                    {{ $complain->type->name }}
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
