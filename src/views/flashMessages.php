<div class="errorContainer">

    <?php
    if (isset($flashMessages)) {
        foreach ($flashMessages as $flashMessage) {
            $type = '';

            switch ($flashMessage->getType()) {
                case \App\Interfaces\FlashMessageServiceInterface::ERROR:
                    $type = 'danger';
                    break;
                case \App\Interfaces\FlashMessageServiceInterface::WARNING:
                    $type = 'warning';
                    break;
                case \App\Interfaces\FlashMessageServiceInterface::SUCCESS:
                    $type = 'success';
                    break;
                case \App\Interfaces\FlashMessageServiceInterface::INFO:
                    $type = 'info';
                    break;
                default:
                    $type = 'primary';
            }

            $message = $flashMessage->getMessage();
            include('flashMessages/flashMessage.php');
        }
    }
    ?>
</div>
