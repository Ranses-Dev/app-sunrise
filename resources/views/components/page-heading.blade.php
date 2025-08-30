@props(['title' => ''])

@if ($title)
   <div class="p-4  text-blue-900 text-center justify-center dark:text-blue-300 flex items-center gap-3 border-b-4 border-blue-200 dark:border-blue-400 pb-4 mb-6 shadow-sm rounded-t-lg bg-white dark:bg-gray-900">
       <p
           class="text-3xl text-center">
           {{ $title }}
       </p>
   </div>
@endif
