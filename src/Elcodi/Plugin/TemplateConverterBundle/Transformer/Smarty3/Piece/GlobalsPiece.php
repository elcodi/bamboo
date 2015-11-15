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

namespace Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece;

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\SimplePieceInterface;

/**
 * Class GlobalsPiece
 */
class GlobalsPiece implements SimplePieceInterface
{
    /**
     * From regexp
     *
     * @return string Regexp with original data
     */
    public function from()
    {
        $globals = [
            // Specific
            '$tpl_dir./',


            // Generic
            '$img_ps_dir',
            '$img_cat_dir',
            '$img_lang_dir',
            '$img_prof_dir',
            '$img_manu_dir',
            '$img_sup_dir',
            '$img_ship_dir',
            '$img_dir',
            '$css_dir',
            '$js_dir',
            '$tpl_dir',
            '$modules_dir',
            '$mail_dir',
            '$pic_dir',
            '$lang_iso',
            '$come_from',
            '$shop_name',
            '$cart_qties',
            '$cart',
            '$currencies',
            '$id_currency_cookie',
            '$currency',
            '$cookie',
            '$languages',
            '$logged',
            '$page_name',
            '$customerName',
            '$priceDisplay',
            '$roundMode',
            '$use_taxes',
        ];

        return array_map(function ($global) {
            return '~{([^\}]*)\\' . $global . '~';
        }, $globals);
    }

    /**
     * To regexp
     *
     * @return string string to replace with
     */
    public function to()
    {
        $globals = [
            // Specific
            '@~~bundle_name~~/',


            // Generic
            '$img_ps_dir',
            '$img_cat_dir',
            '$img_lang_dir',
            '$img_prof_dir',
            '$img_manu_dir',
            '$img_sup_dir',
            '$img_ship_dir',
            '$img_dir',
            '$css_dir',
            '$js_dir',
            '@~~bundle_name~~',
            '$modules_dir',
            '$mail_dir',
            '$pic_dir',
            '$lang_iso',
            '$come_from',
            '$shop_name',
            '$cart_qties',
            '$cart',
            '$currencies',
            '$id_currency_cookie',
            '$currency',
            '$cookie',
            '$languages',
            '$logged',
            '$page_name',
            'user.name',
            '$priceDisplay',
            '$roundMode',
            '$use_taxes',
        ];

        return array_map(function ($global) {
            return '{$1' . $global;
        }, $globals);
    }
}
