<?php


namespace Bones\SirMess\Model;


class Person
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
