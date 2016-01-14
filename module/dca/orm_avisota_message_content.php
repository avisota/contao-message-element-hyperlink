<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-message-element-hyperlink
 * @license    LGPL-3.0+
 * @filesource
 */


/**
 * Table orm_avisota_message_content
 * Entity Avisota\Contao:MessageContent
 */
$GLOBALS['TL_DCA']['orm_avisota_message_content']['metapalettes']['hyperlink'] = array
(
    'type'      => array('cell', 'type', 'headline'),
    'link'      => array('url', 'linkTitle', 'embed'),
    'expert'    => array(':hide', 'cssID', 'space'),
    'published' => array('invisible'),
);

$GLOBALS['TL_DCA']['orm_avisota_message_content']['fields']['url']       = array
(
    'label'     => &$GLOBALS['TL_LANG']['MSC']['url'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array(
        'mandatory'      => true,
        'rgxp'           => 'url',
        'decodeEntities' => true,
        'maxlength'      => 255,
        'tl_class'       => 'w50 wizard'
    ),
);
$GLOBALS['TL_DCA']['orm_avisota_message_content']['fields']['linkTitle'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['orm_avisota_message_content']['linkTitle'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('maxlength' => 255, 'tl_class' => 'w50'),
);
$GLOBALS['TL_DCA']['orm_avisota_message_content']['fields']['embed']     = array
(
    'label'     => &$GLOBALS['TL_LANG']['orm_avisota_message_content']['embed'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('maxlength' => 255, 'tl_class' => 'long clr'),
);
