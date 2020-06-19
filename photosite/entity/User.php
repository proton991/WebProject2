<?php


class User
{
    public $username;

    public $pass;

    public $state;

    public $date_joined;

    public $data_last_modified;

    /**
     * User constructor.
     * @param $username
     * @param $pass
     * @param $state
     * @param $date_joined
     * @param $data_last_modified
     */
    public function __construct($username, $pass, $state, $date_joined, $data_last_modified)
    {
        $this->username = $username;
        $this->pass = $pass;
        $this->state = $state;
        $this->date_joined = $date_joined;
        $this->data_last_modified = $data_last_modified;
    }


}