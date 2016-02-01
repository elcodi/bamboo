<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Plugin\StoreSetupWizardBundle\Templating;

use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;
use Elcodi\Plugin\CustomShippingBundle\Repository\CarrierRepository;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardRoutes;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardStatus;

/**
 * Class TwigRenderer
 */
class TwigRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var WizardStatus
     *
     * A WizardStatus
     */
    protected $wizardStatus;

    /**
     * @var RequestStack
     *
     * A request stack
     */
    protected $requestStack;

    /**
     * @var StoreInterface
     *
     * Store
     */
    protected $store;

    /**
     * @var WizardRoutes
     *
     * The wizard routes service
     */
    protected $wizardRoutes;

    /**
     * @var CarrierRepository
     *
     * A carrier repository
     */
    protected $carrierRepository;

    /**
     * Builds a new class
     *
     * @param WizardStatus      $wizardStatus      The Wizard status
     * @param RequestStack      $requestStack      A request stack
     * @param StoreInterface    $store             Store
     * @param WizardRoutes      $wizardRoutes      A wizard routes service
     * @param CarrierRepository $carrierRepository A carrier repository
     */
    public function __construct(
        WizardStatus $wizardStatus,
        RequestStack $requestStack,
        StoreInterface $store,
        WizardRoutes $wizardRoutes,
        CarrierRepository $carrierRepository
    ) {
        $this->requestStack = $requestStack;
        $this->wizardStatus = $wizardStatus;
        $this->store = $store;
        $this->wizardRoutes = $wizardRoutes;
        $this->carrierRepository = $carrierRepository;
    }

    /**
     * Set plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders the mini wizard bar
     *
     * @param EventInterface $event The event
     */
    public function renderMiniWizard(EventInterface $event)
    {
        if (
            $this->plugin->isEnabled() &&
            $this->isVisible() &&
            !$this->wizardStatus->isWizardFinished()
        ) {
            $stepsFinished = $this
                ->wizardStatus
                ->getStepsFinishStatus();

            $activeStep = $this
                ->wizardStatus
                ->getNextStep();

            $firstCarrier = $this
                ->carrierRepository
                ->findOneBy(
                    ['enabled' => true],
                    ['id' => 'ASC']
                );

            $firstCarrier = ($firstCarrier instanceof CarrierInterface)
                ? $firstCarrier
                : false;

            $this->appendTemplate(
                '@ElcodiStoreSetupWizard/Wizard/wizard.html.twig',
                $event,
                $this->plugin,
                [
                    'stepsFinished' => $stepsFinished,
                    'activeStep'    => $activeStep,
                    'isMiniWizard'  => true,
                    'carrier'       => $firstCarrier,
                ]
            );
        }
    }

    /**
     * Render the message to enable store.
     *
     * @param EventInterface $event The event
     */
    public function renderEnableStoreMessage(EventInterface $event)
    {
        if ($this
            ->plugin
            ->isUsable()
        ) {
            $masterRequest = $this
                ->requestStack
                ->getMasterRequest();

            $route = $masterRequest
                ->attributes
                ->get('_route');

            if (
                $this->wizardStatus->isWizardFinished() &&
                'admin_configuration_list' != $route
            ) {
                $this->appendTemplate(
                    '@ElcodiStoreSetupWizard/Wizard/enable-store.html.twig',
                    $event,
                    $this->plugin
                );
            }
        }
    }

    /**
     * Render the next step message.
     *
     * @param EventInterface $event The event
     */
    public function renderGoNextStepMessage(EventInterface $event)
    {
        if ($this
            ->plugin
            ->isUsable()
        ) {
            $masterRequest = $this
                ->requestStack
                ->getMasterRequest();
            $currentRoute = $masterRequest
                ->attributes
                ->get('_route');

            $isWizardRoute = $this
                ->wizardRoutes
                ->isWizardSetupRoute($currentRoute);

            $isWizardFinished = $this
                ->wizardStatus
                ->isWizardFinished();

            if (
                $isWizardRoute &&
                !$isWizardFinished
            ) {
                $currentStep = $this
                    ->wizardRoutes
                    ->getStepByRoute($currentRoute);

                $isStepFinished = $this
                    ->wizardStatus
                    ->isStepFinished($currentStep);

                if (
                    1 != $currentStep &&
                    $isStepFinished
                ) {
                    $stepsFinished = $this
                        ->wizardStatus
                        ->getStepsFinishStatus();

                    $activeStep = $this
                        ->wizardStatus
                        ->getNextStep();

                    $firstCarrier = $this
                        ->carrierRepository
                        ->findOneBy(
                            ['enabled' => true],
                            ['id' => 'ASC']
                        );

                    $firstCarrier = ($firstCarrier instanceof CarrierInterface)
                        ? $firstCarrier
                        : false;

                    $this->appendTemplate(
                        '@ElcodiStoreSetupWizard/Wizard/wizard.html.twig',
                        $event,
                        $this->plugin,
                        [
                            'stepsFinished' => $stepsFinished,
                            'activeStep'    => $activeStep,
                            'isMiniWizard'  => true,
                            'carrier'       => $firstCarrier,
                        ]
                    );
                }
            }
        }
    }

    /**
     * Render the disable under construction mode.
     *
     * @param EventInterface $event The event
     */
    public function renderDisableUnderConstructionMode(EventInterface $event)
    {
        if ($this
            ->plugin
            ->isUsable()
        ) {
            $masterRequest = $this
                ->requestStack
                ->getMasterRequest();
            $currentRoute = $masterRequest
                ->attributes
                ->get('_route');

            $isWizardFinished = $this
                ->wizardStatus
                ->isWizardFinished();

            if (
                'admin_configuration_list' == $currentRoute &&
                $isWizardFinished
            ) {
                $this->appendTemplate(
                    '@ElcodiStoreSetupWizard/Wizard/disable-under-construction.html.twig',
                    $event,
                    $this->plugin
                );
            }
        }
    }

    /**
     * Checks if the wizard is visible for this request.
     *
     * @return boolean If visible
     */
    protected function isVisible()
    {
        $masterRequest = $this
            ->requestStack
            ->getMasterRequest();

        if ($masterRequest
            ->query
            ->get('modal', false)
        ) {
            return false;
        }

        $route = $masterRequest
            ->attributes
            ->get('_route');

        return !$this
            ->wizardRoutes
            ->isWizardHidden($route);
    }
}
