<?php

declare(strict_types=1);

/*
 * This file is part of SolidInvoice project.
 *
 * (c) 2013-2017 Pierre du Plessis <info@customscripts.co.za>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SolidInvoice\SettingsBundle\Form\Type;

use SolidInvoice\SettingsBundle\Entity\Setting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Settings.
 */
class SettingsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['settings'] as $key => $setting) {
            if (is_array($setting)) {
                $builder->add($key, self::class, ['settings' => $setting]);

                continue;
            }

            /* @var Setting $setting */
            $builder->add(
                $key,
                $setting->getType(),
                [
                    'help' => $setting->getDescription(),
                    'required' => false,
                ]
            );
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('settings');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'settings';
    }
}
