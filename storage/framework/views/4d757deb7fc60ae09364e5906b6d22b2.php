<?php if (isset($component)) { $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $attributes; } ?>
<?php $component = App\View\Components\UpdateModalComponent::resolve(['title' => 'إضافة أصل ثابت'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('update-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UpdateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f)): ?>
<?php $attributes = $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f; ?>
<?php unset($__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f)): ?>
<?php $component = $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f; ?>
<?php unset($__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/asset/update-asset.blade.php ENDPATH**/ ?>