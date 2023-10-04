<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg max-w-md">
            @if (Session::has('success'))
                <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 mb-4">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('fail'))
                <div role="alert"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ Session::get('fail') }}
                </div>
            @endif
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Select Payment Method</h1>

            <form action="{{ route('payment.select.post', [$order->id, $order->orderedBy, $order->orderedFrom]) }}"
                method="POST">
                @csrf
                <!-- Payment Method Selection -->
                <div class="flex flex-col space-y-4">
                    <!-- Esewa -->
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="esewa" class="text-indigo-500" />
                        <span class="text-lg font-semibold text-gray-800">Esewa</span>
                    </label>

                    <!-- Visa Card -->
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="stripe" class="text-indigo-500" />
                        <span class="text-lg font-semibold text-gray-800">Visa Card</span>
                    </label>

                    <!-- COD -->
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="COD" class="text-indigo-500" />
                        <span class="text-lg font-semibold text-gray-800">Cash On Delivery</span>
                    </label>
                </div>

                <!-- Proceed Button -->
                <div class="mt-8">

                    <button type="submit"
                        class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
