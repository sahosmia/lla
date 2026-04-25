<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['btnText' => '', 'btnUrl' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['btnText' => '', 'btnUrl' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">
    <tbody>
       <tr>
          <td style="font-size:0px;padding:0px;word-break:break-word" align="center">
             <div style="font-family:Helvetica,Arial,sans-serif; margin: 10px 0 10px;font-size:14px;line-height:18px;text-align:left;color:#4c4c4c;display: inline-block;">
                <a href="<?php echo e($btnUrl); ?>" style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:18px;text-align:left;color:#fff; background-color: #295C51; display: block; border-radius: 10px; padding: 10px; text-decoration: none;"><?php echo e($btnText); ?></a>
             </div>
          </td>
       </tr>
    </tbody>
 </table><?php /**PATH C:\Users\User\Desktop\well-known\resources\views/components/email/button.blade.php ENDPATH**/ ?>