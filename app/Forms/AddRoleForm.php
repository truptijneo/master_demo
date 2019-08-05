<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class AddRoleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', Field::TEXT, [
                'attr' => ['class' => 'form-control'],
                'rules' => 'required|min:5'
            ])
            ->add('guard_name', Field::TEXT, [
                'rules' => 'required|min:5|max:20'
            ])
            ->add('submit', 'submit', [
                'label' => 'Save'
            ])
            ->add('clear', 'reset', [
                'label' => 'Clear'
            ]);
    }
}