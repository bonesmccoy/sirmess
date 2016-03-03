<?php


namespace Bones\SirMess\Model;


class User
{

    /**
     * @var integer
     */
    private $id;


    public function __construct($id)
    {
        $this->id = $id;
    }


    public function getId()
    {
        return $this->id;
    }
}
