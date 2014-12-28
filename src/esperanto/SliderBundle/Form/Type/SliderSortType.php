<?php
/**
 * SliderType.php
 *
 * @since 25/10/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace esperanto\SliderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderSortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'textarea', array(
            'label' => 'form.label.title'
        ));

        $builder->add('url', 'text', array(
            'label' => ' ',
            'attr' => array('class' => 'link-type-external'),
        ));

        $builder->add('text', 'textarea', array(
            'label' => 'form.label.text'
        ));

        $builder->add('link', 'text', array(
            'label' => 'form.label.link'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults( array(
            'data_class' => 'esperanto\SliderBundle\Entity\Slider'
        ));
    }

    public function getName()
    {
        return 'esperanto_slider_slider';
    }
} 