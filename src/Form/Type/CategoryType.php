<?php
namespace App\Form\Type;



use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent_category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.parent_category = 0');
                },
                'choice_label' => 'category_name',
            ]);  

        $builder
            ->add('category_name', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.parent_category != 0');
                },
                'choice_label' => 'category_name',
            ]);             

        $builder
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}