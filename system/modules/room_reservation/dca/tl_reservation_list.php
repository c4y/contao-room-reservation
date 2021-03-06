<?php

/**                                                                                                                                                                                                                                   
 * Contao Open Source CMS                                                                                                                                                                                                             
 * Copyright (C) 2005-2014 Leo Feyer                                                                                                                                                                                                  
 *                                                                                                                                                                                                                                    
 * Formerly known as TYPOlight Open Source CMS.                                                                                                                                                                                       
 *                                                                                                                                                                                                                                    
 * This program is free software: you can redistribute it and/or                                                                                                                                                                      
 * modify it under the terms of the GNU Lesser General Public                                                                                                                                                                         
 * License as published by the Free Software Foundation, either                                                                                                                                                                       
 * version 3 of the License, or (at your option) any later version.                                                                                                                                                                   
 *                                                                                                                                                                                                                                    
 * This program is distributed in the hope that it will be useful,                                                                                                                                                                    
 * but WITHOUT ANY WARRANTY; without even the implied warranty of                                                                                                                                                                     
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU                                                                                                                                                                   
 * Lesser General Public License for more details.                                                                                                                                                                                    
 *                                                                                                                                                                                                                                    
 * You should have received a copy of the GNU Lesser General Public                                                                                                                                                                   
 * License along with this program. If not, please visit the Free                                                                                                                                                                     
 * Software Foundation website at <http://www.gnu.org/licenses/>.                                                                                                                                                                     
 *                                                                                                                                                                                                                                    
 * PHP version 5     
 *
 * @category  Contao  
 * @package   RoomReservation                                                                                                                                                                                                                                                                                                                                                                                                               
 * @author    Dennis Sagasser <sagasser@gispack.com>
 * @copyright 2014 Dennis Sagasser                                                                                                                                                                                                      
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @link      https://contao.org                                                                                                                                                                                                                                                                                                                                                                                                                                  
 */  

/**
 * Table tl_reservation_list
 */
$GLOBALS['TL_DCA']['tl_reservation_list'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'     => 'Table',
        'closed'            => true,
        'notEditable'       => true,
        'notDeletable'      => true,
        'sql'               => array
        (
            'keys' => array
            (
                'id'    => 'primary',
            )
        ),
    ),
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                  => 2,
            'panelLayout'           => 'filter;search,sort,limit',
            'fields'                => array('id ASC'),
        ), 
        'label' => array 
        ( 
            'fields'                => array('arrival', 'departure', 'rooms', 'firstname', 'lastname'), 
            'format'                => '<em>%s - %s</em> <b>|</b> %s <b>|</b> %s %s' 
        ), 
        'operations' => array 
        (  
            'show' => array 
            ( 
                'label'             => &$GLOBALS['TL_LANG']['tl_reservation_list']['show'], 
                'href'              => 'act=show', 
                'icon'              => 'show.gif' 
            ) 
        ) 
    ), 
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment",
            'sorting' => true,
        ),
        'tstamp' => array
        (
            'sql'           => "int(10) unsigned NOT NULL"
        ),
        'arrival' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['arrival'],
            'sql'           => "int(10) unsigned NOT NULL default '0'",
            'flag'          => 6,
            'search'        => true, 
            'sorting'       => true,
            'filter'        => true,
            'eval'          => array
            (
                'rgxp' => 'date'
            ),
        ),
        'departure' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['departure'],
            'sql'           => "int(10) unsigned NOT NULL default '0'",
            'flag'          => 6,
            'search'        => true, 
            'sorting'       => true,
            'filter'        => true,
            'eval'          => array
            (
                'rgxp' => 'date'
            ),
        ),
        'rooms' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['rooms'],
            'sql'           => "text NOT NULL"
        ),
        'lastname' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['lastname'],
            'sql'           => "varchar(255) NOT NULL default ''",
            'search'        => true, 
            'sorting'       => true,
            'filter'        => true,
        ),
        'firstname' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['firstname'],
            'sql'           => "varchar(255) NOT NULL default ''",
        ),
        'address' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['address'],
            'sql'           => "varchar(255) NOT NULL default ''"
        ),
        'postcode' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['postcode'],
            'sql'           => "varchar(255) NOT NULL default ''",
            'search'        => true, 
            'sorting'       => true,
            'filter'        => true,
        ),
        'country' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['country'],
            'sql'           => "varchar(255) NOT NULL default ''",
            'search'        => true, 
            'sorting'       => true,
            'filter'        => true,
        ),
        'phone' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['phone'],
            'sql'           => "varchar(255) NULL"
        ),
        'email' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['email'],
            'sql'           => "varchar(255) NOT NULL default ''",
            'search'        => true, 
            'sorting'       => true,
        ),
        'remarks' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_reservation_list']['remarks'],
            'sql'           => "text NULL"
        ),
    )
);