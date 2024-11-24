 <div class="modal" id="print_modal" wire:ignore.self>

        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> <?php echo e(trans('admin.print_product_code')); ?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body my-3">
                <div class="col-12 mb-2">
                    <div id="print">
                        <div class="d-flex justify-content-center align-items-center">
                            <?php
                                echo DNS1D::getBarcodeSVG($product_code, 'C39',2,50);
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary float-left mt-3 mr-2" onclick="openPrintPage()">
                            <i class="fas fa-print ml-1"></i>طباعة
                        </button>
                    </div>
                </div>
</div>


            </div>
        </div>


</div>



<script>
    function openPrintPage() {
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(document.getElementById('print').innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>



<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/products/print-code.blade.php ENDPATH**/ ?>