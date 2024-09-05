<?php

namespace App\Settings;

use Jbtronics\SettingsBundle\Settings\Settings;
use Jbtronics\SettingsBundle\Settings\SettingsTrait;
use Jbtronics\SettingsBundle\Settings\SettingsParameter;
use Jbtronics\SettingsBundle\ParameterTypes\BoolType;
use Jbtronics\SettingsBundle\ParameterTypes\IntType;
use Symfony\Component\Validator\Constraints as Assert;
use Jbtronics\SettingsBundle\Storage\JSONFileStorageAdapter;

#[Settings(storageAdapter: JSONFileStorageAdapter::class)]
class PaiementSettings {
    use SettingsTrait; // Disable constructor and __clone methods

    //The property is public here for simplicity, but it can also be protected or private
    #[SettingsParameter(type: BoolType::class, label: 'Remise si paiement unique', description: 'Ce parametre détermine si une remise est appliqué lors que la scolarité est payé en une fois.')]
    private bool $remiseSiPaiementUnique = true; // The default value can be set right here in most cases

    #[SettingsParameter(type: IntType::class, label: 'Pourcentage de remise pour un paiement unique', description: 'Ce parametre détermine le pourcentage ')]
    #[Assert\Range(min: 1, max: 100,)] // You can use symfony/validator to restrict possible values
    private ?int $pourcentageRemise = 10;

    public function getPourcentageRemise() : int
    {
        return $this->pourcentageRemise;
    }

    public function setValeurRemise(int $valeur) : void
    {
        $this->pourcentageRemise = $valeur;
    }

    
    public function getRemiseSiPaiementUnique() : bool
    {
        return $this->remiseSiPaiementUnique;
    }

    public function setRemiseSiPaiementUnique(bool $valeur) : void
    {
        $this->remiseSiPaiementUnique = $valeur;
    }
}
