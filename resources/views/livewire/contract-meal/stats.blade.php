<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Card Delivery Cost -->
    <div
        class="bg-gradient-to-br from-blue-100 to-blue-300 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2 text-blue-800">Delivery Cost</h3>
        <ul class="text-blue-900 space-y-1">
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Daily:</span>
                <strong>{{ $this->stats()['delivery_cost'] ?? 0  }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Weekly:</span>
                <strong>{{  $this->stats()['weekly_delivery_cost'] ?? 0  }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Monthly:</span>
                <strong>{{  $this->stats()['monthly_delivery_cost'] ?? 0 }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Yearly:</span>
                <strong>{{  $this->stats()['yearly_delivery_cost'] ?? 0  }}</strong>
            </li>
        </ul>
    </div>
    <!-- Card 2 -->
    <div
        class="bg-gradient-to-br from-green-100 to-green-300 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-center w-12 h-12 bg-green-500 text-white rounded-full mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path
                    d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z">
                </path>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2 text-green-800">Food Cost</h3>
        <ul class="text-green-900 space-y-1">
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Daily:</span>
                <strong>{{ $this->stats()['food_cost'] ?? 0}}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Weekly:</span>
                <strong class="text-end"> {{ $this->stats()['weekly_food_cost'] ?? 0 }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Monthly:</span>
                <strong>{{ $this->stats()['monthly_food_cost'] ?? 0 }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4"><span class="font-semibold">Yearly:</span>
                <strong>{{ $this->stats()['yearly_food_cost'] ?? 0 }}</strong>
            </li>
        </ul>
    </div>
    <!-- Card 3 -->
    <div
        class="bg-gradient-to-br from-yellow-100 to-yellow-300 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-center w-12 h-12 bg-yellow-500 text-white rounded-full mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 16h-1v-4h-1m4 0h-1V7h-1m-4 0h1v4h1m-4 0h1v4h1"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2 text-yellow-800">Program Delivery Cost</h3>
        <ul class="text-yellow-900 space-y-1">
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Daily:</span>
                <strong>{{ $this->stats()['program_delivery_cost'] ?? 0 }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Weekly:</span>
                <strong>{{ $this->stats()['weekly_program_delivery_cost'] ?? 0 }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Monthly:</span>
                <strong>{{ $this->stats()['monthly_program_delivery_cost'] ?? 0 }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4">
                <span class="font-semibold">Yearly:</span>
                <strong>{{ $this->stats()['yearly_program_delivery_cost'] ?? 0 }}</strong>
            </li>
        </ul>
    </div>
    <!-- Totals -->
    <div
        class="bg-gradient-to-br from-purple-100 to-purple-300 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-center w-12 h-12 bg-purple-500 text-white rounded-full mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2 text-purple-800">Totals</h3>
        <ul class="text-purple-900 space-y-2 ">
            <li class="w-full flex justify-between gap-x-4"><span class="font-semibold">Daily:</span>
                <strong>{{ ($this->stats()['daily_total'] ?? 0) }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4"><span class="font-semibold">Weekly:</span>
                <strong>{{ ($this->stats()['weekly_total'] ?? 0) }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4"><span class="font-semibold">Monthly:</span>
                <strong>{{ ($this->stats()['monthly_total'] ?? 0) }}</strong>
            </li>
            <li class="w-full flex justify-between gap-x-4"><span class="font-semibold">Yearly:</span>
                <strong>{{ ($this->stats()['yearly_total'] ?? 0) }}</strong>
            </li>
        </ul>
    </div>
</div>
