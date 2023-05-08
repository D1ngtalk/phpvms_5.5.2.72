<?php
   /**
 * Pirep Auto Accept & Decline for PHPvms
 * For more information, visit www.baggelis.com
 *
 * Pirep Auto Accept & Decline is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Vangelis Boulasikis
 * @copyright Copyright (c) 2014, Vangelis Boulasikis
 * @link http://www.baggelis.com
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

    class PirepAutoAccept extends CodonModule {

        public function HTMLHead()
        {
            $this->set('sidebar', 'PirepAutoAccept/sidebar_PirepAutoAccept.php');

        }

        public function Navbar() {
            echo '<li><a href="'.SITE_URL.'/admin/index.php/PirepAutoAccept">PirepAutoAccept</a></li>';
        }

        public function index()
        {
            $this->overview();
        }

        public function overview()
        {
            switch($this->post->action)
            {
                case 'addcriteria':
                    $this->add_criteria_post();
                    break;

                case 'editcriteria':
                    $this->edit_criteria_post();
                    break;

                case 'deletecriteria':
                    $this->delete_criteria_post();
                    break;   

                case 'savesettings':
                    $this->edit_settings_post();
                    return; 
                    break;

            }

            $this->set('allcriteria', PirepAcData::get_criteria());
            $this->render('PirepAutoAccept/autopirep_criterialist.php');
            $this->set('settings', PirepAcData::get_settings());
            $this->render('PirepAutoAccept/autopirep_settings_mainform.php');  
            $this->render('PirepAutoAccept/footer.php');  

        } 

        public function addcriteria()
        {
            $this->set('title', 'Add New Criteria');
            $this->set('action', 'addcriteria');
            $this->render('PirepAutoAccept/autopirep_addcriteria.php');
        }

        public function reject_pirep_post($id)
        {
            $pirepid = $id;


            PIREPData::ChangePIREPStatus($pirepid, PIREP_REJECTED); // 2 is rejected
            $pirep_details = PIREPData::GetReportDetails($pirepid);

            // If it was previously accepted, subtract the flight data
            if(intval($pirep_details->accepted) == PIREP_ACCEPTED)
            {
                PilotData::UpdateFlightData($pirep_details->pilotid, -1 * floatval($pirep->flighttime), -1);
            }

            //PilotData::UpdatePilotStats($pirep_details->pilotid);
            RanksData::CalculateUpdatePilotRank($pirep_details->pilotid);
            PilotData::resetPilotPay($pirep_details->pilotid);
            StatsData::UpdateTotalHours();



            # Call the event
            CodonEvent::Dispatch('pirep_rejected', 'PIREPAdmin', $pirep_details);
        } 

        public function approve_pirep_post($id)
        {
            $pirepid = $id;   

            if($pirepid == '') return;

            $pirep_details  = PIREPData::GetReportDetails($pirepid);

            # See if it's already been accepted
            if(intval($pirep_details->accepted) == PIREP_ACCEPTED) return;

            # Update pilot stats
            SchedulesData::IncrementFlownCount($pirep_details->code, $pirep_details->flightnum);
            PIREPData::ChangePIREPStatus($pirepid, PIREP_ACCEPTED); // 1 is accepted
            PilotData::UpdateFlightData($pirep_details->pilotid, $pirep_details->flighttime, 1);
            PilotData::UpdatePilotPay($pirep_details->pilotid, $pirep_details->flighttime);

            RanksData::CalculateUpdatePilotRank($pirep_details->pilotid);
            PilotData::GenerateSignature($pirep_details->pilotid);
            StatsData::UpdateTotalHours();



            # Call the event
            CodonEvent::Dispatch('pirep_accepted', 'PIREPAdmin', $pirep_details);
        }

        public function editcriteria()
        {
            $this->set('title', 'Edit Criteria');
            $this->set('action', 'editcriteria');
            $this->set('criteria', PirepAcData::getCriteriaById($this->get->id));

            $this->render('PirepAutoAccept/autopirep_editcriteria.php');

        }   

        

        protected function edit_settings_post()
        {


            PirepAcData::editSettings($this->post->setting_id, $this->post->moduleenabled,$this->post->landing_rate,$this->post->source, $this->post->send_mail_to_admin, $this->post->send_mail_to_pilot,$this->post->admin_code);

            if(DB::errno() != 0)
            {
                $this->set('message', 'There was an error editing the Settings');
                $this->render('core_error.php');
                return false;
            }
            $this->set('message', 'Settings Are Saved');
            $this->render('core_success.php'); 
            $this->set('allcriteria', PirepAcData::get_criteria());
            $this->render('PirepAutoAccept/autopirep_criterialist.php');
            $this->set('settings', PirepAcData::get_settings());
            $this->render('PirepAutoAccept/autopirep_settings_mainform.php');  
            $this->render('PirepAutoAccept/footer.php');  

        } 

        protected function add_criteria_post()
        {

            if($this->post->name == '')
            {
                $this->set('message', 'You must insert a description ');
                $this->render('core_error.php');
                return;
            }


            PirepAcData::addcriteria($this->post->name, $this->post->value,$this->post->msg);



            $this->set('message',  'Added the criteria "'.$this->post->name.' - '.$this->post->value.'"');
            $this->render('core_success.php');

            LogData::addLog(Auth::$userinfo->pilotid, 'Added the criteria "'.$this->post->name.'"');
        }

        protected function edit_criteria_post()
        {


            if($this->post->name == '')
            {
                $this->set('message', 'Criteria Description cannot be blank');
                $this->render('core_error.php');
            }

            $crit = PirepAcData::getCriteriaById($this->post->code);
            if($crit && $crit->criteria_description != $this->post->name)
            {
                $this->set('message', 'This criteria with this description already exists!');
                $this->render('core_error.php');
                return;
            }

            if(isset($this->post->enabled))
                $enabled = true;
            else
                $enabled = false;

            PirepAcData::editCriteria($this->post->id, $this->post->name, $this->post->value,$this->post->msg, $enabled);

            if(DB::errno() != 0)
            {
                $this->set('message', 'There was an error editing the criteria');
                $this->render('core_error.php');
                return false;
            }

            $this->set('message', 'Edited the criteria "'.$this->post->name.'"');
            $this->render('core_success.php');

            LogData::addLog(Auth::$userinfo->pilotid, 'Edited the criteria "'.$this->post->name.'"');
        }

        protected function delete_criteria_post()
        {

            if($this->post->id=='')
            {
                $this->set('message', 'Invalid Criteria!');
                $this->render('core_error.php');
                return;
            }

            PirepAcData::deleteCriteria($this->post->id);
            $this->set('message', 'Criteria removed!');
            $this->render('core_success.php');
            LogData::addLog(Auth::$userinfo->pilotid, 'Deleted the criteria "'.$this->post->id.'"'); 
            return;
        }

       


    }

