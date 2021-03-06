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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_room_occupancy']['showPeriodOptions'] = array('Zeitspanne aktivieren', 'Aktiviert die Optionen, um mehrere Tage gleichzeitig zu bearbeiten. Achtung: Bereits angelegte Daten werden überschrieben.');
$GLOBALS['TL_LANG']['tl_room_occupancy']['startDate']         = array('Startdatum', 'Bitte geben Sie das Startdatum gemäß des globalen Datumsformats ein.'); 
$GLOBALS['TL_LANG']['tl_room_occupancy']['date']              = array('Datum', '');
$GLOBALS['TL_LANG']['tl_room_occupancy']['endDate']           = array('Enddatum', 'Bitte geben Sie das Startdatum gemäß des globalen Datumsformats ein.');
$GLOBALS['TL_LANG']['tl_room_occupancy']['count']             = array('Zimmeranzahl', 'Die Anzahl der verfügbaren Zimmer');
$GLOBALS['TL_LANG']['tl_room_occupancy']['price']             = array('Tagespreis', 'Den aktuellen Tagespreis angeben.');
$GLOBALS['TL_LANG']['tl_room_occupancy']['mls']               = array('Minimum Length of Stay', 'Mindestaufenthaltszeit in Tagen.');
$GLOBALS['TL_LANG']['tl_room_occupancy']['year']              = array('Jahr', '');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_room_occupancy']['date_legend'] = 'Zeitspanne';

/**
 * Reference
 */

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_room_occupancy']['new'] = array('Zimmerbelegung bearbeiten', 'Den Kalender für die Zimmerbelegung öffnen.'); 
$GLOBALS['TL_LANG']['MSC']['editRecord']        = 'Zimmerbelegung bearbeiten'; 