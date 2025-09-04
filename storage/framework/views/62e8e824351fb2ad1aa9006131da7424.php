<?php if(!empty(setting('_gdpr.enable_gdpr')) && (!empty(setting('_gdpr.gdpr_title')) || !empty(setting('_gdpr.gdpr_description')))): ?>
    <div id="gdpr-note" class="am-cookies-note-wrap" style="display: none;">
        <div class="am-cookies-note">
            <div class="am-cookies-note_content">
                <?php if(!empty(setting('_gdpr.gdpr_logo'))): ?>
                    <img src="<?php echo e(url(Storage::url(setting('_gdpr.gdpr_logo')[0]['path']))); ?>" alt="GDPR">
                <?php endif; ?>
                <div class="am-cookies-note_msg">
                    <?php if(!empty(setting('_gdpr.gdpr_title'))): ?>
                        <span><?php echo setting('_gdpr.gdpr_title'); ?></span>
                    <?php endif; ?>
                    <?php if(!empty(setting('_gdpr.gdpr_description'))): ?>
                        <span><?php echo setting('_gdpr.gdpr_description'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="am-cookies-note_btn">
                <button class="am-btn" id="gdpr-close"><?php echo e(__('auth.close')); ?></button>
                <button class="am-btn am-secondary-btn" id="gdpr-accept"><?php echo e(__('auth.accept_all')); ?></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gdprAccepted = localStorage.getItem('gdpr');
            const gdprNote = document.getElementById('gdpr-note');

            if (!gdprAccepted) {
                gdprNote.style.display = 'block';
            }

            document.getElementById('gdpr-close').addEventListener('click', function () {
                gdprNote.style.display = 'none';
            });

            document.getElementById('gdpr-accept').addEventListener('click', function () {
                localStorage.setItem('gdpr', 'true');
                gdprNote.style.display = 'none';
            });
        });
    </script>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/gdpr.blade.php ENDPATH**/ ?>