@php 
$invoice = isset($invoice) ? $invoice : null;
$invoice = isset($purchase) ? $purchase : $invoice;
$invoice = isset($quotation) ? $quotation : $invoice;
$primary_color = get_business_option('invoice_primary_color', '#30336b', $invoice->business_id);
@endphp

<style type="text/css">
.default-invoice .invoice-header{background: {{ $primary_color; }} !important;}
.default-invoice .invoice-body table thead th{background-color: {{ $primary_color; }} !important;}
.default-invoice .invoice-summary table td {background-color: {{ $primary_color; }} !important;}
</style>