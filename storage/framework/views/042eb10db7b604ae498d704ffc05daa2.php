<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty(setting('_general.enable_multi_currency'))): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty(setting('_general.multi_currency_list'))): ?>
        <?php
            $currencies = currencyList();
            $selectedCurrency  = getCurrentCurrency();
        ?>
        <form class="am-switch-language am-multi-currency" action="<?php echo e(route('switch-currency')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="am-currency">
            <div class="am-language-select am-currency-select">
                <a href="javascript:void(0);" class="am-currency-anchor">
                    <?php echo $selectedCurrency['code'] . '&nbsp;' . $selectedCurrency['symbol']; ?><i class="am-icon-chevron-down"></i>
                </a>
                <ul class="sub-menutwo currency-menu">
                    <?php
                        $baseCurrency       = setting('_general.base_currency') ?? 'USD';
                        $baseCurrencySymbol = $currencies[$baseCurrency]['symbol'] ?? '$';
                    ?>
                    <li data-currency="<?php echo e($baseCurrency); ?>" class="<?php echo e($selectedCurrency['code'] == $baseCurrency ? 'active' : ''); ?>">
                        <span><?php echo $baseCurrency . '&nbsp;' . $baseCurrencySymbol; ?></span>
                    </li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty(setting('_general.multi_currency_list'))): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = setting('_general.multi_currency_list'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li data-currency="<?php echo $currency['code']; ?>" class="<?php echo e($selectedCurrency['code'] == $currency['code'] ? 'active' : ''); ?>">
                                <span><?php echo $currencies[$currency['code']]['code'] . '&nbsp;' . $currencies[$currency['code']]['symbol']; ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        </form>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\Users\User\Desktop\well-known\resources\views/components/multi-currency.blade.php ENDPATH**/ ?>