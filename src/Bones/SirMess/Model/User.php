<?php


namespace Bones\SirMess\Model;


use FOS\Message\Model\PersonInterface;

class User implements PersonInterface
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
        return $this->getId();
    }
}
