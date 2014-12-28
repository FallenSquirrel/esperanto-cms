<?php
/**
 * GroupType.php
 *
 * @since 21/10/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace esperanto\UserBundle\Form\Type;

use esperanto\AdminBundle\Security\Roles\RolesProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupType extends AbstractType
{
    protected $roles;

    public function __construct(RolesProvider $rolesProvider)
    {
        $roles = array_keys($rolesProvider->getRoles());

        foreach ($roles as $role) {
            $this->roles[$role] = (sprintf('label.%s', $role));
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'group.form.label.name'
        ));
        $builder->add('roles', 'choice', array(
            'label' => 'group.form.label.roles',
            'choices' => $this->roles,
            'multiple' => true,
            'expanded' => true,
            'attr' => array('class' => 'category-list')
        ));
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'esperanto/UserBundle/Entity/Group'
        );
    }

    public function getName()
    {
        return 'esperanto_user_group';
    }
}