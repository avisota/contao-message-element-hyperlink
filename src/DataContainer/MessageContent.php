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

namespace Avisota\Contao\Message\Element\Hyperlink\DataContainer;

use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Image\GenerateHtmlEvent;
use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\ManipulateWidgetEvent;
use ContaoCommunityAlliance\UrlBuilder\UrlBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * The mesage content subscriber.
 */
class MessageContent implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            ManipulateWidgetEvent::NAME => array(
                array('modalPagePickerForPropertyUrl')
            )
        );
    }

    /**
     * Get the modal page picker for property url.
     *
     * @param ManipulateWidgetEvent $event The event.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function modalPagePickerForPropertyUrl(ManipulateWidgetEvent $event)
    {
        $environment = $event->getEnvironment();
        $property    = $event->getProperty();

        if ($environment->getDataDefinition()->getName() !== 'orm_avisota_message_content'
            || $property->getName() !== 'url'
        ) {
            return;
        }

        $inputProvider   = $environment->getInputProvider();
        $entity          = $event->getModel()->getEntity();
        $translator      = $environment->getTranslator();
        $eventDispatcher = $environment->getEventDispatcher();

        $generateImageHtmlEvent = new GenerateHtmlEvent(
            'pickpage.gif',
            $translator->translate('pagepicker', 'MSC'),
            'style="vertical-align:top; cursor:pointer;"'
        );

        $eventDispatcher->dispatch(ContaoEvents::IMAGE_GET_HTML, $generateImageHtmlEvent);

        $urlBuilder = new UrlBuilder();
        $urlBuilder->setPath('contao/page.php')
            ->setQueryParameter('do', $inputProvider->getParameter('do'))
            ->setQueryParameter('table', $inputProvider->getParameter('table'))
            ->setQueryParameter('field', $property->getName())
            ->setQueryParameter('value', '')
            ->setQueryParameter('switch', '1');

        $event->getWidget()->wizard .=
            ' <a href="' . $urlBuilder->getUrl() . '" title="' . $translator->translate('pagepicker', 'MSC')
            . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':768,\'title\':\''
            . str_replace("'", "\\'", $property->getLabel()) . '\',\'url\':this.href,\'id\':\'' . $property->getName()
            . '\',\'tag\':\'ctrl_' . $property->getName()
            . (($inputProvider->getParameter('act') === 'editAll') ? '_' . $entity->getId() : '')
            . '\',\'self\':this});return false">'
            . $generateImageHtmlEvent->getHtml()
            . '</a>';
    }
}
