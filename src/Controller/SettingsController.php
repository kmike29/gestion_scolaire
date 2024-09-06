<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Settings\PaiementSettings;
use Jbtronics\SettingsBundle\Form\SettingsFormFactoryInterface;
use Jbtronics\SettingsBundle\Manager\SettingsManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends AbstractController
{
    public function __construct(
        private SettingsFormFactoryInterface $settingsFormFactory,
        private SettingsManagerInterface  $settingsManager
    ) {
    }

    #[Route('/settings', name: 'app_setting')]
    public function index(PaiementSettings $settings): Response
    {

        dump($settings->getPourcentageRemise());
        dump($settings->getRemiseSiPaiementUnique());

        return $this->render('settings/index.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }

    #[Route('/edit_settings', name: 'edit_setting')]
    public function edit(Request $request): Response
    {


        $clone = $this->settingsManager->createTemporaryCopy(PaiementSettings::class);

        //Create a builder for the settings form
        $builder = $this->settingsFormFactory->createSettingsFormBuilder($clone);

        //Add a submit button, so we can save the form
        $builder->add('submit', SubmitType::class, [
            'label' => 'Sauvegarder'
        ]);

        //Create the form
        $form = $builder->getForm();

        //Handle the form submission
        $form->handleRequest($request);

        //If the form was submitted and the data is valid, then it
        if ($form->isSubmitted() && $form->isValid()) {
            //Merge the clone containing the modified data back into the managed instance
            $this->settingsManager->mergeTemporaryCopy($clone);

            //Save the settings
            $this->settingsManager->save();
        }


        return $this->render('settings/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
