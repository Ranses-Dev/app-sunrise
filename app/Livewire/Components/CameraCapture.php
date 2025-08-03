<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class CameraCapture extends Component
{
    public bool $show = false;

    public $image;
    public function render()
    {
        return view('livewire.components.camera-capture');
    }
    public function closeModalPicture()
    {
        $this->show = false;
    }
    #[On('camera-show')]
    public function showModalPicture()
    {
        $this->show = true;
    }
    
    public function capture()
    {
        $this->dispatch('camera-capture:save', [
            'image' => $this->image,
        ]);
        $this->closeModalPicture();
    }
}
