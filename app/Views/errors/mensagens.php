<?php if ($error = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
    <?php $oldInput = \App\Core\Flash::getOldInput($_ENV['FLASH_OLD_INPUT_KEY']); ?>
    <?php foreach ($error as $type => $message): ?>
    <div class="<?php echo htmlspecialchars($type); ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endforeach; ?>
<?php endif; ?>