<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-core
 * @license    LGPL-3.0+
 * @filesource
 */

namespace Avisota\Contao\Message\Element\Hyperlink;

use Avisota\Contao\Core\Message\Renderer\MessagePreRendererInterface;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Image\GenerateHtmlEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DataContainer
 *
 * @package Avisota\Contao\Message\Element\Hyperlink
 */
class DataContainer
{
    /**
     * Return the link picker wizard
     *
     * @param object
     *
     * @return string
     */
    public function pagePicker($dc)
    {
        $fieldId = 'ctrl_' . $dc->field . ((\Input::getInstance()->get('act') == 'editAll') ? '_' . $dc->id : '');

        $generateImageHtmlEvent = new GenerateHtmlEvent(
            'pickpage.gif',
            $GLOBALS['TL_LANG']['MSC']['pagepicker'],
            'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $fieldId . '\')"'
        );

        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $GLOBALS['container']['event-dispatcher'];
        $eventDispatcher->dispatch(ContaoEvents::IMAGE_GET_HTML, $generateImageHtmlEvent);

        return ' ' . $generateImageHtmlEvent->getHtml();
    }
}
