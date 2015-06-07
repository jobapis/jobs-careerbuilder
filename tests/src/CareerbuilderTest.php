<?php namespace JobBrander\Jobs\Client\Providers\Test;

use JobBrander\Jobs\Client\Providers\Careerbuilder;
use Mockery as m;

class CareerbuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Careerbuilder();
    }

    public function testItWillUseJsonFormat()
    {
        $format = $this->client->getFormat();

        $this->assertEquals('xml', $format);
    }

    public function testItUsesUSHostSite()
    {
        $hostSite = $this->client->getHostSite();

        $this->assertEquals('US', $hostSite);
    }

    public function testItWillUseGetHttpVerb()
    {
        $verb = $this->client->getVerb();

        $this->assertEquals('GET', $verb);
    }

    public function testListingPath()
    {
        $path = $this->client->getListingsPath();

        $this->assertEquals('Results.JobSearchResult', $path);
    }

    public function testItWillProvideEmptyParameters()
    {
        $parameters = $this->client->getParameters();

        $this->assertEmpty($parameters);
        $this->assertTrue(is_array($parameters));
    }

    public function testUrlIncludesKeywordWhenProvided()
    {
        $keyword = uniqid().' '.uniqid();
        $param = 'Keywords='.urlencode($keyword);

        $url = $this->client->setKeyword($keyword)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesKeywordWhenNotProvided()
    {
        $param = 'Keywords=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCityWhenCityProvided()
    {
        $city = uniqid();
        $param = 'FacetCity='.urlencode($city);
        $facetsParam = 'UseFacets=true';

        $url = $this->client->setCity($city)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($facetsParam, $url);
    }

    public function testUrlIncludesStateWhenStateProvided()
    {
        $state = uniqid();
        $param = 'FacetState='.urlencode($state);
        $facetsParam = 'UseFacets=true';

        $url = $this->client->setState($state)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($facetsParam, $url);
    }

    public function testUrlNotIncludesCityWhenNotProvided()
    {
        $param = 'FacetCity=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlNotIncludesStateWhenNotProvided()
    {
        $param = 'FacetState=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesPageWhenProvided()
    {
        $page = uniqid();
        $param = 'PageNumber='.$page;
        $collapseParam = 'EnableCompanyCollapse=true';

        $url = $this->client->setPage($page)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($collapseParam, $url);
    }

    public function testUrlNotIncludesPageWhenNotProvided()
    {
        $param = 'PageNumber=';

        $url = $this->client->setPage(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCountWhenProvided()
    {
        $count = uniqid();
        $param = 'PerPage='.$count;
        $collapseParam = 'EnableCompanyCollapse=true';

        $url = $this->client->setCount($count)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($collapseParam, $url);
    }

    public function testUrlNotIncludesStartWhenNotProvided()
    {
        $param = 'PerPage=';

        $url = $this->client->setCount(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testItCanCreateJobFromPayload()
    {
        $city = uniqid();
        $this->client->setCity($city);
        $payload = $this->createJobArray();

        $results = $this->client->createJobObject($payload);

        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    private function createJobArray() {
        return [
            'Company' => uniqid(),
            'CompanyDetailsURL' => uniqid(),
            'DescriptionTeaser' => uniqid(),
            'OnetCode' => uniqid(),
            'ONetFriendlyTitle' => uniqid(),
            'EmploymentType' => uniqid(),
            'EducationRequired' => uniqid(),
            'ExperienceRequired' => uniqid(),
            'JobDetailsURL' => uniqid(),
            'Location' => uniqid(),
            'City' => uniqid(),
            'State' => uniqid(),
            'PostedTime' => date('F j, Y, g:i a'),
            'Pay' => uniqid(),
            'JobTitle' => uniqid(),
            'CompanyImageURL' => uniqid(),
            'Skills' => [
                'Skill' => [
                    0 => uniqid(),
                    1 => uniqid(),
                    2 => uniqid(),
                    3 => uniqid(),
                ]
            ]
        ];
    }
}
