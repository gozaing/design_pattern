<?php

// 送信対象のUserクラス
class User {
    private $name;
    private $mail;
    private $tel;

    // 仮に利用するpropertyを定義
    public function __construct($name, $mail, $tel) {
        $this->name = $name;
        $this->mail = $mail;
        $this->tel  = $tel;
    }

    // 仮に名前だけ出力するためにgetter設置
    public function getName() {
        return $this->name;
    }

}

// 抽象クラス
abstract class MessageStrategy {
    protected $user;
    public abstract function send();
    public abstract function __construct(User $user);
}

// コンテキストクラス
class MessageContext {
    private $strategy;

    public function __construct(MessageStrategy $message) {
        $this->strategy = $message;

    }

    public function send() {
        $this->strategy->send();
    }
}

// 具象クラス(Mail)
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

// 具象クラス(SMS)
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

// 具象クラス(PushNotification)
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

// 送信対象のテストUserインスタンス
$user = new User('Pさん', 'test@example.com', '090xxxxyyyy');

// Mailが送信される
$strategy = new ConcreteMailMessage($user);

// $strategyにどのクラスを代入するかでMail / SMS / PushNotification とsend()の振る舞いを変える
// SMSが送信される
// $strategy = new ConcreteSMSMessage($user);

// Push通知が送信される
// $strategy = new ConcretePushNotificationMessage($user);

// Contextクラスにstrategyクラスを注入
$contextMessage = new MessageContext($strategy);

// 注入されたオブジェクトのsend()メソッドをcallする
$contextMessage->send();

// mail->to(Pさん) と出力される
