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

namespace Elcodi\Plugin\TemplateConverterBundle\Transformer;

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\CodeCaptureInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\PieceInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\SimplePieceInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\SplitablePieceInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\TemplateTransformerInterface;

/**
 * Class PieceCollector
 */
class PieceCollector implements TemplateTransformerInterface
{
    /**
     * @var PieceInterface[]
     *
     * Pieces
     */
    protected $pieces = [];

    /**
     * Add piece
     *
     * @param PieceInterface $piece Piece
     */
    public function addPiece(PieceInterface $piece)
    {
        $this->pieces[] = $piece;
    }

    /**
     * Transform to Twig
     *
     * @param string $data Data
     *
     * @return string Data transformed
     */
    public function toTwig($data)
    {
        foreach ($this->pieces as $piece) {

            if ($piece instanceof SimplePieceInterface) {
                $data = $this->toTwigSimple($piece, $data);
            }

            if ($piece instanceof SplitablePieceInterface) {
                $data = $this->toTwigSplitable($piece, $data);
            }
        }

        return $data;
    }

    /**
     * To Twig simple
     *
     * @param SimplePieceInterface $piece Simple piece
     * @param string               $data  Data
     *
     * @return string Data
     */
    private function toTwigSimple(
        SimplePieceInterface $piece,
        $data
    )
    {
        do {
            $newData = preg_replace(
                $piece->from(),
                $piece->to(),
                $data
            );
        } while ($newData != $data && $data = $newData);

        return $data;
    }

    /**
     * To Twig splitable
     *
     * @param SplitablePieceInterface $piece Splitable piece
     * @param string                  $data  Data
     *
     * @return string Data
     */
    private function toTwigSplitable(
        SplitablePieceInterface $piece,
        $data
    )
    {
        while (preg_match_all(
                $piece->fromSplit(),
                $data,
                $matches,
                PREG_SET_ORDER
            ) > 0) {

            if (isset($matches[0])) {
                foreach ($matches[0] as $match) {

                    $data = str_replace(
                        $match,
                        $piece->toSplit($match),
                        $data
                    );
                }
            }
        }

        return $data;
    }

    /**
     * Get Capturer piece
     *
     * @return CodeCaptureInterface Code capturer
     */
    public function getCapturer()
    {
        // TODO: Implement getCapturer() method.
    }
}
