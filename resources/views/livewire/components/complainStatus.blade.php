<?php
/** @var \App\Models\OrderComplain $orderComplain */

?>

@if($orderComplain->isPending())
    <span class="badge bg-warning">جار المعالجة</span>
@endif

@if($orderComplain->isSolved())
    <span class="badge bg-success">تم المعالجة</span>
@endif

@if($orderComplain->notSolved())
    <span class="badge bg-danger">لم تتم المعالجة</span>
@endif
