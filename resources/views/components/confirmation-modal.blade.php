<div
    x-data="{
        open: false,
        message: '',
        confirmAction: null,
        handleConfirmEvent(event) {
            this.message = event.detail.message;
            this.confirmAction = event.detail.onConfirm;
            this.open = true;
        },
        confirm() {
            if (typeof this.confirmAction === 'function') {
                this.confirmAction();
                this.open = false;
            }
        },
        cancel() { // Added a dedicated cancel method for clarity
            this.open = false;
        }
    }"
    x-init="window.addEventListener('show-confirmation', e => handleConfirmEvent(e))"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    @click.self="cancel()" {{-- Allows clicking outside to cancel --}}
>
    <div 
        class="bg-white rounded-lg p-6 shadow-md w-full max-w-md"
        @click.stop {{-- Prevent clicks inside from closing the modal --}}
    >
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Confirmation</h2>
        <p class="text-gray-700 mb-6" x-text="message"></p>
        <div class="flex justify-end gap-3">
            <button @click="cancel()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
            <button @click="confirm()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirm</button>
        </div>
    </div>
</div>