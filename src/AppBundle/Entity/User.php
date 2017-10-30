<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 25/10/17
 * Time: 10:39
 */

namespace AppBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Tests\Extension\DataCollector\FormDataExtractorTest_SimpleValueExporter;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity({"email"},message="it looks like your have an account !")
 */
class User implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }


    /**
     * @Assert\NotBlank()
     */
    private $plainPassword;

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }
    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



    /**
     * @ORM\Column(type="string",unique=true)
     * @Assert\NotBlank(groups={"Registration"})
     * @Assert\Email()
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $email
     */
    public function setUsername($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */


   private $groups;
    public function getRoles()
    {
        $roles = [];
      /*  foreach ($this->groups as $group){
            $roles = array_merge($roles,$group->getRoles());
        }
        if(!in_array('ROLE_USER',$roles)){
            $roles[] = 'ROLE_USER';
        }*/

        return $roles;
    }

    public function getPassword()
    {
       return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
       return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null ;
    }

}