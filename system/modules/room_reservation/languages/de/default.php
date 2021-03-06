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
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['strFormArrival']            = 'Anreise';
$GLOBALS['TL_LANG']['MSC']['strFormDeparture']          = 'Abreise';
$GLOBALS['TL_LANG']['MSC']['strFormSubmit']             = 'Verfügbarkeit prüfen';
$GLOBALS['TL_LANG']['MSC']['count']                     = 'Anzahl';
$GLOBALS['TL_LANG']['MSC']['strFormRoomtype']           = 'Zimmertyp wählen';
$GLOBALS['TL_LANG']['MSC']['countError']                = 'Bitte geben Sie die gewünschte Zimmeranzahl an.';
$GLOBALS['TL_LANG']['MSC']['notEnoughRoomsError']       = 'Nicht genügend Zimmer frei für Zimmertyp "%s" in diesem Zeitraum.';
$GLOBALS['TL_LANG']['MSC']['noRoomsForRoomtype']        = 'Keine Zimmer frei für Zimmertyp "%s" in diesem Zeitraum.';
$GLOBALS['TL_LANG']['MSC']['maxCountError']             = 'Reservierung für Zimmertyp "%s" nicht möglich. Maximal verfügbare Anzahl für diesen Zeitraum: %s.';
$GLOBALS['TL_LANG']['MSC']['mlsError']                  = 'Reservierung für Zimmertyp "%s" nicht möglich. Mindestaufenthalt erforderlich: %s Nächte.';
$GLOBALS['TL_LANG']['MSC']['reservationPossible']       = 'Für den ausgewählten Zeitraum ist eine Reservierung möglich:';
$GLOBALS['TL_LANG']['MSC']['total']                     = 'Gesamtpreis: ';
$GLOBALS['TL_LANG']['MSC']['totalOverview']             = 'EUR %s (&#216; EUR %s pro Übernachtung)';
$GLOBALS['TL_LANG']['MSC']['reservationNotPossible']    = 'Für den ausgewählten Zeitraum ist leider keine Reservierung möglich.';
$GLOBALS['TL_LANG']['MSC']['strFormSalutation']         = 'Anrede';
$GLOBALS['TL_LANG']['MSC']['strFormMale']               = 'Herr';
$GLOBALS['TL_LANG']['MSC']['strFormFemale']             = 'Frau';
$GLOBALS['TL_LANG']['MSC']['strFormFirstname']          = 'Vorname';
$GLOBALS['TL_LANG']['MSC']['strFormLastname']           = 'Nachname';
$GLOBALS['TL_LANG']['MSC']['strFormAddress']            = 'Adresse';
$GLOBALS['TL_LANG']['MSC']['strFormPostcodeCity']       = 'PLZ / Ort';
$GLOBALS['TL_LANG']['MSC']['strFormCity']               = 'PLZ / Ort';
$GLOBALS['TL_LANG']['MSC']['strFormCountry']            = 'Land';
$GLOBALS['TL_LANG']['MSC']['strFormEmail']              = 'E-Mail';
$GLOBALS['TL_LANG']['MSC']['strFormPhone']              = 'Telefon';
$GLOBALS['TL_LANG']['MSC']['strFormRemarks']            = 'Bemerkungen';
$GLOBALS['TL_LANG']['MSC']['strFormConfirmation']       = 'Bestätigung';
$GLOBALS['TL_LANG']['MSC']['strFormConfirmationText']   = 'Hiermit bestätige ich die verbindliche Reservierung.';
$GLOBALS['TL_LANG']['MSC']['strFormReservationSubmit']  = 'Verbindlich reservieren';
$GLOBALS['TL_LANG']['MSC']['strFormReservationSuccess'] = 'Vielen Dank für ihre Reservierung! In Kürze erhalten Sie von uns eine E-Mail mit weiterführenden Informationen.';
$GLOBALS['TL_LANG']['MSC']['dateOfArrival']             = 'Datum der Anreise:';
$GLOBALS['TL_LANG']['MSC']['dateOfDeparture']           = 'Datum der Abreise:';
$GLOBALS['TL_LANG']['MSC']['rooms']                     = 'Zimmer:';
$GLOBALS['TL_LANG']['MSC']['showTotalOverview']         = '[Preisübersicht anzeigen]';
$GLOBALS['TL_LANG']['MSC']['date']                      = 'Datum';
$GLOBALS['TL_LANG']['MSC']['price']                     = 'Preis*';
$GLOBALS['TL_LANG']['MSC']['type']                      = 'Zimmertyp';
$GLOBALS['TL_LANG']['MSC']['inclusive']                 = '* (inkl. Frühstück, Service, MwSt.)';
$GLOBALS['TL_LANG']['MSC']['reserveNow']                = 'Jetzt reservieren »';
$GLOBALS['TL_LANG']['MSC']['backToStart']               = '« Zurück zur Startseite';
$GLOBALS['TL_LANG']['MSC']['dearSir']                   = 'Sehr geehrter Herr';
$GLOBALS['TL_LANG']['MSC']['dearMadame']                = 'Sehr geehrte Frau';