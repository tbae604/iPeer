<?php
App::import('Lib', 'system_base');

class EnrolStudentTestCase extends SystemBaseTestCase
{
    public function startCase()
    {
        parent::startCase();
        echo "Start Role system test.\n";
        $this->getSession()->open($this->url);

        $login = PageFactory::initElements($this->session, 'Login');
        $home = $login->login('root', 'ipeeripeer');
    }

    public function testUnenrolEnrolStudent()
    {
        return;
        // unenroll Student from his course
        $this->session->open($this->url.'users/edit/6');
        $this->session->elementWithWait(PHPWebDriver_WebDriverBy::ID, "course_1")->sendKeys('none');
        $this->session->elementWithWait(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        $msg = $this->session->elementWithWait(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'div[class="message good-message green"]')->text();
        $this->assertEqual($msg,'User successfully updated!');
        
        // log in as ex-student and check for 0 courses
        $this->waitForLogoutLogin('redshirt0002');
        $this->session->open($this->url.'home');
        $msg = $this->session->elementWithWait(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'div[class="eventSummary alldone"]')->text();
        $this->assertEqual($msg,'No Event(s) Pending');
        
        // put student back in
        $this->waitForLogoutLogin('root');
        $this->session->open($this->url.'users/edit/6');
        $this->session->elementWithWait(PHPWebDriver_WebDriverBy::ID, "course_1")->sendKeys('student');
        $this->session->elementWithWait(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        $msg = $this->session->elementWithWait(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'div[class="message good-message green"]')->text();
        $this->assertEqual($msg,'User successfully updated!');
        
        // log in as student and check for some events
        $this->waitForLogoutLogin('redshirt0002');
        $this->session->open($this->url.'home');
        $msg = $this->session->elementWithWait(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'div[class="eventSummary pending"]')->text();
        $this->assertTrue(!empty($msg));
    }
    
    public function testStudentInstructorDuality() {
        
    }
    
    public function testSingleCourseDualityPrevention() {
        
    }

}
