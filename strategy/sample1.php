<?php

// 抽象クラス
abstract class MessageStrategy {
    public abstract function send();
}

// コンテキストクラス
class MessageContext {
    private $strategy;

    public function __construct(MessageStrategy $message, $user) {
        $this->strategy = $message;

    }

    public function send() {
        $this->strategy->send();
    }
}

// 具象クラス
class ConcreteMailMessage extends MessageStrategy {
    public function __construct() {
        // 前処理
    }

    public function send() {
        echo 'mail'.PHP_EOL;
    }
}
class ConcreteSMSMessage extends MessageStrategy {
    public function __construct() {
        // 前処理
    }

    public function send() {
        echo 'sms'.PHP_EOL;;
    }
}
class ConcretePushNotificationMessage extends MessageStrategy {
    public function __construct() {
        // 前処理
    }

    public function send() {
        echo 'push'.PHP_EOL;;
    }
}

$strategy = new ConcreteMailMessage();
$contextMessage = new MessageContext($strategy);
$contextMessage->send();
