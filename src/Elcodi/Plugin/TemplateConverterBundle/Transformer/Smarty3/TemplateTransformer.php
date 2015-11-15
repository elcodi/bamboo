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

namespace Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3;

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\CodeCaptureInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\TemplateTransformerInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\PieceCollector;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Capture\Smarty3Capture;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece;

/**
 * Class TemplateTransformer
 */
class TemplateTransformer implements TemplateTransformerInterface
{
    /**
     * Transform to Twig
     *
     * @param string $data Data
     *
     * @return string Data transformed
     */
    public function toTwig($data)
    {
        $pieceCollector = new PieceCollector();

        /**
         * Format elements
         * We assume that
         *
         * * Variables are with $
         */
        $pieceCollector->addPiece(new Piece\GlobalsPiece());
        $pieceCollector->addPiece(new Piece\IssetPiece());
        $pieceCollector->addPiece(new Piece\EmptyPiece());
        $pieceCollector->addPiece(new Piece\NotPiece());
        $pieceCollector->addPiece(new Piece\InArrayPiece());

        /**
         * Structure elements
         * We assume that
         *
         * * Variables are with $
         * * All given elements should follow format { }
         * * All resulting elements should follow format {% %}
         */
        $pieceCollector->addPiece(new Piece\IfPiece());
        $pieceCollector->addPiece(new Piece\ElsePiece());
        $pieceCollector->addPiece(new Piece\EqualPiece());
        $pieceCollector->addPiece(new Piece\EndifPiece());
        $pieceCollector->addPiece(new Piece\ElseIfPiece());
        $pieceCollector->addPiece(new Piece\OperatorsPiece());
        $pieceCollector->addPiece(new Piece\AssignPiece());
        $pieceCollector->addPiece(new Piece\IncludePiece());

        /**
         * Var elements
         *
         * * Variables are with $
         * * Variables are converted to Twig variables (no $)
         */
        //$pieceCollector->addPiece(new Piece\VarPiece());

        return $pieceCollector->toTwig($data);
    }

    /**
     * Get Capturer piece
     *
     * @return CodeCaptureInterface Code capturer
     */
    public function getCapturer()
    {
        return new Smarty3Capture();
    }
}
