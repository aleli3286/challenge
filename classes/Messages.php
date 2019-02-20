<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 8:55 AM
 */

class Messages
{
    const KEY_MESSAGES = 'messages';
    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';

    public function showMessages($removeAfter = true)
    {
        $messages = isset($_SESSION[self::KEY_MESSAGES]) ? $_SESSION[self::KEY_MESSAGES] : [];
        if ($messages) {
            foreach ($messages as $message) {
            ?>
                <div class="alert alert-<?php echo $message['type'] == self::TYPE_SUCCESS ? 'success' : 'danger' ?>">
                    <?php if (self::TYPE_SUCCESS == $message['type']) : ?>
                    SUCCESS:
                    <?php elseif (self::TYPE_ERROR == $message['type']) : ?>
                    ERROR:
                    <?php else : ?>
                    Unknown error:
                    <?php endif ?>
                    <?php echo $message['text'] ?>
                </div>
            <?php
            }
        }

        if ($removeAfter) {
            unset($_SESSION[self::KEY_MESSAGES]);
        }
    }

    public function addSuccessMessage($message)
    {
        $this->addMessage(self::TYPE_SUCCESS, $message);
    }

    public function addErrorMessage($message)
    {
        $this->addMessage(self::TYPE_ERROR, $message);
    }

    private function addMessage($type, $text)
    {
        $messages = isset($_SESSION[self::KEY_MESSAGES]) ? $_SESSION[self::KEY_MESSAGES] : [];
        $messages[] = [
            'type' => $type,
            'text' => $text
        ];

        $_SESSION[self::KEY_MESSAGES] = $messages;
    }
}