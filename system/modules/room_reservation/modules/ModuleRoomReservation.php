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

namespace Contao;

/**
 * Class ModuleRoomReservation
 *
 * Specifies insert tags for the confirmation mail to the customer.
 * 
 * @category  Contao  
 * @package   RoomReservation                                                                                                                                                                                                                                                                                                                                                                                                               
 * @author    Dennis Sagasser <sagasser@gispack.com>
 * @copyright 2014 Dennis Sagasser                                                                                                                                                                                                      
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @link      https://contao.org            
 */

class ModuleRoomReservation extends \Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_reservation_form';

    /**
     * Redirect to the selected page
     * 
     * @return string
     */
    public function generate()
    {
        return parent::generate();
    }

    /**
     * Generate module
     * 
     * @return null
     */
    protected function compile()
    {
        $objSsession = Session::getInstance();
        
        $this->loadLanguageFile('tl_room_reservation');

        // Initialize form fields
        $objWidgetArrival            = new \FormCalendarField();
        $objWidgetArrival->dateImage = true;
        $objWidgetArrival->id        = 'arrival';
        $objWidgetArrival->label     = $GLOBALS['TL_LANG']['MSC']['strFormArrival'];
        $objWidgetArrival->name      = 'arrival';
        $objWidgetArrival->mandatory = true;
        $objWidgetArrival->rgxp      = 'date';
        $objWidgetArrival->value     = $this->Input->post('arrival');

        $this->Template->objWidgetArrival = $objWidgetArrival;

        $objWidgetDeparture                = new \FormCalendarField();
        $objWidgetDeparture->dateImage     = true;
        $objWidgetDeparture->id            = 'departure';
        $objWidgetDeparture->label         = $GLOBALS['TL_LANG']['MSC']['strFormDeparture'];
        $objWidgetDeparture->name          = 'departure';
        $objWidgetDeparture->mandatory     = true;
        $objWidgetDeparture->rgxp          = 'date';
        $objWidgetDeparture->dateDirection = '+1';
        $objWidgetDeparture->value         = $this->Input->post('departure');

        $this->Template->objWidgetDeparture = $objWidgetDeparture;

        $objWidgetSubmit         = new FormSubmit();
        $objWidgetSubmit->id     = 'submit';
        $objWidgetSubmit->slabel = $GLOBALS['TL_LANG']['MSC']['strFormSubmit'];

        $this->Template->objWidgetSubmit = $objWidgetSubmit;

        $objModuleParams = $this->Database->prepare("
            SELECT id AS value, roomtype AS label, maxcount
            FROM tl_roomtype 
            WHERE published = '1' 
            AND (? BETWEEN start AND stop OR (start = '' AND stop = '')) 
            ORDER BY roomtype")
                ->execute(time()); 
        
        $i = 0;
        while ($objModuleParams->next()) {
            for ($i = 0; $i <= $objModuleParams->maxcount; $i++) {
                $arrSelectOptions[$i] = array('value' => $i, 'label' => $i);
            }
            $objSelectMenu          = new FormSelectMenu();
            $objSelectMenu->id      = $objModuleParams->value;
            $objSelectMenu->label   = $GLOBALS['TL_LANG']['MSC']['count'].' '.$objModuleParams->label;
            $objSelectMenu->name    = $objModuleParams->value;
            $objSelectMenu->options = $arrSelectOptions;

            $arrSelect[] = $objSelectMenu;
            $i++;           
        }    
        
        $this->Template->arrSelects = $arrSelect; 
        
        $objWidgetCheckboxes            = new FormCheckBox();
        $objWidgetCheckboxes->id        = 'roomtype';
        $objWidgetCheckboxes->label     = $GLOBALS['TL_LANG']['MSC']['strFormRoomtype'];
        $objWidgetCheckboxes->name      = 'roomtype';
        $objWidgetCheckboxes->mandatory = true;
        $objWidgetCheckboxes->options   = $objModuleParams->fetchAllAssoc();
        $objWidgetCheckboxes->value     = $this->Input->post('roomtype');

        $this->Template->objWidgetCheckboxes = $objWidgetCheckboxes; 
        
        if ($this->Input->post('FORM_SUBMIT') === 'form_availability_submit') { 
            $objArrivalDate     = new Date($this->Input->post('arrival'), $GLOBALS['TL_CONFIG']['dateFormat']);
            $objDepartureDate   = new Date($this->Input->post('departure'), $GLOBALS['TL_CONFIG']['dateFormat']);
            $intTstampArrival   = $objArrivalDate->tstamp; 
            $intTstampDeparture = $objDepartureDate->tstamp; 
            $strStartDate       = date('Y-m-d', $intTstampArrival);
            $strEndtDate        = date('Y-m-d', $intTstampDeparture);
            $intDifference      = ($intTstampDeparture - $intTstampArrival) / 86400;          
            $intTotal           = 0;

            if ($this->Input->post('roomtype')) {
                foreach (array($this->Input->post('roomtype')) as $intRoomtype) { 
                    (intval($this->Input->post($intRoomtype)) < 1) ? $objWidgetCheckboxes->addError($GLOBALS['TL_LANG']['MSC']['countError']) : 
                        $arrResultRow = $this->Database->prepare("
                            SELECT count(*) as countAvailableNights, MIN(count) AS minCount, (SUM(price) * ?) AS total, roomtype AS type, mls
                            FROM tl_room_occupancy o, tl_roomtype t 
                            WHERE date >= ? AND date < ?
                            AND pid = ?
                            AND o.pid = t.id")
                                ->execute(intval($this->Input->post($intRoomtype)), $strStartDate, $strEndtDate, $intRoomtype)->fetchAssoc();

                    (intval($arrResultRow['countAvailableNights']) !== $intDifference)? $objWidgetCheckboxes->addError(sprintf($GLOBALS['TL_LANG']['MSC']['notEnoughRoomsError'], $arrResultRow['type'])) : '';
                        ($arrResultRow['minCount'] === null || intval($arrResultRow['minCount']) === 0) ? $objWidgetCheckboxes->addError(sprintf($GLOBALS['TL_LANG']['MSC']['noRoomsForRoomtype'], $arrResultRow['type'])) :
                            (intval($this->Input->post($intRoomtype)) > intval($arrResultRow['minCount'])) ? $objWidgetCheckboxes->addError(sprintf($GLOBALS['TL_LANG']['MSC']['maxCountError'], $arrResultRow['type'], $arrResultRow['minCount'])) :
                                (intval($arrResultRow['mls']) > $intDifference) ? $objWidgetCheckboxes->addError(sprintf($GLOBALS['TL_LANG']['MSC']['mlsError'], $arrResultRow['type'], $arrResultRow['minCount'])) :
                                    $arrResult = $this->Database->prepare("
                                        SELECT date, (price * ?) as price, roomtype
                                        FROM tl_room_occupancy o, tl_roomtype t 
                                        WHERE date >= ? AND date < ?
                                        AND pid = ?
                                        AND o.pid = t.id")
                                            ->execute(intval($this->Input->post($intRoomtype)), $strStartDate, $strEndtDate, $intRoomtype)->fetchAllAssoc();
                    
                    $arrOverview[]   = $arrResult;                 
                    $arrRooms[]      = $this->Input->post($intRoomtype).' '.$arrResult[0]['roomtype'];
                    $arrRoomtypes[]  = $intRoomtype;
                    $arrCountRooms[] = intval($this->Input->post($intRoomtype));
                    $intTotal        = $intTotal + intval($arrResultRow['total']);
                }    
            }            
            
            $objWidgetArrival->validate(); 
            $objWidgetDeparture->validate();
            $objWidgetCheckboxes->validate();
       
            if (!$objWidgetCheckboxes->hasErrors() && !$objWidgetArrival->hasErrors() && !$objWidgetDeparture->hasErrors() && $intTotal !== 0) {
                $floatAverage                 = $intTotal / $intDifference;
                $this->Template->infoMessage  = $GLOBALS['TL_LANG']['MSC']['reservationPossible'];
                $this->Template->priceMessage = sprintf($GLOBALS['TL_LANG']['MSC']['totalOverview'], System::getFormattedNumber($intTotal), System::getFormattedNumber($floatAverage));
                $this->Template->arrOverview  = $arrOverview;
                $arrTypesCount                = array_combine($arrRoomtypes, $arrCountRooms);
                
                $objSsession->set('arrival', $this->Input->post('arrival'));
                $objSsession->set('departure', $this->Input->post('departure'));
                $objSsession->set('rooms', $arrRooms);
                $objSsession->set('priceMessage', $this->Template->priceMessage);
                $objSsession->set('typesCount', $arrTypesCount);
                $objSsession->set('tstampArrival', $intTstampArrival);
                $objSsession->set('tstampDeparture', $intTstampDeparture);                 
            } else {
                $this->Template->errorMessage = $GLOBALS['TL_LANG']['MSC']['reservationNotPossible'];               
            }
        }
   
        if ($this->Input->get('FORM_PAGE') === 'page2') { 
            
            $objWidgetSalutation            = new FormRadioButton();
            $objWidgetSalutation->id        = 'salutation';
            $objWidgetSalutation->label     = $GLOBALS['TL_LANG']['MSC']['strFormSalutation'];
            $objWidgetSalutation->name      = 'salutation';
            $objWidgetSalutation->mandatory = true;
            $objWidgetSalutation->options   = array(array(value => 'male', label => $GLOBALS['TL_LANG']['MSC']['strFormMale']), array(value => 'female', label => $GLOBALS['TL_LANG']['MSC']['strFormFemale']));
            
            $this->Template->objWidgetSalutation = $objWidgetSalutation;
            
            $objWidgetFirstName            = new FormTextField();
            $objWidgetFirstName->id        = 'firstname';
            $objWidgetFirstName->label     = $GLOBALS['TL_LANG']['MSC']['strFormFirstname'];
            $objWidgetFirstName->name      = 'firstname';
            $objWidgetFirstName->mandatory = true;
            $objWidgetFirstName->rgxp      = 'alpha';
            $objWidgetFirstName->value     = $this->Input->post('firstname');
            
            $this->Template->objWidgetFirstName = $objWidgetFirstName;
            
            $objWidgetLastName            = new FormTextField();
            $objWidgetLastName->id        = 'lastname';
            $objWidgetLastName->label     = $GLOBALS['TL_LANG']['MSC']['strFormLastname'];
            $objWidgetLastName->name      = 'lastname';
            $objWidgetLastName->mandatory = true;
            $objWidgetLastName->rgxp      = 'alpha';
            $objWidgetLastName->value     = $this->Input->post('lastname');
            
            $this->Template->objWidgetLastName = $objWidgetLastName;
            
            $objWidgetAddress            = new FormTextField();
            $objWidgetAddress->id        = 'address';
            $objWidgetAddress->label     = $GLOBALS['TL_LANG']['MSC']['strFormAddress'];
            $objWidgetAddress->name      = 'address';
            $objWidgetAddress->mandatory = true;
            $objWidgetAddress->rgxp      = 'alnum';
            $objWidgetAddress->value     = $this->Input->post('address');
            
            $this->Template->objWidgetAddress = $objWidgetAddress;          
            
            $objWidgetPostCode            = new FormTextField();
            $objWidgetPostCode->id        = 'postcode';
            $objWidgetPostCode->label     = $GLOBALS['TL_LANG']['MSC']['strFormPostcodeCity'];
            $objWidgetPostCode->name      = 'postcode';
            $objWidgetPostCode->mandatory = true;
            $objWidgetPostCode->rgxp      = 'alnum';
            $objWidgetPostCode->value     = $this->Input->post('postcode');
            
            $this->Template->objWidgetPostCode = $objWidgetPostCode;
 
            $objWidgetCity            = new FormTextField();
            $objWidgetCity->id        = 'city';
            $objWidgetCity->label     = $GLOBALS['TL_LANG']['MSC']['strFormPostcodeCity'];
            $objWidgetCity->name      = 'city';
            $objWidgetCity->mandatory = true;
            $objWidgetCity->rgxp      = 'alpha';
            $objWidgetCity->value     = $this->Input->post('city');
            
            $this->Template->objWidgetCity = $objWidgetCity;    

            $objWidgetCountry            = new FormTextField();
            $objWidgetCountry->id        = 'country';
            $objWidgetCountry->label     = $GLOBALS['TL_LANG']['MSC']['strFormCountry'];
            $objWidgetCountry->name      = 'country';
            $objWidgetCountry->mandatory = true;
            $objWidgetCountry->rgxp      = 'alpha';
            $objWidgetCountry->value     = $this->Input->post('country');            
            
            $this->Template->objWidgetCountry = $objWidgetCountry; 
            
            $objWidgetEmail            = new FormTextField();
            $objWidgetEmail->id        = 'email';
            $objWidgetEmail->label     = $GLOBALS['TL_LANG']['MSC']['strFormEmail'];
            $objWidgetEmail->name      = 'email';
            $objWidgetEmail->mandatory = true;
            $objWidgetEmail->rgxp      = 'email';
            $objWidgetEmail->value     = $this->Input->post('email');            
            
            $this->Template->objWidgetEmail = $objWidgetEmail; 
            
            $objWidgetPhone            = new FormTextField();
            $objWidgetPhone->id        = 'phone';
            $objWidgetPhone->label     = $GLOBALS['TL_LANG']['MSC']['strFormPhone'];
            $objWidgetPhone->name      = 'phone';
            $objWidgetPhone->mandatory = false;
            $objWidgetPhone->rgxp      = 'phone';
            $objWidgetPhone->value     = $this->Input->post('phone');            
            
            $this->Template->objWidgetPhone = $objWidgetPhone;  

            $objWidgetRemarks            = new FormTextArea();
            $objWidgetRemarks->id        = 'remarks';
            $objWidgetRemarks->label     = $GLOBALS['TL_LANG']['MSC']['strFormRemarks'];
            $objWidgetRemarks->name      = 'remarks';
            $objWidgetRemarks->mandatory = false;
            $objWidgetRemarks->value     = $this->Input->post('remarks');            
            
            $this->Template->objWidgetRemarks = $objWidgetRemarks; 
            
            $objWidgetConfirmation            = new FormCheckBox();
            $objWidgetConfirmation->id        = 'confirmation';
            $objWidgetConfirmation->label     = $GLOBALS['TL_LANG']['MSC']['strFormConfirmation'];
            $objWidgetConfirmation->name      = 'confirmation';
            $objWidgetConfirmation->mandatory = true;
            $objWidgetConfirmation->options   = array(array(value => '1', label => $GLOBALS['TL_LANG']['MSC']['strFormConfirmationText']));
            $objWidgetConfirmation->value     = $this->Input->post('confirmation');            
            
            $this->Template->objWidgetConfirmation = $objWidgetConfirmation;            
            
            $objWidgetSubmit        = new FormSubmit();
            $objWidgetSubmit->id    = 'submit';
            $objWidgetSubmit->label = $GLOBALS['TL_LANG']['MSC']['strFormReservationSubmit'];

            $this->Template->objWidgetSubmit = $objWidgetSubmit;           
        }
        
        if ($this->Input->post('FORM_SUBMIT') === 'form_reservation_submit') {
            $objWidgetSalutation->validate(); 
            $objWidgetFirstName->validate(); 
            $objWidgetLastName->validate();
            $objWidgetAddress->validate();
            $objWidgetPostCode->validate(); 
            $objWidgetCity->validate();
            $objWidgetCountry->validate();
            $objWidgetEmail->validate(); 
            $objWidgetPhone->validate();
            $objWidgetRemarks->validate();
            $objWidgetConfirmation->validate();  
            
            if (!$objWidgetSalutation->hasErrors() && !$objWidgetFirstName->hasErrors() && !$objWidgetLastName->hasErrors() && !$objWidgetAddress->hasErrors() && !$objWidgetPostCode->hasErrors() && !$objWidgetCity->hasErrors() && !$objWidgetCountry->hasErrors() && !$objWidgetEmail->hasErrors() && !$objWidgetPhone->hasErrors() && !$objWidgetRemarks->hasErrors() && !$objWidgetConfirmation->hasErrors()) {

                $intCurrentTstamp  = $objSsession->get('tstampArrival');
                $arrTypesCount     = $objSsession->get('typesCount');
                $arrTypesCountKeys = array_keys($arrTypesCount);
                
                while ($intCurrentTstamp < $objSsession->get('tstampDeparture')) {
                    $strCurrentDate = date('Y-m-d', $intCurrentTstamp);
                    foreach ($arrTypesCountKeys as $intRoomtype) {
                        $objSetRoomCount = $this->Database->prepare("
                            UPDATE tl_room_occupancy 
                            SET count = count - ? 
                            WHERE pid = ? 
                            AND date = ?")
                                ->execute($arrTypesCount[$intRoomtype], $intRoomtype, $strCurrentDate);
                    }
                    $intCurrentTstamp = $intCurrentTstamp + 86400;
                }
                
                $this->Template->infoMessage = $GLOBALS['TL_LANG']['MSC']['strFormReservationSuccess'];
                $this->send();
                
                $objInsertReservation = $this->Database->prepare("
                    INSERT INTO tl_reservation_list 
                    (arrival, departure, tstamp, rooms, lastname, firstname, address, postcode, country, phone, email, remarks)
                    VALUES(%d, %d, %d, ?, ?, ?, ?, ?, ?, ?, ?, ?)")
                        ->execute($objSsession->get('tstampArrival'), 
                            $objSsession->get('tstampDeparture'), 
                            time(),
                            $objSsession->get('rooms'), 
                            $this->Input->post('lastname'), 
                            $this->Input->post('firstname'), 
                            $this->Input->post('address'), 
                            $this->Input->post('postcode'), 
                            $this->Input->post('country'), 
                            $this->Input->post('phone'), 
                            $this->Input->post('email'), 
                            $this->Input->post('remarks'));

                $objSsession->remove('tstampArrival');
                $objSsession->remove('tstampDeparture');
                $objSsession->remove('typesCount');
                $objSsession->remove('arrival');
                $objSsession->remove('departure');            
                $objSsession->remove('priceMessage');
                $objSsession->remove('rooms');
            }
        }
    }
    
    /**
     * Sends a confirmation mail to the user
     * 
     * @return string
     */
    public function send()
    {
        $objSettings = $this->Database->prepare("SELECT * FROM tl_reservation_settings")->limit(1)->execute(); 

        if ($objSettings->useSMTP) {
            $GLOBALS['TL_CONFIG']['useSMTP']  = true;
            $GLOBALS['TL_CONFIG']['smtpHost'] = $objSettings->smtpHost;
            $GLOBALS['TL_CONFIG']['smtpUser'] = $objSettings->smtpUser;
            $GLOBALS['TL_CONFIG']['smtpPass'] = $objSettings->smtpPass;
            $GLOBALS['TL_CONFIG']['smtpEnc']  = $objSettings->smtpEnc;
            $GLOBALS['TL_CONFIG']['smtpPort'] = $objSettings->smtpPort;
        }

        // Add default sender address
        if ($objSettings->sender == '') {
            list($objSettings->senderName, $objSettings->sender) = \String::splitFriendlyEmail($GLOBALS['TL_CONFIG']['adminEmail']);
        }

        $arrAttachments            = array();
        $blnAttachmentsFormatError = false;

        // Add attachments
        if ($objSettings->addFile) {
            $files = deserialize($objSettings->files);

            if (!empty($files) && is_array($files)) {
                    $objFiles = \FilesModel::findMultipleByUuids($files);

                if ($objFiles === null) {
                    if (!\Validator::isUuid($files[0])) {
                        $blnAttachmentsFormatError = true;
                        \Message::addError($GLOBALS['TL_LANG']['ERR']['version2format']);
                    }
                } else {
                    while ($objFiles->next()) {
                        if (is_file(TL_ROOT . '/' . $objFiles->path)) {
                            $arrAttachments[] = $objFiles->path;
                        }
                    }
                }
            }
        }

        // Replace insert tags
        $strHtml = $this->replaceInsertTags($objSettings->content, false);
        $strText = $this->replaceInsertTags($objSettings->text, false);

        // Convert relative URLs
        if ($objSettings->externalImages) {
            $strHtml = $this->convertRelativeUrls($strHtml);
        }

        // Send newsletter
        if (!$blnAttachmentsFormatError) {
            // Send newsletter
            $objEmail = $this->generateEmailObject($objSettings, $arrAttachments);
            $this->sendConfirmation($objEmail, $objSettings, $this->Input->post('email'), $strText, $strHtml);
        }
    }    
    /**
     * Generate the e-mail object and return it
     * 
     * @param \Database\Result $objSettings    Database result
     * @param array            $arrAttachments E-mail attachments
     * 
     * @return \Email
     */
    protected function generateEmailObject(\Database\Result $objSettings, $arrAttachments)
    {
        $objEmail = new \Email();

        $objEmail->from    = $objSettings->sender;
        $objEmail->subject = $objSettings->subject;

        // Add sender name
        if ($objSettings->senderName != '') {
            $objEmail->fromName = $objSettings->senderName;
        }

        $objEmail->embedImages = !$objSettings->externalImages;
        $objEmail->logFile     = 'reservation_' . $objSettings->id . '.log';

        // Attachments
        if (!empty($arrAttachments) && is_array($arrAttachments)) {
            foreach ($arrAttachments as $strAttachment) {
                $objEmail->attachFile(TL_ROOT . '/' . $strAttachment);
            }
        }
        
        return $objEmail;
    }
    
    /**
     * Compile the confirmation and send it
     * 
     * @param \Email           $objEmail     E-mail object
     * @param \Database\Result $objSettings  Database result
     * @param string           $strRecipient Recipient
     * @param string           $strText      Plain text
     * @param string           $strHtml      HTML text
     * @param string           $css          CSS
     * 
     * @return string CSS
     */
    protected function sendConfirmation(\Email $objEmail, \Database\Result $objSettings, $strRecipient, $strText, $strHtml, $css=null)
    {
        // Prepare the text content
        $objEmail->text = \String::parseSimpleTokens($strText, $strRecipient);

        // Add the HTML content
        if (!$objSettings->sendText) {
            // Default template
            if ($objSettings->template == '') {
                    $objSettings->template = 'mail_default';
            }

            // Load the mail template
            $objTemplate = new \BackendTemplate($objSettings->template);
            $objTemplate->setData($objSettings->row());

            $objTemplate->title     = $objSettings->subject;
            $objTemplate->body      = \String::parseSimpleTokens($strHtml, $strRecipient);
            $objTemplate->charset   = $GLOBALS['TL_CONFIG']['characterSet'];
            $objTemplate->css       = $css; // Backwards compatibility
            $objTemplate->recipient = $strRecipient;

            // Parse template
            $objEmail->html     = $objTemplate->parse();
            $objEmail->imageDir = TL_ROOT . '/';
        }

        // Deactivate invalid addresses
        try {
            $objEmail->sendTo($strRecipient);
        }
        catch (\Swift_RfcComplianceException $e) {
            $_SESSION['REJECTED_RECIPIENTS'][] = $strRecipient;
        }

        // Rejected recipients
        if ($objEmail->hasFailures()) {
            $_SESSION['REJECTED_RECIPIENTS'][] = $strRecipient;
        }
    }
}