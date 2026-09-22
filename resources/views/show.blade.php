<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Queue Status</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="5">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 text-center max-w-md w-full">
        <h2 class="text-gray-500 font-semibold mb-2 uppercase tracking-wide">Queue Status</h2>
        
        <div class="my-6">
            <h1 class="text-6xl font-black text-gray-800 mb-2">{{ $queue->tracking_number }}</h1>
            <p class="text-xl text-gray-600">{{ $queue->name }}</p>
        </div>

        <div class="mt-8 mb-4">
            @if($queue->status === 'holding')
                <div class="bg-yellow-50 text-yellow-800 px-6 py-4 rounded-lg font-bold border border-yellow-200">
                    🕒 Waiting in Line
                </div>
            @elseif($queue->status === 'active')
                <div class="bg-blue-50 text-blue-800 px-6 py-4 rounded-lg font-bold border border-blue-200">
                    📢 You are next in line!
                </div>
            @elseif($queue->status === 'serving')
                <div class="bg-green-50 text-green-800 px-6 py-4 rounded-lg font-bold border border-green-200 shadow-sm animate-pulse">
                    ✅ Please proceed to {{ $queue->assigned_teller ?? 'the counter' }}
                </div>
            @elseif(in_array($queue->status, ['completed', 'held']))
                <div class="bg-gray-50 text-gray-800 p-6 rounded-lg border border-gray-200 shadow-sm mb-6 text-left">
                    @if($queue->status === 'completed')
                        <h3 class="text-xl font-bold text-center mb-4 text-green-600">🎉 Transaction Complete</h3>
                    @else
                        <h3 class="text-xl font-bold text-center mb-4 text-orange-600">⚠️ No Show (Cancelled)</h3>
                    @endif
                    
                    <div class="space-y-2 text-sm">
                        <p class="flex justify-between"><span class="text-gray-500">Name:</span> <span class="font-medium">{{ $queue->name }}</span></p>
                        <p class="flex justify-between"><span class="text-gray-500">Teller:</span> <span class="font-medium">{{ $queue->assigned_teller ?? 'Counter' }}</span></p>
                        <p class="flex justify-between"><span class="text-gray-500">Final Status:</span> <span class="font-bold {{ $queue->status === 'completed' ? 'text-green-600' : 'text-orange-600' }}">{{ $queue->status === 'completed' ? 'Successfully Served' : 'Marked as No Show' }}</span></p>
                        <p class="flex justify-between"><span class="text-gray-500">Joined at:</span> <span class="font-medium">{{ $queue->created_at->format('h:i A') }}</span></p>
                        <p class="flex justify-between"><span class="text-gray-500">Finished at:</span> <span class="font-medium">{{ $queue->updated_at->format('h:i A') }}</span></p>
                        <p class="flex justify-between pt-2 mt-2 border-t border-gray-200"><span class="text-gray-500">Total Duration:</span> <span class="font-bold">{{ $queue->created_at->diffForHumans($queue->updated_at, true) }}</span></p>
                    </div>
                </div>
                <a href="/" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-md transition text-lg text-center">
                    Request New Ticket
                </a>
            @else
                <div class="bg-gray-100 text-gray-800 px-6 py-4 rounded-lg font-bold">
                    Status: {{ ucfirst($queue->status) }}
                </div>
            @endif
        </div>
        
        <p class="mt-6 text-sm text-gray-400 flex items-center justify-center gap-2">
            <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Auto-refreshing every 5 seconds
        </p>
    </div>
</body>
</html>
