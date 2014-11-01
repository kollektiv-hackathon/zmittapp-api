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

class MenuItemType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('id', 'hidden', array('mapped' => false))
            ->add('appetizer')
            ->add('main_course')
            ->add('desert')
            ->add('price')
            ->add('date')
            ->add('vegetarian')
            ->add('vegan')
            ->add('restaurant', 'entity', array(
                'class' => 'Zmittapp\ApiBundle\Entity\Restaurant',
                'property' => 'id',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Zmittapp\ApiBundle\Entity\MenuItem',
            'csrf_protection'   => false
        ));
    }

    public function getName(){
        return 'menuItem';
    }

} 