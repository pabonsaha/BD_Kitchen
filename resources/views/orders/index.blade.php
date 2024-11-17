@extends('user.layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6">Order List</h2>
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full bg-white border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left font-medium text-gray-700">Order ID</th>
                    <th class="py-3 px-6 text-left font-medium text-gray-700"> Order Date</th>
                    <th class="py-3 px-6 text-left font-medium text-gray-700">Total Price</th>
                </tr>
            </thead>
            <tbody>

                @if($orders->isEmpty())
                    <h5>No Order Found</h5>
                @else
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $order->id }}</td>
                            <td class="py-3 px-6">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-6">{{ number_format($order->grand_total_amount, 2) }}tk</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
