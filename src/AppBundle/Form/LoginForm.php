<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 27/10/17
 * Time: 10:13
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder ->add('_username')
                 ->add('_password',PasswordType::class);
    }

}