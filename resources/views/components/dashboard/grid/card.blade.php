@props(['title', 'value', 'icon' => null, 'link' => '#'])

<div {{ $attributes->class("p-6  shadow  ") }}>
    <div class="flex flex-row   items-center  space-x-4">
        <!-- Icono -->
        @if ($icon)
            <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-white/20">
                {{ $icon }}
            </div>
        @endif
        <div>
            <!-- Valor -->
            <dd class="text-3xl font-semibold tracking-tight">
                {{ $value }}
            </dd>

            <!-- Título -->
            <dt class="mt-1 text-sm font-semibold text-gray-600 dark:text-gray-300">
                {{ $title }}
            </dt>
        </div>


    </div>

    <!-- Separador -->
    <div class="my-4 border-t border-gray-400 dark:border-gray-100"></div>

    <!-- Link -->
    <div class="hover:underline flex justify-start items-start">
        @isset($action)
            {{ $action }}
        @endisset

    </div>

</div>
