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

    public function testItCanConnect()
    {
        $job_count = rand(2,10);
        $listings = ['Results' => [
            'JobSearchResult' => $this->createJobArray($job_count)
            ]
        ];
        $source = $this->client->getSource();
        $keyword = 'project manager';

        $this->client->setKeyword($keyword)
            ->setCity('Chicago')
            ->setState('IL');

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive($this->client->getFormat())->once()->andReturn($listings);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($this->client->getVerb()))
            ->with($this->client->getUrl(), $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        /*
        foreach ($listings['resultItemList'] as $i => $result) {
            $this->assertEquals($listings['resultItemList'][$i]['jobTitle'], $results->get($i)->title);
            $this->assertEquals($listings['resultItemList'][$i]['company'], $results->get($i)->company);
            $this->assertEquals($listings['resultItemList'][$i]['location'], $results->get($i)->location);
            $this->assertEquals($listings['resultItemList'][$i]['detailUrl'], $results->get($i)->url);
            $this->assertEquals($keyword, $results->get($i)->query);
            $this->assertEquals($source, $results->get($i)->source);
        }
        */

        $this->assertEquals(count($listings['Results']['JobSearchResult']), $results->count());
    }

    private function createJobArray($num = 10) {
        $jobs = [];
        $i = 0;
        while ($i < 10) {
            $jobs[] = [
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
            $i++;
        }
        return $jobs;
    }
}
