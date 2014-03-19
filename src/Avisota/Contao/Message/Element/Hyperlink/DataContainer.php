<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota/contao-core
 * @license    LGPL-3.0+
 * @filesource
 */

namespace Avisota\Contao\Message\Element\Hyperlink;

use Avisota\Contao\Core\Message\Renderer\MessagePreRendererInterface;
use Avisota\Contao\Message\Core\Renderer\MessageRenderer;
use Avisota\Renderer\MessageRendererInterface;
use Contao\Doctrine\ORM\DataContainer\General\EntityModel;
use Contao\Doctrine\ORM\EntityAccessor;
use Contao\Doctrine\ORM\EntityHelper;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Image\GenerateHtmlEvent;
use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetGroupHeaderEvent;
use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\ParentViewChildRecordEvent;
use ContaoCommunityAlliance\DcGeneral\DC_General;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
