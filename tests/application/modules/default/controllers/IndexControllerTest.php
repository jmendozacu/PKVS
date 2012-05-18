<?php
class IndexControllerTest extends ControllerTestCase
{
    public function testIndexWithResponseCodeOf200 ()
    {
        $this->dispatch('/');
        $this->assertAction("index");
        $this->assertController("index");
       $this->assertResponseCode(200,
        'The response code is ' . $this->getResponse()
            ->getHttpResponseCode());

    }
}
