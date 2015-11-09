<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
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

namespace Elcodi\Plugin\TemplateConverterBundle\Command;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Plugin\TemplateConverterBundle\Converter\TemplateConverter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TemplateConvertCommand
 */
class TemplateConvertCommand extends AbstractElcodiCommand
{
    /**
     * @var TemplateConverter
     *
     * Template converter
     */
    private $templateConverter;

    /**
     * Constructor
     *
     * @param TemplateConverter $templateConverter Template converter
     */
    public function __construct(TemplateConverter $templateConverter)
    {
        $this->templateConverter = $templateConverter;

        parent::__construct();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:template:convert')
            ->setDescription('Drop a set of countries')
            ->addArgument(
                'project-path',
                InputArgument::REQUIRED,
                'What is the path of the template you want to convert?'
            )
            ->addArgument(
                'new-path',
                InputArgument::REQUIRED,
                'Where do you want to place your new template?'
            );

        parent::configure();
    }

    /**
     * This command loads all the locations for the received country
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return integer|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output);

        $projectPath = $input->getArgument('project-path');
        $newPath = $input->getArgument('new-path');
        $this
            ->templateConverter
            ->convertFromProjectPath(
                $projectPath,
                $newPath
            );

        $this->finishCommand($output);
    }
}
