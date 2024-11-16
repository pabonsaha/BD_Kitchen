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
                    <tr>
                        <td colspan="3" class="py-4 px-6 text-center text-gray-500">No orders found. Here is some demo data:</td>
                    </tr>
                    <!-- Demo data -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-6">DEMO-001</td>
                        <td class="py-3 px-6">2024-11-01</td>
                        <td class="py-3 px-6">$99.99</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-6">DEMO-002</td>
                        <td class="py-3 px-6">2024-11-02</td>
                        <td class="py-3 px-6">$49.50</td>
                    </tr>
                @else
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $order->id }}</td>
                            <td class="py-3 px-6">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-6">${{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
