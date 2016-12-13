<?php

/**
 * 送信対象のUserクラス
 */
class User {
    private $name;
    private $mail;
    private $tel;

    /**
     * 仮に利用するpropertyを定義
     * User constructor.
     * @param $name
     * @param $mail
     * @param $tel
     */
    public function __construct($name, $mail, $tel) {
        $this->name = $name;
        $this->mail = $mail;
        $this->tel  = $tel;
    }

    /**
     * 仮に名前だけ出力するためにgetter設置
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

}

/**
 * 抽象クラス
 * Class MessageStrategy
 */
abstract class MessageStrategy {
    protected $user;
    public abstract function send();
    public abstract function __construct(User $user);
}

/**
 * コンテキストクラス
 * Class MessageContext
 */
class MessageContext {
    private $strategy;

    /**
     * MessageContext constructor.
     * @param MessageStrategy $message
     */
    public function __construct(MessageStrategy $message) {
        $this->strategy = $message;

    }

    public function send() {
        $this->strategy->send();
    }
}

/**
 * 具象クラス(Mail)
 * Class ConcreteMailMessage
 */
class ConcreteMailMessage extends MessageStrategy {
    public function __construct(User $user) {
        $this->user = $user;
        // mailに関する前処理
        // ...
    }

    public function send() {
        echo 'mail->to('. $this->user->getName(). ')'. PHP_EOL;
    }
}

/**
 * 具象クラス(SMS)
 * Class ConcreteSMSMessage
 */
class ConcreteSMSMessage extends MessageStrategy {
    public function __construct(User $user) {
        $this->user = $user;
        // smsに関する前処理
        // ...
    }

    public function send() {
        echo 'sms->to('. $this->user->getName(). ')'. PHP_EOL;
    }
}

/**
 * 具象クラス(PushNotification)
 * Class ConcretePushNotificationMessage
 */
class ConcretePushNotificationMessage extends MessageStrategy {
    public function __construct(User $user) {
        $this->user = $user;
        // Push通知に関する前処理
        // ...
    }

    public function send() {
        echo 'push->to('.$this->user->getName(). ')'. PHP_EOL;
    }
}

// ------------------------------
// 実際に利用するイメージです
// ------------------------------

// 送信対象のテストUserインスタンス
$user = new User('Pさん', 'test@example.com', '090xxxxyyyy');

// Mail送信
$strategy = new ConcreteMailMessage($user);

// $strategyにどのクラスを代入するかでMail / SMS / PushNotification とsend()の振る舞いを変える
// SMS送信
// $strategy = new ConcreteSMSMessage($user);

// Push通知
// $strategy = new ConcretePushNotificationMessage($user);

// Contextクラスにstrategyクラスを注入
$contextMessage = new MessageContext($strategy);

// 送信処理 注入されたオブジェクトのsend()メソッドをcall
$contextMessage->send();

// mail->to(Pさん) と出力される
