<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zmittapp\ApiBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RestaurantType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('id', 'hidden', array('mapped' => false))
            ->add('name')
            ->add('address')
            ->add('city')
            ->add('zip')
            ->add('country')
            ->add('phone')
            ->add('email')
            ->add('lat')
            ->add('lon')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Zmittapp\ApiBundle\Entity\Restaurant',
            'csrf_protection'   => false
        ));
    }

    public function getName(){
        return 'restaurant';
    }

} 