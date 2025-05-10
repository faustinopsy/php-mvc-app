<?php if ($error = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
    <?php $oldInput = \App\Core\Flash::getOldInput($_ENV['FLASH_OLD_INPUT_KEY']); ?>
    <?php foreach ($error as $type => $message): ?>
    <div class="<?php echo htmlspecialchars($type); ?>" id="flash-message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
    setTimeout(() => {
        flashMessage.style.display='none';
    }, 2000);
    }
});
</script>