<div>

    <flux:modal name="take-picture" wire:model.live='show' @close="closeModalPicture" class="md:w-96">
        <div class="space-y-6">
            <div class="w-full" x-data="{
        initCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    this.$refs.video.srcObject = stream;
                })
                .catch(err => {
                    console.error('Error accessing the camera:', err);
                });
        },
        captureImage() {
            const canvas = this.$refs.canvas;
            const video = this.$refs.video;
            const context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            const dataURL = canvas.toDataURL('image/png');
           Livewire.dispatch('camera-capture:save', { image: dataURL });
              this.$wire.show = false;
        }
    }" x-init="initCamera()" @camera-reset.window="initCamera()">
                <video x-ref="video" class="w-full h-auto" autoplay></video>
                <flux:button icon="camera" @click="captureImage" class="w-full mt-4">Capture Image</flux:button>
                <canvas x-ref="canvas" class="hidden"></canvas>
                <div id="imagePreview" class="mt-4"></div>
            </div>
        </div>
    </flux:modal>
</div>
