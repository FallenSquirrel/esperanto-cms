<?php
namespace esperanto\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categories', 'collection', array(
            'type' => new CategoryType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'esperanto\CategoryBundle\Entity\Collection',
        ));
    }

    public function getName()
    {
        return 'esperanto_category_collection';
    }
}