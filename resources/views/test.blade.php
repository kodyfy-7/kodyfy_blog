@php
    $array = array(array('metaname' => 'color', 'metavalue' => 'blue'), array('metaname'  => 'size', 'metavalue' => 'big'));
@endphp

<h3>Buy movie Tickets</h3>
<form action="{{route('pay')}}" method="post" id="paymentForm">
    @csrf
    <input type="hidden" name="amount" value="500">
    <input type="hidden" name="payment_method" value="both">
    <input type="hidden" name="description" value="Beats by dre">
    <input type="hidden" name="country" value="NG">
    <input type="hidden" name="currency" value="NGN">
    <input type="hidden" name="email" value="test@test.com">
    <input type="hidden" name="firstname" value="Oluwole">
    <input type="hidden" name="lastname" value="Adebiyi">
    <input type="hidden" name="metadata" value="{{ json_encode($array) }}">
    <input type="hidden" name="phonenumber" value="09085985896">
    {{-- <input type="hidden" name="" value=""> --}}
    {{-- <input type="hidden" name="" value=""> --}}
    {{-- <input type="hidden" name="" value=""> --}}
    {{-- <input type="hidden" name="" value=""> --}}
    <input type="submit" value="buy">
</form>