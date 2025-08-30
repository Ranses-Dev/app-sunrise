@props(['placeholder'=>'','label'=>'','model'])
<flux:input {{$attributes->merge(['class'=>'w-full'])}} placeholder="{{$placeholder}}" label="{{$label}}" wire:model.live.debounce1000ms="{{$model}}" />
