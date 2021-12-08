<?php

/**
 * User
 *
 * An example user class
 */
class UserUseStaticMethod
{

    /**
     * Email address
     * @var string
     */
    public $email;

    /**
     * Mailer object
     * @var Mailer
     */
    protected $mailer;

    protected $mailerCallable;

    /**
     * Constructor
     *
     * @param string $email The user's email
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function setMailerCallable(callable $mailerCallable)
    {
        $this->mailerCallable = $mailerCallable;
    }

    /**
     * Mailer setter
     *
     * @param Mailer $mailer A Mailer object
     *
     * @return void
     */
    public function setMailer(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * Send the user a message
     *
     * @param string $message The message
     *
     * @return boolean
     */
    public function notify(string $message)
    {
//        return $this->mailer::send($this->email, $message);
        return Mailer::send($this->email, $message);
//        return call_user_func($this->mailerCallable, $this->email, $message);
    }
}
