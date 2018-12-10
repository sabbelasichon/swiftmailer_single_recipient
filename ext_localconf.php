<?php

$boot = function () {
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Core\Mail\Mailer::class,
        'postInitializeMailer',
        \Ssch\SwiftmailerSingleRecipient\Aspect\SingleRecipientAspect::class,
        'handle',
        false
    );
};

$boot();
unset($boot);
