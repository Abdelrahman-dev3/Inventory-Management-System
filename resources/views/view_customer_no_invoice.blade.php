@extends('layouts.main')

@section('title', 'Add Supplier')

@section('style')
<style>
    .my-box {
        height: 50px;
        transition: all 5s ease;
        overflow: hidden; 
        cursor: pointer;
    }

    .my-box.active_inv {
        height: fit-content;
    }
</style>

@endsection

@section('content')
<h1 style="font-weight: bold;text-align: center;color: #0000001f;margin-top: 236px;">This Customer Does't Have A Invoices</h1>
@endsection