<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 17.4.2016
 * Time: 9:37
 */
class UserManager
{
    /**
     * zakoduje heslo
     * @param $password string;
     * @return string
     */
    public function returnImprint($password)
    {
        $sul = 'fd16sdfd2ew#$koksaker1';
        return hash('sha256', $password.$sul);
    }

    /**
     * zaregistruje uzivatele
     * @param $username string; prezdivka uzivatele
     * @param $password string; heslo uzivatele
     * @param $passwordAgain string; znovu heslo uzivatele
     * @param $year int; antispam aktualni rok
     * @throws errorUser
     * @internal param string $nickname ; prezdivka uzivatele
     */
    public function register($username,$password, $passwordAgain, $year)
    {
        if($year != date('Y'))
            throw new errorUser('fails years');
        if($password != $passwordAgain)
            throw new errorUser('fails again password');
        $user = array(
        'username' => $username,
        'password' => $this->returnImprint($password),
        'levelAdmin' => 1,
        );
        try
        {
            Database::insert('users', $user);
        }
        catch (PDOException $error)
        {
            throw new errorUser('already is register');
        }
    }

    /**
     * prihlasi uzivatele
     * @param $nickname string; prezdivka
     * @param $password string; heslo uzivatele
     * @throws errorUser
     */
    public function login($username, $password)
    {
        $user =  Database::oneQuery('
                SELECT user_id, username, levelAdmin
                FROM users
                WHERE username = ? AND password = ?
        ', array($username, $this->returnImprint($password)));
        if(!$user)
            throw new errorUser('failed name or passsword');
        $_SESSION['username'] = $user;
    }

    /**
     * odhlasi uzivatele
     */
    public function logout()
    {
        unset($_SESSION['username']);
    }

    /**
     * zjisti zda je uzivatel administratorem, nebo spisovatele a tak
     * jestli neni uzivatel prihalse nic, tak vraci NULL
     * @return null
     */
    public  function returnUser()
    {
        if(isset($_SESSION['username']))
            return $_SESSION['username'];
        return null;
    }
}